@extends('layouts.administrator.master')


@section('content')
    @php
        $dataCard = [
            [
                'name' => 'Master Berkas Digital',
                'url' => route('berkas-digital.master.index'),
                'color' => 'info',
            ],
            [
                'name' => 'Setting Berkas Klaim',
                'url' => route('berkas-digital.setting.index'),
                'color' => 'info',
            ],
            [
                'name' => 'Berkas Digital',
                'url' => '#',
                'color' => 'info',
            ],
            [
                'name' => 'Setting Urutan Berkas Digital',
                'url' => '#',
                'color' => 'info',
            ],
        ];
    @endphp
    <div class="row">
        @foreach ($dataCard as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none">
                    <x-content-card>

                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $item['color'] }} text-white rounded p-3 me-3">
                                <i class="{{ $item['icon'] ?? 'fas fa-folder-open' }}"></i>
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
