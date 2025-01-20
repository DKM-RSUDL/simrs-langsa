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
                    <h5 class="mb-0 text-secondary fw-bold">ASESMEN PRA OPERASI</h5>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form>
                            <!-- Section A -->
                            <div class="mb-4">
                                <h6 class="fw-bold">A. CATATAN KEPERAWATAN PRA OPERASI</h6>
                                <p class="text-muted small">(Diisi oleh perawat ruangan maksimal 1 jam sebelum diantar ke
                                    kamar operasi)</p>

                                <!-- Vital Signs -->
                                <div class="row mb-3">
                                    <label class="col-md-3">1. Tanda-tanda vital</label>
                                    <div class="col-md-9">
                                        <div class="row g-2">
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">Suhu:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">Nadi:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">RR:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">TD:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">Skor Nyeri:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">TB:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <span class="input-group-text">BB:</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        style="width: 70px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Mental -->
                                <div class="row mb-3">
                                    <label class="col-md-3">2. Status mental</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="sadarPenuh">
                                            <label class="form-check-label" for="sadarPenuh">Sadar penuh</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="bingung">
                                            <label class="form-check-label" for="bingung">Bingung</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="mengantuk">
                                            <label class="form-check-label" for="mengantuk">Mengantuk</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="koma">
                                            <label class="form-check-label" for="koma">Koma</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Riwayat Penyakit -->
                                <div class="row mb-3">
                                    <label class="col-md-3">3. Riwayat penyakit</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hipertensi">
                                            <label class="form-check-label" for="hipertensi">Hipertensi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="diabetes">
                                            <label class="form-check-label" for="diabetes">Diabetes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hepatitis">
                                            <label class="form-check-label" for="hepatitis">Hepatitis</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lainLain">
                                            <label class="form-check-label" for="lainLain">Lain-lain</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pengobatan saat ini -->
                                <div class="row mb-3">
                                    <label class="col-md-3">4. Pengobatan saat ini</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan pengobatan saat ini">
                                    </div>
                                </div>

                                <!-- Alat bantu -->
                                <div class="row mb-3">
                                    <label class="col-md-3">5. Alat bantu yang digunakan</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Masukkan alat bantu">
                                    </div>
                                </div>

                                <!-- Operasi sebelumnya -->
                                <div class="row mb-3">
                                    <label class="col-md-3">6. Operasi sebelumnya</label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Jenis operasi:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Kapan:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Di:</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alergi -->
                                <div class="row mb-3">
                                    <label class="col-md-3">7. Alergi</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="alergi"
                                                id="tidakAda">
                                            <label class="form-check-label" for="tidakAda">Tidak ada</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="alergi"
                                                id="tidakDiketahui">
                                            <label class="form-check-label" for="tidakDiketahui">Tidak diketahui</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="alergi"
                                                id="ada">
                                            <label class="form-check-label" for="ada">Ada, jelaskan:</label>
                                            <input type="text" class="form-control form-control-sm ms-2"
                                                style="width: 200px">
                                        </div>
                                    </div>
                                </div>

                                <!-- Laboratory Results -->
                                <div class="row mb-3">
                                    <label class="col-md-3">8. Hasil Laboratorium</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hb">
                                            <label class="form-check-label" for="hb">HB</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="bt">
                                            <label class="form-check-label" for="bt">BT</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="ct">
                                            <label class="form-check-label" for="ct">CT/APTT</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="gol_darah">
                                            <label class="form-check-label" for="gol_darah">Gol Darah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="urine">
                                            <label class="form-check-label" for="urine">Urine</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lainLainLab">
                                            <label class="form-check-label" for="lainLainLab">Lain-lain:</label>
                                            <input type="text" class="form-control form-control-sm ms-2"
                                                style="width: 150px">
                                        </div>
                                    </div>
                                </div>

                                <!-- Batal/flu/demam -->
                                <div class="row mb-3">
                                    <label class="col-md-3">9. Batuk/flu/demam</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="batal"
                                                id="yaBatal">
                                            <label class="form-check-label" for="yaBatal">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="batal"
                                                id="tidakBatal">
                                            <label class="form-check-label" for="tidakBatal">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menstruasi -->
                                <div class="row mb-3">
                                    <label class="col-md-3">10. Bila pasien perempuan, apakah sedang
                                        haid/menstruasi</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="menstruasi"
                                                id="yaMenstruasi">
                                            <label class="form-check-label" for="yaMenstruasi">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="menstruasi"
                                                id="tidakMenstruasi">
                                            <label class="form-check-label" for="tidakMenstruasi">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section B -->

                            <div class="mb-4">
                                <h6 class="fw-bold">B. CEKLIST PERSIAPAN OPERASI</h6>
                                <p class="text-muted small">(Diisi oleh perawat ruangan dan perawat kamar bedah)</p>

                                <div class="row mb-3">
                                    <label class="col-md-2">Beri tanda :</label>
                                    <div class="col-md-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checkYa">
                                            <label class="form-check-label" for="checkYa">✓ Ya</label>
                                        </div>
                                        <span class="mx-2">atau</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checkTidak">
                                            <label class="form-check-label" for="checkTidak">✗ Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 60%">VERIFIKASI PASIEN</th>
                                                <th class="text-center" style="width: 20%">Perawat Ruangan</th>
                                                <th class="text-center" style="width: 20%">Perawat K. Bedah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1. Periksa identitas pasien</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2. Periksa gelang identitas / gelang operasi / gelang alergi</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3. IPRI dan surat pengantar rawat</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4. Jenis dan lokasi pembedahan dipastikan bersama pasien</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5. Masalah bahasa / komunikasi</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6. Periksa kelengkapan persetujuan pembedahan surat ijin operasi</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7. Periksa kelengkapan persetujuan anestesi</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">8. Periksa kelengkapan hasil konsultasi :</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">• Cardiologi</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">• Pulmonology</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">• Rehab Medik</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">• Dietation</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>9. Surat ketersediaan ICU bila dibutuhkan</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>10. Periksa kelengkapan status rawat inap / rawat jalan</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>11. Periksa kelengkapan X-ray / CT-Scan / MRI / EKG / Angiografi / Echo
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 60%">PERSIAPAN FISIK PASIEN</th>
                                                <th class="text-center" style="width: 20%">Perawat Ruangan</th>
                                                <th class="text-center" style="width: 20%">Perawat K. Bedah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1. Puasa / makan dan minum terakhir</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2. Prothese luar dilepaskan (gigi palsu, lensa kontak)</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3. Menggunakan prothese dalam (pacemaker, implant, prothese, panggul, VP
                                                    shunt)</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4. Penjepit rambut / cat kuku / perhiasan dilepaskan</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5. Persiapan kulit / cukur</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6. Pengosongan kandung kemih / clysma</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7. Memastikan persediaan darah</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>8. Alat bantu (kacamata, alat bantu dengar) disimpan</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>9. Obat yang disertakan</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>10. Obat terakhir yang diberikan
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>11. Vaskulerakses (cimino), dll
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 60%">PERSIAPAN LAIN - LAIN</th>
                                                <th class="text-center" style="width: 20%">Perawat Ruangan</th>
                                                <th class="text-center" style="width: 20%">Perawat K. Bedah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1. Site marking (terlampir)</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2. Penjelaskan singkat oleh dokter tentang prosedur yang akan dilakukan
                                                    kepada pasien</td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                                <td class="text-center"><input type="checkbox" class="form-check-input">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
