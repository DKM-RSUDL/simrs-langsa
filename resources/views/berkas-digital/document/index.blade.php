@extends('layouts.administrator.master')

@push('css')
    <style>
        .tab-minimal {
            border-bottom: 1px solid #e5e7eb;
        }

        .tab-minimal .tab-link {
            background: none;
            border: 1px solid transparent;
            padding: 6px 12px;
            font-size: 14px;
            color: #9ca3af;
            font-weight: 500;
            position: relative;
            cursor: pointer;

            /* rounded di atas saja */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .tab-minimal .tab-link.active {
            color: #111827;
            font-weight: 600;
            background-color: #ffffff;
            border-color: #e5e7eb;
            border-bottom-color: transparent;
            /* nyatu ke konten */
        }

        .tab-minimal .tab-link.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #3b82f6;
        }
    </style>
@endpush

@section('content')

    @php
        $isRawatInap = request()->has('rawat_inap');
        $isRawatJalan = request()->has('rawat_jalan');

        if (!$isRawatInap && !$isRawatJalan) {
            $isRawatInap = true;
        }
    @endphp

    <x-content-card>

        {{-- Tab --}}
        @include('berkas-digital.document.tab-component.index')

        {{-- Content Rawat Inap --}}
        @if(request()->has('rawat_inap') || (!request()->has('rawat_inap') && !request()->has('rawat_jalan')))
            @include('berkas-digital.document.rawat-inap')
        @endif

        {{-- Content Rawat Jalan --}}
        @if(request()->has('rawat_jalan'))
            @include('berkas-digital.document.rawat-jalan')
        @endif

    </x-content-card>

@endsection