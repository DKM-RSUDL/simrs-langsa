@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* General Styling */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        /* Typography */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a252f;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a252f;
            margin-bottom: 1rem;
            padding-left: 0.75rem;
            border-left: 4px solid #007bff;
        }

        /* Layout */
        .section-separator {
            margin: 2rem 0;
            padding-top: 1rem;
            border-top: 2px solid #e9ecef;
        }

        .form-group {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .form-group label {
            flex: 0 0 180px;
            font-size: 0.875rem;
        }

        .form-control-plaintext {
            font-size: 0.875rem;
            color: #495057;
            padding: 0.25rem 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Diagnosis Section */
        .diagnosis-section {
            margin-bottom: 1.5rem;
        }

        .diagnosis-item {
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }

        .diagnosis-item p {
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn-outline-primary {
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
            font-size: 0.875rem;
        }

        /* Progress Bar */
        .progress-wrapper {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .progress-label {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .progress-percentage {
            font-size: 0.875rem;
            color: #28a745;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
        }

        .progress-bar-custom {
            background-color: #007bff;
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            min-width: 300px;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-group label {
                flex: none;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .header-asesmen {
                font-size: 1.5rem;
            }

            .card-header {
                font-size: 1rem;
            }
        }

        /* Checkbox yang tercentang - hijau */
        input[type="checkbox"],
        input[type="radio"] {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            cursor: pointer;
            position: relative;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 3px;
            border: 2px solid #dee2e6;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        /* Checkbox yang tidak tercentang - abu-abu */
        input[type="checkbox"]:not(:checked) {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            opacity: 0.7;
        }

        /* Checkbox yang tercentang - hijau */
        input[type="checkbox"]:checked {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            opacity: 1 !important;
        }

        /* Tanda centang hijau */
        input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: -2px;
            left: 2px;
            color: white;
            font-size: 14px;
            font-weight: bold;
            line-height: 1;
        }

        /* Radio button styling */
        input[type="radio"] {
            border-radius: 50%;
        }

        /* Radio button yang tidak terpilih - abu-abu */
        input[type="radio"]:not(:checked) {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            opacity: 0.7;
        }

        /* Radio button yang terpilih - hijau */
        input[type="radio"]:checked {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            opacity: 1 !important;
        }

        /* Dot untuk radio button */
        input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: white;
        }

        /* Disabled state - tetap mempertahankan warna */
        input[type="checkbox"]:disabled,
        input[type="radio"]:disabled {
            cursor: not-allowed;
        }

        input[type="checkbox"]:disabled:checked {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            opacity: 1 !important;
        }

        input[type="radio"]:disabled:checked {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            opacity: 1 !important;
        }

        input[type="checkbox"]:disabled:not(:checked) {
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
            opacity: 0.7 !important;
        }

        input[type="radio"]:disabled:not(:checked) {
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
            opacity: 0.7 !important;
        }

        /* Styling untuk container */
        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            margin-bottom: 5px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            margin-right: 10px;
            margin-bottom: 8px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background-color: #f8f9fa;
        }

        .radio-item.selected {
            background-color: #d4edda;
            border-color: #28a745;
        }

        .checkbox-item label,
        .radio-item label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: #495057;
        }
    </style>
@endpush

@push('js')
    <script>
        function printPDF(element) {
            const id = element.dataset.id;
            const kdUnit = element.dataset.kdUnit;
            const kdPasien = element.dataset.kdPasien;
            const tglMasuk = element.dataset.tglMasuk;
            const urutMasuk = element.dataset.urutMasuk;

            const missingParams = [];
            if (!id) missingParams.push('ID');
            if (!kdUnit) missingParams.push('Unit Code');
            if (!kdPasien) missingParams.push('Patient Code');
            if (!tglMasuk) missingParams.push('Admission Date');
            if (!urutMasuk) missingParams.push('Entry Order');

            if (missingParams.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Missing parameters: ${missingParams.join(', ')}`,
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#007bff'
                });
                return;
            }

            Swal.fire({
                title: 'Generating PDF',
                html: 'Please wait while the document is being prepared...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    const url = `/unit-pelayanan/rawat-inap/unit/${kdUnit}/pelayanan/${kdPasien}/${tglMasuk}/${urutMasuk}/asesmen/medis/tht/${id}/print-pdf`;

                    const pdfWindow = window.open(url, '_blank');

                    if (!pdfWindow || pdfWindow.closed || typeof pdfWindow.closed === 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Popup Blocked',
                            text: 'Please allow popups to view the PDF',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007bff'
                        });
                    }

                    setTimeout(() => {
                        Swal.close();
                    }, 2000);
                }
            });
        }
    </script>
@endpush