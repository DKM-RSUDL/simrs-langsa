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
                        'title' => 'Perbarui Checklist Keselamatan (Time Out)',
                        'description' =>
                            'Perbarui data operasi Checklist Keselamatan (Time Out) pasien dengan mengisi formulir di bawah ini.',
                    ])

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" id="timeOutForm"
                        action="{{ route('operasi.pelayanan.ceklist-keselamatan.update-timeout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $timeout->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Two cards in a row: Medical Staff & Date/Time -->
                        <div class="row g-3 mb-3 mt-2">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0">Informasi Tim Medis</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Ahli Bedah</label>
                                            <select class="form-select" name="ahli_bedah" required>
                                                <option value="" disabled>Pilih Ahli Bedah</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $timeout->ahli_bedah == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Dokter Anestesi</label>
                                            <select class="form-select" name="dokter_anastesi" required>
                                                <option value="" disabled>Pilih Dokter Anestesi</option>
                                                @foreach ($dokterAnastesi as $dokter)
                                                    <option value="{{ $dokter->kd_dokter }}"
                                                        {{ $timeout->ahli_anastesi == $dokter->kd_dokter ? 'selected' : '' }}>
                                                        {{ $dokter->dokter->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Perawat</label>
                                            <select class="form-select" name="perawat" required>
                                                <option value="" disabled>Pilih Perawat</option>
                                                @foreach ($perawat as $p)
                                                    <option value="{{ $p->kd_perawat }}"
                                                        {{ $timeout->perawat == $p->kd_perawat ? 'selected' : '' }}>
                                                        {{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0">Waktu Time Out</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Time Out</label>
                                            <input type="date" class="form-control" name="tgl_timeout"
                                                value="{{ date('Y-m-d', strtotime($timeout->waktu_timeout)) }}" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Jam Time Out</label>
                                            <input type="time" class="form-control" name="jam_timeout"
                                                value="{{ date('H:i', strtotime($timeout->waktu_timeout)) }}" required>
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
                                        <strong>1. Konfirmasi seluruh anggota tim telah memperkenalkan nama dan
                                            peran</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="konfirmasi_tim"
                                                value="1" id="konfirmasiTimYa"
                                                {{ $timeout->konfirmasi_tim == 1 ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="konfirmasiTimYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="konfirmasi_tim"
                                                value="0" {{ $timeout->konfirmasi_tim == 0 ? 'checked' : '' }}
                                                id="konfirmasiTimTidak">
                                            <label class="form-check-label" for="konfirmasiTimTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div class="card mb-3 checklist-card">
                                    <div class="card-header bg-light py-2">
                                        <strong>2. Dokter bedah, dokter anestesi dan Perawat melakukan konfirmasi secara
                                            Verbal</strong>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td width="60%">a. Nama pasien</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="konfirmasi_nama" value="1" id="konfirmasiNamaYa"
                                                                {{ $timeout->konfirmasi_nama == 1 ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="konfirmasiNamaYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="konfirmasi_nama" value="0"
                                                                {{ $timeout->konfirmasi_nama == 0 ? 'checked' : '' }}
                                                                id="konfirmasiNamaTidak">
                                                            <label class="form-check-label"
                                                                for="konfirmasiNamaTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>b. Prosedur</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="konfirmasi_prosedur" value="1"
                                                                id="konfirmasiProsedurYa"
                                                                {{ $timeout->konfirmasi_prosedur == 1 ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="konfirmasiProsedurYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="konfirmasi_prosedur" value="0"
                                                                id="konfirmasiProsedurTidak"
                                                                {{ $timeout->konfirmasi_prosedur == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="konfirmasiProsedurTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>c. Lokasi dimana insisi akan dibuat/posisi</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="konfirmasi_lokasi" value="1"
                                                                id="konfirmasiLokasiYa"
                                                                {{ $timeout->konfirmasi_lokasi == 1 ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="konfirmasiLokasiYa">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="konfirmasi_lokasi" value="0"
                                                                id="konfirmasiLokasiTidak"
                                                                {{ $timeout->konfirmasi_lokasi == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="konfirmasiLokasiTidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Section 3 -->
                                <div class="card mb-3 checklist-card">
                                    <div class="card-header bg-light py-2">
                                        <strong>3. Apakah antibiotik profilaksis sudah diberikan sebelumnya?</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="antibiotik_profilaksis" value="1" id="antibiotikYa"
                                                    {{ $timeout->antibiotik_profilaksis == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="antibiotikYa">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="antibiotik_profilaksis" value="0"
                                                    {{ $timeout->antibiotik_profilaksis == 0 ? 'checked' : '' }}
                                                    id="antibiotikTidak">
                                                <label class="form-check-label" for="antibiotikTidak">Tidak</label>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">a. Nama antibiotik yang diberikan</label>
                                                <input type="text" class="form-control" name="nama_antibiotik"
                                                    value="{{ $timeout->nama_antibiotik }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">b. Dosis antibiotik yang diberikan</label>
                                                <input type="text" class="form-control" name="dosis_antibiotik"
                                                    value="{{ $timeout->dosis_antibiotik }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 4 -->
                                <div class="card mb-3 checklist-card">
                                    <div class="card-header bg-light py-2">
                                        <strong>4. Antisipasi Kejadian Kritis</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">a. Review dokter bedah: langkah apa yang akan
                                                dilakukan bila kondisi kritis atau kejadian yang tidak diharapkan
                                                lamanya operasi, antisipasi kehilangan darah?</label>
                                            <textarea class="form-control" name="review_bedah" rows="3">{{ $timeout->review_bedah }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">b. Review tim anastesi: apakah ada hal khusus
                                                yang perlu diperhatikan pada pasien?</label>
                                            <textarea class="form-control" name="review_anastesi" rows="3">{{ $timeout->review_anastesi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">c. Review tim perawat: apakah peralatan sudah
                                                steril, adakah alat-alat yang perlu diperhatikan khusus atau dalam
                                                masalah?</label>
                                            <textarea class="form-control" name="review_perawat" rows="3">{{ $timeout->review_perawat }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 5 -->
                                <div class="card mb-3 checklist-card">
                                    <div class="card-header bg-light py-2">
                                        <strong>5. Apakah foto rontgen/CT-Scan dan MRI telah ditayangkan?</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="foto_rontgen"
                                                value="1" id="fotoRontgenYa"
                                                {{ $timeout->foto_rontgen == 1 ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="fotoRontgenYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="foto_rontgen"
                                                value="0" {{ $timeout->foto_rontgen == 0 ? 'checked' : '' }}
                                                id="fotoRontgenTidak">
                                            <label class="form-check-label" for="fotoRontgenTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanda Tangan Tim -->
                                <h6 class="mb-0 mt-4">Tanda Tangan Tim</h6>
                                <p class="text-muted mb-3">Catatan: Tanda tangan akan diperbarui secara digital
                                    saat menyimpan form.</p>

                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30%">Tim</th>
                                            <th width="40%">Nama</th>
                                            <th width="30%">Tanda tangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ahli Bedah</td>
                                            <td>
                                                <span
                                                    class="text-muted">{{ $timeout->dokterBedah->nama_lengkap ?? 'Diisi otomatis saat disimpan' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">Digital</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ahli Anestesi</td>
                                            <td>
                                                <span
                                                    class="text-muted">{{ $timeout->dokterAnastesi->dokter->nama_lengkap ?? 'Diisi otomatis saat disimpan' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">Digital</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Perawat</td>
                                            <td>
                                                <span
                                                    class="text-muted">{{ $timeout->perawatData->nama ?? 'Diisi otomatis saat disimpan' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">Digital</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
