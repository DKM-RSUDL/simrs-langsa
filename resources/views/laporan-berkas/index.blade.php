@extends('layouts.administrator.master')


@section('content')
    @php
        $dataCard = [
            [
                "name" => "Master Berkas Digital",
                "url" => "#",
                'color' => 'info',
            ],
            [
                "name" => "Setting Berkas Claim",
                "url" => "#",
                'color' => 'info',
            ],
            [
                "name" => "Berkas Digital",
                "url" => "#",
                'color' => 'info',
            ],
            [
                "name" => "Setting Urutan Berkas Digital",
                "url" => "#",
                'color' => 'info',
            ]
        ]
    @endphp
    <div class="row g-4">
        @foreach ($dataCard as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none">
                    <x-content-card>

                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $item['color'] }} text-white rounded p-3 me-3">
                                <i class="{{ $item['icon'] ?? 'bi bi-folder2' }}"></i>
                            </div>
                            <div>
                                <small class="fw-semibold">{{ $item['name'] }}</small>
                            </div>
                        </div>
                    </x-content-card>
                </a>
            </div>
        @endforeach
    </div>




@endsection