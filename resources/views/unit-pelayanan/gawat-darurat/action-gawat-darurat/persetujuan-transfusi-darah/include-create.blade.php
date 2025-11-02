@push('css')
    <style>
        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 900px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-weight: 600;
        }

        .hospital-info {
            font-size: 14px;
            margin-top: 10px;
            opacity: 0.9;
        }

        .form-content {
            padding: 40px;
        }

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

        .section-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .section-title i {
            margin-right: 10px;
            width: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .radio-group {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .radio-item {
            flex: 1;
            position: relative;
        }

        .radio-item input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: block;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            font-weight: 500;
        }

        .radio-label:hover {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .radio-item input[type="radio"]:checked+.radio-label {
            border-color: #667eea;
            background: #667eea;
            color: white;
        }

        .hidden-section {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .consent-section {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 2px solid #ffc107;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
        }

        .consent-title {
            color: #856404;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
        }

        .info-box {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-title {
            color: #0d47a1;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .info-title i {
            margin-right: 8px;
        }

        .info-list {
            margin: 0;
            padding-left: 20px;
        }

        .info-list li {
            margin-bottom: 8px;
            color: #1976d2;
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
        }

        .required {
            color: #dc3545;
        }

        .declarant-info {
            background: #f0f8ff;
            border: 2px solid #b3d9ff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
        }

        .declarant-name {
            font-size: 14px;
            font-weight: 600;
            color: #0066cc;
            margin-top: 10px;
            min-height: 20px;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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
            // Set default values
            const today = new Date();
            const tanggalInput = document.getElementById('tanggal');
            const jamInput = document.getElementById('jam');

            if (tanggalInput) tanggalInput.value = today.toISOString().split('T')[0];
            if (jamInput) jamInput.value = today.toTimeString().split(' ')[0].substring(0, 5);

            // DEBUGGING: Cek semua element penting
            const dokterSelect = document.getElementById('dokter');
            const dokterName = document.getElementById('dokter-name');

            // Handle persetujuan untuk selection
            const persetujuanRadios = document.querySelectorAll('input[name="persetujuan_untuk"]');
            const keluargaSection = document.getElementById('keluarga-section');
            const declarantName = document.getElementById('declarant-name');
            const yangMenyatakan = document.getElementById('yang_menyatakan');
            const namaKeluarga = document.getElementById('nama_keluarga');

            // Initialize declarant name dengan nama pasien jika ada
            if (declarantName) {
                declarantName.textContent = '{{ $dataMedis->pasien->nama ?? "Akan terisi otomatis" }}';
            }
            if (yangMenyatakan) {
                yangMenyatakan.value = '{{ $dataMedis->pasien->nama ?? "" }}';
            }

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

            function updateDokterName() {
                if (!dokterSelect || !dokterName) {
                    return false;
                }

                const selectedValue = dokterSelect.value;

                if (selectedValue && selectedValue !== '') {
                    // Method 1: Menggunakan selectedIndex
                    const selectedOption = dokterSelect.options[dokterSelect.selectedIndex];
                    if (selectedOption) {
                        const namaDokter = selectedOption.textContent.trim();

                        dokterName.textContent = namaDokter;
                        dokterName.innerHTML = namaDokter;
                        dokterName.innerText = namaDokter;

                        dokterName.style.color = '#0066cc';
                        dokterName.style.fontWeight = '600';

                        return true;
                    }

                    // Method 2: Menggunakan querySelector (backup)
                    const option = dokterSelect.querySelector(`option[value="${selectedValue}"]`);
                    if (option) {
                        const namaDokter = option.textContent.trim();
                        console.log('Nama dokter dari querySelector:', namaDokter);
                        dokterName.textContent = namaDokter;
                        dokterName.style.color = '#0066cc';
                        dokterName.style.fontWeight = '600';
                        return true;
                    }
                }

                // Default jika tidak ada yang dipilih
                dokterName.textContent = 'Pilih dokter di atas';
                dokterName.style.color = '#999';
                dokterName.style.fontWeight = 'normal';
                return false;
            }

            function forceDOMRefresh(element) {
                if (!element) return;

                // Method 1: Hide and show
                const originalDisplay = element.style.display;
                element.style.display = 'none';
                element.offsetHeight;
                element.style.display = originalDisplay || 'block';
            }

            // Event listener untuk perubahan dokter
            if (dokterSelect) {
                dokterSelect.addEventListener('change', function () {
                    const success = updateDokterName();
                    if (success) {
                        setTimeout(() => forceDOMRefresh(dokterName), 50);
                    }
                });

                if (typeof $ !== 'undefined' && $.fn.select2) {

                    // Primary Select2 select event
                    $('#dokter').on('select2:select', function (e) {
                        const data = e.params.data;

                        // Direct update dari Select2 data
                        if (data && data.text && dokterName) {
                            const cleanText = data.text.trim();

                            dokterName.textContent = cleanText;
                            $(dokterName).text(cleanText);
                            dokterName.innerHTML = cleanText;

                            // Style update
                            dokterName.style.color = '#0066cc';
                            dokterName.style.fontWeight = '600';

                            // Force jQuery update
                            $(dokterName).trigger('change');
                        }

                        // Backup: Use standard method
                        setTimeout(() => {
                            updateDokterName();
                            forceDOMRefresh(dokterName);
                        }, 100);
                    });

                    // Select2 clear event
                    $('#dokter').on('select2:clear', function (e) {
                        if (dokterName) {
                            dokterName.textContent = 'Pilih dokter di atas';
                            dokterName.style.color = '#999';
                            dokterName.style.fontWeight = 'normal';
                        }
                    });

                    // Additional Select2 events for robustness
                    $('#dokter').on('select2:close', function (e) {
                        setTimeout(updateDokterName, 150);
                    });

                    $('#dokter').on('change.select2', function (e) {
                        setTimeout(updateDokterName, 100);
                    });
                }

                let lastDokterValue = '';
                setInterval(() => {
                    if (dokterSelect.value !== lastDokterValue) {
                        lastDokterValue = dokterSelect.value;
                        updateDokterName();
                    }
                }, 1000);
            }

            // Handle saksi names
            const namaSaksi1 = document.getElementById('nama_saksi1');
            const namaSaksi2 = document.getElementById('nama_saksi2');
            const saksi1Name = document.getElementById('saksi1-name');
            const saksi2Name = document.getElementById('saksi2-name');

            if (namaSaksi1 && saksi1Name) {
                namaSaksi1.addEventListener('input', function () {
                    const nama = this.value || 'Masukkan nama saksi 1';
                    saksi1Name.textContent = nama;
                    if (this.value) {
                        saksi1Name.style.color = '#0066cc';
                        saksi1Name.style.fontWeight = '600';
                    } else {
                        saksi1Name.style.color = '#999';
                        saksi1Name.style.fontWeight = 'normal';
                    }
                });
            }

            if (namaSaksi2 && saksi2Name) {
                namaSaksi2.addEventListener('input', function () {
                    const nama = this.value || 'Masukkan nama saksi 2';
                    saksi2Name.textContent = nama;
                    if (this.value) {
                        saksi2Name.style.color = '#0066cc';
                        saksi2Name.style.fontWeight = '600';
                    } else {
                        saksi2Name.style.color = '#999';
                        saksi2Name.style.fontWeight = 'normal';
                    }
                });
            }

            // Phone number formatting
            const phoneInputs = document.querySelectorAll('input[type="tel"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 0 && !value.startsWith('0')) {
                        value = '0' + value;
                    }
                    this.value = value;
                });
            });

            // KTP number formatting
            const ktpInputs = document.querySelectorAll('input[name*="no_ktp"]');
            ktpInputs.forEach(input => {
                input.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 16) {
                        value = value.substring(0, 16);
                    }
                    this.value = value;
                });
            });

            setTimeout(function () {

                // Initialize dokter jika ada old value
                if (dokterSelect && dokterSelect.value) {
                    console.log('🔄 Initializing dokter from old value:', dokterSelect.value);
                    updateDokterName();
                }

                // Initialize saksi names jika ada old value
                if (namaSaksi1 && namaSaksi1.value && saksi1Name) {
                    saksi1Name.textContent = namaSaksi1.value;
                    saksi1Name.style.color = '#0066cc';
                    saksi1Name.style.fontWeight = '600';
                }

                if (namaSaksi2 && namaSaksi2.value && saksi2Name) {
                    saksi2Name.textContent = namaSaksi2.value;
                    saksi2Name.style.color = '#0066cc';
                    saksi2Name.style.fontWeight = '600';
                }

                // Initialize persetujuan untuk
                const checkedPersetujuan = document.querySelector('input[name="persetujuan_untuk"]:checked');
                if (checkedPersetujuan) {
                    checkedPersetujuan.dispatchEvent(new Event('change'));
                }

            }, 800);

            // Form submission validation
            const transfusiForm = document.getElementById('transfusi_form');
            if (transfusiForm) {
                transfusiForm.addEventListener('submit', function (e) {
                    const requiredFields = this.querySelectorAll('input[required], select[required], textarea[required]');
                    let isValid = true;
                    let firstInvalidField = null;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        if (firstInvalidField) {
                            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstInvalidField.focus();
                        }
                        alert('Mohon lengkapi semua field yang wajib diisi');
                    }
                });
            }

        });
    </script>
@endpush
