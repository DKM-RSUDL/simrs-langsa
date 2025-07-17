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
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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

        #duplicate-warning {
            border-left: 4px solid #ffc107;
            background: linear-gradient(45deg, #fff3cd, #ffeaa7);
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            // Fungsi untuk menghitung skor total dan menentukan kategori
            function hitungSkorTotal() {
                let total = 0;

                // PERBAIKAN: Array criteria yang sesuai dengan nama field di HTML
                const criteria = [
                    'bab', 'bak', 'membersihkan_diri', 'penggunaan_jamban', 'makan',
                    'berubah_sikap', 'berpindah', 'berpakaian', 'naik_turun_tangga', 'mandi'
                ];

                criteria.forEach(function (criterion) {
                    const value = parseInt($(`input[name="${criterion}"]:checked`).val()) || 0;
                    total += value;
                });

                $('#barthel_skorTotal').text(total);
                $('#barthel_skorTotalInput').val(total);

                // KATEGORI YANG BENAR SESUAI PDF
                let kategori = '';
                let cardClass = '';

                if (total === 20) {
                    kategori = 'Mandiri';
                    cardClass = 'bg-success text-white';
                } else if (total >= 12 && total <= 19) {
                    kategori = 'Ketergantungan Ringan';
                    cardClass = 'bg-info text-white';
                } else if (total >= 9 && total <= 11) {
                    kategori = 'Ketergantungan Sedang';
                    cardClass = 'bg-warning text-dark';
                } else if (total >= 5 && total <= 8) {
                    kategori = 'Ketergantungan Berat';
                    cardClass = 'bg-danger text-white';
                } else if (total >= 0 && total <= 4) {
                    kategori = 'Ketergantungan Total';
                    cardClass = 'bg-danger text-white';
                } else {
                    kategori = 'Belum Dinilai';
                    cardClass = 'bg-light';
                }

                $('#barthel_kategoriText').text(kategori);
                $('#barthel_kategoriInput').val(kategori);
                $('#barthel_kategori').removeClass('bg-success bg-info bg-warning bg-danger bg-light text-white text-dark').addClass(cardClass);
            }

            // Cek duplikasi data
            function checkDuplicate() {
                const tanggal = $('#tanggal').val();
                const nilaiSkor = $('#nilai_skor').val();

                if (tanggal && nilaiSkor) {
                    $.ajax({
                        url: '{{ route("rawat-jalan.status-fungsional.check-duplicate", [$dataMedis->kd_unit, $dataMedis->kd_pasien, date("Y-m-d", strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}',
                        method: 'GET',
                        data: {
                            tanggal: tanggal,
                            nilai_skor: nilaiSkor
                        },
                        success: function(response) {
                            if (response.exists) {
                                $('#duplicate-warning').show();
                                $('#duplicate-message').text(response.message);
                                $('#barthel_simpan').prop('disabled', true);
                            } else {
                                $('#duplicate-warning').hide();
                                $('#barthel_simpan').prop('disabled', false);
                            }
                        }
                    });
                }
            }

            // Event listener untuk cek duplikasi
            $('#tanggal, #nilai_skor').on('change', checkDuplicate);

            // Event listener untuk radio button
            $('input[type="radio"]').on('change', function () {
                const group = $(this).attr('name');
                $(`.resiko_jatuh__criteria-form-check[data-group="${group}"]`).removeClass('selected');
                $(this).closest('.resiko_jatuh__criteria-form-check').addClass('selected');
                hitungSkorTotal();
            });

            // Tambahkan efek klik pada form-check
            $('.resiko_jatuh__criteria-form-check').on('click', function () {
                const radio = $(this).find('input[type="radio"]');
                if (radio.length && !radio.prop('checked')) {
                    radio.prop('checked', true).trigger('change');
                }
            });

            // Inisialisasi skor awal dan status form
            hitungSkorTotal();
            $('input[type="radio"]:checked').each(function () {
                $(this).closest('.resiko_jatuh__criteria-form-check').addClass('selected');
            });

            // Validasi form sebelum submit
            $('#barthel_form').on('submit', function (e) {
                // PERBAIKAN: Array criteria yang sesuai dengan nama field di HTML
                const criteria = [
                    'bab', 'bak', 'membersihkan_diri', 'penggunaan_jamban', 'makan',
                    'berubah_sikap', 'berpindah', 'berpakaian', 'naik_turun_tangga', 'mandi'
                ];
                let allAnswered = true;
                let missingFields = [];

                criteria.forEach(function (field) {
                    if (!$(`input[name="${field}"]:checked`).length) {
                        allAnswered = false;
                        missingFields.push(field);
                    }
                });

                if (!allAnswered) {
                    e.preventDefault();
                    missingFields.forEach(function (field) {
                        $(`input[name="${field}"]`).closest('.resiko_jatuh__criteria-section').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });
                    });

                    alert(`Mohon lengkapi ${missingFields.length} kriteria yang belum dinilai!`);

                    setTimeout(function () {
                        $('.resiko_jatuh__criteria-section').css({
                            'border': '1px solid #e9ecef',
                            'background': ''
                        });
                    }, 3000);

                    return false;
                }

                // Pastikan skor total dan kategori terisi
                const skorTotal = $('#barthel_skorTotalInput').val();
                const kategori = $('#barthel_kategoriInput').val();

                if (!skorTotal || !kategori) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua penilaian terlebih dahulu!');
                    return false;
                }

                // Show loading state
                $('#barthel_simpan').prop('disabled', true).html('<i class="ti-reload mr-2"></i> Menyimpan...');
            });

            // Auto dismiss alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush
