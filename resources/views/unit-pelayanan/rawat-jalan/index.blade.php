@extends('layouts.administrator.master')

@section('content')
    @php
        $cards = [
            ['title' => 'Anak', 'description' => 'Pasien: 0'],
            ['title' => 'Gigi dan Mulut', 'description' => 'Pasien: 0'],
            ['title' => 'Kulit dan Kelamin', 'description' => 'Pasien: 0'],
            ['title' => 'Rheumatology', 'description' => 'Pasien: 0'],
            ['title' => 'Bedah', 'description' => 'Pasien: 0', 'url' => 'bedah.index'],
            ['title' => 'Gigi Periodonti', 'description' => 'Pasien: 0'],
            ['title' => 'Mata', 'description' => 'Pasien: 0'],
            ['title' => 'THT', 'description' => 'Pasien: 0'],
            ['title' => 'Bedah Mulut', 'description' => 'Pasien: 0'],
            ['title' => 'Internis Pria', 'description' => 'Pasien: 3'],
            ['title' => 'Syaraf/Neurology', 'description' => 'Pasien: 0'],
            ['title' => 'TB Dot', 'description' => 'Pasien: 0'],
            ['title' => 'Bedah Digestive', 'description' => 'Pasien: 0'],
            ['title' => 'Internis Wanita', 'description' => 'Pasien: 10'],
            ['title' => 'Obgyn', 'description' => 'Pasien: 0'],
            ['title' => 'Umum', 'description' => 'Pasien: 0'],
            ['title' => 'Bedah Mulut', 'description' => 'Pasien: 0'],
            ['title' => 'Jantung', 'description' => 'Pasien: 0'],
            ['title' => 'Ortopedi', 'description' => 'Pasien: 0'],
            ['title' => 'Urologi', 'description' => 'Pasien: 0'],
            ['title' => 'Geriatri', 'description' => 'Pasien: 10'],
            ['title' => 'Jiwa', 'description' => 'Pasien: 0'],
            ['title' => 'Paru', 'description' => 'Pasien: 0'],
        ];
    @endphp

    <div class="content-wrapper">
        <h5 class="fw-bold">Ruang/Klinik</h5>
        <p>Pilih ruang/klinik pelayanan pasien:</p>
        <div class="row">
            @foreach ($cards as $card)
                <div class="col-md-2 p-2">
                    <a href="{{ isset($card['url']) ? route($card['url']) : '#' }}" class="text-decoration-none card-hover">
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
            @endforeach

        </div>
    </div>
@endsection
