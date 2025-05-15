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
            min-width: 200px;
            flex-shrink: 0;
        }

        .form-group .form-control,
        .form-group .form-select {
            flex: 1;
        }

        /* Custom table styling */
        .table-asesmen {
            margin-bottom: 0;
        }

        .table-asesmen th {
            background-color: #f8f9fa;
            font-weight: 600;
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: middle;
        }

        .table-asesmen td {
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: top;
        }

        .table-asesmen .label-col {
            background-color: #f8f9fa;
            font-weight: 600;
            width: 200px;
        }

        /* Form control styling inside table */
        .table-asesmen .form-control,
        .table-asesmen .form-select {
            border: 1px solid #ced4da;
            box-shadow: none;
            background-color: transparent;
            padding: 8px 12px;
        }

        .table-asesmen .form-control:focus,
        .table-asesmen .form-select:focus {
            background-color: #fff;
            border: 1px solid #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        /* Checkbox and radio styling */
        .form-check-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.125rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
            cursor: pointer;
        }

        /* Inline input styling */
        .input-inline {
            width: auto;
            display: inline-block;
            margin: 0 5px;
        }

        .input-sm {
            width: 80px;
        }

        .input-md {
            width: 120px;
        }

        .input-lg {
            width: 200px;
        }

        /* Button styling */
        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                align-items: stretch;
            }

            .form-group label {
                min-width: auto;
                margin-bottom: 0.5rem;
            }

            .form-check-group {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .table-asesmen .label-col {
                width: auto;
            }

            .input-inline {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        // Toggle form fields based on radio selection
        document.addEventListener('DOMContentLoaded', function () {
            // Merokok toggle
            const merokokRadios = document.querySelectorAll('input[name="merokok"]');
            const merokokInputs = document.querySelectorAll('input[name="merokok_jumlah"], input[name="merokok_lama"]');

            merokokRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const isYa = this.value === 'ya';
                    merokokInputs.forEach(input => {
                        input.disabled = !isYa;
                        if (!isYa) input.value = '';
                    });
                });
            });

            // Alkohol toggle
            const alkoholRadios = document.querySelectorAll('input[name="alkohol"]');
            const alkoholInput = document.querySelector('input[name="alkohol_jumlah"]');

            alkoholRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const isYa = this.value === 'ya';
                    alkoholInput.disabled = !isYa;
                    if (!isYa) alkoholInput.value = '';
                });
            });

            // Obat-obatan toggle
            const obatRadios = document.querySelectorAll('input[name="obat_obatan"]');
            const obatInput = document.querySelector('input[name="obat_jenis"]');

            obatRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const isYa = this.value === 'ya';
                    obatInput.disabled = !isYa;
                    if (!isYa) obatInput.value = '';
                });
            });

            // Initial state
            merokokInputs.forEach(input => input.disabled = true);
            alkoholInput.disabled = true;
            obatInput.disabled = true;
        });
    </script>
@endpush
