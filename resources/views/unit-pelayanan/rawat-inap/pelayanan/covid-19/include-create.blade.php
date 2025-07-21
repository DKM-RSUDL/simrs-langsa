@push('css')
    <style>
        .section-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .form-content {
                padding: 20px;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
            }

            .main-container {
                margin: 10px;
                border-radius: 15px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle persetujuan untuk selection
            const persetujuanRadios = document.querySelectorAll('input[name="persetujuan_untuk"]');
            const keluargaSection = document.getElementById('keluarga-section');
            const declarantName = document.getElementById('declarant-name');
            const yangMenyatakan = document.getElementById('yang_menyatakan');
            const namaKeluarga = document.getElementById('nama_keluarga');

            persetujuanRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'keluarga') {
                        if (keluargaSection) {
                            keluargaSection.style.display = 'block';
                            keluargaSection.classList.remove('hidden-section');

                            // Make family fields required
                            const familyInputs = keluargaSection.querySelectorAll('input, select, textarea');
                            familyInputs.forEach(input => {
                                input.setAttribute('required', 'required');
                            });
                        }

                        if (declarantName) {
                            declarantName.textContent = 'Akan terisi dari nama keluarga yang diisi';
                        }

                        // Auto-fill declarant name from family name
                        if (namaKeluarga) {
                            namaKeluarga.addEventListener('input', function () {
                                const namaValue = this.value || 'Akan terisi dari nama keluarga yang diisi';
                                if (declarantName) declarantName.textContent = namaValue;
                                if (yangMenyatakan) yangMenyatakan.value = this.value;
                            });
                        }

                    } else if (this.value === 'diri_sendiri') {
                        if (keluargaSection) {
                            keluargaSection.style.display = 'none';
                            keluargaSection.classList.add('hidden-section');

                            // Remove required attribute from family fields
                            const familyInputs = keluargaSection.querySelectorAll('input, select, textarea');
                            familyInputs.forEach(input => {
                                input.removeAttribute('required');
                            });
                        }

                        const pasienName = '{{ $dataMedis->pasien->nama ?? "Nama Pasien" }}';
                        if (declarantName) declarantName.textContent = pasienName;
                        if (yangMenyatakan) yangMenyatakan.value = pasienName;
                    }
                });
            });

        });
    </script>
@endpush