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
                    <h5 class="mb-0 text-secondary fw-bold">CEKLIST KESELAMATAN PASIEN OPERASI</h5>
                </div>

                <!-- Sign In Section -->
                <div class="card mb-3">
                    <div class="card-header text-center bg-primary text-white">
                        <h6 class="mb-0">Sebelum Induksi Anastesi<br />(SIGN IN)</h6>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>KETERANGAN</th>
                                    <th>YA</th>
                                    <th>TIDAK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td colspan="3">Pasien telah dikonfirmasikan</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>a. Identifikasi dan gelang pasien</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>b. Lokasi operasi</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>c. Prosedur Operasi</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>d. Informed Consent Anestesi</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>e. Informed Consent Operasi</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lokasi operasi sudah diberi tanda?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mesin dan obat-obat anastesi sudah dicek lengkap?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Pulse oximeter sudah terpasang dan berfungsi?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Pulse oximeter sudah terpasang dan berfungsi?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Kesulitan bernafas/ resiko aspirasi?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Resiko kehilangan darah > 500 ml (7 ml/ kg BB pada anak)?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Dua akses intravena/ akses sentral dan rencana terapi cairan?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Time Out Section -->
                <div class="card mb-3">
                    <div class="card-header text-center bg-primary text-white">
                        <h6 class="mb-0">Sebelum Insisi<br />(TIME OUT)</h6>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>KETERANGAN</th>
                                    <th>YA</th>
                                    <th>TIDAK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Konfirmasi seluruh anggota tim telah memperkenalkan nama dan peran</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td colspan="3">Dokter bedah, dokter anestesi dan Perawat melakukan
                                        konfirmasi secara verbal:</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>a. Nama pasien</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>b. Prosedur</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>c. Lokasi dimana insisi akan dibuat/ posisi</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td colspan="3">Apakah antibiotic profilaksis sudah diberi-kan sebelumnya ?
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        a. Nama antibiotik yang diberikan:<br />
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        b. Dosis antibiotik yang diberikan:<br />
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td colspan="3">Antisipasi Kejadian Kritis:</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        a. Review dokter bedah: langkah apa yang akan dilakukan bila kondisi kritis
                                        atau kejadian yang tidak diharapkan lamanya operasi, antisipasi kehilangan
                                        darah?<br />
                                        <textarea class="form-control" rows="2"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        b. Review tim anestesi: apakah ada hal khusus yang perlu diperhatikan pada
                                        pasien?<br />
                                        <textarea class="form-control" rows="2"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        c. Review tim perawat: apakah peralatan sudah steril, adakah alat-alat yang
                                        perlu diperhatikan khusus atau dalam masa-alah?<br />
                                        <textarea class="form-control" rows="2"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Apakah foto rontgen/ CT-Scan dan MRI te-lah ditayangkan?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sign Out Section -->
                <div class="card mb-3">
                    <div class="card-header text-center bg-primary text-white">
                        <h6 class="mb-0">Sebelum Tutup Luka Operasi<br />(SIGN OUT)</h6>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>KETERANGAN</th>
                                    <th>YA</th>
                                    <th>TIDAK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td colspan="3">Perawat melakukan konfirmasi secara verbal dengan tim:</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>a. Nama prosedur tindakan telah dicatat</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>b. Instrument, sponge, dan jarum telah dihitung dengan benar</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>c. Spesimen telah diberi label (terma-suk nama pasien dan asal jaringan
                                        specimen)</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>d. Apakah masalah dengan peralatan selama operasi?</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Dokter bedah, dokter Anestesi, dan per-awat melakukan review masalah utama
                                        apa yang harus diperhatikan untuk penyembuhan dan manajemen risiko
                                        selanjutnya.</td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td colspan="3">
                                        Hal-hal yang harus diperhatikan:<br />
                                        <textarea class="form-control" rows="4"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button class="btn btn-primary">Simpan</button>
            </div>

        </div>
    </div>
@endsection
