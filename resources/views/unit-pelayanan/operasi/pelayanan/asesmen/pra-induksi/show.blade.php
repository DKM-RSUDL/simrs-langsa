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
                    'title' => 'Rincian Pra Induksi',
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
                                            datasets: [
                                                {
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
                                                                    Sering cemberut konstan, rahang terkatup, dagu bergetar,
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
                                                                    Tidak nyaman, gelisah, tegang, tonus meningkat, kaku,
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
                                                                    Berbaring dengan tenang, posisi normal, bergerak dengan
                                                                    mudah dan bebas
                                                                @elseif($painScaleData['flacc']['activity'] == 1)
                                                                    Menggeliat, menggeser maju mundur, tegang, ragu-ragu
                                                                    untuk bergerak, menjaga tekanan pada bagian tubuh
                                                                @elseif($painScaleData['flacc']['activity'] == 2)
                                                                    Melengkung, kaku, atau menyentak, posisi tetap, goyang,
                                                                    gerakan kepala dari sisi ke sisi, menggosok bagian tubuh
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
                                                                    Terus menerus menangis, berteriak, saat nafas, sering
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
                                                                    @elseif($painScaleData['cries']['requires'] == 2) Membutuhkan
                                                                        oksigen> 30%
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
                                                                    @elseif($painScaleData['cries']['increased'] == 2) Denyut jantung
                                                                        dan TD meningkata> 20% dari baseline
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
                            <div class="card mt-3">
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
                    <div class="section-separator mt-4">
                        <h6 class="fw-bold">Skala Pada Pasien</h6>
                        @if (isset($patientScoreData['selected_score']))
                            <div class="form-group">
                                <label style="min-width: 200px;">Skala yang Digunakan</label>
                                <input type="text" class="form-control"
                                    value="{{ ucfirst($patientScoreData['selected_score'] ?? '') }}" disabled>
                            </div>

                            @if ($patientScoreData['selected_score'] == 'bromage')
                                <div class="mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title">Bromage Score (SAB/Subarachnoid Block)</h6>
                                    </div>
                                    <div class="">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Score Pasca Anestesi dan Sedasi</th>
                                                    <th>Jam</th>
                                                    <th>15'</th>
                                                    <th>30'</th>
                                                    <th>45'</th>
                                                    <th>1</th>
                                                    <th>2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Post anestesi vital sign</td>
                                                    <td>{{ $patientScoreData['bromage_data']['time'] ?? '-' }}</td>
                                                    <td colspan="5"></td>
                                                </tr>
                                                <tr>
                                                    <td>Gerakan penuh dari tungkai</td>
                                                    <td>{{ $patientScoreData['bromage_data']['gerakan_penuh']['jam'] ?? '-' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['gerakan_penuh']['checked_15'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['gerakan_penuh']['checked_30'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['gerakan_penuh']['checked_45'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['gerakan_penuh']['checked_1'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['gerakan_penuh']['checked_2'] ? '✓' : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tak mampu ekstensi tungkai</td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_ekstensi']['jam'] ?? '-' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_ekstensi']['checked_15'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_ekstensi']['checked_30'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_ekstensi']['checked_45'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_ekstensi']['checked_1'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_ekstensi']['checked_2'] ? '✓' : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tak mampu fleksi/lutut</td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_fleksi']['jam'] ?? '-' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_fleksi']['checked_15'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_fleksi']['checked_30'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_fleksi']['checked_45'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_fleksi']['checked_1'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_fleksi']['checked_2'] ? '✓' : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tak mampu fleksi/pergerakan kaki</td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_pergerakan']['jam'] ?? '-' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_pergerakan']['checked_15'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_pergerakan']['checked_30'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_pergerakan']['checked_45'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_pergerakan']['checked_1'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['tak_pergerakan']['checked_2'] ? '✓' : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jam Pindah Ruang Perawatan</td>
                                                    <td>{{ $patientScoreData['bromage_data']['jam_pindah']['jam'] ?? '-' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['jam_pindah']['checked_15'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['jam_pindah']['checked_30'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['jam_pindah']['checked_45'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['jam_pindah']['checked_1'] ? '✓' : '' }}
                                                    </td>
                                                    <td>{{ $patientScoreData['bromage_data']['jam_pindah']['checked_2'] ? '✓' : '' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if ($patientScoreData['selected_score'] == 'steward' && !empty($patientScoreData['steward_data']))
                                <!-- Steward Score Display -->
                                <div class="mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title">Steward Score (Anak-anak)</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Score Pasca Anestesi dan Sedasi</th>
                                                    <th>Jam</th>
                                                    <th>15'</th>
                                                    <th>30'</th>
                                                    <th>45'</th>
                                                    <th>1</th>
                                                    <th>2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Post anestesi vital sign</td>
                                                    <td>{{ $patientScoreData['steward_data']['time'] ?? '-' }}</td>
                                                    <td colspan="5"></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kesadaran:
                                                        <span class="badge bg-info">
                                                            @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                                {{ $patientScoreData['steward_data']['kesadaran']['value'] ?? 'Tidak ada data' }}
                                                            @else
                                                                {{ $patientScoreData['steward_data']['kesadaran'] ?? '-' }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                            {{ $patientScoreData['steward_data']['kesadaran']['jam'] ?? '-' }}
                                                        @else
                                                            {{ $patientScoreData['steward_data']['kesadaran_jam'] ?? '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                            {{ $patientScoreData['steward_data']['kesadaran']['checked_15'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['kesadaran_15']) && $patientScoreData['steward_data']['kesadaran_15'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                            {{ $patientScoreData['steward_data']['kesadaran']['checked_30'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['kesadaran_30']) && $patientScoreData['steward_data']['kesadaran_30'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                            {{ $patientScoreData['steward_data']['kesadaran']['checked_45'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['kesadaran_45']) && $patientScoreData['steward_data']['kesadaran_45'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                            {{ $patientScoreData['steward_data']['kesadaran']['checked_1'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['kesadaran_1']) && $patientScoreData['steward_data']['kesadaran_1'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['kesadaran'] ?? null))
                                                            {{ $patientScoreData['steward_data']['kesadaran']['checked_2'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['kesadaran_2']) && $patientScoreData['steward_data']['kesadaran_2'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Respirasi:
                                                        <span class="badge bg-info">
                                                            @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                                {{ $patientScoreData['steward_data']['respirasi']['value'] ?? 'Tidak ada data' }}
                                                            @else
                                                                {{ $patientScoreData['steward_data']['respirasi'] ?? '-' }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                            {{ $patientScoreData['steward_data']['respirasi']['jam'] ?? '-' }}
                                                        @else
                                                            {{ $patientScoreData['steward_data']['respirasi_jam'] ?? '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                            {{ $patientScoreData['steward_data']['respirasi']['checked_15'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['respirasi_15']) && $patientScoreData['steward_data']['respirasi_15'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                            {{ $patientScoreData['steward_data']['respirasi']['checked_30'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['respirasi_30']) && $patientScoreData['steward_data']['respirasi_30'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                            {{ $patientScoreData['steward_data']['respirasi']['checked_45'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['respirasi_45']) && $patientScoreData['steward_data']['respirasi_45'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                            {{ $patientScoreData['steward_data']['respirasi']['checked_1'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['respirasi_1']) && $patientScoreData['steward_data']['respirasi_1'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['respirasi'] ?? null))
                                                            {{ $patientScoreData['steward_data']['respirasi']['checked_2'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['respirasi_2']) && $patientScoreData['steward_data']['respirasi_2'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Aktivitas Motorik:
                                                        <span class="badge bg-info">
                                                            @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                                {{ $patientScoreData['steward_data']['motorik']['value'] ?? 'Tidak ada data' }}
                                                            @else
                                                                {{ $patientScoreData['steward_data']['motorik'] ?? '-' }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                            {{ $patientScoreData['steward_data']['motorik']['jam'] ?? '-' }}
                                                        @else
                                                            {{ $patientScoreData['steward_data']['motorik_jam'] ?? '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                            {{ $patientScoreData['steward_data']['motorik']['checked_15'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['motorik_15']) && $patientScoreData['steward_data']['motorik_15'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                            {{ $patientScoreData['steward_data']['motorik']['checked_30'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['motorik_30']) && $patientScoreData['steward_data']['motorik_30'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                            {{ $patientScoreData['steward_data']['motorik']['checked_45'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['motorik_45']) && $patientScoreData['steward_data']['motorik_45'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                            {{ $patientScoreData['steward_data']['motorik']['checked_1'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['motorik_1']) && $patientScoreData['steward_data']['motorik_1'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($patientScoreData['steward_data']['motorik'] ?? null))
                                                            {{ $patientScoreData['steward_data']['motorik']['checked_2'] ? '✓' : '' }}
                                                        @else
                                                            {{ isset($patientScoreData['steward_data']['motorik_2']) && $patientScoreData['steward_data']['motorik_2'] ? '✓' : '' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jam Pindah Ruang</td>
                                                    <td colspan="6">
                                                        @if (is_array($patientScoreData['steward_data']['jam_pindah'] ?? null))
                                                            {{ json_encode($patientScoreData['steward_data']['jam_pindah']) }}
                                                        @else
                                                            {{ $patientScoreData['steward_data']['jam_pindah'] ?? '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- Aldrete Score Display -->
                            @if ($patientScoreData['selected_score'] == 'aldrete' && !empty($patientScoreData['aldrete_data']))
                                <div class="mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title">Score Aldrete</h6>
                                    </div>
                                    <div class="">
                                        <h6 class="text-center mt-4">Data Penilaian Score Aldrete</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Jam Pasca Anestesi</label>
                                            <input type="text" class="form-control"
                                                value="{{ $patientScoreData['aldrete_data']['aldrete_tanggal'] ?? '-' }}"
                                                disabled>
                                        </div>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Interval/Jam</th>
                                                        <th>Skor</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($patientScoreData['aldrete_data']['interval_data']) &&
                                                            is_array($patientScoreData['aldrete_data']['interval_data']))
                                                        @foreach ($patientScoreData['aldrete_data']['interval_data'] as $interval)
                                                            <tr>
                                                                <td>{{ $interval['jam'] ?? '-' }}</td>
                                                                <td>{{ $interval['skor'] ?? '-' }}</td>
                                                                <td>{{ $interval['keterangan'] ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>{{ $patientScoreData['aldrete_data']['interval_jam_1'] ?? '-' }}
                                                            </td>
                                                            <td>{{ $patientScoreData['aldrete_data']['skor_1'] ?? '-' }}
                                                            </td>
                                                            <td>{{ $patientScoreData['aldrete_data']['keterangan_1'] ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $patientScoreData['aldrete_data']['interval_jam_2'] ?? '-' }}
                                                            </td>
                                                            <td>{{ $patientScoreData['aldrete_data']['skor_2'] ?? '-' }}
                                                            </td>
                                                            <td>{{ $patientScoreData['aldrete_data']['keterangan_2'] ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $patientScoreData['aldrete_data']['interval_jam_3'] ?? '-' }}
                                                            </td>
                                                            <td>{{ $patientScoreData['aldrete_data']['skor_3'] ?? '-' }}
                                                            </td>
                                                            <td>{{ $patientScoreData['aldrete_data']['keterangan_3'] ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="bg-success text-white p-2 rounded mt-3 mb-3">
                                            <strong>Kesimpulan Akhir: </strong>
                                            {{ $patientScoreData['aldrete_data']['kesimpulan_akhir'] ?? ($patientScoreData['aldrete_data']['kesimpulan'] ?? 'Belum Ada Kesimpulan') }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($patientScoreData['selected_score'] == 'padds' && !empty($patientScoreData['padds_data']))
                                <!-- PADDS Score Display -->
                                <div class="mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title">Score PADDS (Khusus Rawat Jalan)</h6>
                                    </div>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="d-block mb-2">Tanda Vital</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text">{{ $patientScoreData['padds_data']['padds_tanda_vital'] ?? '0' }}</span>
                                                        <input type="text" class="form-control"
                                                            value="@if (isset($patientScoreData['padds_data']['padds_tanda_vital'])) @if ($patientScoreData['padds_data']['padds_tanda_vital'] == '2') Tekanan darah dan nadi 15-24% dari pre Op @elseif($patientScoreData['padds_data']['padds_tanda_vital'] == '1') Tekanan darah dan nadi 25-40% dari pre Op @elseif($patientScoreData['padds_data']['padds_tanda_vital'] == '0') Tekanan darah dan nadi >40% dari pre Op @endif @endif"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="d-block mb-2">Aktivitas</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text">{{ $patientScoreData['padds_data']['padds_aktivitas'] ?? '0' }}</span>
                                                        <input type="text" class="form-control"
                                                            value="@if (isset($patientScoreData['padds_data']['padds_aktivitas'])) @if ($patientScoreData['padds_data']['padds_aktivitas'] == '2') Berjalan normal, tidak pusing saat berdiri @elseif($patientScoreData['padds_data']['padds_aktivitas'] == '1') Butuh bantuan untuk berjalan @elseif($patientScoreData['padds_data']['padds_aktivitas'] == '0') Tidak dapat berjalan @endif @endif"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="d-block mb-2">Mual/muntah</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text">{{ $patientScoreData['padds_data']['padds_mual_muntah'] ?? '0' }}</span>
                                                        <input type="text" class="form-control"
                                                            value="@if (isset($patientScoreData['padds_data']['padds_mual_muntah'])) @if ($patientScoreData['padds_data']['padds_mual_muntah'] == '2') Tidak ada atau ringan, tetap bisa makan @elseif($patientScoreData['padds_data']['padds_mual_muntah'] == '1') Sedang, terkontrol dengan obat @elseif($patientScoreData['padds_data']['padds_mual_muntah'] == '0') Berat, tidak terkontrol dengan obat @endif @endif"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="d-block mb-2">Perdarahan</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text">{{ $patientScoreData['padds_data']['padds_perdarahan'] ?? '0' }}</span>
                                                        <input type="text" class="form-control"
                                                            value="@if (isset($patientScoreData['padds_data']['padds_perdarahan'])) @if ($patientScoreData['padds_data']['padds_perdarahan'] == '2') Minimal (tidak perlu ganti verban) @elseif($patientScoreData['padds_data']['padds_perdarahan'] == '1') Sedang (perlu ganti verban 1-2 kali) @elseif($patientScoreData['padds_data']['padds_perdarahan'] == '0') Berat (perlu ganti verban 3 kali atau lebih) @endif @endif"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="d-block mb-2">Nyeri</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text">{{ $patientScoreData['padds_data']['padds_nyeri'] ?? '0' }}</span>
                                                        <input type="text" class="form-control"
                                                            value="@if (isset($patientScoreData['padds_data']['padds_nyeri'])) @if ($patientScoreData['padds_data']['padds_nyeri'] == '2') Nyeri ringan, nyaman, dapat diterima @elseif($patientScoreData['padds_data']['padds_nyeri'] == '1') Nyeri sedang sampai berat, terkontrol dengan analgesik oral @elseif($patientScoreData['padds_data']['padds_nyeri'] == '0') Nyeri berat, tidak terkontrol dengan analgesik oral @endif @endif"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="d-block mb-2"
                                                        style="background-color: #177F75; color: white; padding: 8px;">Kesimpulan</label>
                                                    <div class="p-3 text-white rounded"
                                                        style="background-color: #177F75;">
                                                        {{ $patientScoreData['padds_data']['padds_kesimpulan'] ?? 'Belum Ada Kesimpulan' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Data Penilaian Score PADDS (Khusus Rawat Jalan)</h6>

                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Jam Pasca Anestesi</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $patientScoreData['padds_data']['padds_tanggal_jam'] ?? '-' }}"
                                                    disabled>
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
                                                    <tbody>
                                                        @if (isset($patientScoreData['padds_data']['time_data']) && is_array($patientScoreData['padds_data']['time_data']))
                                                            @foreach ($patientScoreData['padds_data']['time_data'] as $timeData)
                                                                <tr>
                                                                    <td>{{ $timeData['jam'] ?? '-' }}</td>
                                                                    <td>{{ $timeData['skor'] ?? '-' }}</td>
                                                                    <td>{{ $timeData['kesimpulan'] ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            @for ($i = 1; $i <= 3; $i++)
                                                                <tr>
                                                                    <td>{{ $patientScoreData['padds_data']['time_' . $i] ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $patientScoreData['padds_data']['skor_' . $i] ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $patientScoreData['padds_data']['kesimpulan_' . $i] ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 mt-4">
                                            <label class="d-block mb-2"
                                                style="background-color: #177F75; color: white; padding: 8px;">Kesimpulan
                                                Akhir</label>
                                            <div class="p-3 text-white rounded" style="background-color: #177F75;">
                                                {{ $patientScoreData['padds_data']['padds_final_kesimpulan'] ?? ($patientScoreData['padds_data']['padds_kesimpulan'] ?? 'Belum Ada Kesimpulan') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                Tidak ada data skala pasien yang tersimpan
                            </div>
                        @endif
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
                                        <input type="text" value="{{ $okPraInduksi->okPraInduksiIpb->minum ?? '-' }}"
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
