@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-800: #1f2937;
        }

        .main-wrapper {
            background: white;
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .header-section h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-section p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .toolbar {
            background: var(--gray-50);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .visit-counter {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-add-visit {
            background: var(--success-color);
            border: none;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-add-visit:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .form-container {
            padding: 2rem;
        }

        .visit-card {
            background: white;
            border: 2px solid var(--gray-100);
            border-radius: 16px;
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .visit-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.15);
        }

        .visit-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .visit-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .visit-number {
            background: rgba(255, 255, 255, 0.2);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .btn-remove {
            background: var(--danger-color);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-remove:hover {
            background: #dc2626;
            transform: scale(1.05);
        }

        .form-section {
            padding: 2rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-100);
        }

        .section-icon {
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .required-label::after {
            content: " *";
            color: var(--danger-color);
        }

        .form-control,
        .form-select {
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group .form-control {
            border-radius: 10px 0 0 10px;
            border-right: none;
        }

        .input-group-text {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
            border-radius: 0 10px 10px 0;
            font-weight: 600;
            padding: 0.8rem 1rem;
        }

        .conditional-field {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-color: var(--warning-color) !important;
            display: none;
            position: relative;
        }

        .conditional-field.show {
            display: block;
            animation: slideIn 0.4s ease-out;
        }

        .conditional-field::before {
            content: "📝 Field ini muncul karena Anda memilih 'Ya'";
            position: absolute;
            top: -25px;
            left: 0;
            background: var(--warning-color);
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .help-text {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.3rem;
            font-style: italic;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .three-col {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }

        .four-col {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .submit-section {
            background: var(--gray-50);
            padding: 2rem;
            text-align: center;
            border-top: 1px solid var(--gray-200);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            color: white;
            padding: 1rem 3rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }

        .info-card {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border: none;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
        }

        .legend-section {
            background: var(--gray-50);
            padding: 2rem;
            border-radius: 12px;
            margin-top: 2rem;
        }

        .legend-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .legend-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }

        .legend-item h6 {
            color: var(--gray-800);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .legend-item p {
            color: #6b7280;
            font-size: 0.85rem;
            margin: 0.2rem 0;
        }

        .progress-indicator {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: center;
        }

        .progress-bar-custom {
            background: var(--gray-200);
            height: 6px;
            border-radius: 3px;
            width: 200px;
            overflow: hidden;
        }

        .progress-fill {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                margin: 0;
                border-radius: 0;
            }

            .form-container {
                padding: 1rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .two-col,
            .three-col,
            .four-col {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .toolbar {
                flex-direction: column;
                gap: 1rem;
            }
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
        }
    </style>
@endpush
