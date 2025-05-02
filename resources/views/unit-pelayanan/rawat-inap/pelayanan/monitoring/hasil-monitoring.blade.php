{{-- Latest Patient Information Card --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Informasi Pasien</h5>
            <span class="badge bg-primary">Monitoring Terakhir:
                {{ $latestMonitoring ? Carbon\Carbon::parse($latestMonitoring->created_at)->format('d M Y H:i') : '-' }}</span>
        </div>
    </div>
    <div class="card-body">
        @if ($latestMonitoring)
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <div class="mb-2">
                            <span class="text-muted fw-semibold">Diagnosa:</span>
                            <div class="mt-1 px-2 py-1 rounded bg-light">{{ $latestMonitoring->diagnosa ?? '-' }}</div>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted fw-semibold">Indikasi ICCU:</span>
                            <div class="mt-1 px-2 py-1 rounded bg-light">{{ $latestMonitoring->indikasi_iccu ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <div class="mb-2">
                            <span class="text-muted fw-semibold">Berat/Tinggi:</span>
                            <div class="mt-1 px-2 py-1 rounded bg-light">
                                {{ $latestMonitoring->berat_badan ? number_format($latestMonitoring->berat_badan, 1) : '-' }}
                                kg
                                /
                                {{ $latestMonitoring->tinggi_badan ? number_format($latestMonitoring->tinggi_badan, 1) : '-' }}
                                cm
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted fw-semibold">Alergi:</span>
                            <div class="mt-1 px-2 py-1 rounded bg-light">
                                {{ $latestMonitoring->alergi ?? 'Tidak Ada Alergi' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>Belum ada data monitoring untuk pasien ini.
            </div>
        @endif
    </div>
</div>


{{-- Vital Signs Chart dengan Filter Rentang Waktu dan Jam --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"></h5>
            <div>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    <input type="date" id="startDateFilter" class="form-control" placeholder="Dari tanggal">
                    <input type="time" id="startTimeFilter" class="form-control" placeholder="Jam mulai">
                    <span class="input-group-text"><i class="fas fa-arrow-right"></i></span>
                    <input type="date" id="endDateFilter" class="form-control" placeholder="Sampai tanggal">
                    <input type="time" id="endTimeFilter" class="form-control" placeholder="Jam selesai">
                    <button type="button" class="btn btn-primary" id="applyDateRangeFilter">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <button type="button" class="btn btn-outline-secondary ms-1" id="resetFilter">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button type="button" class="btn btn-success ms-1" id="printChartBtn">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div style="height: 400px;">
            <canvas id="vitalSignsChart"></canvas>
        </div>
    </div>
</div>

{{-- Daily Summary Table --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Ringkasan Data Harian {{ $title }}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0" id="dailySummaryTable">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Sistolik (Avg)</th>
                        <th>Diastolik (Avg)</th>
                        <th>HR (Avg)</th>
                        <th>RR (Avg)</th>
                        <th>Suhu (Avg)</th>
                        <th>MAP (Avg)</th>
                        <th>Jumlah Pengukuran</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>


@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Load moment.js jika belum ada
            if (typeof moment === 'undefined') {
                $.getScript('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js', function() {
                    initializeChart();
                });
            } else {
                initializeChart();
            }

            function initializeChart() {
                // Data dari backend
                var monitoringData = @json($allMonitoringRecords ?? []);
                var currentFilteredData = monitoringData; // Untuk menyimpan data hasil filter terakhir
                var filterRangeText = "Semua data"; // Teks filter default

                // Periksa apakah ada data monitoring
                if (!monitoringData || monitoringData.length === 0) {
                    $('#vitalSignsChart').parent().html(
                        '<div class="alert alert-info">Belum ada data monitoring.</div>');
                    $('#dailySummaryTable tbody').html(
                        '<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>');
                    return;
                }

                // Proses data untuk grafik
                processChartData(monitoringData);

                // Filter rentang tanggal dan jam
                $('#applyDateRangeFilter').on('click', function() {
                    var startDate = $('#startDateFilter').val();
                    var startTime = $('#startTimeFilter').val() || '00:00';
                    var endDate = $('#endDateFilter').val();
                    var endTime = $('#endTimeFilter').val() || '23:59';

                    console.log("Rentang waktu yang dipilih:", startDate, startTime, "sampai", endDate,
                        endTime); // Debug

                    if (!startDate || !endDate) {
                        alert("Pilih tanggal mulai dan tanggal akhir terlebih dahulu");
                        return;
                    }

                    // Buat objek DateTime untuk perbandingan
                    var startDateTime = new Date(startDate + 'T' + startTime);
                    var endDateTime = new Date(endDate + 'T' + endTime);

                    // Validasi rentang waktu
                    if (startDateTime > endDateTime) {
                        alert("Tanggal dan jam mulai tidak boleh lebih besar dari tanggal dan jam akhir");
                        return;
                    }

                    // Filter data berdasarkan rentang waktu
                    var filteredData = monitoringData.filter(function(item) {
                        var itemDateTime = new Date(item.tgl_implementasi + 'T' + item
                            .jam_implementasi);
                        return itemDateTime >= startDateTime && itemDateTime <= endDateTime;
                    });

                    console.log("Data setelah difilter:", filteredData.length); // Debug

                    if (filteredData.length === 0) {
                        alert("Tidak ada data pada rentang waktu " +
                            formatReadableDate(startDate) + " " + startTime + " sampai " +
                            formatReadableDate(endDate) + " " + endTime);
                        return;
                    }

                    // Simpan data hasil filter dan teks filter
                    currentFilteredData = filteredData;
                    filterRangeText = formatReadableDate(startDate) + " " + startTime + " s.d " +
                        formatReadableDate(endDate) + " " + endTime;

                    processChartData(filteredData);
                });

                // Reset filter
                $('#resetFilter').on('click', function() {
                    $('#startDateFilter').val('');
                    $('#startTimeFilter').val('');
                    $('#endDateFilter').val('');
                    $('#endTimeFilter').val('');
                    currentFilteredData = monitoringData;
                    filterRangeText = "Semua data";
                    processChartData(monitoringData);
                });

                // Print button handler
                // Print button handler
                // Print button handler
                $('#printChartBtn').on('click', function() {
                    // Dapatkan nilai tanggal dari filter
                    var startDate = $('#startDateFilter').val() || '';
                    var startTime = $('#startTimeFilter').val() || '';
                    var endDate = $('#endDateFilter').val() || '';
                    var endTime = $('#endTimeFilter').val() || '';

                    // Buat URL dengan parameter wajib
                    var printUrl = '{{ route('rawat-inap.monitoring.print', [
                        'kd_unit' => $dataMedis->kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk
                    ]) }}';
                    
                    // Tambahkan parameter tanggal ke URL dengan benar
                    // Periksa apakah URL sudah memiliki parameter
                    var separator = printUrl.includes('?') ? '&' : '?';
                    
                    if (startDate) {
                        printUrl += separator + 'start_date=' + startDate;
                        separator = '&'; // Setelah parameter pertama, selalu gunakan &
                        
                        if (startTime) printUrl += '&start_time=' + startTime;
                    }
                    
                    if (endDate) {
                        printUrl += '&end_date=' + endDate;
                        if (endTime) printUrl += '&end_time=' + endTime;
                    }

                    // Buka window baru untuk print
                    window.open(printUrl, '_blank');
                });
            }
        });

        // Format tanggal menjadi format yang mudah dibaca
        function formatReadableDate(dateString) {
            var parts = dateString.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

        function processChartData(data) {
            console.log("Memproses data:", data.length, "records"); // Debug

            // Urutkan data berdasarkan waktu (asc)
            data = data.sort(function(a, b) {
                var timeA = new Date(a.tgl_implementasi + "T" + a.jam_implementasi);
                var timeB = new Date(b.tgl_implementasi + "T" + b.jam_implementasi);
                return timeA - timeB;
            });

            // Siapkan array untuk data grafik
            var labels = [];
            var sistolikData = [];
            var diastolikData = [];
            var hrData = [];
            var rrData = [];
            var suhuData = [];
            var mapData = [];

            // Ambil data dari setiap record
            data.forEach(function(item) {
                if (!item.detail) {
                    console.log("Item tanpa detail:", item); // Debug
                    return;
                }

                // Format label waktu
                var formattedTime;
                try {
                    // Coba parsing dengan format ISO
                    var dateTime = new Date(item.tgl_implementasi + "T" + item.jam_implementasi);
                    formattedTime = padZero(dateTime.getDate()) + "/" +
                        padZero(dateTime.getMonth() + 1) + " " +
                        padZero(dateTime.getHours()) + ":" +
                        padZero(dateTime.getMinutes());
                } catch (e) {
                    // Fallback ke manual parsing
                    var dateParts = item.tgl_implementasi.split('-');
                    var timeParts = item.jam_implementasi.split(':');
                    formattedTime = padZero(parseInt(dateParts[2])) + "/" +
                        padZero(parseInt(dateParts[1])) + " " +
                        padZero(parseInt(timeParts[0])) + ":" +
                        padZero(parseInt(timeParts[1]));
                }

                labels.push(formattedTime);

                // Ambil nilai vital signs dengan validasi
                sistolikData.push(parseValidNumber(item.detail.sistolik));
                diastolikData.push(parseValidNumber(item.detail.diastolik));
                hrData.push(parseValidNumber(item.detail.hr));
                rrData.push(parseValidNumber(item.detail.rr));
                suhuData.push(parseValidNumber(item.detail.temp));
                mapData.push(parseValidNumber(item.detail.map));
            });

            console.log("Data yang diproses:", labels.length, "label points"); // Debug

            // Buat grafik area seperti pada contoh
            createAreaChart(labels, sistolikData, diastolikData, hrData, rrData, suhuData, mapData);

            // Perbarui tabel ringkasan
            updateSummaryTable(data);
        }

        // Parse nilai menjadi angka yang valid, atau null jika tidak valid
        function parseValidNumber(value) {
            if (value === null || value === undefined || value === '') return null;

            var parsed = parseFloat(value);
            return isNaN(parsed) ? null : parsed;
        }

        // Pad angka dengan 0 di depan jika kurang dari 10
        function padZero(num) {
            return num < 10 ? '0' + num : num;
        }

        function createAreaChart(labels, sistolikData, diastolikData, hrData, rrData, suhuData, mapData) {
            // Hapus chart lama jika ada
            if (window.vitalChart) {
                window.vitalChart.destroy();
            }

            // Dapatkan context canvas
            var ctx = document.getElementById('vitalSignsChart').getContext('2d');

            // Definisi dataset dengan area fill seperti pada contoh
            var datasets = [{
                    label: 'Sistolik',
                    data: sistolikData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Diastolik',
                    data: diastolikData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'HR',
                    data: hrData,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'RR',
                    data: rrData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Suhu',
                    data: suhuData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'MAP',
                    data: mapData,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                }
            ];

            // Buat chart baru dengan area fill
            window.vitalChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    spanGaps: true, // Menghubungkan garis melalui nilai null
                    title: {
                        display: true,
                        text:  '{{ $title }} Tanda Vital Sign',
                        fontSize: 16,
                        fontStyle: 'bold'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Waktu Pengukuran'
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            },
                            gridLines: {
                                color: 'rgba(200, 200, 200, 0.2)'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Nilai'
                            },
                            gridLines: {
                                color: 'rgba(200, 200, 200, 0.2)'
                            },
                            ticks: {
                                beginAtZero: false,
                                min: 0,
                                max: 200,
                                stepSize: 20
                            }
                        }]
                    },
                    elements: {
                        line: {
                            tension: 0.4 // Membuat kurva lebih smooth seperti di contoh
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            });
        }

        function updateSummaryTable(data) {
            // Kelompokkan data berdasarkan tanggal
            var groupedData = {};

            data.forEach(function(item) {
                if (!item.detail) return;

                var date = item.tgl_implementasi;

                if (!groupedData[date]) {
                    groupedData[date] = {
                        sistolik: [],
                        diastolik: [],
                        hr: [],
                        rr: [],
                        suhu: [],
                        map: [],
                        count: 0
                    };
                }

                // Tambahkan nilai ke array untuk perhitungan rata-rata dengan validasi
                if (item.detail.sistolik) {
                    var sistolik = parseFloat(item.detail.sistolik);
                    if (!isNaN(sistolik)) groupedData[date].sistolik.push(sistolik);
                }

                if (item.detail.diastolik) {
                    var diastolik = parseFloat(item.detail.diastolik);
                    if (!isNaN(diastolik)) groupedData[date].diastolik.push(diastolik);
                }

                if (item.detail.hr) {
                    var hr = parseFloat(item.detail.hr);
                    if (!isNaN(hr)) groupedData[date].hr.push(hr);
                }

                if (item.detail.rr) {
                    var rr = parseFloat(item.detail.rr);
                    if (!isNaN(rr)) groupedData[date].rr.push(rr);
                }

                if (item.detail.temp) {
                    var suhu = parseFloat(item.detail.temp);
                    if (!isNaN(suhu)) groupedData[date].suhu.push(suhu);
                }

                if (item.detail.map) {
                    var map = parseFloat(item.detail.map);
                    if (!isNaN(map)) groupedData[date].map.push(map);
                }

                groupedData[date].count++;
            });

            // Ubah menjadi array untuk sorting
            var summaryData = [];

            for (var date in groupedData) {
                summaryData.push({
                    date: date,
                    sistolik: calculateAverage(groupedData[date].sistolik),
                    diastolik: calculateAverage(groupedData[date].diastolik),
                    hr: calculateAverage(groupedData[date].hr),
                    rr: calculateAverage(groupedData[date].rr),
                    suhu: calculateAverage(groupedData[date].suhu),
                    map: calculateAverage(groupedData[date].map),
                    count: groupedData[date].count
                });
            }

            // Urutkan berdasarkan tanggal terbaru
            summaryData.sort(function(a, b) {
                return new Date(b.date) - new Date(a.date);
            });

            // Perbarui tabel
            var tbody = $('#dailySummaryTable tbody');
            tbody.empty();

            if (summaryData.length === 0) {
                tbody.append('<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>');
                return;
            }

            // Tambahkan baris ke tabel
            summaryData.forEach(function(item) {
                var formattedDate = formatDate(item.date);

                tbody.append(`
                <tr>
                    <td>${formattedDate}</td>
                    <td>${item.sistolik}</td>
                    <td>${item.diastolik}</td>
                    <td>${item.hr}</td>
                    <td>${item.rr}</td>
                    <td>${item.suhu}</td>
                    <td>${item.map}</td>
                    <td>${item.count}</td>
                </tr>
            `);
            });
        }

        function calculateAverage(values) {
            if (!values || values.length === 0) return '-';

            var sum = 0;
            var count = 0;

            for (var i = 0; i < values.length; i++) {
                if (!isNaN(values[i])) {
                    sum += values[i];
                    count++;
                }
            }

            if (count === 0) return '-';

            return (sum / count).toFixed(1);
        }

        function formatDate(dateString) {
            var parts = dateString.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

        // Fungsi untuk mendapatkan judul unit
        function getUnitTitle(kdUnit) {
            var unitTitles = {
                '10015': 'Monitoring ICCU',
                '10016': 'Monitoring ICU',
                '10131': 'Monitoring NICU',
                '10132': 'Monitoring PICU'
            };

            return unitTitles[kdUnit] || 'Monitoring Intensive Care';
        }
    </script>
@endpush
