@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.operasi.pelayanan.include.nav')


            <div class="container-fluid py-3">
                <!-- Form Header -->
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h5 class="mb-0 text-secondary fw-bold">CATATAN INTRA DAN PASCA OPERASI</h5>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">CATATAN KEPERAWATAN INTRA OPERASI</h5>
                        <small>Diisi lengkap oleh staf perawat kamar operasi</small>
                    </div>
                    <div class="card-body">
                        <!-- Initial Checklist -->
                        <div class="my-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text">1. Time Out</span>
                                        <span class="input-group-text">Ya Jam:</span>
                                        <input type="text" class="form-control">
                                        <div class="input-group-text">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="timeoutTidak">
                                                <label class="form-check-label" for="timeoutTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">2. Cek kesterilan peralatan dan fungsinya:</label>
                                    <div class="ms-3">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">a. Instrument</span>
                                            <span class="input-group-text">Ya Jam:</span>
                                            <input type="text" class="form-control">
                                            <div class="input-group-text">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="instrumentTidak">
                                                    <label class="form-check-label" for="instrumentTidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">b. Prothese/Implant</span>
                                            <span class="input-group-text">Ya Jam:</span>
                                            <input type="text" class="form-control">
                                            <div class="input-group-text">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="protheseTidak">
                                                    <label class="form-check-label" for="protheseTidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Operation Time -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Mulai Pukul:</label>
                                    <input type="time" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Selesai Pukul:</label>
                                    <input type="time" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Operation Type -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dilakukan operasi/Jenis Operasi:</label>
                            <input type="text" class="form-control mb-2">
                            <label class="form-label">Tipe operasi:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="elektif">
                                <label class="form-check-label" for="elektif">Elektif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="darurat">
                                <label class="form-check-label" for="darurat">Darurat</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="odc">
                                <label class="form-check-label" for="odc">Operasi ODC</label>
                            </div>
                        </div>

                        <!-- Detailed Checklist -->
                        <div class="mb-3">
                            <div class="row g-3">
                                <!-- 1. Consciousness Level -->
                                <div class="col-12">
                                    <label class="form-label">1. Tingkat Kesadaran Waktu Masuk Kamar Operasi:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="tenang">
                                            <label class="form-check-label" for="tenang">Tenang</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="mudahDibangunkan">
                                            <label class="form-check-label" for="mudahDibangunkan">Mudah
                                                dibangunkan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Surgery Type -->
                                <div class="col-12">
                                    <label class="form-label">2. Tipe Pembedahan:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="umum">
                                            <label class="form-check-label" for="umum">Umum</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lokal">
                                            <label class="form-check-label" for="lokal">Lokal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="regional">
                                            <label class="form-check-label" for="regional">Regional</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. IV Position -->
                                <div class="col-12">
                                    <label class="form-label">3. Posisi Kanula Intra Vena:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="tanganKanan">
                                            <label class="form-check-label" for="tanganKanan">Tangan Kanan/Ki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="kakiKanan">
                                            <label class="form-check-label" for="kakiKanan">Kaki Kanan/Ki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="arteriLine">
                                            <label class="form-check-label" for="arteriLine">Arterial Line</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cvp">
                                            <label class="form-check-label" for="cvp">CVP</label>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text">Lain-lain:</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Operation Position -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">4. Posisi Operasi (Diawasi Oleh):</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="telentang">
                                                    <label class="form-check-label" for="telentang">Telentang</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="lithotomy">
                                                    <label class="form-check-label" for="lithotomy">Lithotomy</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="tengkurap">
                                                    <label class="form-check-label" for="tengkurap">Tengkurap</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="lateralKaKi">
                                                    <label class="form-check-label" for="lateralKaKi">Lateral
                                                        Ka/Ki</label>
                                                </div>
                                            </div>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text">Lain-lain:</span>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. Arm Position -->
                                <div class="col-12">
                                    <label class="form-label">5. Posisi Lengan:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lenganTerentang">
                                            <label class="form-check-label" for="lenganTerentang">Lengan Terentang
                                                Ka/Ki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lenganTerlipat">
                                            <label class="form-check-label" for="lenganTerlipat">Lengan Terlipat
                                                Ka/Ki</label>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text">Lain-lain:</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- 6. Support Equipment -->
                                <div class="col-12">
                                    <label class="form-label">6. Posisi Alat Bantu Yang Digunakan:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="paparanLengan">
                                            <label class="form-check-label" for="paparanLengan">Papan Lengan
                                                Penyangga</label>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text">Lain-lain:</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- 7. Catheter Use -->
                                <div class="col-12">
                                    <label class="form-label">7. Memakai Kateter Urin:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kateter"
                                                id="ya">
                                            <label class="form-check-label" for="ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kateter"
                                                id="tidak">
                                            <label class="form-check-label" for="tidak">Tidak</label>
                                        </div>
                                        <span class="ms-3">Bila Ya, dilakukan di:</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="kamarOperasi">
                                            <label class="form-check-label" for="kamarOperasi">Kamar Operasi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="ruangan">
                                            <label class="form-check-label" for="ruangan">Ruangan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 8. Skin Preparation -->
                                <div class="col-12">
                                    <label class="form-label">8. Persiapan Kulit:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="chlorhexidine">
                                            <label class="form-check-label" for="chlorhexidine">Chlorhexidine 70%</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="povidone">
                                            <label class="form-check-label"
                                                for="povidone">Povidone-Iodine/Betadine</label>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text">Lain-lain:</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- 9. Diathermy Usage -->
                                <div class="col-12">
                                    <label class="form-label">9. Pemakaian Diathermy:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="tidak">
                                            <label class="form-check-label" for="tidak">Tidak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="monopolar">
                                            <label class="form-check-label" for="monopolar">Monopolar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="bipolar">
                                            <label class="form-check-label" for="bipolar">Bipolar</label>
                                        </div>

                                        <!-- Diathermy Sub-items -->
                                        <div class="ms-4 mt-2">
                                            <div class="mb-2">
                                                <label class="form-label">• Lokasi dan Dispersive Electrode:</label>
                                                <div class="form-check form-check-inline ms-2">
                                                    <input class="form-check-input" type="checkbox" id="bokongKaki">
                                                    <label class="form-check-label" for="bokongKaki">Bokong Kaki</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="pahaKaki">
                                                    <label class="form-check-label" for="pahaKaki">Paha Kaki</label>
                                                </div>
                                                <div class="input-group d-inline-flex ms-2" style="width: auto;">
                                                    <span class="input-group-text">Lain-lain:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">• Pemeriksaan Kondisi Kulit Sebelum
                                                    Operasi:</label>
                                                <div class="form-check form-check-inline ms-2">
                                                    <input class="form-check-input" type="checkbox" id="utuh">
                                                    <label class="form-check-label" for="utuh">Utuh</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="mengelembung">
                                                    <label class="form-check-label"
                                                        for="mengelembung">Mengelembung</label>
                                                </div>
                                                <div class="input-group d-inline-flex ms-2" style="width: auto;">
                                                    <span class="input-group-text">Lain-lain:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">• Pemeriksaan Kondisi Kulit Sesudah
                                                    Operasi:</label>
                                                <div class="form-check form-check-inline ms-2">
                                                    <input class="form-check-input" type="checkbox" id="utuhSetelah">
                                                    <label class="form-check-label" for="utuhSetelah">Utuh</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="mengelembungSetelah">
                                                    <label class="form-check-label"
                                                        for="mengelembungSetelah">Mengelembung</label>
                                                </div>
                                                <div class="input-group d-inline-flex ms-2" style="width: auto;">
                                                    <span class="input-group-text">Lain-lain:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <div class="input-group">
                                                    <span class="input-group-text">Kode Unit Elektrosurgikal:</span>
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-text">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="tidakElektro">
                                                            <label class="form-check-label"
                                                                for="tidakElektro">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 10. Temperature Control Unit -->
                                <div class="col-12">
                                    <label class="form-label">10. Unit Pendingin / Penghangat Operasi:</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="unitSuhu"
                                                id="suhuYa">
                                            <label class="form-check-label" for="suhuYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="unitSuhu"
                                                id="suhuTidak">
                                            <label class="form-check-label" for="suhuTidak">Tidak</label>
                                        </div>
                                        <span class="ms-2">Bila Ya, Pengukuran temperatur:</span>

                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">mulai</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">°C</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">jam mulai</span>
                                                    <input type="time" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">selesai</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">°C</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">jam selesai</span>
                                                    <input type="time" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group mt-2">
                                            <span class="input-group-text">Kode Unit</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- 11. Tourniquet Usage -->
                                <div class="mb-3">
                                    <label class="form-label">11. Pemakaian Torniquet</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="torniquetYa">
                                            <label class="form-check-label" for="torniquetYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="torniquetTidak">
                                            <label class="form-check-label" for="torniquetTidak">Tidak</label>
                                        </div>
                                        <div class="mt-2">
                                            <label>(Diawasi oleh: <input type="text" class="form-control-sm d-inline"
                                                    style="width: 200px;">)</label>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Lokasi</th>
                                                        <th>Waktu mulai</th>
                                                        <th>Waktu Selesai</th>
                                                        <th>Tekanan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="lenganKanan">
                                                                <label class="form-check-label" for="lenganKanan">Lengan
                                                                    Kanan</label>
                                                            </div>
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="text" class="form-control form-control-sm">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="kakiKanan">
                                                                <label class="form-check-label" for="kakiKanan">Kaki
                                                                    Kanan</label>
                                                            </div>
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="text" class="form-control form-control-sm">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="lenganKiri">
                                                                <label class="form-check-label" for="lenganKiri">Lengan
                                                                    Kiri</label>
                                                            </div>
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="text" class="form-control form-control-sm">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="kakiKiri">
                                                                <label class="form-check-label" for="kakiKiri">Kaki
                                                                    Kiri</label>
                                                            </div>
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="time" class="form-control form-control-sm">
                                                        </td>
                                                        <td><input type="text" class="form-control form-control-sm">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- 12. Laser Usage -->
                                <div class="mb-3">
                                    <label class="form-label">12. Pemakaian Laser</label>
                                    <div class="ms-3">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <label>Diawasi oleh:</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="text" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-auto">
                                                <label>Kode Model:</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="text" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 13. Implant Usage -->
                                <div class="mb-3">
                                    <label class="form-label">13. Pemakaian Implant Da</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="implantYa">
                                            <label class="form-check-label" for="implantYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="implantTidak">
                                            <label class="form-check-label" for="implantTidak">Tidak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="implantKedua">
                                            <label class="form-check-label" for="implantKedua">Keduanya</label>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label>Type:</label>
                                                <input type="text" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Size:</label>
                                                <input type="text" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <label>No Seri:</label>
                                                <input type="text" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 14. Instrument Count -->
                                <div class="mb-3">
                                    <label class="form-label">14. Hitung Instrument/Kassa/Jarum</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Hitung</th>
                                                    <th>Kassa</th>
                                                    <th>Jarum</th>
                                                    <th>Instrument</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Hitung 1</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hitung 2</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hitung 3</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Jumlah:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="row g-2">
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tidakLengkapKassa">
                                                                    <label class="form-check-label"
                                                                        for="tidakLengkapKassa">Tidak Lengkap</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tidakPerluKassa">
                                                                    <label class="form-check-label"
                                                                        for="tidakPerluKassa">Tidak Perlu</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tidakLengkapJarum">
                                                                    <label class="form-check-label"
                                                                        for="tidakLengkapJarum">Tidak Lengkap</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tidakPerluJarum">
                                                                    <label class="form-check-label"
                                                                        for="tidakPerluJarum">Tidak Perlu</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tidakLengkapInstrument">
                                                                    <label class="form-check-label"
                                                                        for="tidakLengkapInstrument">Tidak Lengkap</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tidakPerluInstrument">
                                                                    <label class="form-check-label"
                                                                        for="tidakPerluInstrument">Tidak Perlu</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="mb-3">
                                            <label>Hitungan ACC oleh Dokter Bedah:</label>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Tanda tangan dan Nama jelas:</label>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Catatan:</label>
                                            <div class="ms-3">
                                                <p>Jika hitungan tidak lengkap, setelah dicari tidak ditemukan.</p>
                                                <p>Bila lengkap, Dokter Bedah langsung tanda tangan.</p>
                                                <div class="form-check form-check-inline">
                                                    <label>Penggunaan tampon:</label>
                                                    <input class="form-check-input ms-2" type="radio" name="tampon"
                                                        id="tamponYa">
                                                    <label class="form-check-label" for="tamponYa">Ya</label>
                                                    <input class="form-check-input ms-2" type="radio" name="tampon"
                                                        id="tamponTidak">
                                                    <label class="form-check-label" for="tamponTidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <!-- 15. Drain Usage -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">15. Pemakaian Drain</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 25%">TIPE DRAIN</th>
                                                    <th style="width: 25%">JENIS DRAIN</th>
                                                    <th style="width: 25%">UKURAN</th>
                                                    <th style="width: 25%">KETERANGAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" class="form-control"></td>
                                                    <td><input type="text" class="form-control"></td>
                                                    <td><input type="text" class="form-control"></td>
                                                    <td><input type="text" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control"></td>
                                                    <td><input type="text" class="form-control"></td>
                                                    <td><input type="text" class="form-control"></td>
                                                    <td><input type="text" class="form-control"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- 16. Wound Irrigation -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">16. Irigasi Luka</label>
                                    <div class="ms-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="sodiumChloride">
                                                    <label class="form-check-label" for="sodiumChloride">Sodium Chloride
                                                        0,9%</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="h2o2">
                                                    <label class="form-check-label" for="h2o2">H₂O₂</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="antiWalkSpray">
                                                    <label class="form-check-label" for="antiWalkSpray">AntiWalk
                                                        Spray</label>
                                                </div>
                                                <div class="input-group mb-2" style="width: 250px;">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox">
                                                    </div>
                                                    <span class="input-group-text">Lain-lain:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 17. Fluid Usage -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">17. Pemakaian Cairan</label>
                                    <div class="ms-3">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Steryn:</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">Liter</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="bss">
                                                    <label class="form-check-label" for="bss">BSS Solution</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">Air untuk irigasi:</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">Liter</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox">
                                                    </div>
                                                    <span class="input-group-text">Lain-lain:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox">
                                                    </div>
                                                    <span class="input-group-text">Sodium Chloride 0,9%:</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">Liter</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 18. Left Equipment -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">18. Alat-alat tertinggal</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="tidakAda">
                                            <label class="form-check-label" for="tidakAda">Tidak Ada</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="ada">
                                            <label class="form-check-label" for="ada">Ada</label>
                                        </div>
                                        <div class="input-group mt-2" style="width: 300px;">
                                            <span class="input-group-text">Jenis:</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- 19. Bandage -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">19. Balutan</label>
                                    <div class="ms-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="tidakAdaBalutan">
                                            <label class="form-check-label" for="tidakAdaBalutan">Tidak Ada</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="pressure">
                                            <label class="form-check-label" for="pressure">Pressure</label>
                                        </div>
                                        <div class="input-group mt-2" style="width: 300px;">
                                            <span class="input-group-text">(Jenis:</span>
                                            <input type="text" class="form-control">
                                            <span class="input-group-text">)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 20. Specimen -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">20. Spesimen</label>
                                    <div class="ms-3">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Histologi (Jenis</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">)</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Kultur (Jenis</span>
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-text">)</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Frozen Section</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text">Jumlah Total Jaringan/Cairan
                                                    Pemeriksaan:</span>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Spesimen untuk pasien:</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Jenis dari jaringan:</span>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Jumlah dari jaringan:</span>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Signature Section -->
                                <div class="mb-4">
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama jelas dan tanda tangan perawat
                                                instrumen:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nama jelas dan tanda tangan perawat sirkuler:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endsection
