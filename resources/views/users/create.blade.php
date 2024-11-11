@extends('layouts.administrator.master')

@section('content')
    <x-form-section title="{{ $title }}">

        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="karyawan">
                            Karyawan
                        </label>

                        <select name="karyawan" id="karyawan"
                            class="form-select select2 @error('karyawan') is-invalid @enderror" required>
                            <option value="">--Pilih Karyawan--</option>
                            @foreach ($karyawan as $kry)
                                <option value="{{ $kry->kd_karyawan }}">
                                    {{ $kry->kd_karyawan . ' | ' . $kry->gelar_depan . ' ' . str()->title($kry->nama) . ' ' . $kry->gelar_belakang }}
                                </option>
                            @endforeach
                        </select>

                        @error('karyawan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">
                            Password
                        </label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror" id="password"
                            value="password" name="password" @required(true)>
                        <small class="text-muted">
                            Ubah jika ingin mengganti password
                        </small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">
                            Role
                        </label>
                        <select class="form-select select2 @error('role') is-invalid @enderror" id="role"
                            name="role" @required(true)>
                            <option value=""></option>
                            @foreach (getRoles() as $role)
                                <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <x-btn-submit-form />

        </form>

    </x-form-section>
@endsection
