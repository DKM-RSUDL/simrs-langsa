<div class="position-relative patient-card">
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
                    class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') }}</p>
            <p><i class="bi bi-hospital"></i>{{ $dataMedis->unit->bagian->bagian }} ({{ $dataMedis->unit->nama_unit }})
            </p>
        </div>
    </div>
</div>

<div class="mt-2 patient-card">
    <div class="card-header">
        <h4>Asesmen :</h4>
    </div>
    <div class="card-body">
        <ol class="list-group list-group-flush assessment-list">
            <li class="list-group-item">
                <a href="#data-masuk" class="text-decoration-none assessment-link">1. Data Masuk</a>
            </li>
            <li class="list-group-item">
                <a href="#identitas-bayi" class="text-decoration-none assessment-link">2. Identitas Bayi</a>
            </li>
            <li class="list-group-item">
                <a href="#anamnesis" class="text-decoration-none assessment-link">3. Anamnesis</a>
            </li>
            <li class="list-group-item">
                <a href="#pemeriksaan-fisik" class="text-decoration-none assessment-link">3. Pemeriksaan Fisik</a>
            </li>
            <li class="list-group-item">
                <a href="#riwayat-kesehatan" class="text-decoration-none assessment-link">4. Riwayat Kesehatan Ibu</a>
            </li>
            <li class="list-group-item">
                <a href="#riwayat-kesehatan" class="text-decoration-none assessment-link">5. Riwayat Kesehatan</a>
            </li>
            <li class="list-group-item">
                <a href="#status-nyeri" class="text-decoration-none assessment-link">6. Status Nyeri</a>
            </li>
            <li class="list-group-item">
                <a href="#alergi" class="text-decoration-none assessment-link">7. Alergi</a>
            </li>
            <li class="list-group-item">
                <a href="#risiko-jatuh" class="text-decoration-none assessment-link">8. Risiko Jatuh</a>
            </li>
            <li class="list-group-item">
                <a href="#decubitus" class="text-decoration-none assessment-link">9. Risiko Decubitus</a>
            </li>
            <li class="list-group-item">
                <a href="#status-gizi" class="text-decoration-none assessment-link">10. Status Gizi</a>
            </li>
            <li class="list-group-item">
                <a href="#status-fungsional" class="text-decoration-none assessment-link">11. Status Fungsional</a>
            </li>
            <li class="list-group-item">
                <a href="#kebutuhan-edukasi" class="text-decoration-none assessment-link">12. Kebutuhan Edukasi</a>
            </li>
            <li class="list-group-item">
                <a href="#discharge-planning" class="text-decoration-none assessment-link">13. Discharge Planning</a>
            </li>
            <li class="list-group-item">
                <a href="#diagnosis" class="text-decoration-none assessment-link">14. Diagnosis</a>
            </li>
            <li class="list-group-item">
                <a href="#implementasi" class="text-decoration-none assessment-link">15. Implementasi</a>
            </li>
            <li class="list-group-item">
                <a href="#evaluasi" class="text-decoration-none assessment-link">16. Evaluasi</a>
            </li>
        </ol>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                            l.parentElement.classList.remove('active');
                        });

                        // Add active class to clicked link
                        this.classList.add('active');
                        this.parentElement.classList.add('active');

                        // Calculate offset to account for fixed header if any
                        const offset = 20; // Adjust this value based on your header height
                        const targetPosition = targetElement.getBoundingClientRect().top + window
                            .pageYOffset - offset;

                        // Smooth scroll to target
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Highlight current section on scroll
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.5
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        document.querySelectorAll('.assessment-link').forEach(link => {
                            link.classList.remove('active');
                            link.parentElement.classList.remove('active');
                            if (link.getAttribute('href') === `#${id}`) {
                                link.classList.add('active');
                                link.parentElement.classList.add('active');
                            }
                        });
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.section-separator').forEach((section) => {
                observer.observe(section);
            });
        });
    </script>
@endpush


@push('css')
    <style>
        /* Existing styles */
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

        /* Modify active state styling */
        .assessment-list li.active {
            background-color: transparent;
            /* Remove background color */
        }

        .assessment-list li.active .assessment-link {
            color: #0d6efd;
            font-weight: 500;
            position: relative;
        }

        /* Add subtle indicator for active state */
        .assessment-list li.active::before {
            content: '';
            position: absolute;
            left: -10px;
            width: 3px;
            height: 100%;
            background-color: #0d6efd;
        }

        .assessment-link {
            color: #6c757d;
            display: block;
            width: 100%;
            transition: all 0.2s ease;
            padding: 4px 0;
        }

        .assessment-link:hover {
            color: #0d6efd;
            text-decoration: none;
            padding-left: 5px;
        }

        /* Remove background color on hover */
        .assessment-list li:hover {
            background-color: transparent;
        }

        /* Other existing styles remain the same */
        .patient-card {
            position: sticky;
            top: 20px;
            z-index: 100;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .patient-card .card-header {
            background: transparent;
            border-bottom: 1px solid #dee2e6;
        }

        .patient-card .card-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        /* Scrollbar styling */
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
    </style>
@endpush
