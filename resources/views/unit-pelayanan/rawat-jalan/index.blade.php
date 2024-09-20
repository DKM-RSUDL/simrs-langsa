@extends('layouts.administrator.master')

@section('content')
    @php
        $cards = [
            ['title' => 'Anak', 'description' => 'Pasien: 0', 'roles' => ['admin', 'dokter']],
            ['title' => 'Gigi dan Mulut', 'description' => 'Pasien: 0', 'roles' => ['admin', 'dokter']],
            ['title' => 'Kulit dan Kelamin', 'description' => 'Pasien: 0', 'roles' => ['admin', 'dokter']],
            ['title' => 'Rheumatology', 'description' => 'Pasien: 0', 'roles' => ['admin', 'dokter']],
            ['title' => 'Bedah', 'description' => 'Pasien: 0', 'url' => 'bedah.index', 'roles' => ['admin', 'dokter']],
            ['title' => 'Gigi Periodonti', 'description' => 'Pasien: 0', 'roles' => ['admin']],
            ['title' => 'Mata', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'THT', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Bedah Mulut', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Internis Pria', 'description' => 'Pasien: 3', 'roles' => ['admin', 'dokter']],
            ['title' => 'Syaraf/Neurology', 'description' => 'Pasien: 0', 'roles' => ['admin']],
            ['title' => 'TB Dot', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Bedah Digestive', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Internis Wanita', 'description' => 'Pasien: 10', 'roles' => ['admin']],
            ['title' => 'Obgyn', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Umum', 'description' => 'Pasien: 0', 'roles' => ['admin', 'user']],
            ['title' => 'Bedah Mulut', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Jantung', 'description' => 'Pasien: 0', 'roles' => ['admin', 'dokter']],
            ['title' => 'Ortopedi', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Urologi', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Geriatri', 'description' => 'Pasien: 10', 'roles' => ['admin', 'dokter']],
            ['title' => 'Jiwa', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
            ['title' => 'Paru', 'description' => 'Pasien: 0', 'roles' => ['dokter']],
        ];
    @endphp

    <div class="content-wrapper">
        <h5 class="fw-bold">Ruang/Klinik</h5>
        <p>Pilih ruang/klinik pelayanan pasien:</p>
        <div class="row">
            @foreach ($cards as $card)
                @if (isset($card['roles']) &&
                        auth()->user()->hasAnyRole($card['roles']))
                    <div class="col-md-3 p-2">
                        <a href="{{ isset($card['url']) ? route($card['url']) : '#' }}"
                            class="text-decoration-none card-hover">
                            <div class="card mb-3 rounded-5 bg-white dark:bg-dark text-dark dark:text-light">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold text-primary">{{ $card['title'] }}</h6>
                                    <hr class="text-secondary">
                                    <p class="text-black">
                                        <img src="{{ asset('assets/img/Account.png') }}" alt="" width="15%">
                                        {{ $card['description'] }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
