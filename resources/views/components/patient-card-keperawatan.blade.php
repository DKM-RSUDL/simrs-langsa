<div class="position-relative card" style="height:auto;">
    <div class="card-body">
        <div class="status-indicators">
            <div class="status-indicator red"></div>
            <div class="status-indicator orange"></div>
            <div class="status-indicator green"></div>
        </div>

        <div class="patient-photo">
            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
        </div>

        <div class="patient-info">
            <h6 class="text-decoration-underline">{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</h6>
            <p class="mb-0">
                {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
            </p>
            <small>{{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
                ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})</small>

            <div class="patient-meta mt-2">
                <p class="mb-0"><strong>RM: {{ $dataMedis->pasien->kd_pasien }}</strong></p>
                <p class="mb-0"><i
                        class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') }}
                </p>
                <p>
                    <i class="bi bi-hospital"></i>
                    {{ $dataMedis->unit->bagian->bagian }}

                    @if ($dataMedis->unit->kd_bagian == 1)
                        @php
                            $nginap = \App\Models\Nginap::join('unit as u', 'nginap.kd_unit_kamar', '=', 'u.kd_unit')
                                ->where('nginap.kd_pasien', $dataMedis->kd_pasien)
                                ->where('nginap.kd_unit', $dataMedis->kd_unit)
                                ->where('nginap.tgl_masuk', $dataMedis->tgl_masuk)
                                ->where('nginap.urut_masuk', $dataMedis->urut_masuk)
                                ->where('nginap.akhir', 1)
                                ->first();
                        @endphp

                        ({{ $nginap->nama_unit ?? '-' }})
                    @else
                        ({{ $dataMedis->unit->nama_unit }})
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mt-2 patient-card">
    <div class="card-header">
        <h4>Asesmen :</h4>
    </div>
    <div class="card-body">
        <ol class="list-group list-group-flush assessment-list">
            <li class="list-group-item d-flex align-items-center">
                <a href="#riwayat-kesehatan" class="text-decoration-none assessment-link">1. Riwayat Kesehatan</a>
                <!-- Ikon check akan ditambahkan secara dinamis jika section terisi -->
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#pemeriksaan-fisik" class="text-decoration-none assessment-link">2. Pemeriksaan Fisik</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#status-psikologi" class="text-decoration-none assessment-link">3. Status Psikologis</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#status-sosial-budaya" class="text-decoration-none assessment-link">4. Status Sosial Budaya</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#status-spiritual" class="text-decoration-none assessment-link">5. Status Spiritual</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#risiko-jatuh" class="text-decoration-none assessment-link">6. Risiko Jatuh</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#skrining-batuk" class="text-decoration-none assessment-link">7. Skrining Batuk</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#status-gizi" class="text-decoration-none assessment-link">8. Status Gizi</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#status-fungsional" class="text-decoration-none assessment-link">9. Status Fungsional</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#kebutuhan-edukasi" class="text-decoration-none assessment-link">10. Edukasi/Pendidikan Dan
                    Pengajaran</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#rencana-pemulangan" class="text-decoration-none assessment-link">11. Perencanaan Pemulangan
                    Pasien/Discharge Planning</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#keperawatan" class="text-decoration-none assessment-link">12. Daftar Masalah dan Rencana
                    Keperawatan</a>
            </li>
        </ol>
    </div>
</div>


@push('css')
    <style>
        .assessment-list {
            list-style: none;
            padding: 0;
        }

        .assessment-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #dee2e6;
            color: #6c757d;
        }

        .assessment-list li:last-child {
            border-bottom: none;
        }

        .assessment-list li.active {
            color: #0d6efd;
            font-weight: 500;
        }

        .list-group-item {
            background: transparent;
            border: none;
            padding: 0.5rem 0;
        }

        .text-success {
            color: #28a745;
        }

        .assessment-link {
            color: #6c757d;
            display: block;
            width: 100%;
        }

        .assessment-link:hover {
            color: #0d6efd;
        }

        .assessment-link.active {
            color: #0d6efd;
            font-weight: 500;
        }

        .col-md-3 {
            position: relative;
            /* Needed for proper stacking context */
        }

        .patient-card {
            position: sticky;
            top: 20px;
            /* Jarak dari atas ketika sticky */
            z-index: 100;
            /* Memastikan card tetap di atas konten lain */
            background: white;
            /* Memastikan background tidak transparan */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        /* Styling untuk card content agar tetap rapi */
        .patient-card .card-header {
            background: transparent;
            border-bottom: 1px solid #dee2e6;
        }

        .patient-card .card-body {
            max-height: calc(100vh - 200px);
            /* Membatasi tinggi maksimum */
            overflow-y: auto;
            /* Memberi scroll jika konten terlalu panjang */
        }

        /* Smooth scrollbar untuk card body */
        .patient-card .card-body::-webkit-scrollbar {
            width: 6px;
        }

        .patient-card .card-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .patient-card .card-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .patient-card .card-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Memastikan assessment list tetap rapi */
        .assessment-list li:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        /* Optional: Animasi smooth untuk hover state */
        .assessment-link {
            transition: color 0.2s ease;
        }
    </style>
@endpush


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add IDs to all section headers
            document.querySelectorAll('.section-separator').forEach((section, index) => {
                const title = section.querySelector('.section-title').textContent.toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w-]+/g, '');
                section.id = title;
            });

            // Handle smooth scrolling
            document.querySelectorAll('.assessment-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        // Remove active class from all links
                        document.querySelectorAll('.assessment-link').forEach(l => {
                            l.classList.remove('active');
                        });

                        // Add active class to clicked link
                        this.classList.add('active');

                        // Smooth scroll to target
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Highlight current section on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        document.querySelectorAll('.assessment-link').forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${id}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }, {
                threshold: 0.5
            });

            document.querySelectorAll('.section-separator').forEach((section) => {
                observer.observe(section);
            });
        });
    </script>
@endpush
