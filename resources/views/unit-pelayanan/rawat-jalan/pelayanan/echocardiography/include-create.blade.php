
@push('css')
    <style>
        .covid-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #5a67d8;
        }

        .form-header h4 {
            margin: 0;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-content {
            padding: 20px;
        }

        .symptom-item,
        .risk-item,
        .comorbid-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .symptom-item:hover,
        .risk-item:hover,
        .comorbid-item:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-1px);
        }

        .form-check-input:checked {
            background-color: #48bb78;
            border-color: #48bb78;
        }

        .form-check-input:checked+.form-check-label {
            color: #2d3748;
            font-weight: 500;
        }

        .date-input {
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            transition: border-color 0.3s ease;
        }

        .date-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .assessment-section {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .assessment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .assessment-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .assessment-card:hover {
            border-color: #cbd5e0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .assessment-card.selected {
            border-color: #48bb78;
            background: #f0fff4;
        }

        .assessment-card.suggested {
            border-color: #fbbf24;
            background: #fffbeb;
        }

        .assessment-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .assessment-desc {
            font-size: 0.9em;
            color: #4a5568;
            line-height: 1.5;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary-custom {
            background: #e2e8f0;
            color: #4a5568;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: #cbd5e0;
            color: #2d3748;
        }

        .alert-info-custom {
            background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%);
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .icon-symptom {
            color: #e53e3e;
        }

        .icon-risk {
            color: #d69e2e;
        }

        .icon-comorbid {
            color: #3182ce;
        }

        .icon-assessment {
            color: #805ad5;
        }

        .section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-title {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 20px;
            flex-wrap: wrap;
        }

        .radio-item {
            position: relative;
        }

        .radio-item input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: block;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px 35px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #4a5568;
            min-width: 150px;
        }

        .radio-label i {
            font-size: 2rem;
            margin-bottom: 8px;
            color: #667eea;
        }

        .radio-label:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .radio-item input[type="radio"]:checked+.radio-label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .radio-item input[type="radio"]:checked+.radio-label i {
            color: white;
        }

        .hidden-section {
            display: none;
        }

        .section-card .row {
            padding: 0 20px;
        }

        .section-card .row:last-child {
            padding-bottom: 20px;
        }

        .conclusion-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
            text-align: center;
        }

        .conclusion-card.kontak-erat {
            border-color: #fbbf24;
            background: #fffbeb;
        }

        .conclusion-card.suspek {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .conclusion-card.non-suspek {
            border-color: #10b981;
            background: #f0fdf4;
        }

        @media (max-width: 768px) {
            .assessment-grid {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
        /* CSS untuk suggested assessment cards */
        .assessment-card.suggested {
            border-color: #fbbf24;
            background: #fffbeb;
            position: relative;
        }

        .assessment-card.suggested::after {
            content: "Disarankan";
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fbbf24;
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
            z-index: 10;
        }

        .assessment-card.selected.suggested::after {
            background: #48bb78;
            content: "Dipilih";
        }

        /* Ensure the suggested style doesn't override selected */
        .assessment-card.selected {
            border-color: #48bb78 !important;
            background: #f0fff4 !important;
        }
        </style>
@endpush

@push('js')
    <script>           
    </script>
@endpush
