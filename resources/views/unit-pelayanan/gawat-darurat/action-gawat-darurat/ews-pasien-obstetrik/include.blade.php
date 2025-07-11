
@push('css')
    <style>
        .header-asesmen {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        .card {
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-plaintext {
            padding-top: calc(0.375rem + 1px);
        }

        .custom-control-label {
            cursor: pointer;
        }

        .table th {
            font-size: 0.9rem;
        }

        /* Total Score Styling */
        .total-score-section {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }

        .total-score-value {
            font-size: 3rem;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }

        /* Kesimpulan Alert Styling */
        .kesimpulan-section {
            margin-top: 25px;
        }

        .kesimpulan-card {
            margin-bottom: 0;
            font-weight: 500;
            padding: 15px;
            text-align: center;
            border: none;
            border-radius: 8px;
        }

        .kesimpulan-hijau {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .kesimpulan-kuning {
            background-color: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }

        .kesimpulan-merah {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Hidden elements */
        .d-none {
            display: none !important;
        }
    </style>
@endpush
