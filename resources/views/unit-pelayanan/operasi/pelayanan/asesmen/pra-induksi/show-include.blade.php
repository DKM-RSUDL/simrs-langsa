@php
    if (!function_exists('getAvpuText')) {
        function getAvpuText($value)
        {
            switch ($value) {
                case 0:
                    return 'Sadar Baik/Alert : 0';
                case 1:
                    return 'Berespon dengan kata-kata/Voice: 1';
                case 2:
                    return 'Hanya berespon jika dirangsang nyeri/pain: 2';
                case 3:
                    return 'Pasien tidak sadar/unresponsive: 3';
                case 4:
                    return 'Gelisah atau bingung: 4';
                case 5:
                    return 'Acute Confusional States: 5';
                default:
                    return '';
            }
        }
    }

    if (!function_exists('getDukunganOksigenText')) {
        function getDukunganOksigenText($value)
        {
            switch ($value) {
                case 1:
                    return 'Udara Bebas';
                case 2:
                    return 'Kanul Nasal';
                case 3:
                    return 'Simple Mark';
                case 4:
                    return 'Rebreathing Mark';
                case 5:
                    return 'No-Rebreathing Mark';
                default:
                    return '';
            }
        }
    }
@endphp

@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        // 5. Pemantauan Selama Anestesi dan Sedasi (PSAS)
        document.addEventListener('DOMContentLoaded', function () {
            // Direct JSON initialization for chart display
            const jsonData = @json($okPraInduksi->okPraInduksiPsas->all_monitoring_data ?? '[]');
            let monitoringData = [];

            try {
                monitoringData = JSON.parse(jsonData);
                if (!Array.isArray(monitoringData)) {
                    monitoringData = [];
                    console.error('Parsed data is not an array');
                }
            } catch (error) {
                console.error('Error parsing JSON data:', error);
            }

            // Extract chart data directly from the parsed JSON
            const chartLabels = monitoringData.map(item => item.time || '');
            const tekananDarahData = monitoringData.map(item => item.tekananDarah || 0);
            const nadiData = monitoringData.map(item => item.nadi || 0);
            const nafasData = monitoringData.map(item => item.nafas || 0);
            const spo2Data = monitoringData.map(item => item.spo2 || 0);

            console.log('Monitoring data:', monitoringData);
            console.log('Chart labels:', chartLabels);
            console.log('Data arrays:', {
                tekananDarah: tekananDarahData,
                nadi: nadiData,
                nafas: nafasData,
                spo2: spo2Data
            });

            // Get chart element
            const chartElement = document.getElementById('vitalSignsChartPSAS');

            if (!chartElement) {
                console.error('Chart element not found');
                return;
            }

            const ctx = chartElement.getContext('2d');

            // Create chart
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: 'Tekanan Darah',
                            data: tekananDarahData,
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
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        });
    </script>
@endpush
