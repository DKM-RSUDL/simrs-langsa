<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')
    @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.show-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Detail Rincian Pra Induksi',
                    'description' => 'Rincian data pra induksi pasien dengan mengisi formulir di bawah ini.',
                ])
                <div class="section-separator mt-0" id="dataMasuk">
                    <h5 class="section-title">1. Data Masuk</h5>
                    <div class="form-group">
                        <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>

                        <input type="date" name="tgl_masuk" id="tgl_masuk"
                            value="{{ date('Y-m-d', strtotime($okPraInduksi->tgl_masuk_pra_induksi)) }}"
                            class="form-control me-3" disabled>
                        <input type="time" name="jam_masuk" id="jam_masuk"
                            value="{{ date('H:i', strtotime($okPraInduksi->jam_masuk)) }}" class="form-control" disabled>
                    </div>
                </div>

                <div class="section-separator" id="praInduksi">
                    <h5 class="section-title">2. Pra Induksi</h5>
                    <div class="form-group">
                        <label style="min-width: 200px;">Diagnosis</label>
                        <input type="text" value="{{ $okPraInduksi->diagnosis ?? '' }}" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Tindakan</label>
                        <input type="text" value="{{ $okPraInduksi->tindakan ?? '' }}" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Spesialis Anestesi</label>
                        <input type="text" value="{{ $okPraInduksi->spesialis_anestesi ?? '' }}" class="form-control"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Penata Anestesi</label>
                        <input type="text" value="{{ $okPraInduksi->penata_anestesi ?? '' }}" class="form-control"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Spesialis Bedah</label>
                        <input type="text" value="{{ $okPraInduksi->spesialis_bedah ?? '' }}" class="form-control"
                            disabled>
                    </div>
                </div>

                <div class="section-separator" id="rasTable">
                    <h5 class="section-title">3. Rencana Anestesi Spinal</h5>
                    <div class="form-group">
                        <label style="min-width: 200px;">Tanggal</label>
                        <input type="date"
                            value="{{ $okPraInduksi->ras_tanggal ? date('Y-m-d', strtotime($okPraInduksi->ras_tanggal)) : '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Tingkat Anestesi</label>
                        <input type="text" value="{{ $okPraInduksi->ras_tingkat_anestesi ?? '' }}" class="form-control"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Jenis Sedasi</label>
                        <input type="text" value="{{ $okPraInduksi->ras_jenis_sedasi ?? '' }}" class="form-control"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Analgesia Pasca</label>
                        <input type="text" value="{{ $okPraInduksi->ras_analgesia_pasca ?? '' }}" class="form-control"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Obat Digunakan</label>
                        <input type="text" value="{{ $okPraInduksi->ras_obat_digunakan ?? '' }}" class="form-control"
                            disabled>
                    </div>
                </div>

                <div class="section-separator" id="evaluasiPraAnestesi">
                    <h5 class="section-title">4. Evaluasi Pra Anestesi dan Sedasi (EPAS)</h5>

                    <div class="mb-3">
                        <h6 class="fw-bold" style="min-width: 200px;">Keadaan Pra-Bedah</h6>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Tek. Darah (mmHg)</label>
                        <div class="col-sm-4">
                            <input type="number"
                                value="{{ $okPraInduksi->okPraInduksiEpas->tekanan_darah_sistole ?? '' }}"
                                class="form-control" disabled>
                        </div>
                        <div class="col-sm-4">
                            <input type="number"
                                value="{{ $okPraInduksi->okPraInduksiEpas->tekanan_darah_diastole ?? '' }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Nadi (Per Menit)</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->nadi ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Nafas (Per Menit)</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->nafas ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Respirasi</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->respirasi ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Saturasi Oksigen (%)</label>
                        <div class="col-sm-4">
                            <input type="text"
                                value="{{ $okPraInduksi->okPraInduksiEpas->saturasi_tanpa_bantuan ?? '' }}"
                                class="form-control" placeholder="Tanpa bantuan O₂" disabled>
                        </div>
                        <div class="col-sm-4">
                            <input type="text"
                                value="{{ $okPraInduksi->okPraInduksiEpas->saturasi_dengan_bantuan ?? '' }}"
                                class="form-control" placeholder="Dengan bantuan O₂" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Suhu (℃)</label>
                        <input type="number" value="{{ $okPraInduksi->okPraInduksiEpas->suhu ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">AVPU</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiEpas->avpu ? getAvpuText($okPraInduksi->okPraInduksiEpas->avpu) : '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Glasgow Coma Scale (GCS)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->gcs_total ?? '' }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Golongan Darah</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->golongan_darah ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Akses Intravena (Tempat Dan Ukuran)</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->akses_intravena ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Status Fisik ASA</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->status_fisik_asa ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold" style="min-width: 200px;">Dukungan Oksigen</h6>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Pemberian Oksigen Kepada Pasien</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiEpas->dukungan_pemberian_oksigen ? getDukunganOksigenText($okPraInduksi->okPraInduksiEpas->dukungan_pemberian_oksigen) : '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Jika Pasien Memerlukan Support
                            Pernapasan</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiEpas->dukungan_support_pernapasan ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Jika Pasien Terintubasi</label>
                        <div class="col-sm-4">
                            <input type="text"
                                value="{{ $okPraInduksi->okPraInduksiEpas->dukungan_terintubasi_o2 ?? '' }}"
                                class="form-control" placeholder="Dengan bantuan O₂" disabled>
                        </div>
                        <div class="col-sm-4">
                            <input type="text"
                                value="{{ $okPraInduksi->okPraInduksiEpas->dukungan_terintubasi_spo2 ?? '' }}"
                                class="form-control" placeholder="persen(%)" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold" style="min-width: 200px;">Antropometri</h6>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Tinggi Badan (Kg)</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiEpas->antropometri_tinggi_badan ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Berat Badan (Kg)</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiEpas->antropometri_berat_badan ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Indeks Massa Tubuh (IMT)</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->antropometri_imt ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Luas Permukaan Tubuh (LPT)</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiEpas->antropometri_lpt ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Obat Dan Pemantauan Selama Prosedur Dengan
                            Anestesi Dan Sedasi</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiEpas->antropometri_obat_dan_pemantauan ?? '' }}"
                            class="form-control" disabled>
                    </div>
                </div>

                <div class="section-separator" id="pemantauanAnestesiPAS">
                    <h5 class="section-title">5. Pemantauan Selama Anestesi dan Sedasi (PSAS)</h5>

                    <div class="alert alert-info">
                        <small>Data ini merupakan pemantauan setiap 5 menit sekali data tersebut berupa
                            Tekanan
                            Darah, Nadi, Nafas, dan Saturasi Oksigen (SpO₂)</small>
                    </div>

                    <!-- Chart section -->
                    <h6 class="mt-4">Grafik Pemantauan Selama Anestesi dan Sedasi</h6>

                    <div class="alert alert-secondary">
                        <small>Grafik menunjukkan Tekanan Darah, Nadi, Nafas, dan Saturasi Oksigen
                            (SpO₂) persen (%) dalam setiap 5 menit sekali</small>
                    </div>

                    <div class="mb-4">
                        <canvas id="vitalSignsChartPSAS" height="150"></canvas>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap mb-2">
                                <div class="me-3">
                                    <label class="form-check-label">
                                        Mulai Anestesi dan Sedasi : <strong>X</strong>
                                    </label>
                                </div>
                                <div class="me-3">
                                    <label class="form-check-label">
                                        Status Anestesi dan Sedasi : <strong>X</strong>
                                    </label>
                                </div>
                                <div class="me-3">
                                    <label class="form-check-label">
                                        Mulai Prosedur : <strong>O</strong>
                                    </label>
                                </div>
                                <div class="me-3">
                                    <label class="form-check-label">
                                        Selesai Prosedur : <strong>O</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display monitoring data in a table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Sistole (mmHg)</th>
                                    <th>Diastole (mmHg)</th>
                                    <th>Nadi (Per Menit)</th>
                                    <th>Nafas (Per Menit)</th>
                                    <th>SpO₂ (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $jsonData = $okPraInduksi->okPraInduksiPsas->all_monitoring_data ?? '[]';
                                    $monitoringData = json_decode($jsonData, true) ?: [];
                                @endphp

                                @forelse($monitoringData as $data)
                                    <tr>
                                        <td>{{ $data['time'] ?? '-' }}</td>
                                        <td>{{ $data['sistole'] ?? '-' }}</td>
                                        <td>{{ $data['diastole'] ?? '-' }}</td>
                                        <td>{{ $data['nadi'] ?? '-' }}</td>
                                        <td>{{ $data['nafas'] ?? '-' }}</td>
                                        <td>{{ $data['spo2'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data
                                            pemantauan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Hal Penting Yang Terjadi Selama Anestesi Dan
                            Sedasi :</label>
                        <textarea class="form-control" rows="3" disabled>{{ $okPraInduksi->okPraInduksiPsas->hal_penting ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Kedalaman Anestesi Dan Sedasi</label>
                        <input type="text" class="form-control"
                            value="{{ $okPraInduksi->okPraInduksiPsas->kedalaman_anestesi ?? '' }}" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Respon Terhadap Anestesi Dan Sedasi</label>
                        <input type="text" class="form-control"
                            value="{{ $okPraInduksi->okPraInduksiPsas->respon_anestesi ?? '' }}" disabled>
                    </div>
                </div>

                <div class="section-separator" id="catatanKamarPemulihanCKP">
                    <h5 class="section-title">6. Catatan Tindakan dan Kondisi Pasien (CTKP)</h5>

                    <div class="form-group row">
                        <label class="col-sm-3">Data Masuk Jam</label>
                        <div class="col-sm-4">
                            <input type="time" name="jam_masuk" id="jam_masuk"
                                value="{{ date('H:i', strtotime($okPraInduksi->okPraInduksiCtkp->jam_masuk_pemulihan_ckp ?? '')) }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Jalan Nafas</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiCtkp->jalan_nafas_ckp ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Jika Jalan Nafas Spontan</label>
                        <input type="text" value="{{ $okPraInduksi->okPraInduksiCtkp->nafas_spontan_ckp ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label style="min-width: 200px;">Kesadaran</label>
                        <input type="text"
                            value="{{ $okPraInduksi->okPraInduksiCtkp->kesadaran_pemulihan_ckp ?? '' }}"
                            class="form-control" disabled>
                    </div>

                    <label style="min-width: 200px;" class=" fw-bold">Score Aldrete</label>
                    <div class="form-group">
                        <label style="min-width: 200px;">Aktivitas</label>
                        <input disabled type="number" name="aktivitas" id="aktivitas" class="form-control pas-input"
                            placeholder="Aktivitas" value="{{ $okPraInduksi->okPraInduksiCtkp->aktivitas ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Sirkulasi</label>
                        <input disabled type="number" name="sirkulasi" id="sirkulasi" class="form-control pas-input"
                            placeholder="Sirkulasi" value="{{ $okPraInduksi->okPraInduksiCtkp->sirkulasi ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Pernafasan</label>
                        <input disabled type="number" name="pernafasan" id="pernafasan" class="form-control pas-input"
                            placeholder="Pernafasan" value="{{ $okPraInduksi->okPraInduksiCtkp->pernafasan ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Kesadaran</label>
                        <input disabled type="number" name="kesadaran" id="kesadaran" class="form-control pas-input"
                            placeholder="Kesadaran" value="{{ $okPraInduksi->okPraInduksiCtkp->kesadaran ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Warna kulit</label>
                        <input disabled type="number" name="warna_kulit" id="warna_kulit"
                            class="form-control pas-input" placeholder="Warna kulit"
                            value="{{ $okPraInduksi->okPraInduksiCtkp->warna_kulit ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Total</label>
                        <input disabled type="number" name="total" id="total" class="form-control pas-input"
                            placeholder="Total" value="{{ $okPraInduksi->okPraInduksiCtkp->total ?? '' }}">
                    </div>

                    <div class="alert alert-info mt-4">
                        <small>Data observasi ini merupakan pemantauan setiap 5 menit sekali, data
                            tersebut
                            berupa Tekanan Darah, Nadi, Nafas, Saturasi Oksigen (SpO₂), dan Tanda Vital
                            Stabil (TVS)</small>
                    </div>

                    @php
                        // Parse JSON observasi data
                        $observasiData = json_decode(
                            $okPraInduksi->okPraInduksiCtkp->all_observasi_data_ckp ?? '[]',
                            true,
                        );

                        // Parse pain scale data
                        $painScaleData = json_decode(
                            $okPraInduksi->okPraInduksiCtkp->pain_scale_data_json ?? '{}',
                            true,
                        );

                        // Parse patient score data
                        $patientScoreData = json_decode(
                            $okPraInduksi->okPraInduksiCtkp->patient_score_data_json ?? '{}',
                            true,
                        );

                        // Initialize chart data arrays
                        $chartLabels = [];
                        $tekananDarahData = [];
                        $nadiData = [];
                        $nafasData = [];
                        $spo2Data = [];
                        $tvsData = [];

                        // Extract data for chart
                        foreach ($observasiData as $data) {
                            $chartLabels[] = $data['time'] ?? '';
                            $tekananDarahData[] = $data['tekananDarah'] ?? 0;
                            $nadiData[] = $data['nadi'] ?? 0;
                            $nafasData[] = $data['nafas'] ?? 0;
                            $spo2Data[] = $data['spo2'] ?? 0;
                            $tvsData[] = $data['tvs'] ?? 0;
                        }
                    @endphp

                    <!-- Chart section -->
                    <h6 class="mt-4">Grafik Pasca Anestesi dan Sedasi</h6>

                    <div class="alert alert-secondary">
                        <small>Grafik menunjukkan Tekanan Darah, Nadi, Nafas, Saturasi Oksigen (SpO₂),
                            dan Tanda Vital Stabil (TVS) dalam setiap 5 menit sekali</small>
                    </div>

                    <div class="mb-4">
                        <canvas id="recoveryVitalChartCKP" height="150"></canvas>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="col-12">
                            <div class="d-flex flex-wrap">
                                <div class="me-3 mb-2">
                                    <span class="badge bg-primary me-1"></span> Sistole
                                    <div class="me-3 mb-2">
                                        <span class="badge bg-primary me-1"></span> Diastole
                                    </div>
                                    <div class="me-3 mb-2">
                                        <span class="badge bg-success me-1"></span> Nadi
                                    </div>
                                    <div class="me-3 mb-2">
                                        <span class="badge bg-info me-1"></span> Nafas
                                    </div>
                                    <div class="me-3 mb-2">
                                        <span class="badge bg-warning me-1"></span> SPO₂
                                    </div>
                                    <div class="me-3 mb-2">
                                        <span class="badge bg-danger me-1"></span> TVS
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Display observasi data in a table -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Sistole (mmHg)</th>
                                        <th>Diastole (mmHg)</th>
                                        <th>Nadi (Per Menit)</th>
                                        <th>Nafas (Per Menit)</th>
                                        <th>SpO₂ (%)</th>
                                        <th>TVS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($observasiData as $data)
                                        <tr>
                                            <td>{{ $data['time'] ?? '-' }}</td>
                                            <td>{{ $data['sistole'] ?? '-' }}</td>
                                            <td>{{ $data['diastole'] ?? '-' }}</td>
                                            <td>{{ $data['nadi'] ?? '-' }}</td>
                                            <td>{{ $data['nafas'] ?? '-' }}</td>
                                            <td>{{ $data['spo2'] ?? '-' }}</td>
                                            <td>{{ $data['tvs'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data observasi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @push('js')
                            <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Pastikan variabel chart sudah terdefinisi secara eksplisit di PHP
                                    var chartLabels = {!! json_encode($chartLabels ?? []) !!};
                                    var sistoleData = {!! json_encode($sistoleData ?? []) !!};
                                    var diastoleData = {!! json_encode($diastoleData ?? []) !!};
                                    var nadiData = {!! json_encode($nadiData ?? []) !!};
                                    var nafasData = {!! json_encode($nafasData ?? []) !!};
                                    var spo2Data = {!! json_encode($spo2Data ?? []) !!};
                                    var tvsData = {!! json_encode($tvsData ?? []) !!};

                                    console.log('CTKP Chart data:', {
                                        labels: chartLabels,
                                        sistole: sistoleData,
                                        diastole: diastoleData,
                                        nadi: nadiData,
                                        nafas: nafasData,
                                        spo2: spo2Data,
                                        tvs: tvsData
                                    });

                                    // Get chart element
                                    var chartElement = document.getElementById('recoveryVitalChartCKP');

                                    if (chartElement && chartLabels.length > 0) {
                                        var ctx = chartElement.getContext('2d');

                                        // Create chart
                                        new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: chartLabels,
                                                datasets: [{
                                                        label: 'Sistole',
                                                        data: sistoleData,
                                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                        borderColor: 'rgba(54, 162, 235, 1)',
                                                        borderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4
                                                    },
                                                    {
                                                        label: 'Diastole',
                                                        data: diastoleData,
                                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                        borderColor: 'rgba(54, 162, 235, 1)',
                                                        borderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4
                                                    },
                                                    {
                                                        label: 'Nadi',
                                                        data: nadiData,
                                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4
                                                    },
                                                    {
                                                        label: 'Nafas',
                                                        data: nafasData,
                                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                                        borderColor: 'rgba(153, 102, 255, 1)',
                                                        borderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4
                                                    },
                                                    {
                                                        label: 'SpO₂',
                                                        data: spo2Data,
                                                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                                        borderColor: 'rgba(255, 159, 64, 1)',
                                                        borderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4
                                                    },
                                                    {
                                                        label: 'TVS',
                                                        data: tvsData,
                                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                                        borderColor: 'rgba(255, 99, 132, 1)',
                                                        borderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4
                                                    }
                                                ]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: true,
                                                scales: {
                                                    y: {
                                                        beginAtZero: false,
                                                        min: 0,
                                                        max: 250,
                                                        ticks: {
                                                            stepSize: 50
                                                        }
                                                    }
                                                },
                                                elements: {
                                                    point: {
                                                        radius: 4
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: true,
                                                        position: 'top'
                                                    },
                                                    tooltip: {
                                                        enabled: true,
                                                        mode: 'index',
                                                        intersect: false
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        console.error('CTKP Chart element not found or data is empty');
                                    }
                                });
                            </script>
                        @endpush

                        <!-- Pain Scale Information -->
                        <div class="section-separator mt-4">
                            <h6 class="fw-bold">Jenis Skala NYERI</h6>
                            @if (isset($painScaleData) && is_array($painScaleData) && isset($painScaleData['selectedScale']))
                                <div class="form-group">
                                    <label style="min-width: 200px;">Skala yang Digunakan</label>
                                    <input type="text" class="form-control"
                                        value="@if ($painScaleData['selectedScale'] == 'nrs') Scale NRS, VAS, VRS
                            @elseif($painScaleData['selectedScale'] == 'flacc') Face, Legs, Activity, Cry, Consolability (FLACC)
                            @elseif($painScaleData['selectedScale'] == 'cries') Crying, Requires, Increased, Expression, Sleepless (CRIES) @endif"
                                        disabled>
                                </div>

                                @if ($painScaleData['selectedScale'] == 'nrs')
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="card-title mb-0">Scale NRS, VAS, VRS</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="min-width: 200px;">Nilai NRS</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $painScaleData['nrs']['nilai'] ?? '0' }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="min-width: 200px;">Jenis Skala</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($painScaleData['nrs']['scaleType']) && $painScaleData['nrs']['scaleType'] == 'wong-baker' ? 'Wong Baker Faces Pain Scale' : 'Numeric Rating Pain Scale' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <label style="min-width: 200px;">Kategori Nyeri</label>
                                                <div
                                                    class="p-2 rounded-3
                                    @if (isset($painScaleData['nrs']['kategori'])) @if ($painScaleData['nrs']['kategori'] == 'Tidak Nyeri' || $painScaleData['nrs']['kategori'] == 'Nyeri Ringan')
                                            bg-success text-white
                                        @elseif($painScaleData['nrs']['kategori'] == 'Nyeri Sedang')
                                            bg-warning
                                        @else
                                            bg-danger text-white @endif
@else
bg-success text-white
                                    @endif">
                                                    {{ $painScaleData['nrs']['kategori'] ?? 'Tidak Nyeri' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($painScaleData['selectedScale'] == 'flacc')
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="card-title mb-0">FLACC Score (Skala untuk anak usia 2 bulan sd 7
                                                tahun)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Nilai</th>
                                                            <th>Deskripsi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Wajah (Face)</strong></td>
                                                            <td>{{ $painScaleData['flacc']['face'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['flacc']['face']))
                                                                    @if ($painScaleData['flacc']['face'] == 0)
                                                                        Tersenyum tidak ada ekspresi
                                                                    @elseif($painScaleData['flacc']['face'] == 1)
                                                                        Kadang meringis, mengerutkan kening, menarik diri,
                                                                        kurang merespond dengan baik/ekspresi datar
                                                                    @elseif($painScaleData['flacc']['face'] == 2)
                                                                        Sering cemberut konstan, rahang terkatup, dagu
                                                                        bergetar,
                                                                        kerutan yang dalam di dahi, mata terkatup, mulut
                                                                        terbuka, garing yang dalam disadari hidung bibir
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <!-- Repeated for all other parameters: legs, activity, cry, consolability -->
                                                        <tr>
                                                            <td><strong>Kaki (Legs)</strong></td>
                                                            <td>{{ $painScaleData['flacc']['legs'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['flacc']['legs']))
                                                                    @if ($painScaleData['flacc']['legs'] == 0)
                                                                        Posisi normal atau santai
                                                                    @elseif($painScaleData['flacc']['legs'] == 1)
                                                                        Tidak nyaman, gelisah, tegang, tonus meningkat,
                                                                        kaku,
                                                                        fleksi/ekstensi anggota badan intermiten
                                                                    @elseif($painScaleData['flacc']['legs'] == 2)
                                                                        Menendang atau kaki dinaikkan,
                                                                        hipertonus/fleksi/ekstensi anggota badan secara
                                                                        berlebihan, tremor
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Aktivitas (Activity)</strong></td>
                                                            <td>{{ $painScaleData['flacc']['activity'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['flacc']['activity']))
                                                                    @if ($painScaleData['flacc']['activity'] == 0)
                                                                        Berbaring dengan tenang, posisi normal, bergerak
                                                                        dengan
                                                                        mudah dan bebas
                                                                    @elseif($painScaleData['flacc']['activity'] == 1)
                                                                        Menggeliat, menggeser maju mundur, tegang, ragu-ragu
                                                                        untuk bergerak, menjaga tekanan pada bagian tubuh
                                                                    @elseif($painScaleData['flacc']['activity'] == 2)
                                                                        Melengkung, kaku, atau menyentak, posisi tetap,
                                                                        goyang,
                                                                        gerakan kepala dari sisi ke sisi, menggosok bagian
                                                                        tubuh
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Menangis (Cry)</strong></td>
                                                            <td>{{ $painScaleData['flacc']['cry'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['flacc']['cry']))
                                                                    @if ($painScaleData['flacc']['cry'] == 0)
                                                                        Tidak menangis (pada saat terjaga atau saat tidur)
                                                                    @elseif($painScaleData['flacc']['cry'] == 1)
                                                                        Erangan atau rengekan, sesekali menangis, mendesis,
                                                                        sesekali mengeluh
                                                                    @elseif($painScaleData['flacc']['cry'] == 2)
                                                                        Terus menerus menangis, berteriak, saat nafas,
                                                                        sering
                                                                        mengeluh, sering mengejut
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Konsolabilitas (Consolability)</strong></td>
                                                            <td>{{ $painScaleData['flacc']['consolability'] ?? '0' }}
                                                            </td>
                                                            <td>
                                                                @if (isset($painScaleData['flacc']['consolability']))
                                                                    @if ($painScaleData['flacc']['consolability'] == 0)
                                                                        Tenang, santai dan riang
                                                                    @elseif($painScaleData['flacc']['consolability'] == 1)
                                                                        Perlu dijadikan denga perhatian perilaku, menggajak
                                                                        berbicara, Perhatian dapat dialihkan
                                                                    @elseif($painScaleData['flacc']['consolability'] == 2)
                                                                        Sulit untuk dibujuk atau dibuat nyaman
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="2"><strong>Total Skor:</strong>
                                                                {{ $painScaleData['flacc']['total'] ?? '0' }}</td>
                                                            <td>
                                                                <div
                                                                    class="p-2 rounded-3
                                                    @if (isset($painScaleData['flacc']['kategori'])) @if ($painScaleData['flacc']['kategori'] == 'NYERI RINGAN')
                                                            bg-success text-white
                                                        @elseif($painScaleData['flacc']['kategori'] == 'NYERI SEDANG')
                                                            bg-warning
                                                        @else
                                                            bg-danger text-white @endif
@else
bg-success text-white
                                                    @endif">
                                                                    <strong>{{ $painScaleData['flacc']['kategori'] ?? 'NYERI RINGAN' }}</strong>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($painScaleData['selectedScale'] == 'cries')
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="card-title mb-0">CRIES Score (Skala untuk anak usia 32 minggu sd
                                                60 minggu)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Nilai</th>
                                                            <th>Deskripsi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Menangis (Cry)</strong></td>
                                                            <td>{{ $painScaleData['cries']['cry'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['cries']['cry']))
                                                                    @if ($painScaleData['cries']['cry'] == 0)
                                                                        Tidak menangis atau tangisan tidak melelahkan
                                                                    @elseif($painScaleData['cries']['cry'] == 1)
                                                                        Tangisan melengking tetapi mudah dihibur
                                                                    @elseif($painScaleData['cries']['cry'] == 2)
                                                                        Tangisan melengking dan tidak mudah dihibur
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <!-- Similar structure for other parameters -->
                                                        <tr>
                                                            <td><strong>Kebutuhan Oksigen (Requires)</strong></td>
                                                            <td>{{ $painScaleData['cries']['requires'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['cries']['requires']))
                                                                    @if ($painScaleData['cries']['requires'] == 0)
                                                                        Tidak membutuhkan oksigen
                                                                    @elseif($painScaleData['cries']['requires'] == 1)
                                                                        Membutuhkan oksigen < 30%
                                                                        @elseif($painScaleData['cries']['requires'] == 2)
                                                                            Membutuhkan oksigen> 30%
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Peningkatan Tanda-tanda Vital
                                                                    (Increased)</strong></td>
                                                            <td>{{ $painScaleData['cries']['increased'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['cries']['increased']))
                                                                    @if ($painScaleData['cries']['increased'] == 0)
                                                                        Denyut jantung dan TD tidak mengalami perubahan
                                                                    @elseif($painScaleData['cries']['increased'] == 1)
                                                                        Denyut jantung dan TD meningkata < 20% dari baseline
                                                                        @elseif($painScaleData['cries']['increased'] == 2) Denyut
                                                                            jantung dan TD meningkata> 20% dari baseline
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Wajah (Expression)</strong></td>
                                                            <td>{{ $painScaleData['cries']['expression'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['cries']['expression']))
                                                                    @if ($painScaleData['cries']['expression'] == 0)
                                                                        Tidak ada senyum
                                                                    @elseif($painScaleData['cries']['expression'] == 1)
                                                                        Seringai ada
                                                                    @elseif($painScaleData['cries']['expression'] == 2)
                                                                        Seringai ada dan tidak ada, tangisan dengkur
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Sulit Tidur (Sleepless)</strong></td>
                                                            <td>{{ $painScaleData['cries']['sleepless'] ?? '0' }}</td>
                                                            <td>
                                                                @if (isset($painScaleData['cries']['sleepless']))
                                                                    @if ($painScaleData['cries']['sleepless'] == 0)
                                                                        Terus menerus tidur
                                                                    @elseif($painScaleData['cries']['sleepless'] == 1)
                                                                        Terbangun pada interval berulang
                                                                    @elseif($painScaleData['cries']['sleepless'] == 2)
                                                                        Terjaga/terbangun terus menerus
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="2"><strong>Total Skor:</strong>
                                                                {{ $painScaleData['cries']['total'] ?? '0' }}</td>
                                                            <td>
                                                                <div
                                                                    class="p-2 rounded-3
                            @if (isset($painScaleData['cries']['kategori'])) @if ($painScaleData['cries']['kategori'] == 'NYERI RINGAN')
                                    bg-success text-white
                                @elseif($painScaleData['cries']['kategori'] == 'NYERI SEDANG')
                                    bg-warning
                                @else
                                    bg-danger text-white @endif
@else
bg-success text-white
                            @endif">
                                                                    <strong>{{ $painScaleData['cries']['kategori'] ?? 'NYERI RINGAN' }}</strong>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Kesimpulan Nyeri Section -->
                                <div class=" mt-3">
                                    <div class="card-header bg-dark text-white">
                                        <h6 class="card-title mb-0">Kesimpulan Nyeri</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-2">Nilai Skala Nyeri</label>
                                                    <input type="text" class="form-control"
                                                        value="@if ($painScaleData['selectedScale'] == 'nrs') {{ $painScaleData['nrs']['nilai'] ?? '0' }}
                        @elseif($painScaleData['selectedScale'] == 'flacc') {{ $painScaleData['flacc']['total'] ?? '0' }}
                        @elseif($painScaleData['selectedScale'] == 'cries') {{ $painScaleData['cries']['total'] ?? '0' }} @endif"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-2">Kategori Nyeri</label>
                                                    <div
                                                        class="p-3 rounded text-white
                @if ($painScaleData['selectedScale'] == 'nrs') @if (isset($painScaleData['nrs']['kategori']))
                        @if ($painScaleData['nrs']['kategori'] == 'Tidak Nyeri' || $painScaleData['nrs']['kategori'] == 'Nyeri Ringan')
                            bg-success
                        @elseif ($painScaleData['nrs']['kategori'] == 'Nyeri Sedang')
                            bg-warning text-dark
                        @else
                            bg-danger @endif
@else
bg-success
                    @endif
@elseif($painScaleData['selectedScale'] == 'flacc')
@if (isset($painScaleData['flacc']['kategori'])) @if ($painScaleData['flacc']['kategori'] == 'NYERI RINGAN')
                            bg-success
                        @elseif ($painScaleData['flacc']['kategori'] == 'NYERI SEDANG')
                            bg-warning text-dark
                        @else
                            bg-danger @endif
@else
bg-success
                    @endif
@elseif($painScaleData['selectedScale'] == 'cries')
@if (isset($painScaleData['cries']['kategori'])) @if ($painScaleData['cries']['kategori'] == 'NYERI RINGAN')
                            bg-success
                        @elseif ($painScaleData['cries']['kategori'] == 'NYERI SEDANG')
                            bg-warning text-dark
                        @else
                            bg-danger @endif
@else
bg-success
                    @endif
@else
bg-success
                @endif">
                                                        @if ($painScaleData['selectedScale'] == 'nrs')
                                                            {{ $painScaleData['nrs']['kategori'] ?? 'Tidak Nyeri' }}
                                                        @elseif($painScaleData['selectedScale'] == 'flacc')
                                                            {{ $painScaleData['flacc']['kategori'] ?? 'NYERI RINGAN' }}
                                                        @elseif($painScaleData['selectedScale'] == 'cries')
                                                            {{ $painScaleData['cries']['kategori'] ?? 'NYERI RINGAN' }}
                                                        @else
                                                            Nyeri Ringan
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Tidak ada data skala nyeri yang tersimpan
                                </div>
                            @endif
                        </div>

                        <!-- Patient Score Information -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Skala Pada Pasien</label>
                            <select name="skala_pasien" id="skalaPasien" class="form-control" disabled>
                                <option value="" disabled
                                    {{ !isset($okPraInduksi->okPraInduksiCtkp->skala_pasien) ? 'selected' : '' }}>Pilih
                                    skala Pemantauan Pasca-Anestesi</option>
                                <option value="bromage"
                                    {{ ($okPraInduksi->okPraInduksiCtkp->skala_pasien ?? '') == 'bromage' ? 'selected' : '' }}>
                                    Bromage Score (SAB/Subarachnoid Block - Anak)</option>
                                <option value="steward"
                                    {{ ($okPraInduksi->okPraInduksiCtkp->skala_pasien ?? '') == 'steward' ? 'selected' : '' }}>
                                    Steward Score (Anak-anak)</option>
                                <option value="aldrete"
                                    {{ ($okPraInduksi->okPraInduksiCtkp->skala_pasien ?? '') == 'aldrete' ? 'selected' : '' }}>
                                    Score Aldrete</option>
                                <option value="padds"
                                    {{ ($okPraInduksi->okPraInduksiCtkp->skala_pasien ?? '') == 'padds' ? 'selected' : '' }}>
                                    Score PADDS (Khusus Rawat Jalan)</option>
                            </select>
                        </div>

                        <!-- Hidden input untuk menyimpan semua data dalam format JSON -->
                        <input type="hidden" id="patientScoreDataJSON" name="patient_score_data_json"
                            value="{{ $okPraInduksi->okPraInduksiCtkp->patient_score_data_json ?? '{}' }}">

                        <!-- Bromage Score Form - Initially Hidden -->
                        <div id="bromageScoreForm" class="score-form" style="display: none;">
                            <h5 class="text-center mt-3 mb-4">Penilaian Bromage Score (SAB/Subarachnoid Block - Anak)</h5>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">Score Pasca Anestesi dan Sedasi</th>
                                        <th width="8%">Score</th>
                                        <th width="17%">Jam Pasca Anestesi</th>
                                        <th width="10%">15'</th>
                                        <th width="10%">30'</th>
                                        <th width="10%">45'</th>
                                        <th width="10%">1 jam</th>
                                        <th width="10%">2 jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Row 1: Gerakan penuh dari tungkai -->
                                    <tr>
                                        <td><strong>Gerakan penuh dari tungkai</strong></td>
                                        <td class="text-center"><strong>0</strong></td>
                                        <td>
                                            <input type="time" name="bromage_gerakan_penuh"
                                                class="form-control form-control-sm" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_15" value="gerakan_penuh_0" data-group="gerakan_penuh"
                                                data-score="0" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_30" value="gerakan_penuh_0" data-group="gerakan_penuh"
                                                data-score="0" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_45" value="gerakan_penuh_0" data-group="gerakan_penuh"
                                                data-score="0" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_60" value="gerakan_penuh_0" data-group="gerakan_penuh"
                                                data-score="0" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_120" value="gerakan_penuh_0"
                                                data-group="gerakan_penuh" data-score="0" disabled>
                                        </td>
                                    </tr>
                                    <!-- Row 2: Tak mampu ekstensi tungkai -->
                                    <tr>
                                        <td><strong>Tak mampu ekstensi tungkai</strong></td>
                                        <td class="text-center"><strong>1</strong></td>
                                        <td>
                                            <input type="time" name="bromage_tak_ekstensi"
                                                class="form-control form-control-sm" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_15" value="tak_ekstensi_1" data-group="tak_ekstensi"
                                                data-score="1" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_30" value="tak_ekstensi_1" data-group="tak_ekstensi"
                                                data-score="1" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_45" value="tak_ekstensi_1" data-group="tak_ekstensi"
                                                data-score="1" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_60" value="tak_ekstensi_1" data-group="tak_ekstensi"
                                                data-score="1" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_120" value="tak_ekstensi_1" data-group="tak_ekstensi"
                                                data-score="1" disabled>
                                        </td>
                                    </tr>
                                    <!-- Row 3: Tak mampu fleksi lutut -->
                                    <tr>
                                        <td><strong>Tak mampu fleksi lutut</strong></td>
                                        <td class="text-center"><strong>2</strong></td>
                                        <td>
                                            <input type="time" name="bromage_tak_fleksi_lutut"
                                                class="form-control form-control-sm" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_15" value="tak_fleksi_lutut_2"
                                                data-group="tak_fleksi_lutut" data-score="2" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_30" value="tak_fleksi_lutut_2"
                                                data-group="tak_fleksi_lutut" data-score="2" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_45" value="tak_fleksi_lutut_2"
                                                data-group="tak_fleksi_lutut" data-score="2" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_60" value="tak_fleksi_lutut_2"
                                                data-group="tak_fleksi_lutut" data-score="2" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_120" value="tak_fleksi_lutut_2"
                                                data-group="tak_fleksi_lutut" data-score="2" disabled>
                                        </td>
                                    </tr>
                                    <!-- Row 4: Tak mampu fleksi pergelangan kaki -->
                                    <tr>
                                        <td><strong>Tak mampu fleksi pergelangan kaki</strong></td>
                                        <td class="text-center"><strong>3</strong></td>
                                        <td>
                                            <input type="time" name="bromage_tak_fleksi_pergelangan"
                                                class="form-control form-control-sm" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_15" value="tak_fleksi_pergelangan_3"
                                                data-group="tak_fleksi_pergelangan" data-score="3" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_30" value="tak_fleksi_pergelangan_3"
                                                data-group="tak_fleksi_pergelangan" data-score="3" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_45" value="tak_fleksi_pergelangan_3"
                                                data-group="tak_fleksi_pergelangan" data-score="3" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_60" value="tak_fleksi_pergelangan_3"
                                                data-group="tak_fleksi_pergelangan" data-score="3" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input bromage-radio" type="radio"
                                                name="bromage_time_120" value="tak_fleksi_pergelangan_3"
                                                data-group="tak_fleksi_pergelangan" data-score="3" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <td colspan="2"><strong>TOTAL SCORE</strong></td>
                                        <td colspan="6">
                                            <div class="d-flex align-items-center">
                                                <span class="me-3"><strong id="bromage_total_score">0</strong></span>
                                                <span class="badge bg-warning text-dark" id="bromage_status">
                                                    Boleh pindah ruang jika score ≥ 2
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Jam Pindah Ruang Perawatan</strong></td>
                                        <td colspan="5">
                                            <input type="time" name="bromage_jam_pindah"
                                                class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" name="bromage_total_score_value" id="bromage_total_score_value"
                                value="0">
                        </div>

                        <!-- Steward Score Form - Initially Hidden -->
                        <div id="stewardScoreForm" class="score-form" style="display: none;">
                            <h5 class="text-center mt-3 mb-4">Penilaian Steward Score (Anak-anak)</h5>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%" rowspan="2">Score Pasca Anestesi dan Sedasi</th>
                                        <th width="15%" rowspan="2">Score</th>
                                        <th width="15%" rowspan="2">Jam Pasca Anestesi</th>
                                        <th colspan="5" class="text-center">Jam</th>
                                    </tr>
                                    <tr>
                                        <th width="10%">15'</th>
                                        <th width="10%">30'</th>
                                        <th width="10%">45'</th>
                                        <th width="10%">1</th>
                                        <th width="10%">2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Kesadaran -->
                                    <tr>
                                        <td rowspan="3"><strong>Kesadaran</strong></td>
                                        <td>Sadar penuh, responsif</td>
                                        <td class="text-center"><strong>2</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_15" value="sadar_2" data-group="kesadaran"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_30" value="sadar_2" data-group="kesadaran"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_45" value="sadar_2" data-group="kesadaran"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_60" value="sadar_2" data-group="kesadaran"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_120" value="sadar_2" data-group="kesadaran"
                                                data-score="2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bangun saat dipanggil/nama disebut</td>
                                        <td class="text-center"><strong>1</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_15" value="bangun_1" data-group="kesadaran"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_30" value="bangun_1" data-group="kesadaran"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_45" value="bangun_1" data-group="kesadaran"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_60" value="bangun_1" data-group="kesadaran"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_120" value="bangun_1" data-group="kesadaran"
                                                data-score="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tidak responsif</td>
                                        <td class="text-center"><strong>0</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_15" value="tidak_responsif_0"
                                                data-group="kesadaran" data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_30" value="tidak_responsif_0"
                                                data-group="kesadaran" data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_45" value="tidak_responsif_0"
                                                data-group="kesadaran" data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_60" value="tidak_responsif_0"
                                                data-group="kesadaran" data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_kesadaran_120" value="tidak_responsif_0"
                                                data-group="kesadaran" data-score="0">
                                        </td>
                                    </tr>
                                    <!-- Respirasi -->
                                    <tr>
                                        <td rowspan="3"><strong>Respirasi</strong></td>
                                        <td>Bernapas normal/menangis</td>
                                        <td class="text-center"><strong>2</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_15" value="normal_2" data-group="respirasi"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_30" value="normal_2" data-group="respirasi"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_45" value="normal_2" data-group="respirasi"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_60" value="normal_2" data-group="respirasi"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_120" value="normal_2" data-group="respirasi"
                                                data-score="2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Napas dangkal/terbatas</td>
                                        <td class="text-center"><strong>1</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_15" value="dangkal_1" data-group="respirasi"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_30" value="dangkal_1" data-group="respirasi"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_45" value="dangkal_1" data-group="respirasi"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_60" value="dangkal_1" data-group="respirasi"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_120" value="dangkal_1" data-group="respirasi"
                                                data-score="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apnea/perlu bantuan napas</td>
                                        <td class="text-center"><strong>0</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_15" value="apnea_0" data-group="respirasi"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_30" value="apnea_0" data-group="respirasi"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_45" value="apnea_0" data-group="respirasi"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_60" value="apnea_0" data-group="respirasi"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_respirasi_120" value="apnea_0" data-group="respirasi"
                                                data-score="0">
                                        </td>
                                    </tr>
                                    <!-- Aktivitas Motorik -->
                                    <tr>
                                        <td rowspan="3"><strong>Aktivitas Motorik</strong></td>
                                        <td>Gerakan aktif/beraturan</td>
                                        <td class="text-center"><strong>2</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_15" value="aktif_2" data-group="motorik"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_30" value="aktif_2" data-group="motorik"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_45" value="aktif_2" data-group="motorik"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_60" value="aktif_2" data-group="motorik"
                                                data-score="2">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_120" value="aktif_2" data-group="motorik"
                                                data-score="2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gerakan lemah/terbatas</td>
                                        <td class="text-center"><strong>1</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_15" value="lemah_1" data-group="motorik"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_30" value="lemah_1" data-group="motorik"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_45" value="lemah_1" data-group="motorik"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_60" value="lemah_1" data-group="motorik"
                                                data-score="1">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_120" value="lemah_1" data-group="motorik"
                                                data-score="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tidak bergerak</td>
                                        <td class="text-center"><strong>0</strong></td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_15" value="tidak_bergerak_0" data-group="motorik"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_30" value="tidak_bergerak_0" data-group="motorik"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_45" value="tidak_bergerak_0" data-group="motorik"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_60" value="tidak_bergerak_0" data-group="motorik"
                                                data-score="0">
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input steward-radio" disabled type="radio"
                                                name="steward_motorik_120" value="tidak_bergerak_0" data-group="motorik"
                                                data-score="0">
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <td colspan="3"><strong>TOTAL SCORE</strong></td>
                                        <td colspan="5">
                                            <div class="d-flex align-items-center">
                                                <span class="me-3"><strong id="steward_total_score">0</strong></span>
                                                <span class="badge bg-warning text-dark" id="steward_status">
                                                    Boleh pindah ruang jika score ≥ 5
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Jam Pindah Ruang</strong></td>
                                        <td colspan="5">
                                            <input type="time" name="steward_jam_pindah"
                                                class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" name="steward_total_score_value" id="steward_total_score_value"
                                value="0">
                        </div>

                        <!-- Aldrete Score Form - Unchanged -->
                        <div id="aldreteScoreForm" class="score-form" style="display: none;">
                            <h5 class="text-center mt-3">Penilaian Score Aldrete</h5>
                            <div class="form-group">
                                <label style="min-width: 200px;">Aktivitas Motorik</label>
                                <select name="aktivitas_motorik" class="form-control" disabled>
                                    <option value="" disabled selected>pilih</option>
                                    <option value="0">Seluruh ekstremitas dapat digerakkan</option>
                                    <option value="1">Dua ekstremitas dapat digerakkan</option>
                                    <option value="2">Tidak dapat bergerak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="min-width: 200px;">Respirasi</label>
                                <select name="respirasi" class="form-control" disabled>
                                    <option value="" disabled selected>pilih</option>
                                    <option value="0">Dapat bernapas dalam dan batuk</option>
                                    <option value="1">Dangkal namun pertukaran udara adekuat</option>
                                    <option value="2">Apneu atau obstruksi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="min-width: 200px;">Sirkulasi</label>
                                <select name="aldrete_sirkulasi" class="form-control" disabled>
                                    <option value="" disabled selected>pilih</option>
                                    <option value="0">Tekanan darah menyimpang < 20 mmHg dari tekanan darah pre
                                            anestesi</option>
                                    <option value="1">Tekanan darah menyimpang 20-50 mmHg dari tekanan darah pre
                                        anestesi</option>
                                    <option value="2">Tekanan darah menyimpang >50 mmHg dari tekanan darah pre
                                        anestesi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="min-width: 200px;">Kesadaran</label>
                                <select name="aldrete_kesadaran" class="form-control" disabled>
                                    <option value="" disabled selected>pilih</option>
                                    <option value="0">Tidak berespon</option>
                                    <option value="1">Bangun namun cepat kembali tertidur</option>
                                    <option value="2">Sadar serta orientasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="min-width: 200px;">Warna Kulit</label>
                                <select name="aldrete_warna_kulit" class="form-control" disabled>
                                    <option value="" disabled selected>pilih</option>
                                    <option value="0">Sianosis</option>
                                    <option value="1">Pucat, ikterik</option>
                                    <option value="2">Merah muda</option>
                                </select>
                            </div>
                            <div class="bg-success text-white p-2 rounded mb-3">
                                <strong>Kesimpulan : </strong> Boleh pindah ruang / Tidak Boleh pindah ruang
                            </div>
                            <h6 class="text-center mt-2">Data Penilaian Score Aldrete</h6>
                            <div class="form-group">
                                <label style="min-width: 200px;">Tanggal Jam Pasca Anestesi</label>
                                <div class="input-group">
                                    <input type="datetime-local" name="aldrete_tanggal" class="form-control" disabled>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Interval/Jam</th>
                                        <th>Skor</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                <input type="time" name="interval_jam_1" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="skor_1" class="form-control"
                                                min="0">
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan_1" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                <input type="time" name="interval_jam_2" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="skor_2" class="form-control"
                                                min="0">
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan_2" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                <input type="time" name="interval_jam_3" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="skor_3" class="form-control"
                                                min="0">
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan_3" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="bg-success text-white p-2 rounded mb-3">
                                <strong>Kesimpulan : </strong> Boleh pindah ruang / Tidak Boleh pindah ruang
                            </div>
                        </div>

                        <!-- PADDS Score Form - Unchanged -->
                        <div id="paddsScoreForm" class="score-form" style="display: none;">
                            <h5 class="text-center mt-3">Penilaian Score PADDS (Khusus Rawat Jalan)</h5>
                            <div class="form-group mb-3">
                                <label class="d-block mb-2">Tanda Vital</label>
                                <select class="form-select" disabled name="padds_tanda_vital" id="paddsTandaVital">
                                    <option value="" selected>pilih</option>
                                    <option value="2">Tekanan darah dan nadi 15-24% dari pre Op</option>
                                    <option value="1">Tekanan darah dan nadi 25-40% dari pre Op</option>
                                    <option value="0">Tekanan darah dan nadi >40% dari pre Op</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-block mb-2">Aktivitas</label>
                                <select class="form-select" disabled name="padds_aktivitas" id="paddsAktivitas">
                                    <option value="" selected>pilih</option>
                                    <option value="2">Berjalan normal, tidak pusing saat berdiri</option>
                                    <option value="1">Butuh bantuan untuk berjalan</option>
                                    <option value="0">Tidak dapat berjalan</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-block mb-2">Mual/muntah</label>
                                <select class="form-select" disabled name="padds_mual_muntah" id="paddsMualMuntah">
                                    <option value="" selected>pilih</option>
                                    <option value="2">Tidak ada atau ringan, tetap bisa makan</option>
                                    <option value="1">Sedang, terkontrol dengan obat</option>
                                    <option value="0">Berat, tidak terkontrol dengan obat</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-block mb-2">Perdarahan</label>
                                <select class="form-select" disabled name="padds_perdarahan" id="paddsPerdarahan">
                                    <option value="" selected>pilih</option>
                                    <option value="2">Minimal (tidak perlu ganti verban)</option>
                                    <option value="1">Sedang (perlu ganti verban 1-2 kali)</option>
                                    <option value="0">Berat (perlu ganti verban 3 kali atau lebih)</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-block mb-2">Nyeri</label>
                                <select class="form-select" disabled name="padds_nyeri" id="paddsNyeri">
                                    <option value="" selected>pilih</option>
                                    <option value="2">Nyeri ringan, nyaman, dapat diterima</option>
                                    <option value="1">Nyeri sedang sampai berat, terkontrol dengan analgesik oral
                                    </option>
                                    <option value="0">Nyeri berat, tidak terkontrol dengan analgesik oral</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-block mb-2"
                                    style="background-color: #177F75; color: white; padding: 8px;">Kesimpulan :</label>
                                <div id="paddsKesimpulan" class="p-3 text-white rounded"
                                    style="background-color: #177F75;">
                                    Boleh pindah ruang / Tidak Boleh pindah ruang
                                </div>
                                <input type="hidden" disabled name="padds_kesimpulan" id="paddsKesimpulanInput"
                                    value="Boleh pindah ruang / Tidak Boleh pindah ruang">
                            </div>
                            <div class="mt-4">
                                <h6>Data Penilaian Score PADDS (Khusus Rawat Jalan)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Jam Pasca Anestesi</label>
                                    <div class="input-group">
                                        <input type="datetime-local" class="form-control" disabled
                                            name="padds_tanggal_jam" id="paddsTanggalJam">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tanggal/Jam</th>
                                                <th>Skor</th>
                                                <th>Kesimpulan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="paddsTimeTable">
                                            <tr>
                                                <td><i class="far fa-clock"></i> Jam</td>
                                                <td>Skor</td>
                                                <td>Kesimpulan</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group mb-3 mt-4">
                                <label class="d-block mb-2"
                                    style="background-color: #177F75; color: white; padding: 8px;">Kesimpulan :</label>
                                <div id="paddsFinalKesimpulan" class="p-3 text-white rounded"
                                    style="background-color: #177F75;">
                                    Boleh pindah ruang / Tidak Boleh pindah ruang
                                </div>
                                <input type="hidden" disabled name="padds_final_kesimpulan"
                                    id="paddsFinalKesimpulanInput"
                                    value="Boleh pindah ruang / Tidak Boleh pindah ruang">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Keluar Kamar Pulih Jam</label>
                            <div class="col-sm-4">
                                <input type="time" name="jam_masuk" id="jam_masuk"
                                    value="{{ date('H:i', strtotime($okPraInduksi->okPraInduksiCtkp->jam_keluar ?? '')) }}"
                                    class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Nilai Skala Nyeri VAS</label>
                            <input type="number" value="{{ $okPraInduksi->okPraInduksiCtkp->nilai_skala_vas ?? '' }}"
                                class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Lanjut Ke Ruang</label>
                            <input type="text" value="{{ $okPraInduksi->okPraInduksiCtkp->lanjut_ruang ?? '' }}"
                                class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Catatan Ruang Pemulihan</label>
                            <textarea class="form-control" rows="2" disabled>{{ $okPraInduksi->okPraInduksiCtkp->catatan_pemulihan ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="section-separator mb-0" id="instruksiPascaBedah">
                        <h5 class="section-title">7. Instruksi Pasca Bedah (IPB)</h5>

                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Bila
                                                Kesakitan</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->bila_kesakitan ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Bila
                                                Mual/Muntah</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->bila_mual_muntah ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Antibiotika</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->antibiotika ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Obat-Obatan
                                                Lain</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->obat_lain ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Cairan
                                                Infus</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->cairan_infus ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Minum</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->minum ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Pemantauan Tanda
                                                Vital Setiap</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->pemantauan_tanda_vital ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Durasi
                                                Pemantauan</label>
                                            <input type="text"
                                                value="{{ $okPraInduksi->okPraInduksiIpb->durasi_pemantauan ?? '-' }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label style="min-width: 200px;" class="fw-bold">E-Signature Dokter</label>
                                    <input type="text"
                                        value="{{ $okPraInduksi->okPraInduksiIpb->dokter_edukasi ?? '-' }}"
                                        class="form-control" disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label style="min-width: 200px;" class="fw-bold">Lain-Lain</label>
                                    <textarea class="form-control" rows="3" disabled>{{ $okPraInduksi->okPraInduksiIpb->lain_lain ?? '-' }}</textarea>
                                </div>

                                @if ($okPraInduksi->okPraInduksiIpb->hardcopyform)
                                    <div class="form-group mb-3">
                                        <label style="min-width: 200px;" class="fw-bold">HardCopy Form
                                            Perlengkapan</label>
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $okPraInduksi->okPraInduksiIpb->hardcopyform) }}"
                                                class="btn btn-primary" target="_blank">
                                                <i class="fas fa-file-alt me-1"></i> Lihat Dokumen
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
            </x-content-card>
        </div>
    </div>
@endsection
