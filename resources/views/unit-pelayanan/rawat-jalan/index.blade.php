@extends('layouts.administrator.master')

@section('content')
    <h6>Ruang/Klinik</h6>

    <div class="row mt-5">
        <div class="col-md-3">
            <a href="{{ route('bedah.index') }}">Bedah</a>
            {{-- <a href="{{ url('unit-pelayanan.rawat-jalan.bedah.index') }}">Bedah</a> --}}
            <p>Pasien: 23</p>
        </div>
        <div class="col-md-3">
            <a href="">Gigi dan Mulut</a>
            <p>Pasien: 03</p>
        </div>
        <div class="col-md-3">
            <a href="">Kulit dan Kelamin</a>
            <p>Pasien: 43</p>
        </div>
        <div class="col-md-3">
            <a href="">Rheumatology</a>
            <p>Pasien: 43</p>
        </div>

        <div class="mt-5"></div>

        <div class="col-md-3">
            <a href="">Bedah</a>
            <p>Pasien: 03</p>
        </div>
        <div class="col-md-3">
            <a href="">Gigi Periodonti</a>
            <p>Pasien: 03</p>
        </div>
        <div class="col-md-3">
            <a href="">Mata</a>
            <p>Pasien: 11</p>
        </div>
        <div class="col-md-3">
            <a href="">THT</a>
            <p>Pasien: 01</p>
        </div>

        <div class="mt-5"></div>

        <div class="col-md-3">
            <a href="">Internis pria</a>
            <p>Pasien: 23</p>
        </div>
        <div class="col-md-3">
            <a href="">Internis Wanita</a>
            <p>Pasien: 03</p>
        </div>
        <div class="col-md-3">
            <a href="">TB</a>
            <p>Pasien: 43</p>
        </div>
        <div class="col-md-3">
            <a href="">Umum</a>
            <p>Pasien: 43</p>
        </div>
    </div>
@endsection
