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

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        textarea.form-control {
            min-height: 100px;
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
                        'title' => 'Perbarui Checklist Keselamatan (Sign Out)',
                        'description' =>
                            'Perbarui data operasi Checklist Keselamatan (Sign Out) pasien dengan mengisi formulir di bawah ini.',
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

                    <form method="POST" id="signOutForm"
                        action="{{ route('operasi.pelayanan.ceklist-keselamatan.update-signout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $signout->id]) }}"
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
                                                        {{ $signout->ahli_bedah == $d->kd_dokter ? 'selected' : '' }}>
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
                                                        {{ $signout->ahli_anastesi == $dokter->kd_dokter ? 'selected' : '' }}>
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
                                                        {{ $signout->perawat == $p->kd_perawat ? 'selected' : '' }}>
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
                                        <h6 class="mb-0">Waktu Sign Out</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Sign Out</label>
                                            <input type="date" class="form-control" name="tgl_signout"
                                                value="{{ date('Y-m-d', strtotime($signout->waktu_signout)) }}" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Jam Sign Out</label>
                                            <input type="time" class="form-control" name="jam_signout"
                                                value="{{ date('H:i', strtotime($signout->waktu_signout)) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checklist Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Checklist Keselamatan Pasien (Sign Out)</h6>
                                <small class="text-muted">Diisi oleh Perawat, Dokter Anastesi dan Operator Sebelum Tutup
                                    Luka Operasi</small>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">NO</th>
                                                <th width="65%">KETERANGAN</th>
                                                <th width="15%">YA</th>
                                                <th width="15%">TIDAK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Item 1 -->
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>
                                                    <strong>Perawat melakukan konfirmasi secara verbal dengan tim:</strong>
                                                </td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>a. Nama prosedur tindakan telah dicatat</td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="konfirmasi_prosedur" value="1"
                                                            id="konfirmasiProsedurYa"
                                                            {{ $signout->konfirmasi_prosedur == 1 ? 'checked' : '' }}
                                                            required>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="konfirmasi_prosedur" value="0"
                                                            id="konfirmasiProsedurTidak"
                                                            {{ $signout->konfirmasi_prosedur == 0 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>b. Instrument, sponge, dan jarum telah dihitung dengan benar</td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="konfirmasi_instrumen" value="1"
                                                            id="konfirmasiInstrumenYa"
                                                            {{ $signout->konfirmasi_instrumen == 1 ? 'checked' : '' }}
                                                            required>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="konfirmasi_instrumen" value="0"
                                                            id="konfirmasiInstrumenTidak"
                                                            {{ $signout->konfirmasi_instrumen == 0 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>c. Spesimen telah diberi label (termasuk nama pasien dan asal jaringan
                                                    specimen)</td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="konfirmasi_spesimen" value="1"
                                                            id="konfirmasiSpesimenYa"
                                                            {{ $signout->konfirmasi_spesimen == 1 ? 'checked' : '' }}
                                                            required>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="konfirmasi_spesimen" value="0"
                                                            id="konfirmasiSpesimenTidak"
                                                            {{ $signout->konfirmasi_spesimen == 0 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>d. Adakah masalah dengan peralatan selama operasi?</td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="masalah_peralatan" value="1"
                                                            id="masalahPeralatanYa"
                                                            {{ $signout->masalah_peralatan == 1 ? 'checked' : '' }}
                                                            required>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio"
                                                            name="masalah_peralatan" value="0"
                                                            id="masalahPeralatanTidak"
                                                            {{ $signout->masalah_peralatan == 0 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Item 2 -->
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>
                                                    <strong>Dokter bedah, dokter Anastesi, dan perawat melakukan review
                                                        masalah utama apa yang harus diperhatikan untuk penyembuhan dan
                                                        manajemen pasien selanjutnya.</strong>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio" name="review_tim"
                                                            value="1" id="reviewTimYa"
                                                            {{ $signout->review_tim == 1 ? 'checked' : '' }} required>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio" name="review_tim"
                                                            value="0" id="reviewTimTidak"
                                                            {{ $signout->review_tim == 0 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Item 3 -->
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>
                                                    <strong>Hal-hal yang harus diperhatikan:</strong>
                                                </td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <textarea class="form-control" name="catatan_penting" rows="4"
                                                        placeholder="Tuliskan hal-hal yang harus diperhatikan...">{{ $signout->catatan_penting }}</textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                                    class="text-muted">{{ $signout->dokterBedah->nama_lengkap ?? 'Diisi otomatis saat disimpan' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">Digital</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ahli Anestesi</td>
                                            <td>
                                                <span
                                                    class="text-muted">{{ $signout->dokterAnastesi->dokter->nama_lengkap ?? 'Diisi otomatis saat disimpan' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">Digital</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Perawat</td>
                                            <td>
                                                <span
                                                    class="text-muted">{{ $signout->perawatData->nama ?? 'Diisi otomatis saat disimpan' }}</span>
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
