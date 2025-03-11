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
            <li class="list-group-item d-flex align-items-center">
                <a href="#data-masuk" class="text-decoration-none assessment-link">1. Data Masuk</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#anamnesis" class="text-decoration-none assessment-link">2. Anamnesis</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#pemeriksaan-fisik" class="text-decoration-none assessment-link">3. Pemeriksaan Fisik</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#riwayat-kesehatan" class="text-decoration-none assessment-link">4. Riwayat Kesehatan</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#riwayat-penggunaan-obat" class="text-decoration-none assessment-link">5. Riwayat Penggunaan
                    Obat</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#alergi" class="text-decoration-none assessment-link">6. Alergi</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#hasil-pemeriksaan-penunjang" class="text-decoration-none assessment-link">7. Hasil Pemeriksaan
                    Penunjang</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#discharge-planning" class="text-decoration-none assessment-link">8. Discharge Planning</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#diagnosis" class="text-decoration-none assessment-link">9. Diagnosis</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#implementasi" class="text-decoration-none assessment-link">10. Implementasi</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="#evaluasi" class="text-decoration-none assessment-link">11. Evaluasi</a>
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
        // baru dari anas
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengecek apakah suatu section sudah lengkap
            function isSectionComplete(section) {
                // Ambil semua field yang terlihat (abaikan input hidden)
                const fields = section.querySelectorAll('input:not([type="hidden"]), select, textarea');
                if (fields.length === 0) return true; // Bila tidak ada field, anggap sudah lengkap

                for (let field of fields) {
                    // Untuk input file, pastikan sudah ada file yang dipilih
                    if (field.type === 'file') {
                        if (field.files.length === 0) return false;
                    }
                    // Untuk checkbox atau radio (jika diperlukan), cek apakah sudah dicentang
                    else if ((field.type === 'checkbox' || field.type === 'radio') && field.required) {
                        if (!field.checked) return false;
                    }
                    // Untuk field lainnya, cek jika nilainya kosong
                    else {
                        if (!field.value || field.value.trim() === '') {
                            return false;
                        }
                    }
                }
                return true;
            }

            // Fungsi untuk memperbarui tampilan daftar asesmen
            function updateAssessmentList() {
                // Array daftar section beserta id-nya (urutan sesuai daftar asesmen)
                const sections = [
                    'data-masuk',
                    'anamnesis',
                    'pemeriksaan-fisik',
                    'riwayat-kesehatan',
                    'riwayat-penggunaan-obat',
                    'alergi',
                    'hasil-pemeriksaan-penunjang',
                    'discharge-planning',
                    'diagnosis',
                    'implementasi',
                    'evaluasi'
                ];

                sections.forEach((sectionId, index) => {
                    const section = document.getElementById(sectionId);
                    // Cari list item yang sesuai dengan urutan (misalnya index ke-0 untuk section pertama)
                    const listItem = document.querySelectorAll('.assessment-list li')[index];

                    // Jika section ada dan sudah lengkap, tambahkan ikon centang jika belum ada
                    if (section && isSectionComplete(section)) {
                        if (!listItem.querySelector('.ti-check-box')) {
                            const icon = document.createElement('i');
                            icon.className = 'ti-check-box text-success ms-auto';
                            listItem.appendChild(icon);
                        }
                    } else {
                        // Jika section belum lengkap, pastikan ikon centang dihapus
                        const icon = listItem.querySelector('.ti-check-box');
                        if (icon) {
                            icon.remove();
                        }
                    }
                });
            }

            // Panggil fungsi updateAssessmentList saat halaman dimuat
            updateAssessmentList();

            // Pasang event listener pada setiap field di tiap section form agar update berjalan realtime
            const sectionIds = [
                'data-masuk',
                'anamnesis',
                'pemeriksaan-fisik',
                'riwayat-kesehatan',
                'riwayat-penggunaan-obat',
                'alergi',
                'hasil-pemeriksaan-penunjang',
                'discharge-planning',
                'diagnosis',
                'implementasi',
                'evaluasi'
            ];

            sectionIds.forEach(id => {
                const section = document.getElementById(id);
                if (section) {
                    const fields = section.querySelectorAll('input:not([type="hidden"]), select, textarea');
                    fields.forEach(field => {
                        field.addEventListener('input', updateAssessmentList);
                        field.addEventListener('change', updateAssessmentList);
                    });
                }
            });
        });


        // lama
        // document.addEventListener('DOMContentLoaded', function () {
        //     // Add IDs to all section headers
        //     document.querySelectorAll('.section-separator').forEach((section, index) => {
        //         const title = section.querySelector('.section-title').textContent.toLowerCase()
        //             .replace(/\s+/g, '-')
        //             .replace(/[^\w-]+/g, '');
        //         section.id = title;
        //     });

        //     // Handle smooth scrolling
        //     document.querySelectorAll('.assessment-link').forEach(link => {
        //         link.addEventListener('click', function (e) {
        //             e.preventDefault();
        //             const targetId = this.getAttribute('href');
        //             const targetElement = document.querySelector(targetId);

        //             if (targetElement) {
        //                 // Remove active class from all links
        //                 document.querySelectorAll('.assessment-link').forEach(l => {
        //                     l.classList.remove('active');
        //                 });

        //                 // Add active class to clicked link
        //                 this.classList.add('active');

        //                 // Smooth scroll to target
        //                 targetElement.scrollIntoView({
        //                     behavior: 'smooth',
        //                     block: 'start'
        //                 });
        //             }
        //         });
        //     });

        //     // Highlight current section on scroll
        //     const observer = new IntersectionObserver((entries) => {
        //         entries.forEach(entry => {
        //             if (entry.isIntersecting) {
        //                 const id = entry.target.id;
        //                 document.querySelectorAll('.assessment-link').forEach(link => {
        //                     link.classList.remove('active');
        //                     if (link.getAttribute('href') === `#${id}`) {
        //                         link.classList.add('active');
        //                     }
        //                 });
        //             }
        //         });
        //     }, {
        //         threshold: 0.5
        //     });

        //     document.querySelectorAll('.section-separator').forEach((section) => {
        //         observer.observe(section);
        //     });
        // });
    </script>
@endpush
