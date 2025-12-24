@extends('layouts.administrator.master')


@section('content')
    @php
        $dataCard = [
            [
                "name_card" => "Master Berkas Digital",
                "url" => "#"
            ],
            [
                "name_card" => "Setting Berkas Claim",
                "url" => "#"
            ],
            [
                "name_card" => "Berkas Digital",
                "url" => "#"
            ],
            [
                "name_card" => "Setting Urutan Berkas Digital",
                "url" => "#"
            ]
        ]
    @endphp
    <div class="row g-4">
        @foreach ($dataCard as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none">
                    <div class="card card-dashboard shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="icon-box">
                                <i class="{{ $item['icon'] ?? 'bi bi-folder2' }}"></i>
                            </div>
                            <div>
                                <p class="mb-0 fs-5 card-title text-primary fw-bold">
                                    {{ $item['name_card'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                </a>
            </div>
        @endforeach
    </div>




@endsection