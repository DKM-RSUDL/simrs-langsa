@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .assessment-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .assessment-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .date-badge {
            background: linear-gradient(135deg, #2047f5 0%, #31389c 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
        }

        .day-number {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .day-month {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        .assessment-title {
            color: #2563eb;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            text-decoration: none;
        }

        .assessment-title:hover {
            color: #1d4ed8;
            text-decoration: none;
        }

        .doctor-name {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .action-buttons .btn {
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            margin-left: 0.25rem;
        }

        .btn-view {
            background-color: #06b6d4;
            border-color: #06b6d4;
            color: white;
        }

        .btn-view:hover {
            background-color: #0891b2;
            border-color: #0891b2;
            color: white;
        }

        .btn-edit {
            background-color: #6b7280;
            border-color: #6b7280;
            color: white;
        }

        .btn-edit:hover {
            background-color: #4b5563;
            border-color: #4b5563;
            color: white;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.75rem;
        }

        .search-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
@endpush