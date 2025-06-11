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

        .dropdown-menu {
            display: none;
            position: fixed;
            /* Ubah ke absolute */
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            transform: translateY(5px);
            /* Tambahkan sedikit offset */
            max-height: 400px;
            overflow-y: auto;
        }

        /* Tambahkan wrapper untuk positioning yang lebih baik */
        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        /* css untuk blade create terminal */
        <style>
        .header-asesmen {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-title {
            /* background: linear-gradient(135deg, #3498db 0%, #fff 100%); */
            color: black;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .subsection-title {
            color: #495057;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-left: 10px;
            border-left: 4px solid #007bff;
        }

        .checkbox-group {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }

        .checkbox-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            padding: 8px 0;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #007bff;
        }

        .checkbox-item label {
            cursor: pointer;
            margin: 0;
            font-weight: 500;
            color: #495057;
            flex: 1;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: #fff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-item:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .radio-item input[type="radio"]:checked+label {
            color: #007bff;
            font-weight: 600;
        }

        .radio-item input[type="radio"] {
            margin-right: 8px;
            accent-color: #007bff;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }        

        .alert-info {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .section-number {
            display: inline-block;
            background: #007bff;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }

        .text-input-group {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-top: 10px;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .radio-group {
                flex-direction: column;
            }

            .radio-item {
                margin-bottom: 10px;
            }
        }

        .checkbox-item.selected {
            background-color: #e3f2fd;
            border-radius: 5px;
            padding: 8px;
        }

        .radio-item.selected {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            // Show/hide nyeri keterangan
            $('input[name="nyeri"]').change(function () {
                if ($(this).val() === '1') {
                    $('#nyeri_keterangan').slideDown();
                } else {
                    $('#nyeri_keterangan').slideUp();
                }
            });

            // Form validation
            $('form').on('submit', function (e) {
                let isValid = true;
                let errorMessage = '';

                // Check required fields
                if (!$('#tanggal_masuk').val()) {
                    isValid = false;
                    errorMessage += 'Tanggal masuk harus diisi.\n';
                }

                if (!$('#jam_masuk').val()) {
                    isValid = false;
                    errorMessage += 'Jam masuk harus diisi.\n';
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }
            });

            // Add visual feedback for checkbox interactions
            $('input[type="checkbox"]').change(function () {
                if ($(this).is(':checked')) {
                    $(this).closest('.checkbox-item').addClass('selected');
                } else {
                    $(this).closest('.checkbox-item').removeClass('selected');
                }
            });

            // Add visual feedback for radio interactions
            $('input[type="radio"]').change(function () {
                $('input[name="' + $(this).attr('name') + '"]').closest('.radio-item').removeClass('selected');
                $(this).closest('.radio-item').addClass('selected');
            });
        });

        // Show/hide spiritual keterangan
        $('input[name="perlu_pelayanan_spiritual"]').change(function () {
            if ($(this).val() === '1') {
                $('#spiritual_keterangan').slideDown();
            } else {
                $('#spiritual_keterangan').slideUp();
                $('input[name="spiritual_keterangan"]').val(''); // Clear the input when hidden
            }
        });

        // not 6
        // Show/hide orang yang ingin dihubungi keterangan
        $('input[name="orang_dihubungi"]').change(function () {
            if ($(this).val() === '1') {
                $('#orang_dihubungi_keterangan').slideDown();
            } else {
                $('#orang_dihubungi_keterangan').slideUp();
                $('#orang_dihubungi_keterangan input').val(''); // Clear all inputs when hidden
            }
        });

        // Show/hide perawat rumah keterangan
        $('input[name="mampu_merawat_rumah"]').change(function () {
            if ($(this).val() === '1') {
                $('#perawat_rumah_keterangan').slideDown();
            } else {
                $('#perawat_rumah_keterangan').slideUp();
                $('input[name="perawat_rumah_oleh"]').val(''); // Clear the input when hidden
            }
        });

        // Handle checkbox groups that should act like radio buttons for mutually exclusive options
        $('input[name="orang_dihubungi"]').change(function() {
            // Uncheck other options when one is selected
            if ($(this).is(':checked')) {
                $('input[name="orang_dihubungi"]').not(this).prop('checked', false);
                $('input[name="orang_dihubungi"]').not(this).closest('.radio-item').removeClass('selected');
            }
        });

        // Similar handling for other mutually exclusive groups
        $('input[name="lingkungan_rumah_siap"]').change(function() {
            if ($(this).is(':checked')) {
                $('input[name="lingkungan_rumah_siap"]').not(this).prop('checked', false);
                $('input[name="lingkungan_rumah_siap"]').not(this).closest('.radio-item').removeClass('selected');
            }
        });

        $('input[name="mampu_merawat_rumah"]').change(function() {
            if ($(this).is(':checked')) {
                $('input[name="mampu_merawat_rumah"]').not(this).prop('checked', false);
                $('input[name="mampu_merawat_rumah"]').not(this).closest('.radio-item').removeClass('selected');
            }
        });

        $('input[name="perlu_home_care"]').change(function() {
            if ($(this).is(':checked')) {
                $('input[name="perlu_home_care"]').not(this).prop('checked', false);
                $('input[name="perlu_home_care"]').not(this).closest('.radio-item').removeClass('selected');
            }
        });

        // Section 8
        $(document).ready(function () {
            // Show/hide donasi organ keterangan
            $('#alternatif_donasi_organ').change(function () {
                if ($(this).is(':checked')) {
                    $('#donasi_organ_keterangan').slideDown();
                } else {
                    $('#donasi_organ_keterangan').slideUp();
                    $('input[name="donasi_organ_detail"]').val(''); // Clear the input when hidden
                }
            });
            
            // Handle mutually exclusive checkboxes for Section 8
            $('input[name^="alternatif_"]').change(function() {
                if ($(this).attr('name') === 'alternatif_tidak' && $(this).is(':checked')) {
                    // If "Tidak" is checked, uncheck others
                    $('input[name="alternatif_autopsi"], input[name="alternatif_donasi_organ"]').prop('checked', false);
                    $('#donasi_organ_keterangan').slideUp();
                    $('input[name="donasi_organ_detail"]').val('');
                } else if (($(this).attr('name') === 'alternatif_autopsi' || $(this).attr('name') === 'alternatif_donasi_organ') && $(this).is(':checked')) {
                    // If Autopsi or Donasi Organ is checked, uncheck "Tidak"
                    $('input[name="alternatif_tidak"]').prop('checked', false);
                }
            });
        });
    </script>
@endpush
