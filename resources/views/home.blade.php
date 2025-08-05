@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
    <style>
        body {
            width: 100%;
        }

        .table-responsive {
            max-height: 300px;
            overflow-y: auto;
        }

        canvas#visitsChart {
            max-height: 300px;
        }

        canvas#queueChart {
            max-height: 250px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .pie-chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }

        .diagnosis-table {
            font-size: 0.9rem;
        }

        .diagnosis-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .diagnosis-table td {
            vertical-align: middle;
        }

        .badge-number {
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.8rem;
            font-weight: bold;
        }

        /* Modern DateTime Card Styles */
        .datetime-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            border: none;
        }

        .date-section {
            background: linear-gradient(135deg, #eaeeff 0%, #f4eaff 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .date-icon {
            color: #000000;
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .day-name {
            color: #000000;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .date-number {
            color: #000000;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 5px;
        }

        .month-year {
            color: #000000;
            font-size: 0.9rem;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .time-section {
            background: linear-gradient(135deg, #f0f5ff, #f1f5f0);
            position: relative;
        }

        .time-icon {
            font-size: 2rem;
            color: #000000;
            margin-bottom: 10px;
        }

        .digital-time {
            font-family: 'Courier New', monospace;
            font-size: 2.8rem;
            font-weight: 700;
            color: #2d3748;
            line-height: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .time-period {
            font-size: 1rem;
            color: #718096;
            font-weight: 500;
            margin-top: 8px;
        }

        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-5">
                <div class="card p-3 mb-4 rounded-lg position-relative">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @if (empty(auth()->user()->karyawan->foto))
                                <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile Picture"
                                    class="rounded-circle w-100 avatar-lg img-fluid"
                                    style="max-width: 100px; height: auto;">
                            @else
                                <img src="https://e-rsudlangsa.id/hrd/user/images/profil/{{ auth()->user()->karyawan->foto }}"
                                    alt="Profile Picture" class="rounded-circle w-100 avatar-lg img-fluid"
                                    style="max-width: 100px; height: auto;">
                            @endif
                        </div>
                        <div class="card-body">
                            <!-- Welcome Message -->
                            <div class="mb-3">
                                <h5 class="text-primary" style="text-align: start; font-size: 1rem; font-weight: 600;">
                                    Selamat Datang!
                                </h5>
                            </div>
                            
                            <!-- User Info -->
                            <h6 class="card-title mb-2" style="font-size: 1.5rem; font-weight: 800; color: #2c3e50;">
                                {{ auth()->user()->name }}
                            </h6>
                            @if (isset(auth()->user()->roles[0]->name))
                                <p class="card-text mb-1" style="font-size: 1rem;">
                                    Roles:
                                    <span class="fw-bold text-dark">{{ auth()->user()->roles[0]->name }}</span>
                                </p>
                            @endif
                            @if (isset(auth()->user()->profile->no_hp))
                                <p class="card-text mb-1" style="font-size: 1rem;">
                                    No Hp:
                                    <span class="fw-bold text-dark">{{ auth()->user()->profile->no_hp }}</span>
                                </p>
                            @endif
                            @if (isset(auth()->user()->email))
                                <p class="card-text mb-2" style="font-size: 1rem;">
                                    Email:
                                    <span class="fw-bold text-dark">{{ auth()->user()->email }}</span>
                                </p>
                            @endif
                            
                            <!-- Social Media Links -->
                            <div class="mt-3 pt-2 border-top">
                                <a href="https://www.instagram.com" target="_blank" class="me-3 text-decoration-none">
                                    <i class="fab fa-instagram fa-lg" style="color: #E4405F;"></i>
                                </a>
                                <a href="https://wa.me/085277678789" target="_blank" class="me-3 text-decoration-none">
                                    <i class="fab fa-whatsapp fa-lg" style="color: #25D366;"></i>
                                </a>
                                <a href="https://www.facebook.com" target="_blank" class="text-decoration-none">
                                    <i class="fab fa-facebook fa-lg" style="color: #1877F2;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="status-badge position-absolute top-0 end-0 mt-2 me-2">
                        <span class="badge bg-light text-success border border-success">
                            <i class="fas fa-circle text-success me-1" style="font-size: 0.6rem;"></i>
                            Online
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 mb-2 rounded-lg position-relative">
                    <div class="row g-0">
                        <!-- Date Section -->
                        <div class="col-6 date-section p-4 text-center position-relative">
                            <div class="date-icon floating">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="day-name" id="dayName">{{ strtoupper(\Carbon\Carbon::now()->locale('id')->dayName) }}</div>
                            <div class="date-number" id="dateNumber">{{ \Carbon\Carbon::now()->format('d') }}</div>
                            <div class="month-year" id="monthYear">{{ strtoupper(\Carbon\Carbon::now()->locale('id')->monthName) }} {{ \Carbon\Carbon::now()->format('Y') }}</div>
                        </div>

                        <!-- Time Section -->
                        <div class="col-6 time-section p-4 text-center">
                            <div class="time-icon floating">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="digital-time" id="digitalTime">{{ \Carbon\Carbon::now()->format('H:i') }}</div>
                            <div class="time-period" id="period">
                                @php
                                    $hour = \Carbon\Carbon::now()->format('H');
                                    if ($hour >= 6 && $hour < 12) echo 'PAGI';
                                    elseif ($hour >= 12 && $hour < 15) echo 'SIANG';
                                    elseif ($hour >= 15 && $hour < 18) echo 'SORE';
                                    else echo 'MALAM';
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-2 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Status RME</h5>
                        <p class="card-text">Sistem Rekam Medis Elektronik RSUD Langsa: <span
                                class="fw-bold text-success">Online</span></p>
                        <a href="#" class="btn btn-primary btn-sm">Cek Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-8">
                <div class="card mb-3 p-4">
                    <div class="row">
                        <div class="col-md-4 p-2">
                            <a href="{{ route('rawat-jalan.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-wheelchair fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rawat Jalan</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Rawat Jalan')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('rawat-inap.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-procedures fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rawat Inap</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Rawat Inap')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('gawat-darurat.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-truck-medical fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Gawat Darurat</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Gawat Darurat')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('operasi.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-person-dots-from-line fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Bedah Sentral</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Bedah Sentral')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('hemodialisa.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-lungs fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Hemodialisa</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Hemodialisa')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="#" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-flask fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Cathlab</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Cathlab')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('forensik.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-magnifying-glass fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Forensik</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Forensik')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('rehab-medis.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-notes-medical fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rehab Medik</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Rehab Medik')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="#" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-mortar-pestle fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Gizi Klinis</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">{{ $visits->where('unit.nama_unit', 'Gizi Klinis')->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 p-4">
                    <h5 class="card-title mb-3">Status Antrian Pasien (Dummy)</h5>
                    <div class="pie-chart-container">
                        <canvas id="queueChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Menunggu</small>
                                <div class="fw-bold text-warning">15</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Proses</small>
                                <div class="fw-bold text-info">8</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Selesai</small>
                                <div class="fw-bold text-success">32</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-8">
                <div class="card p-3 mb-4 rounded-lg position-relative">
                    <h5 class="card-title mb-3">Total Kunjungan Pasien - Tahun 2025</h5>
                    <div class="chart-container">
                        <canvas id="visitsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 p-3">
                    <h5 class="card-title mb-3">Top 10 Diagnosis (Dummy)</h5>
                    <div class="table-responsive">
                        <table class="table table-sm diagnosis-table">
                            <thead>
                                <tr>
                                    <th scope="col" width="15%">#</th>
                                    <th scope="col" width="60%">Diagnosis</th>
                                    <th scope="col" width="25%" class="text-center">Kasus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">1</span>
                                    </td>
                                    <td>Hipertensi Esensial</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">127</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">2</span>
                                    </td>
                                    <td>Diabetes Mellitus Tipe 2</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">98</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">3</span>
                                    </td>
                                    <td>ISPA (Infeksi Saluran Pernapasan Atas)</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">85</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">4</span>
                                    </td>
                                    <td>Gastritis</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">72</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">5</span>
                                    </td>
                                    <td>Demam Berdarah Dengue</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">64</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">6</span>
                                    </td>
                                    <td>Asma Bronkial</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">58</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">7</span>
                                    </td>
                                    <td>Penyakit Jantung Koroner</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">45</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">8</span>
                                    </td>
                                    <td>Diare Akut</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">41</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">9</span>
                                    </td>
                                    <td>Stroke Iskemik</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">38</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge badge-number bg-secondary text-white">10</span>
                                    </td>
                                    <td>Pneumonia</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">35</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

            // Update clock every second
            function updateClock() {
                const now = new Date();
                
                // Indonesian day and month names
                const days = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
                const months = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 
                               'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
                
                const dayName = days[now.getDay()];
                const date = now.getDate().toString().padStart(2, '0');
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                
                // Determine period
                let period = 'PAGI';
                const hour = now.getHours();
                if (hour >= 12 && hour < 15) period = 'SIANG';
                else if (hour >= 15 && hour < 18) period = 'SORE';
                else if (hour >= 18 || hour < 6) period = 'MALAM';
                
                // Update elements
                const dayNameEl = document.getElementById('dayName');
                const dateNumberEl = document.getElementById('dateNumber');
                const monthYearEl = document.getElementById('monthYear');
                const digitalTimeEl = document.getElementById('digitalTime');
                const periodEl = document.getElementById('period');
                
                if (dayNameEl) dayNameEl.textContent = dayName;
                if (dateNumberEl) dateNumberEl.textContent = date;
                if (monthYearEl) monthYearEl.textContent = `${month} ${year}`;
                if (digitalTimeEl) digitalTimeEl.textContent = `${hours}:${minutes}`;
                if (periodEl) periodEl.textContent = period;
            }

            // Update immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);


            // Chart Kunjungan Pasien (Bar Chart)
            const ctx = document.getElementById('visitsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Total Kunjungan Pasien',
                        data: @json($chartData),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)', // Sep
                            'rgba(54, 162, 235, 0.6)', // Oct
                            'rgba(54, 162, 235, 0.6)', // Nov
                            'rgba(54, 162, 235, 0.6)', // Dec
                            
                            'rgba(54, 162, 235, 0.6)', // Sep
                            'rgba(54, 162, 235, 0.6)', // Oct
                            'rgba(54, 162, 235, 0.6)', // Nov
                            'rgba(54, 162, 235, 0.6)', // Dec
                            
                            'rgba(54, 162, 235, 0.6)', // Sep
                            'rgba(54, 162, 235, 0.6)', // Oct
                            'rgba(54, 162, 235, 0.6)', // Nov
                            'rgba(54, 162, 235, 0.6)', // Dec
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            cornerRadius: 5,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            ticks: {
                                stepSize: 2,
                                color: '#666',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.1)',
                                lineWidth: 1
                            }
                        },
                        x: {
                            ticks: {
                                color: '#666',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 20,
                            right: 20,
                            bottom: 20,
                            left: 20
                        }
                    }
                }
            });

            // Chart Status Antrian (Pie Chart)
            const queueCtx = document.getElementById('queueChart').getContext('2d');
            new Chart(queueCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Dalam Proses', 'Selesai'],
                    datasets: [{
                        data: [15, 8, 32],
                        backgroundColor: [
                            'rgba(255, 193, 7, 0.8)', // Warning - Menunggu
                            'rgba(13, 202, 240, 0.8)', // Info - Proses
                            'rgba(25, 135, 84, 0.8)' // Success - Selesai
                        ],
                        borderColor: [
                            'rgba(255, 193, 7, 1)',
                            'rgba(13, 202, 240, 1)',
                            'rgba(25, 135, 84, 1)'
                        ],
                        borderWidth: 2,
                        cutout: '60%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            cornerRadius: 5,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        });
    </script>
@endpush