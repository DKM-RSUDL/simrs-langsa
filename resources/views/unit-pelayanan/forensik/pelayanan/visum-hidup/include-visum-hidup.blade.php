@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .header-asesmen {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 15px;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-plaintext {
            padding-top: calc(0.375rem + 1px);
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 8px 12px;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label,
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .required {
            color: #dc3545;
        }

        /* Error message styling */
        .text-danger {
            color: #dc3545 !important;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .form-control.is-invalid,
        .trix-editor.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-control.is-valid,
        .trix-editor.is-valid {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .patient-info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
        }

        .patient-info-item {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .patient-info-label {
            font-weight: 600;
            min-width: 180px;
            color: #495057;
            flex-shrink: 0;
        }

        .patient-info-value {
            color: #212529;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid #007bff;
            color: #007bff;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: white;
            transform: translateY(-1px);
        }

        /* Trix Editor Customization */
        .trix-editor {
            border: 1px solid #ced4da;
            border-radius: 4px;
            min-height: 120px;
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
            font-size: 14px;
            line-height: 1.5;
        }

        .trix-editor:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .trix-editor--focus {
            border-color: #80bdff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }

        .trix-content {
            padding: 5px 0;
        }

        .datetime-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            color: #495057;
        }

        /* Section Layout */
        .examination-section {
            background: #fdfdfd;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .examination-section h5 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        /* Two column layout for forms */
        .form-row-custom {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .form-col-half {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 15px;
            padding-left: 15px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .card-body {
                padding: 10px;
            }

            .header-asesmen {
                padding: 15px 10px;
                text-align: center;
            }

            .card-header {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .datetime-container {
                padding: 10px;
                margin-bottom: 15px;
            }

            .patient-info-item {
                flex-direction: column;
                margin-bottom: 12px;
            }

            .patient-info-label {
                min-width: unset;
                margin-bottom: 2px;
                font-weight: 600;
            }

            .form-col-half {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 15px;
            }

            .trix-editor {
                min-height: 100px;
            }
        }

        @media (max-width: 576px) {
            .header-asesmen h3 {
                font-size: 1.3rem;
            }

            .header-asesmen p {
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            .form-group label {
                font-size: 0.9rem;
                font-weight: 600;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 8px 15px;
            }
        }

        @media print {

            .btn,
            .card-header {
                display: none !important;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
@endpush