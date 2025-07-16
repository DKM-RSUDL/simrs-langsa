@push('css')
    <style>
        .resiko_jatuh__header-asesmen {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .resiko_jatuh__section-separator {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .resiko_jatuh__section-separator h5 {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .resiko_jatuh__section-separator h5:before {
            content: '';
            width: 4px;
            height: 25px;
            background: #667eea;
            margin-right: 10px;
            border-radius: 2px;
        }

        .resiko_jatuh__form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .resiko_jatuh__form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .resiko_jatuh__form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .resiko_jatuh__form-check {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resiko_jatuh__form-check:hover {
            border-color: #667eea;
            background: #f0f3ff;
            transform: translateX(5px);
        }

        .resiko_jatuh__form-check-input:checked~.resiko_jatuh__form-check-label {
            color: #667eea;
            font-weight: 600;
        }

        .resiko_jatuh__form-check input:checked+label {
            color: #667eea !important;
        }

        .resiko_jatuh__form-check.selected {
            border-color: #667eea;
            background: #e8f0fe;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
        }

        .resiko_jatuh__criteria-form-check {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resiko_jatuh__criteria-form-check:hover {
            border-color: #667eea;
            background: #f0f3ff;
            transform: translateX(5px);
        }

        .resiko_jatuh__criteria-form-check-input:checked~.resiko_jatuh__criteria-form-check-label {
            color: #667eea;
            font-weight: 600;
        }

        .resiko_jatuh__criteria-form-check input:checked+label {
            color: #667eea !important;
        }

        .resiko_jatuh__criteria-form-check.selected {
            border-color: #667eea;
            background: #e8f0fe;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
        }

        .resiko_jatuh__badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .resiko_jatuh__badge-info {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }

        .resiko_jatuh__badge-success {
            background: #28a745;
            color: white;
        }

        .resiko_jatuh__badge-warning {
            background: #ffc107;
            color: #212529;
        }

        .resiko_jatuh__badge-danger {
            background: #dc3545;
            color: white;
        }

        .resiko_jatuh__font-weight-bold {
            color: #495057;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .resiko_jatuh__font-weight-bold:before {
            content: '';
            width: 6px;
            height: 6px;
            background: #667eea;
            border-radius: 50%;
            margin-right: 10px;
        }

        .resiko_jatuh__card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .resiko_jatuh__card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .resiko_jatuh__score-total {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            animation: resiko_jatuh__pulse 2s infinite;
        }

        @keyframes resiko_jatuh__pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .resiko_jatuh__result-card {
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .resiko_jatuh__result-card h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        .resiko_jatuh__btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .resiko_jatuh__btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(45deg, #764ba2, #667eea);
        }

        .resiko_jatuh__criteria-section {
            background: #fafbfc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .resiko_jatuh__score-badge {
            float: right;
            margin-top: 2px;
        }

        .resiko_jatuh__fade-in {
            animation: resiko_jatuh__fadeIn 0.6s ease-in;
        }

        @keyframes resiko_jatuh__fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .resiko_jatuh__btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .resiko_jatuh__btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateX(-3px);
        }

        .resiko_jatuh__keterangan-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .resiko_jatuh__keterangan-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .resiko_jatuh__keterangan-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
        }

        .resiko_jatuh__keterangan-list li {
            margin-bottom: 8px;
        }

        /* Style khusus untuk section intervensi */
        .resiko_jatuh__intervensi-rr {
            border-left: 4px solid #28a745;
        }

        .resiko_jatuh__intervensi-rr h5 {
            color: #28a745;
        }

        .resiko_jatuh__intervensi-rs {
            border-left: 4px solid #ffc107;
        }

        .resiko_jatuh__intervensi-rs h5 {
            color: #856404;
        }

        .resiko_jatuh__intervensi-rt {
            border-left: 4px solid #dc3545;
        }

        .resiko_jatuh__intervensi-rt h5 {
            color: #dc3545;
        }

        .resiko_jatuh__table-intervensi {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .resiko_jatuh__table-intervensi th,
        .resiko_jatuh__table-intervensi td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }

        .resiko_jatuh__table-intervensi th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .resiko_jatuh__table-intervensi .shift-header {
            background-color: #e9ecef;
            font-weight: 600;
        }

        #duplicate-warning {
            border-left: 4px solid #ffc107;
            background: linear-gradient(45deg, #fff3cd, #ffeaa7);
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            // Fungsi untuk menghitung skor total
            function hitungSkorTotal() {
                let total = 0;

                // Mengambil nilai dari setiap radio button yang dipilih
                const riwayatJatuh = $('input[name="riwayat_jatuh"]:checked').val() || 0;
                const diagnosaSekunder = $('input[name="diagnosa_sekunder"]:checked').val() || 0;
                const bantuanAmbulasi = $('input[name="bantuan_ambulasi"]:checked').val() || 0;
                const terpasangInfus = $('input[name="terpasang_infus"]:checked').val() || 0;
                const gayaBerjalan = $('input[name="gaya_berjalan"]:checked').val() || 0;
                const statusMental = $('input[name="status_mental"]:checked').val() || 0;

                total = parseInt(riwayatJatuh) + parseInt(diagnosaSekunder) + parseInt(bantuanAmbulasi) +
                    parseInt(terpasangInfus) + parseInt(gayaBerjalan) + parseInt(statusMental);

                // Update tampilan skor dengan animasi
                $('#resikoJatuh_skorTotal').text(total);

                // **TAMBAHAN PENTING: Update input hidden untuk skor total**
                $('#resikoJatuh_skorTotalInput').val(total);

                // Sembunyikan semua section intervensi terlebih dahulu
                $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();

                // Tentukan kategori resiko dan warna
                let kategori = '';
                let kategoriLengkap = '';
                let cardClass = '';
                let kodeResiko = '';

                if (total >= 0 && total <= 24) {
                    kategori = 'RESIKO RENDAH';
                    kodeResiko = 'RR';
                    kategoriLengkap = 'RR';
                    cardClass = 'bg-success text-white';
                    // Tampilkan intervensi RR dengan animasi
                    $('#resikoJatuh_intervensiRR').show().addClass('resiko_jatuh__fade-in');
                } else if (total >= 25 && total <= 44) {
                    kategori = 'RESIKO SEDANG';
                    kodeResiko = 'RS';
                    kategoriLengkap = 'RS';
                    cardClass = 'bg-warning text-dark';
                    // Tampilkan intervensi RS dengan animasi
                    $('#resikoJatuh_intervensiRS').show().addClass('resiko_jatuh__fade-in');
                } else if (total >= 45) {
                    kategori = 'RESIKO TINGGI';
                    kodeResiko = 'RT';
                    kategoriLengkap = 'RT';
                    cardClass = 'bg-danger text-white';
                    // Tampilkan intervensi RT dengan animasi
                    $('#resikoJatuh_intervensiRT').show().addClass('resiko_jatuh__fade-in');
                }

                // Update tampilan kategori
                $('#resikoJatuh_kategoriResiko').text(`${kategori} (${kodeResiko})`);
                $('#resikoJatuh_hasilResiko').removeClass('bg-success bg-warning bg-danger text-white text-dark').addClass(cardClass);

                // **TAMBAHAN PENTING: Update input hidden untuk kategori resiko**
                $('#resikoJatuh_kategoriResikoInput').val(kategoriLengkap);
            }

            // Function untuk mengecek duplikasi - DIPERBAIKI
            function checkDuplicateDateTime() {
                const tanggal = $('#tanggal').val();
                const shift = $('#shift').val();

                if (tanggal && shift) {
                    // AJAX call untuk mengecek duplikasi
                    $.ajax({
                        url: "{{ route('rawat-jalan.resiko-jatuh.morse.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        method: 'POST',
                        data: {
                            _token: $('input[name="_token"]').val(), // Ambil dari form token
                            tanggal: tanggal,
                            shift: shift
                        },
                        success: function (response) {
                            if (response.exists) {
                                // Show warning message
                                showDuplicateWarning(true);
                                $('#resikoJatuh_simpan').prop('disabled', true);
                            } else {
                                // Hide warning message
                                showDuplicateWarning(false);
                                $('#resikoJatuh_simpan').prop('disabled', false);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error checking duplicate:', error);
                            // On error, allow submission
                            showDuplicateWarning(false);
                            $('#resikoJatuh_simpan').prop('disabled', false);
                        }
                    });
                } else {
                    showDuplicateWarning(false);
                    $('#resikoJatuh_simpan').prop('disabled', false);
                }
            }

            // Function untuk menampilkan/menyembunyikan warning
            function showDuplicateWarning(show) {
                if (show) {
                    if ($('#duplicate-warning').length === 0) {
                        const warningHtml = `
                        <div id="duplicate-warning" class="alert alert-warning mt-2" style="border-left: 4px solid #ffc107;">
                            <i class="ti-alert-triangle"></i>
                            <strong>Peringatan:</strong> Data dengan tanggal dan shift ini sudah ada!
                        </div>
                    `;
                        $('#shift').closest('.form-group').after(warningHtml);
                    }
                    $('#duplicate-warning').show();
                } else {
                    $('#duplicate-warning').hide();
                }
            }

            // **TAMBAHAN EVENT LISTENER UNTUK TANGGAL DAN SHIFT - INI YANG HILANG**
            $('#tanggal, #shift').on('change blur', function () {
                checkDuplicateDateTime();
            });

            // Event listener untuk radio button dengan efek visual
            $('input[type="radio"]').on('change', function () {
                const group = $(this).attr('name');

                // Remove selected class from all form-check in the same group
                $(`.resiko_jatuh__form-check[data-group="${group}"], .resiko_jatuh__criteria-form-check[data-group="${group}"]`).removeClass('selected');

                // Add selected class to the clicked form-check
                $(this).closest('.resiko_jatuh__form-check, .resiko_jatuh__criteria-form-check').addClass('selected');

                // Hitung ulang skor
                hitungSkorTotal();
            });

            // Event listener untuk checkbox intervensi
            $('input[name^="intervensi_"]').on('change', function () {
                const checkbox = $(this);
                const formCheck = checkbox.closest('.resiko_jatuh__criteria-form-check');

                if (checkbox.is(':checked')) {
                    formCheck.addClass('selected');
                } else {
                    formCheck.removeClass('selected');
                }
            });

            // Tambahkan efek hover dan klik pada form-check
            $('.resiko_jatuh__form-check, .resiko_jatuh__criteria-form-check').on('click', function () {
                const radio = $(this).find('input[type="radio"]');
                const checkbox = $(this).find('input[type="checkbox"]');

                if (radio.length && !radio.prop('checked')) {
                    radio.prop('checked', true).trigger('change');
                } else if (checkbox.length) {
                    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                }
            });

            // Hitung skor awal berdasarkan nilai yang sudah ada
            hitungSkorTotal();

            // Set initial state untuk form-check yang sudah dipilih
            $('input[type="radio"]:checked').each(function () {
                $(this).closest('.resiko_jatuh__criteria-form-check').addClass('selected');
            });

            $('input[type="checkbox"]:checked').each(function () {
                $(this).closest('.resiko_jatuh__criteria-form-check').addClass('selected');
            });

            // Validasi form dengan notifikasi yang lebih baik
            $('#resikoJatuh_form').on('submit', function (e) {
                const requiredFields = ['riwayat_jatuh', 'diagnosa_sekunder', 'bantuan_ambulasi', 'terpasang_infus', 'gaya_berjalan', 'status_mental'];
                let allAnswered = true;
                let missingFields = [];

                requiredFields.forEach(function (field) {
                    if (!$('input[name="' + field + '"]:checked').length) {
                        allAnswered = false;
                        missingFields.push(field);
                    }
                });

                // **TAMBAHAN: Pastikan skor total dan kategori terisi sebelum submit**
                const skorTotal = $('#resikoJatuh_skorTotalInput').val();
                const kategoriResiko = $('#resikoJatuh_kategoriResikoInput').val();

                if (!skorTotal || !kategoriResiko) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua penilaian terlebih dahulu!');
                    return false;
                }

                // Validasi khusus berdasarkan kategori resiko yang muncul
                if ($('#resikoJatuh_intervensiRR').is(':visible')) {
                    // Validasi untuk RR
                    if (!$('input[name="intervensi_rr[]"]:checked').length) {
                        allAnswered = false;
                        alert('Untuk pasien dengan resiko rendah, wajib memilih minimal 1 intervensi pencegahan!');
                        $('#resikoJatuh_intervensiRR').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });

                        setTimeout(function () {
                            $('#resikoJatuh_intervensiRR').css({
                                'border': '1px solid #e9ecef',
                                'background': ''
                            });
                        }, 3000);

                        return false;
                    }
                }

                if ($('#resikoJatuh_intervensiRS').is(':visible')) {
                    // Validasi untuk RS
                    if (!$('input[name="intervensi_rs[]"]:checked').length) {
                        allAnswered = false;
                        alert('Untuk pasien dengan resiko sedang, wajib memilih minimal 1 intervensi pencegahan!');
                        $('#resikoJatuh_intervensiRS').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });

                        setTimeout(function () {
                            $('#resikoJatuh_intervensiRS').css({
                                'border': '1px solid #e9ecef',
                                'background': ''
                            });
                        }, 3000);

                        return false;
                    }
                }

                if ($('#resikoJatuh_intervensiRT').is(':visible')) {
                    // Validasi untuk RT
                    if (!$('input[name="intervensi_rt[]"]:checked').length) {
                        allAnswered = false;
                        alert('Untuk pasien dengan resiko tinggi, wajib memilih minimal 1 intervensi pencegahan!');
                        $('#resikoJatuh_intervensiRT').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });

                        setTimeout(function () {
                            $('#resikoJatuh_intervensiRT').css({
                                'border': '1px solid #e9ecef',
                                'background': ''
                            });
                        }, 3000);

                        return false;
                    }
                }

                if (!allAnswered) {
                    e.preventDefault();

                    // Highlight missing fields
                    missingFields.forEach(function (field) {
                        $(`input[name="${field}"]`).closest('.resiko_jatuh__criteria-section, .resiko_jatuh__section-separator').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });
                    });

                    alert(`Mohon lengkapi ${missingFields.length} kriteria yang belum dinilai!`);

                    // Remove highlight after 3 seconds
                    setTimeout(function () {
                        $('.resiko_jatuh__criteria-section, .resiko_jatuh__section-separator').css({
                            'border': '1px solid #e9ecef',
                            'background': ''
                        });
                    }, 3000);

                    return false;
                }

                // **TAMBAHAN: Debug log untuk memastikan data terkirim**
                console.log('Data yang akan dikirim:');
                console.log('Skor Total:', $('#resikoJatuh_skorTotalInput').val());
                console.log('Kategori Resiko:', $('#resikoJatuh_kategoriResikoInput').val());

                // Show loading state
                $('#resikoJatuh_simpan').prop('disabled', true).html('<i class="ti-reload mr-2"></i> Mengupdate...');
            });
        });
    </script>
@endpush
