@extends('layouts.administrator.master')

@push('css')
    <style>
        /* Minimal custom styling */
        .checklist-card {
            transition: background-color 0.2s;
        }

        .checklist-card:hover {
            background-color: #f9f9f9;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="row g-3">
            <!-- Patient Info Card -->
            <div class="col-md-3">
                @include('components.patient-card')
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <x-content-card>
                    <x-button-previous />

                    @include('components.page-header', [
                        'title' => 'Perbarui Checklist Keselamatan (Sign In)',
                        'description' =>
                            'Perbarui data operasi Checklist Keselamatan (Sign In) pasien dengan mengisi formulir di bawah ini.',
                    ])


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ms-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" id="signInForm"
                        action="{{ route('operasi.pelayanan.ceklist-keselamatan.update-signin', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $signin->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Two cards in a row: Medical Staff & Date/Time -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0">Informasi Tim Medis</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Dokter Anestesi</label>
                                            <select class="form-select" name="dokter_anastesi" required>
                                                <option value="" disabled>Pilih Dokter Anestesi</option>
                                                @foreach ($dokterAnastesi as $dokter)
                                                    <option value="{{ $dokter->kd_dokter }}"
                                                        {{ $signin->ahli_anastesi == $dokter->kd_dokter ? 'selected' : '' }}>
                                                        {{ $dokter->dokter->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Perawat</label>
                                            <select class="form-select" name="perawat" required>
                                                <option value="" disabled>Pilih Perawat</option>
                                                @foreach ($perawat as $p)
                                                    <option value="{{ $p->kd_perawat }}"
                                                        {{ $signin->perawat == $p->kd_perawat ? 'selected' : '' }}>
                                                        {{ $p->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0">Waktu Sign In</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Sign In</label>
                                            <input type="date" class="form-control" name="tgl_signin"
                                                value="{{ date('Y-m-d', strtotime($signin->waktu_signin)) }}" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Jam Sign In</label>
                                            <input type="time" class="form-control" name="jam_signin"
                                                value="{{ date('H:i', strtotime($signin->waktu_signin)) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checklist Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Checklist Keselamatan Pasien</h6>
                            </div>
                            <div class="card-body">
                                <!-- Section 1 -->
                                <div class="card mb-3 checklist-card">
                                    <div class="card-header bg-light py-2">
                                        <strong>1. Pasien telah dikonfirmasikan</strong>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td width="60%">a. Identifikasi dan gelang pasien</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="identifikasi" value="1" id="identifikasiYa"
                                                                {{ $signin->identifikasi == 1 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="identifikasiYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="identifikasi" value="0"
                                                                {{ $signin->identifikasi == 0 ? 'checked' : '' }}
                                                                id="identifikasiTidak">
                                                            <label class="form-check-label"
                                                                for="identifikasiTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>b. Lokasi operasi</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="lokasi"
                                                                value="1" id="lokasiYa"
                                                                {{ $signin->lokasi == 1 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="lokasiYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="lokasi"
                                                                value="0" id="lokasiTidak"
                                                                {{ $signin->lokasi == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="lokasiTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>c. Prosedur Operasi</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prosedur"
                                                                value="1" id="prosedurYa"
                                                                {{ $signin->prosedur == 1 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="prosedurYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prosedur"
                                                                value="0" id="prosedurTidak"
                                                                {{ $signin->prosedur == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="prosedurTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>d. Informed Consent Anestesi</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="informed_anestesi" value="1"
                                                                id="informedAnestesiYa"
                                                                {{ $signin->informed_anestesi == 1 ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="informedAnestesiYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="informed_anestesi" value="0"
                                                                id="informedAnestesiTidak"
                                                                {{ $signin->informed_anestesi == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="informedAnestesiTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>e. Informed Consent Operasi</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="informed_operasi" value="1"
                                                                id="informedOperasiYa"
                                                                {{ $signin->informed_operasi == 1 ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="informedOperasiYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="informed_operasi" value="0"
                                                                id="informedOperasiTidak"
                                                                {{ $signin->informed_operasi == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="informedOperasiTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Other Checklist Items -->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr class="checklist-card">
                                                <td width="60%">2. Lokasi operasi sudah diberi tanda?</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="tanda_lokasi" value="1" id="tandaLokasiYa"
                                                            {{ $signin->tanda_lokasi == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="tandaLokasiYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="tanda_lokasi" value="0" id="tandaLokasiTidak"
                                                            {{ $signin->tanda_lokasi == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="tandaLokasiTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="checklist-card">
                                                <td>3. Mesin dan obat-obat anestesi sudah di cek lengkap?</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="mesin_obat"
                                                            value="1" id="mesinObatYa"
                                                            {{ $signin->mesin_obat == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="mesinObatYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="mesin_obat"
                                                            value="0" id="mesinObatTidak"
                                                            {{ $signin->mesin_obat == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mesinObatTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="checklist-card">
                                                <td>4. Pulse oximeter sudah terpasang dan berfungsi?</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="pulse_oximeter" value="1" id="pulseOximeterYa"
                                                            {{ $signin->pulse_oximeter == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="pulseOximeterYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="pulse_oximeter" value="0" id="pulseOximeterTidak"
                                                            {{ $signin->pulse_oximeter == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pulseOximeterTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="checklist-card">
                                                <td>5. Kesulitan bernafas/ resiko aspirasi?</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="kesulitan_bernafas" value="1"
                                                            id="kesulitanBernafasYa"
                                                            {{ $signin->kesulitan_bernafas == 1 ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label"
                                                            for="kesulitanBernafasYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="kesulitan_bernafas" value="0"
                                                            id="kesulitanBernafasTidak"
                                                            {{ $signin->kesulitan_bernafas == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kesulitanBernafasTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="checklist-card">
                                                <td>6. Resiko kehilangan darah > 500 ml (7 ml/kg BB pada anak)?</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="resiko_darah" value="1" id="resikoDarahYa"
                                                            {{ $signin->resiko_darah == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="resikoDarahYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="resiko_darah" value="0" id="resikoDarahTidak"
                                                            {{ $signin->resiko_darah == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="resikoDarahTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="checklist-card">
                                                <td>7. Dua akses intravena/ akses sentral dan rencana terapi cairan?
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="akses_intravena" value="1" id="aksesIntravenaYa"
                                                            {{ $signin->akses_intravena == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="aksesIntravenaYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="akses_intravena" value="0"
                                                            id="aksesIntravenaTidak"
                                                            {{ $signin->akses_intravena == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="aksesIntravenaTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <x-button-submit-confirm label="Perbarui" confirmTitle="Simpan checklist?"
                                confirmText="Pastikan semua isian sudah benar sebelum disimpan." confirmOk="Simpan"
                                confirmCancel="Batal" :spinner="true" loadingLabel="Menyimpan..."
                                loadingOverlay="#loadingOverlay" />
                        </div>
                    </form>
                </x-content-card>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('js/helpers/confirm-form.js') }}"></script>
@endpush
