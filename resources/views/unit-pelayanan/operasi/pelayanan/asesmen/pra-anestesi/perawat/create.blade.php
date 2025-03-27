<!-- create -->
@extends('layouts.administrator.master')

@push('css')
    <style>
        .select2-container .select2-dropdown {
            z-index: 2000; /* Sesuaikan dengan z-index modal Bootstrap */
        }
    </style>
@endpush

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.patient-card')
        </div>

        <div class="col-md-9">

            <form method="POST" action="{{ route('operasi.pelayanan.asesmen.pra-anestesi.perawat.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">

                            <div class="px-3">
                                <div>
                                    <a href="{{ url()->previous() }}" class="btn">
                                        <i class="ti-arrow-left"></i> Kembali
                                    </a>

                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">1. Data Masuk</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>

                                            <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control me-3">
                                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencanaTindakan">
                                        <h5 class="section-title">2. Catatan Keperawatan Pra-Operasi</h5>

                                        <div class="form-group align-items-center">
                                            <label style="min-width: 200px;">Tek. Darah (mmHg)</label>

                                            <div class="me-4">
                                                <label for="sistole" class="form-label">Sistole</label>
                                                <input type="number" name="sistole" id="sistole" class="form-control">
                                            </div>

                                            <div class="">
                                                <label for="diastole" class="form-label">Diastole</label>
                                                <input type="number" name="diastole" id="diastole" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="nadi" style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="number" name="nadi" id="nadi" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="nafas" style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="number" name="nafas" id="nafas" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="suhu" style="min-width: 200px;">Suhu (C)</label>
                                            <input type="number" name="suhu" id="suhu" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="skala_nyeri" style="min-width: 200px;">Nilai Skala Nyeri VAS</label>
                                            <input type="number" name="skala_nyeri" id="skala_nyeri" min="0" max="10" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="tinggi_badan" style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                            <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="berat_badan" style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="number" name="berat_badan" id="berat_badan" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="imt" style="min-width: 200px;">Indeks Masa Tubuh (IMT)</label>
                                            <input type="number" name="imt" id="imt" class="form-control" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="lpt" style="min-width: 200px;">Luas Permukaan Tubuh (LPT)</label>
                                            <input type="number" name="lpt" id="lpt" class="form-control" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="status_mental" style="min-width: 200px;">Status Mental</label>
                                            <select name="status_mental" id="status_mental" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Sadar Penuh</option>
                                                <option value="2">Bingung</option>
                                                <option value="3">Agitasi</option>
                                                <option value="4">Mengantuk</option>
                                                <option value="5">Koma</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="penyakit_sekarang" style="min-width: 200px;">Riwayat Penyakit Sekarang</label>

                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#penyakitSekarangModal"><i class="bi bi-plus-square"></i> Tambah</button>

                                                    <div class="bg-secondary-subtle rounded-2 p-3" id="penyakitsekarang-list">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="penyakit_dahulu" style="min-width: 200px;">Riwayat Penyakit Dahulu</label>

                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#penyakitDahuluModal"><i class="bi bi-plus-square"></i> Tambah</button>

                                                    <div class="bg-secondary-subtle rounded-2 p-3" id="penyakitdahulu-list">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="alat_bantu" style="min-width: 200px;">Alat Bantu Yang Digunakan</label>
                                            <select name="alat_bantu" id="alat_bantu" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Kacamata</option>
                                                <option value="2">Lensa Kontak</option>
                                                <option value="3">Gigi Palsu</option>
                                                <option value="4">Alat Bantu Dengar</option>
                                                <option value="5">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="jenis_operasi" style="min-width: 200px;">Jenis/Nama Operasi</label>

                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#jenisOperasiModal"><i class="bi bi-plus-square"></i> Tambah</button>

                                                    <div class="bg-secondary-subtle rounded-2 p-3" id="jenisoperasi-list">
                                                        {{-- <a href="#" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                                                        <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                                                        <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal dibedah dan dimana</label>

                                            <input type="date" name="tgl_bedah" id="tgl_bedah" class="form-control me-3">
                                            <input type="text" name="tempat_bedah" id="tempat_bedah" placeholder="Jelaskan" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Alergi</label>

                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#alergiModal"><i class="bi bi-plus-square"></i> Tambah</button>

                                                    <table class="table table-bordered table-hover" id="tableAlergi">
                                                        <thead>
                                                            <tr>
                                                                <th>Alergen</th>
                                                                <th>Reaksi</th>
                                                                <th>Severe</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hasil_lab" style="min-width: 200px;">Hasil Laboratorium</label>
                                            <div class="">
                                                <input type="checkbox" name="hasil_lab[]" id="hb" value="HB">
                                                <label for="hb">HB</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="hasil_lab[]" id="bt" value="BT">
                                                <label for="bt">BT</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="hasil_lab[]" id="ct" value="CT/APTT">
                                                <label for="ct">CT/APTT</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="hasil_lab[]" id="gol_darah" value="Gol Darah">
                                                <label for="gol_darah">Gol Darah</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="hasil_lab[]" id="urine" value="Urine">
                                                <label for="urine">Urine</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hasil_lab_lainnya" style="min-width: 200px;">Hasil Lab Lainnya</label>
                                            <input type="text" class="form-control" name="hasil_lab_lainnya" id="hasil_lab_lainnya">
                                        </div>

                                        <div class="form-group">
                                            <label for="batuk" style="min-width: 200px;">Batuk / Flu / Demam</label>
                                            <select name="batuk" id="batuk" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="haid" style="min-width: 200px;">Pasien Sedang Haid / Menstruasi</label>
                                            <select name="haid" id="haid" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencanaTindakan">
                                        <h5 class="section-title">3. Persiapan Operasi</h5>
                                        <p class="mt-3 fw-bold">Validasi Informasi Pasien</p>

                                        <table class="table">
                                            <thead>
                                                <tr align="middle">
                                                    <th>Verifikasi Pasien</th>
                                                    <th>Perawat Bedah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Periksa identitas pasien</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="identitas_pasien">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Periksa gelang identitas / gelang operasi / gelang alergi</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="periksa_gelang">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>IPRI dan surat pengantar rawat</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="ipri">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis dan lokasi pembedahan dipastikan bersama pasien</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="lokasi_pembedahan">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Periksa kelengkapan persetujuan pembedahan surat ijin operasi</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="persetujuan_operasi">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Periksa kelengkapan persetujuan anestesi</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="persetujuan_anestesi">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Periksa kelengkapan hasil konsultasi :</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>1. Cardiologi</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="cardiologi">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2. Pulmonology</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="pulmonology">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3. Rehab Medik</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="rehab_medik">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4. Dietation</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="dietation">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Surat ketersediaan ICU bila dibutuhkan</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="surat_icu">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Periksa kelengkapan status rawat inap / rawat jalan</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="kelengkapan_ranap">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Periksa kelengkapan X-ray / CT-Scan / MRI / EKG / Angiografi / Echo</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="verifikasi[]" id="" value="kelengkapan_xray">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p class="mt-4 fw-bold">Persiapan Fisik Pasien</p>

                                        <table class="table">
                                            <thead>
                                                <tr align="middle">
                                                    <th>Persiapan Fisik Pasien</th>
                                                    <th>Perawat Bedah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Puasa / makan dan minum terakhir</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="puasa">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Prothese luar dilepaskan (gigi palsu, lensa kontak)</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="prothese_luar">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Menggunakan prothese dalam (pacemaker, implant, prothese, panggul, VP shunt)</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="prothese_dalam">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penjepit rambut / cat kuku / perhiasan dilepaskan</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="perhiasan">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Persiapan kulit / cukur</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="kulit_cukur">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pengosongan kandung kemih / clysma</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="clysma">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Memastikan persediaan darah</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="persediaan_darah">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Alat bantu (kacamata, alat bantu dengar) disimpan</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="alat_bantu_disimpan">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Obat yang disertakan</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="obat_disertakan">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Obat terakhir yang diberikan</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="obat_terakhir">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Vaskulerakses (cimino), dll</td>
                                                    <td align="middle">
                                                        <input type="checkbox" class="form-check-input" name="persiapan_fisik[]" id="" value="vaskulerakses">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p class="mt-4 fw-bold">Diperiksa Oleh</p>

                                        <div class="form-group">
                                            <label for="perawat_penerima" style="min-width: 200px;">Perawat Penerima</label>
                                            <select name="perawat_penerima" id="perawat_penerima" class="form-select select2">
                                                <option value="">--Pilih Perawat--</option>
                                                @foreach ($perawat as $prwt)
                                                    <option value="{{ $prwt->id }}" @selected($prwt->id == auth()->user()->id)>{{ $prwt->karyawan->gelar_depan . ' ' . str()->title($prwt->karyawan->nama) . ' ' . $prwt->karyawan->gelar_belakang }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="waktu_diperiksa" style="min-width: 200px;">Waktu Diperiksa</label>
                                            <input type="date" class="form-control" name="tgl_periksa" id="tgl_diperiksa">
                                            <input type="time" class="form-control" name="jam_periksa" id="jam_diperiksa">
                                        </div>

                                        <p class="mt-4 fw-bold">Persiapan Lain-lain</p>

                                        <div class="form-group">
                                            <label for="site_marking" style="min-width: 200px;">Site Marking (Terlampir)</label>
                                            <select name="site_marking" id="site_marking" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="penjelasan_prosedur" style="max-width: 200px;">
                                                Penjelasan singkat oleh dokter tentang prosedur yang akan dilakukan kepada pasien
                                            </label>
                                            <select name="penjelasan_prosedur" id="penjelasan_prosedur" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- MODAL PENYAKIT SEKARANG --}}
    <div class="modal fade" id="penyakitSekarangModal" tabindex="-1" aria-labelledby="penyakitSekarangModalLabel" aria-hidden="true"
        style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penyakitSekarangModalLabel">Tambah Riwayat Penyakit Sekarang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control dropdown-toggle" id="searchInput" placeholder="Nama Penyakit" aria-expanded="false" autocomplete="off">
                    <button type="button" class="btn btn-sm btn-primary mt-2 float-end btn-add-list">Tambah</button>

                    <h6 class="fw-bold mt-5">Daftar Penyakit</h6>
                    <ol type="1" class="list-data">
                        {{-- <li>HYPERTENSI KRONIS</li> --}}
                    </ol>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save-list" data-type="penyakitsekarang">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PENYAKIT DAHULU --}}
    <div class="modal fade" id="penyakitDahuluModal" tabindex="-1" aria-labelledby="penyakitDahuluModalLabel" aria-hidden="true"
        style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penyakitDahuluModalLabel">Tambah Riwayat Penyakit Dahulu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control dropdown-toggle" id="searchInput" placeholder="Nama Penyakit" aria-expanded="false" autocomplete="off">
                    <button type="button" class="btn btn-sm btn-primary mt-2 float-end btn-add-list">Tambah</button>

                    <h6 class="fw-bold mt-5">Daftar Penyakit</h6>
                    <ol type="1" class="list-data">
                        {{-- <li>HYPERTENSI KRONIS</li> --}}
                    </ol>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save-list" data-type="penyakitdahulu">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL JENIS OPERASI --}}
    <div class="modal fade" id="jenisOperasiModal" tabindex="-1" aria-labelledby="jenisOperasiModalLabel" aria-hidden="true"
        style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jenisOperasiModalLabel">Tambah Jenis Operasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="jenisOperasiInput" class="form-select select2">
                        <option value="">--Pilih--</option>
                        @foreach ($jenisOperasi as $jenis)
                            <option value="{{ $jenis->deskripsi }}">{{ $jenis->deskripsi }}</option>
                        @endforeach
                    </select>

                    <h6 class="fw-bold mt-5">Daftar Operasi</h6>
                    <ol type="1" class="list-data">
                        {{-- <li>HYPERTENSI KRONIS</li> --}}
                    </ol>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save-list" data-type="jenisoperasi">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ALERGI --}}
    <div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true"
        style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alergiModalLabel">Tambah Alergi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alergen" class="form-label">Alergen</label>
                        <input type="text" class="form-control" id="alergen">
                    </div>

                    <div class="form-group mt-3">
                        <label for="reaksi" class="form-label">Reaksi</label>
                        <input type="text" class="form-control" id="reaksi">
                    </div>

                    <div class="form-group mt-3">
                        <label for="severe" class="form-label">Severe</label>
                        <select id="severe" class="form-select">
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSaveAlergen">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $('.btn-add-list').click(function(e) {
            let $this = $(this);
            let inputEl = $this.siblings('#searchInput');
            let valInput = $(inputEl).val();

            if(valInput != '') {
                $this.siblings('.list-data').append(`<li>${valInput}</li>`);
                $(inputEl).val('');
            }
        });

        $('.btn-save-list').click(function() {
            let $this = $(this);
            let type = $this.attr('data-type');
            let modal = $this.closest('.modal');
            let selectedListEl = $(modal).find('.list-data li');

            let selectedInputList = '';
            $(selectedListEl).each(function (i, e) {
                selectedInputList += `<div class="d-flex justify-content-between align-items-center">
                                        <p class="fw-bold text-primary m-0 text-decoration-underline">${$(e).text()}</p>
                                        <input type="hidden" name="${type}[]" value="${$(e).text()}">
                                        <button type="button" class="btn text-danger btn-sm btn-delete-list">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>`;
            });

            $('#' + type + '-list').html(selectedInputList);
            $(modal).modal('hide');
        });

        $('#jenisOperasiModal #jenisOperasiInput').change(function(e) {
            let $this = $(this);
            // let inputEl = $this.siblings('#searchInput');
            let valInput = $this.val();

            if(valInput != '') {
                $this.siblings('.list-data').append(`<li>${valInput}</li>`);
                // $(inputEl).val('');
            }
        });

        $(document).on('click', '.btn-delete-list', function(e) {
            let $this = $(this);
            $this.closest('.d-flex').remove();
        });

        $('#jenisOperasiModal').on('shown.bs.modal', function () {
            $('#jenisOperasiModal .select2').select2({
                dropdownParent: $('#jenisOperasiModal'), // Menetapkan modal sebagai parent dropdown
                width: '100%' // Opsional: untuk memastikan lebar dropdown sesuai
            });
        });


        $('#btnSaveAlergen').click(function(e) {
            let alergen = $('#alergiModal #alergen').val();
            let reaksi = $('#alergiModal #reaksi').val();
            let severe = $('#alergiModal #severe').val();

            if(alergen == '' || reaksi == '' || severe == '') {
                showToast('error', 'Inputan reaksi wajib di isi semua !');
                return false;
            }

            let valJson = `{"alergen": "${alergen}", "reaksi": "${reaksi}", "severe": "${severe}"}`;

            $('#tableAlergi tbody').append(`<tr>
                                                <td>${alergen}</td>
                                                <td>${reaksi}</td>
                                                <td>${severe}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-alergi">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <input type='hidden' name='alergi[]' value='${valJson}'>
                                                </td>

                                            </tr>`);

            $('#alergiModal').modal('hide');
            $('#alergiModal #alergen').val('');
            $('#alergiModal #reaksi').val('');
            $('#alergiModal #severe').val('Ringan');
        });

        $(document).on('click', '.btn-delete-alergi', function(e) {
            let $this = $(this);
            $this.closest('tr').remove();
        });
    </script>
@endpush
