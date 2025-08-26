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

        /* 7. resiko jatuh */
        .risk-form {
            display: none;
        }

        .conclusion {
            background-color: #198754;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }

        .conclusion.warning {
            background-color: #ffc107;
        }

        .conclusion.danger {
            background-color: #dc3545;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section h6 {
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .suggestions-list {
            position: absolute;
            z-index: 1000;
            width: calc(100% - 2rem);
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .selected-item {
            display: inline-flex;
            align-items: center;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .selected-item .delete-btn {
            margin-left: 8px;
            color: #dc3545;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0 4px;
        }
    </style>
@endpush

@push('js')
    <script>

    </script>
@endpush
