@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
    <style>
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .diagnosis-table th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
@endpush

@section('content')
    <!-- Welcome Card with DateTime -->
    <div class="row">
        <div class="col-12">
            <x-content-card>
                <div class="row align-items-center g-3">
                    <!-- Profile Section -->
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                @if (empty(auth()->user()->karyawan->foto))
                                    <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile Picture"
                                        class="rounded-circle border border-white border-3" width="80" height="80"
                                        style="object-fit: cover; size: cover; aspect-ratio: 1/1;">
                                @else
                                    <img src="https://e-rsudlangsa.id/hrd/user/images/profil/{{ auth()->user()->karyawan->foto }}"
                                        alt="Profile Picture" class="rounded-circle border border-white border-3"
                                        width="80" height="80"
                                        style="object-fit: cover; size: cover; aspect-ratio: 1/1;">
                                @endif
                            </div>
                            <div>
                                <small>Selamat Datang!</small>
                                <h4 class="fw-bold mb-2">{{ auth()->user()->name }}</h4>
                                <div class="d-flex gap-3 flex-wrap small">
                                    @if (isset(auth()->user()->roles[0]->name))
                                        <span><i class="bi bi-person-badge me-1"></i>
                                            {{ auth()->user()->roles[0]->name }}</span>
                                    @endif
                                    @if (isset(auth()->user()->karyawan->email))
                                        <span><i class="bi bi-envelope me-1"></i> {{ auth()->user()->karyawan->email }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DateTime Section -->
                    <div class="col-md-4 text-end">
                        <div class="mb-2">
                            <span class="fw-semibold" id="fullDate">
                                {{ strtoupper(\Carbon\Carbon::now()->locale('id')->dayName) }},
                                {{ \Carbon\Carbon::now()->format('d') }}
                                {{ strtoupper(\Carbon\Carbon::now()->locale('id')->monthName) }}
                                {{ \Carbon\Carbon::now()->format('Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="fw-bold fs-4" id="digitalTime">
                                {{ \Carbon\Carbon::now()->format('H:i:s') }}
                            </span>
                            <small class="ms-2" id="period">
                                @php
                                    $hour = \Carbon\Carbon::now()->format('H');
                                    if ($hour >= 6 && $hour < 12) {
                                        echo 'PAGI';
                                    } elseif ($hour >= 12 && $hour < 15) {
                                        echo 'SIANG';
                                    } elseif ($hour >= 15 && $hour < 18) {
                                        echo 'SORE';
                                    } else {
                                        echo 'MALAM';
                                    }
                                @endphp
                            </small>
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>

    <!-- Unit Stats Cards -->
    <div class="row">
        @php
            // Determine if current user is an admin (allow admins to see everything)
            $isAdmin = false;
            if (auth()->check()) {
                // $roleName = optional(optional(auth()->user())->roles[0])->name;
                $roleName = isset(auth()->user()->roles[0]->name) ? auth()->user()->roles[0]->name : null;
                $isAdmin = $roleName && in_array(strtolower($roleName), ['admin', 'administrator']);
            }

            // Add a permission key for each unit so we can check role access similar to navigation.blade.php
            // Permission strings follow the same convention used in navigation (e.g. the menu/url slug)
            $units = [
                [
                    'name' => 'Rawat Jalan',
                    'icon' => 'fa-wheelchair',
                    'color' => 'primary',
                    'route' => 'rawat-jalan.index',
                    'permission' => 'unit-pelayanan/rawat-jalan',
                    'count' => countActivePatientAllRajal(),
                ],
                [
                    'name' => 'Rawat Inap',
                    'icon' => 'fa-procedures',
                    'color' => 'success',
                    'route' => 'rawat-inap.index',
                    'permission' => 'unit-pelayanan/rawat-inap',
                    'count' => countAktivePatientAllRanap(),
                ],
                [
                    'name' => 'Gawat Darurat',
                    'icon' => 'fa-truck-medical',
                    'color' => 'danger',
                    'route' => 'gawat-darurat.index',
                    'permission' => 'unit-pelayanan/gawat-darurat',
                    'count' => countActivePatientIGD(),
                ],
                [
                    'name' => 'Bedah Sentral',
                    'icon' => 'fa-person-dots-from-line',
                    'color' => 'warning',
                    'route' => 'operasi.index',
                    'permission' => 'unit-pelayanan/operasi',
                    // 'count' => $visits->where('unit.kd_unit', '71')->count(),
                    'count' => 0,
                ],
                [
                    'name' => 'Hemodialisa',
                    'icon' => 'fa-lungs',
                    'color' => 'info',
                    'route' => 'hemodialisa.index',
                    'permission' => 'unit-pelayanan/hemodialisa',
                    // 'count' => $visits->where('unit.kd_unit', '71')->count(),
                    'count' => 0,
                ],
                // [
                //     'name' => 'Cathlab',
                //     'icon' => 'fa-flask',
                //     'color' => 'secondary',
                //     'route' => null,
                //     'permission' => null,
                //     'count' => $visits->where('unit.nama_unit', 'Cathlab')->count(),
                // ],
                [
                    'name' => 'Forensik',
                    'icon' => 'fa-magnifying-glass',
                    'color' => 'dark',
                    'route' => 'forensik.index',
                    'permission' => 'unit-pelayanan/forensik',
                    // 'count' => $visits->where('unit.kd_unit', '76')->count(),
                    'count' => 0,
                ],
                [
                    'name' => 'Rehab Medik',
                    'icon' => 'fa-notes-medical',
                    'color' => 'primary',
                    'route' => 'rehab-medis.index',
                    'permission' => 'unit-pelayanan/rehab-medis',
                    // 'count' => $visits->where('unit.nama_unit', 'Rehab Medik')->count(),
                    'count' => 0,
                ],
                // [
                //     'name' => 'Gizi Klinis',
                //     'icon' => 'fa-mortar-pestle',
                //     'color' => 'success',
                //     'route' => null,
                //     'permission' => null,
                //     'count' => $visits->where('unit.nama_unit', 'Gizi Klinis')->count(),
                // ],
            ];
        @endphp

        @foreach ($units as $unit)
            {{-- If a permission is provided, show the unit when the user can read it OR when user is admin. Otherwise show by default. --}}
            @if (!empty($unit['permission']))
                @if (
                    $isAdmin ||
                        auth()->user()
                            ?->can('read ' . $unit['permission']))
                    <div class="col-6 col-md-4 col-lg-3">
                        @if ($unit['route'])
                            <a href="{{ route($unit['route']) }}" class="text-decoration-none">
                            @else
                                <a href="#" class="text-decoration-none">
                        @endif
                        <x-content-card>
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $unit['color'] }} text-white rounded p-3 me-3">
                                    <i class="fa {{ $unit['icon'] }} fa-lg"></i>
                                </div>
                                <div>
                                    <small class="fw-semibold">{{ $unit['name'] }}</small>
                                    <h5 class="fw-bold mb-0">{{ $unit['count'] }}</h5>
                                </div>
                            </div>
                        </x-content-card>
                        </a>
                    </div>
                @endif
            @else
                {{-- Render items without specific permission for everyone --}}
                <div class="col-6 col-md-4 col-lg-3">
                    @if ($unit['route'])
                        <a href="{{ route($unit['route']) }}" class="text-decoration-none">
                        @else
                            <a href="#" class="text-decoration-none">
                    @endif
                    <x-content-card>
                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $unit['color'] }} text-white rounded p-3 me-3">
                                <i class="fa {{ $unit['icon'] }} fa-lg"></i>
                            </div>
                            <div>
                                <small class="fw-semibold">{{ $unit['name'] }}</small>
                                <h5 class="fw-bold mb-0">{{ $unit['count'] }}</h5>
                            </div>
                        </div>
                    </x-content-card>
                    </a>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Antrian & Diagnosis -->
    <div class="row mb-4">
        <!-- Status Antrian -->
        <div class="col-md-6">
            <div class="card h-100 border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Status Antrian Pasien</h5>
                    <div class="chart-container">
                        <canvas id="queueChart"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Menunggu</small>
                                <div class="fw-bold text-warning fs-5">15</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Proses</small>
                                <div class="fw-bold text-info fs-5">8</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Selesai</small>
                                <div class="fw-bold text-success fs-5">32</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 10 Diagnosis -->
        <div class="col-md-6">
            <div class="card h-100 border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Top 10 Diagnosis</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover diagnosis-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="10%">#</th>
                                    <th scope="col" width="65%">Diagnosis</th>
                                    <th scope="col" width="25%" class="text-center">Kasus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">1</span></td>
                                    <td>Hipertensi Esensial</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">127</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">2</span></td>
                                    <td>Diabetes Mellitus Tipe 2</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">98</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">3</span></td>
                                    <td>ISPA</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">85</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">4</span></td>
                                    <td>Gastritis</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">72</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">5</span></td>
                                    <td>Demam Berdarah Dengue</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">64</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">6</span></td>
                                    <td>Asma Bronkial</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">58</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">7</span></td>
                                    <td>Penyakit Jantung Koroner</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">45</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">8</span></td>
                                    <td>Diare Akut</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">41</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">9</span></td>
                                    <td>Stroke Iskemik</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">38</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge rounded-pill bg-primary">10</span></td>
                                    <td>Pneumonia</td>
                                    <td class="text-center"><span class="badge bg-light text-dark">35</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kunjungan Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Total Kunjungan Pasien - Tahun 2025</h5>
                    <div class="chart-container">
                        <canvas id="visitsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update clock
            function updateClock() {
                const now = new Date();
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                const dayName = days[now.getDay()];
                const date = now.getDate().toString().padStart(2, '0');
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');

                let period = 'Pagi';
                const hour = now.getHours();
                if (hour >= 12 && hour < 15) period = 'Siang';
                else if (hour >= 15 && hour < 18) period = 'Sore';
                else if (hour >= 18 || hour < 6) period = 'Malam';

                const fullDateEl = document.getElementById('fullDate');
                const digitalTimeEl = document.getElementById('digitalTime');
                const periodEl = document.getElementById('period');

                if (fullDateEl) fullDateEl.textContent = `${dayName}, ${date} ${month} ${year}`;
                if (digitalTimeEl) digitalTimeEl.textContent = `${hours}:${minutes}:${seconds}`;
                if (periodEl) periodEl.textContent = period;
            }

            updateClock();
            setInterval(updateClock, 1000);

            // Chart Kunjungan
            const ctx = document.getElementById('visitsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Total Kunjungan',
                        data: @json($chartData),
                        backgroundColor: 'rgba(13, 110, 253, 0.8)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart Antrian
            const queueCtx = document.getElementById('queueChart').getContext('2d');
            new Chart(queueCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Dalam Proses', 'Selesai'],
                    datasets: [{
                        data: [15, 8, 32],
                        backgroundColor: ['#ffc107', '#0dcaf0', '#198754'],
                        borderWidth: 2,
                        cutout: '65%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
