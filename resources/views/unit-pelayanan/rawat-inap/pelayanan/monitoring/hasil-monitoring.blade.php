{{-- resources/views/unit-pelayanan/rawat-inap/pelayanan/monitoring/hasil-monitoring.blade.php --}}

<div>
    <div class="card-body">
        <div class="mb-4">
            <h6 class="mb-3 fw-bold">Filter Data Monitoring {{ $title }}</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Hari Rawat</label>
                        <select class="form-select" id="hariRawatFilter">
                            <option value="">-- Pilih Hari Rawat --</option>
                            {{-- Options akan diisi melalui JavaScript --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-primary" id="filterData">
                                <i class="fas fa-search"></i> Filter Data
                            </button>
                            <button type="button" class="btn btn-secondary" id="resetFilter">
                                <i class="fas fa-refresh"></i> Reset
                            </button>
                            <button type="button" class="btn btn-success" id="loadAllDays">
                                <i class="fas fa-list"></i> Muat Semua Hari
                            </button>
                            {{-- Tombol Print --}}
                            <button type="button" class="btn btn-info text-white" id="printMonitoring">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4" id="loadingState" style="display: none;">
            <div class="card-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat data monitoring...</p>
            </div>
        </div>

        <div class="alert alert-info" id="noDataState">
            <h6>Tidak Ada Data</h6>
            <p class="mb-0">Silakan pilih hari rawat dan klik "Filter Data" untuk menampilkan hasil monitoring.</p>
        </div>

        <div class="alert alert-primary" id="filterInfo" style="display: none;">
            <strong>Filter Aktif:</strong> <span id="filterInfoText"></span>
        </div>

        <div class="card mb-4" id="dataSelectionSection" style="display: none;">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Pilih Data untuk Detail</h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Record Monitoring</label>
                    <select class="form-select" id="monitoringFilter">
                        <option value="">-- Pilih Tanggal dan Jam --</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-4" id="vitalDetails" style="display: none;">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Detail Vital Signs {{ $title }}</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="vital-stats">
                            <div class="vital-item mb-2">
                                <strong>Tanggal:</strong> <span id="detail-date"></span>
                            </div>
                            <div class="vital-item mb-2">
                                <strong>Jam:</strong> <span id="detail-time"></span>
                            </div>
                            <div class="vital-item mb-2">
                                <strong>Hari Rawat:</strong> <span id="detail-hari-rawat"></span>
                            </div>
                            <div class="vital-item mb-2">
                                <strong>Sistolik:</strong> <span id="detail-sistolik"></span> mmHg
                            </div>
                            <div class="vital-item mb-2">
                                <strong>Diastolik:</strong> <span id="detail-diastolik"></span> mmHg
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vital-stats">
                            <div class="vital-item mb-2">
                                <strong>MAP:</strong> <span id="detail-map"></span> mmHg
                            </div>
                            <div class="vital-item mb-2">
                                <strong>HR:</strong> <span id="detail-hr"></span> bpm
                            </div>
                            <div class="vital-item mb-2">
                                <strong>RR:</strong> <span id="detail-rr"></span> x/menit
                            </div>
                            <div class="vital-item mb-2">
                                <strong>Suhu:</strong> <span id="detail-temp"></span> °C
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="chartSection" style="display: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold">Grafik Vital Signs</h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="showAllLines">Tampilkan Semua</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="hideAllLines">Sembunyikan Semua</button>
                    </div>
                </div>
                <canvas id="vitalSignsChart" height="100"></canvas>
                <div class="mt-3">
                    <small class="text-muted">
                        <strong>Petunjuk:</strong> Klik pada legenda untuk menampilkan/menyembunyikan data tertentu
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            let vitalSignsChart = null;
            let currentFilteredData = [];
            let availableHariRawat = [];

            // Get current route parameters
            const routeParams = {
                kd_unit: '{{ $kd_unit }}',
                kd_pasien: '{{ $kd_pasien }}',
                tgl_masuk: '{{ $tgl_masuk }}',
                urut_masuk: '{{ $urut_masuk }}'
            };

            // Initialize
            $('#noDataState').show();
            loadAvailableHariRawat();

            // Load available hari rawat options
            function loadAvailableHariRawat() {
                $.ajax({
                    url: `{{ route('rawat-inap.monitoring.available-days', ['kd_unit' => ':kd_unit', 'kd_pasien' => ':kd_pasien', 'tgl_masuk' => ':tgl_masuk', 'urut_masuk' => ':urut_masuk']) }}`
                        .replace(':kd_unit', routeParams.kd_unit)
                        .replace(':kd_pasien', routeParams.kd_pasien)
                        .replace(':tgl_masuk', routeParams.tgl_masuk)
                        .replace(':urut_masuk', routeParams.urut_masuk),
                    method: 'GET',
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            availableHariRawat = response.data;
                            populateHariRawatOptions(response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading hari rawat:', error);
                    }
                });
            }

            function populateHariRawatOptions(hariRawatData) {
                const $select = $('#hariRawatFilter');
                $select.empty().append('<option value="">-- Pilih Hari Rawat --</option>');
                
                hariRawatData.forEach(item => {
                    $select.append(`<option value="${item.hari_rawat}">Hari Rawat Ke-${item.hari_rawat} (${item.count} data)</option>`);
                });
            }

            // Filter Data Event
            $('#filterData').on('click', function() {
                const selectedHariRawat = $('#hariRawatFilter').val();
                
                if (!selectedHariRawat) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih hari rawat terlebih dahulu'
                    });
                    return;
                }

                filterByHariRawat(selectedHariRawat);
            });

            // Load All Days Event
            $('#loadAllDays').on('click', function() {
                loadAllDaysData();
            });

            // Reset Filter Event
            $('#resetFilter').on('click', function() {
                $('#hariRawatFilter').val('');
                $('#monitoringFilter').empty().append('<option value="">-- Pilih Tanggal dan Jam --</option>');
                $('#dataSelectionSection').hide();
                $('#vitalDetails').hide();
                $('#chartSection').hide();
                $('#noDataState').show();
                $('#filterInfo').hide();
                currentFilteredData = [];
            });

            // Monitoring Filter Change Event
            $('#monitoringFilter').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue) {
                    getMonitoringDetail(selectedValue);
                } else {
                    $('#vitalDetails').hide();
                }
            });

            // Chart Legend Toggle Events
            $('#showAllLines').on('click', function() {
                if (vitalSignsChart) {
                    vitalSignsChart.data.datasets.forEach(dataset => {
                        dataset.hidden = false;
                    });
                    vitalSignsChart.update();
                }
            });

            $('#hideAllLines').on('click', function() {
                if (vitalSignsChart) {
                    vitalSignsChart.data.datasets.forEach(dataset => {
                        dataset.hidden = true;
                    });
                    vitalSignsChart.update();
                }
            });

            // Print Monitoring Event
            $('#printMonitoring').on('click', function() {
                const selectedHariRawat = $('#hariRawatFilter').val();

                let printUrl = `{{ route('rawat-inap.monitoring.print', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ]) }}`;

                const params = new URLSearchParams();
                if (selectedHariRawat) {
                    params.append('hari_rawat', selectedHariRawat);
                }
                
                if (params.toString()) {
                    printUrl += '?' + params.toString();
                }
                
                window.open(printUrl, '_blank');
            });

            function filterByHariRawat(hariRawat) {
                $('#loadingState').show();
                $('#noDataState').hide();
                $('#filterInfo').hide();
                $('#dataSelectionSection').hide();
                $('#vitalDetails').hide();
                $('#chartSection').hide();

                // AJAX call to get filtered data by hari rawat
                $.ajax({
                    url: `{{ route('rawat-inap.monitoring.filter-by-day', ['kd_unit' => ':kd_unit', 'kd_pasien' => ':kd_pasien', 'tgl_masuk' => ':tgl_masuk', 'urut_masuk' => ':urut_masuk']) }}`
                        .replace(':kd_unit', routeParams.kd_unit)
                        .replace(':kd_pasien', routeParams.kd_pasien)
                        .replace(':tgl_masuk', routeParams.tgl_masuk)
                        .replace(':urut_masuk', routeParams.urut_masuk),
                    method: 'GET',
                    data: {
                        hari_rawat: hariRawat
                    },
                    success: function(response) {
                        $('#loadingState').hide();

                        if (response.success && response.data.length > 0) {
                            currentFilteredData = response.data;
                            
                            // Show filter info
                            $('#filterInfo').show();
                            $('#filterInfoText').text(`Hari Rawat Ke-${hariRawat} (${response.count} data monitoring)`);

                            // Populate monitoring filter dropdown
                            populateMonitoringFilter(response.data);
                            
                            // Show data selection section
                            $('#dataSelectionSection').show();
                            
                            // Create and display chart
                            createVitalSignsChart(response.data, hariRawat);
                            $('#chartSection').show();

                        } else {
                            $('#noDataState').show();
                            $('#noDataState').html(`
                                <div class="alert alert-info">
                                    <h6>Tidak Ada Data</h6>
                                    <p class="mb-0">Tidak ditemukan data monitoring untuk Hari Rawat Ke-${hariRawat}.</p>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingState').hide();
                        console.error('Error:', error);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memuat data. Silakan coba lagi.'
                        });
                    }
                });
            }

            function loadAllDaysData() {
                $('#loadingState').show();
                $('#noDataState').hide();
                $('#filterInfo').hide();
                $('#dataSelectionSection').hide();
                $('#vitalDetails').hide();
                $('#chartSection').hide();

                // AJAX call to get all monitoring data
                $.ajax({
                    url: `{{ route('rawat-inap.monitoring.all-data', ['kd_unit' => ':kd_unit', 'kd_pasien' => ':kd_pasien', 'tgl_masuk' => ':tgl_masuk', 'urut_masuk' => ':urut_masuk']) }}`
                        .replace(':kd_unit', routeParams.kd_unit)
                        .replace(':kd_pasien', routeParams.kd_pasien)
                        .replace(':tgl_masuk', routeParams.tgl_masuk)
                        .replace(':urut_masuk', routeParams.urut_masuk),
                    method: 'GET',
                    success: function(response) {
                        $('#loadingState').hide();

                        if (response.success && response.data.length > 0) {
                            currentFilteredData = response.data;
                            
                            // Show filter info
                            $('#filterInfo').show();
                            $('#filterInfoText').text(`Semua Hari Rawat (${response.count} data monitoring)`);

                            // Populate monitoring filter dropdown
                            populateMonitoringFilter(response.data);
                            
                            // Show data selection section
                            $('#dataSelectionSection').show();
                            
                            // Create and display chart
                            createVitalSignsChart(response.data, 'all');
                            $('#chartSection').show();

                        } else {
                            $('#noDataState').show();
                            $('#noDataState').html(`
                                <div class="alert alert-info">
                                    <h6>Tidak Ada Data</h6>
                                    <p class="mb-0">Tidak ditemukan data monitoring.</p>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingState').hide();
                        console.error('Error:', error);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memuat data. Silakan coba lagi.'
                        });
                    }
                });
            }

            function getMonitoringDetail(monitoringId) {
                $.ajax({
                    url: `{{ route('rawat-inap.monitoring.detail', ['kd_unit' => ':kd_unit', 'kd_pasien' => ':kd_pasien', 'tgl_masuk' => ':tgl_masuk', 'urut_masuk' => ':urut_masuk', 'id' => ':id']) }}`
                        .replace(':kd_unit', routeParams.kd_unit)
                        .replace(':kd_pasien', routeParams.kd_pasien)
                        .replace(':tgl_masuk', routeParams.tgl_masuk)
                        .replace(':urut_masuk', routeParams.urut_masuk)
                        .replace(':id', monitoringId),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            displayVitalDetails(response.data);
                            $('#vitalDetails').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error getting detail:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memuat detail data.'
                        });
                    }
                });
            }

            function populateMonitoringFilter(data) {
                const $select = $('#monitoringFilter');
                $select.empty().append('<option value="">-- Pilih Tanggal dan Jam --</option>');
                
                data.forEach(record => {
                    $select.append(`<option value="${record.id}">${record.formatted_datetime} (Hari ${record.hari_rawat})</option>`);
                });
            }

            function displayVitalDetails(data) {
                $('#detail-date').text(data.formatted_date);
                $('#detail-time').text(data.formatted_time);
                $('#detail-hari-rawat').text('Hari Ke-' + data.hari_rawat);
                $('#detail-sistolik').text(data.detail.sistolik || '-');
                $('#detail-diastolik').text(data.detail.diastolik || '-');
                $('#detail-map').text(data.detail.map || '-');
                $('#detail-hr').text(data.detail.hr || '-');
                $('#detail-rr').text(data.detail.rr || '-');
                $('#detail-temp').text(data.detail.temp || '-');
            }

            function createVitalSignsChart(data, hariRawat) {
                const ctx = document.getElementById('vitalSignsChart').getContext('2d');
                
                // Destroy existing chart if exists
                if (vitalSignsChart) {
                    vitalSignsChart.destroy();
                }

                const labels = data.map(record => record.formatted_datetime);

                const chartData = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Sistolik (mmHg)',
                            data: data.map(record => record.detail.sistolik || 0),
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Diastolik (mmHg)',
                            data: data.map(record => record.detail.diastolik || 0),
                            borderColor: '#ffc107',
                            backgroundColor: 'rgba(255, 193, 7, 0.1)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'MAP (mmHg)',
                            data: data.map(record => record.detail.map || 0),
                            borderColor: '#17a2b8',
                            backgroundColor: 'rgba(23, 162, 184, 0.1)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Heart Rate (bpm)',
                            data: data.map(record => record.detail.hr || 0),
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Resp. Rate (x/menit)',
                            data: data.map(record => record.detail.rr || 0),
                            borderColor: '#6f42c1',
                            backgroundColor: 'rgba(111, 66, 193, 0.1)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Suhu (°C)',
                            data: data.map(record => record.detail.temp || 0),
                            borderColor: '#fd7e14',
                            backgroundColor: 'rgba(253, 126, 20, 0.1)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }
                    ]
                };

                const chartTitle = hariRawat === 'all' ? 'Tren Vital Signs - Semua Hari Rawat' : `Tren Vital Signs - Hari Rawat Ke-${hariRawat}`;

                const chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            },
                            onClick: function(e, legendItem, legend) {
                                const dataset = legend.chart.data.datasets[legendItem.datasetIndex];
                                dataset.hidden = !dataset.hidden;
                                legend.chart.update();
                            }
                        },
                        title: {
                            display: true,
                            text: chartTitle,
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(0,0,0,0.8)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal dan Jam',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Nilai',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            suggestedMin: 0,
                            suggestedMax: 200,
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.1)'
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                };

                vitalSignsChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: chartOptions
                });
            }
        });
    </script>
@endpush

@push('css')
<style>
    .vital-stats {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    
    .vital-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .vital-item:last-child {
        border-bottom: none;
    }
    
    .vital-item strong {
        color: #495057;
        min-width: 120px;
    }
    
    .vital-item span {
        font-weight: 600;
        color: #212529;
    }
    
    #vitalSignsChart {
        height: 400px !important;
    }
    
    .btn-group .btn {
        font-size: 0.875rem;
    }
    
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
    
    .alert-info {
        border: 1px solid #b8daff;
        background-color: #d1ecf1;
    }
    
    .alert-primary {
        border: 1px solid #b8daff;
        background-color: #cce7ff;
    }
</style>
@endpush