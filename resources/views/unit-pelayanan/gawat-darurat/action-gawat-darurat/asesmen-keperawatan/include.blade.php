    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
            }

            .header-asesmen {
                margin-top: 1rem;
                font-size: 1.5rem;
                font-weight: 600;
            }

            .progress-wrapper {
                background: #f8f9fa;
                border-radius: 8px;
            }

            .progress-status {
                display: flex;
                justify-content: space-between;
            }

            .progress-label {
                color: #6c757d;
                font-size: 14px;
                font-weight: 500;
            }

            .progress-percentage {
                color: #198754;
                font-weight: 600;
            }

            .custom-progress {
                height: 8px;
                background-color: #e9ecef;
                border-radius: 4px;
                overflow: hidden;
            }

            .progress-bar-custom {
                height: 100%;
                background-color: #097dd6;
                transition: width 0.6s ease;
            }

            .section-separator {
                border-top: 2px solid #097dd6;
                margin: 2rem 0;
                padding-top: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
            }

            .form-group {
                margin-bottom: 1rem;
                display: flex;
                align-items: flex-start;
            }

            .form-group label {
                margin-right: 1rem;
                padding-top: 0.5rem;
            }

            .diagnosis-section {
                margin-top: 1.5rem;
            }

            .diagnosis-row {
                padding: 0.5rem 1rem;
                border-color: #dee2e6 !important;
            }

            .diagnosis-item {
                background-color: transparent;
            }

            .border-top {
                border-top: 1px solid #dee2e6 !important;
            }

            .border-bottom {
                border-bottom: 1px solid #dee2e6 !important;
            }

            .form-check {
                margin: 0;
                padding-left: 1.5rem;
                min-height: auto;
            }

            .form-check-input {
                margin-top: 0.3rem;
            }

            .form-check label {
                margin-right: 0;
                padding-top: 0;
            }

            .btn-outline-primary {
                color: #097dd6;
                border-color: #097dd6;
            }

            .btn-outline-primary:hover {
                background-color: #097dd6;
                color: white;
            }

            .pain-scale-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
            }

            .pain-scale-image {
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
            }
        </style>
    @endpush

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tglAsesmen = document.getElementById('tgl_asesmen_keperawatan');
                const jamAsesmen = document.getElementById('jam_asesmen_keperawatan');

                tglAsesmen.addEventListener('change', function(e) {
                    // Handle date change
                });

                jamAsesmen.addEventListener('change', function(e) {
                    // Handle time change
                });

                // Mengambil semua checkbox diagnosis
                const diagnosisCheckboxes = document.querySelectorAll('.diagnosis-checkbox');

                diagnosisCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        // Mengambil ID checkbox Aktual dan Risiko terkait
                        const aktualId = this.dataset.aktual;
                        const risikoId = this.dataset.risiko;

                        const aktualCheckbox = document.getElementById(aktualId);
                        const risikoCheckbox = document.getElementById(risikoId);

                        if (this.checked) {
                            // Jika diagnosis dicentang, aktifkan checkbox Aktual & Risiko
                            aktualCheckbox.disabled = false;
                            risikoCheckbox.disabled = false;
                        } else {
                            // Jika diagnosis tidak dicentang, nonaktifkan dan hapus centang Aktual & Risiko
                            aktualCheckbox.disabled = true;
                            risikoCheckbox.disabled = true;
                            aktualCheckbox.checked = false;
                            risikoCheckbox.checked = false;
                        }
                    });
                });

                // Inisialisasi status awal checkbox Aktual & Risiko
                diagnosisCheckboxes.forEach(checkbox => {
                    const aktualId = checkbox.dataset.aktual;
                    const risikoId = checkbox.dataset.risiko;

                    const aktualCheckbox = document.getElementById(aktualId);
                    const risikoCheckbox = document.getElementById(risikoId);

                    // Nonaktifkan checkbox Aktual & Risiko jika diagnosis belum dipilih
                    if (!checkbox.checked) {
                        aktualCheckbox.disabled = true;
                        risikoCheckbox.disabled = true;
                    }
                });

            });
        </script>
    @endpush
