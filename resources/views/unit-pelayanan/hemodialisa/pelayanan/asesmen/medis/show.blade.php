@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
            }

            .header-asesmen {
                margin-top: 1rem;
                font-size: 1.5rem;
                font-weight: 600;
            }

            .progress-wrapper {
                background: #f8f9fa;
                border-radius: 8px;
            }

            .progress-status {
                display: flex;
                justify-content: space-between;
            }

            .progress-label {
                color: #6c757d;
                font-size: 14px;
                font-weight: 500;
            }

            .progress-percentage {
                color: #198754;
                font-weight: 600;
            }

            .custom-progress {
                height: 8px;
                background-color: #e9ecef;
                border-radius: 4px;
                overflow: hidden;
            }

            .progress-bar-custom {
                height: 100%;
                background-color: #097dd6;
                transition: width 0.6s ease;
            }

            .section-separator {
                border-top: 2px solid #097dd6;
                margin: 2rem 0;
                padding-top: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
            }

            .form-group {
                margin-bottom: 1rem;
                display: flex;
                align-items: flex-start;
            }

            .form-group label {
                margin-right: 1rem;
                padding-top: 0.5rem;
            }

            .diagnosis-section {
                margin-top: 1.5rem;
            }

            .diagnosis-row {
                padding: 0.5rem 1rem;
                border-color: #dee2e6 !important;
            }

            .diagnosis-item {
                background-color: transparent;
            }

            .border-top {
                border-top: 1px solid #dee2e6 !important;
            }

            .border-bottom {
                border-bottom: 1px solid #dee2e6 !important;
            }

            .form-check {
                margin: 0;
                padding-left: 1.5rem;
                min-height: auto;
            }

            .form-check-input {
                margin-top: 0.3rem;
            }

            .form-check label {
                margin-right: 0;
                padding-top: 0;
            }

            .btn-outline-primary {
                color: #097dd6;
                border-color: #097dd6;
            }

            .btn-outline-primary:hover {
                background-color: #097dd6;
                color: white;
            }

            .pain-scale-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
            }

            .pain-scale-image {
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
            }

            /* Optional: Styling untuk tombol aktif */
            .tambah-keterangan.active {
                background-color: #0d6efd;
                color: white;
            }
        </style>
    @endpush


    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">

                            {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                            <div class="px-3">
                                <div>
                                    <div class="section-separator">
                                        <h5 class="section-title">1. Anamnesis</h5>

                                        <div class="form-group">
                                            <label for="anamnesis" style="min-width: 200px;">Anamnesis</label>
                                            <textarea name="anamnesis" id="anamnesis" class="form-control" disabled>{{ $asesmen->fisik->anamnesis }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">2. Pemeriksaan Fisik</h5>

                                        <div class="form-group align-items-center">
                                            <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="sistole" class="form-label">Sistole</label>
                                                    <input type="number" name="sistole" id="sistole" class="form-control"
                                                        value="{{ $asesmen->fisik->sistole }}" disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="diastole" class="form-label">Diastole</label>
                                                    <input type="number" name="diastole" id="diastole"
                                                        class="form-control" value="{{ $asesmen->fisik->diastole }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="nadi" style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="number" name="nadi" id="nadi" class="form-control"
                                                value="{{ $asesmen->fisik->nadi }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="nafas" style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="number" name="nafas" id="nafas" class="form-control"
                                                value="{{ $asesmen->fisik->nafas }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="suhu" style="min-width: 200px;">Suhu (C)</label>
                                            <input type="number" name="suhu" id="suhu" class="form-control"
                                                value="{{ $asesmen->fisik->suhu }}" disabled>
                                        </div>

                                        <div class="form-group align-items-center">
                                            <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="so_tb_o2" class="form-label">Tanpa bantuan O2</label>
                                                    <input type="number" name="so_tb_o2" id="so_tb_o2"
                                                        class="form-control" value="{{ $asesmen->fisik->so_tb_o2 }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="so_db_o2" class="form-label">Dengan bantuan O2</label>
                                                    <input type="number" name="so_db_o2" id="so_db_o2"
                                                        class="form-control" value="{{ $asesmen->fisik->so_db_o2 }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="avpu" style="min-width: 200px;">AVPU</label>

                                            <select name="avpu" id="avpu" class="form-select" disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="0" @selected($asesmen->fisik->avpu == 0)>Sadar Baik/Alert: 0
                                                </option>
                                                <option value="1" @selected($asesmen->fisik->avpu == 1)>Berespon dengan
                                                    kata-kata/Voice: 1</option>
                                                <option value="2" @selected($asesmen->fisik->avpu == 2)>Hanya berespons jika
                                                    dirangsang nyeri/Pain: 2</option>
                                                <option value="3" @selected($asesmen->fisik->avpu == 3)>Pasien tidak
                                                    sadar/Unresponsive: 3</option>
                                                <option value="4" @selected($asesmen->fisik->avpu == 4)>Gelisah atau bingung: 4
                                                </option>
                                                <option value="5" @selected($asesmen->fisik->avpu == 5)>Acute Confusional
                                                    States: 5</option>
                                            </select>
                                        </div>

                                        <p class="fw-bold">Antropometri</p>

                                        <div class="form-group">
                                            <label for="tinggi_badan" style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                            <input type="number" name="tinggi_badan" id="tinggi_badan"
                                                class="form-control" onkeyup="hitungImtLpt()"
                                                value="{{ $asesmen->fisik->tinggi_badan }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="berat_badan" style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="number" name="berat_badan" id="berat_badan"
                                                class="form-control" onkeyup="hitungImtLpt()"
                                                value="{{ $asesmen->fisik->berat_badan }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="imt" style="min-width: 200px;">Index Massa Tubuh
                                                (IMT)</label>
                                            <input type="number" name="imt" id="imt" class="form-control"
                                                value="{{ $asesmen->fisik->imt }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="lpt" style="min-width: 200px;">Luas Permukaan Tubuh
                                                (LPT)</label>
                                            <input type="number" name="lpt" id="lpt" class="form-control"
                                                value="{{ $asesmen->fisik->lpt }}" disabled>
                                        </div>


                                        <div class="alert alert-info mb-3">
                                            <p class="mb-0 small">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk
                                                menambah
                                                keterangan fisik yang ditemukan tidak normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                            </p>
                                        </div>

                                        <div class="row g-3">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            @php
                                                                $pemeriksaanData = $asesmen->pemFisik
                                                                    ->where('id_item_fisik', $item->id)
                                                                    ->first();
                                                                $keterangan = '';
                                                                $isNormal = true;

                                                                if (!empty($pemeriksaanData)) {
                                                                    $keterangan = $pemeriksaanData->keterangan;
                                                                    $isNormal = $pemeriksaanData->is_normal;
                                                                }
                                                            @endphp

                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}
                                                                    </div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ $item->id }}-normal"
                                                                            name="{{ $item->id }}-normal"
                                                                            @checked($isNormal) disabled>
                                                                        <label class="form-check-label"
                                                                            for="{{ $item->id }}-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan disabled"
                                                                        type="button"
                                                                        data-target="{{ $item->id }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2"
                                                                    id="{{ $item->id }}-keterangan"
                                                                    style="display:{{ $isNormal ? 'none' : 'block' }};">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal..."
                                                                        value="{{ $keterangan }}" disabled>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Status Nyeri</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Skala Nyeri</label>
                                            <input type="text" class="form-control" value="Scale NRS, VAS, VRS"
                                                disabled>
                                        </div>

                                        <div class="form-group justify-content-center">
                                            <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt=""
                                                class="w-50">
                                        </div>

                                        <div class="form-group">
                                            <label for="skala_nyeri" style="min-width: 200px;">Nilai Skala Nyeri</label>
                                            <input type="number" class="form-control" name="skala_nyeri"
                                                id="skala_nyeri" min="0" max="10"
                                                value="{{ $asesmen->fisik->skala_nyeri }}" disabled>
                                        </div>

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">4. Riwayat Kesehatan</h5>

                                        <div class="form-group">
                                            <label for="penyakit_sekarang" style="min-width: 200px;">Riwayat Penyakit
                                                Sekarang</label>

                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <div class="bg-secondary-subtle rounded-2 p-3"
                                                        id="penyakitsekarang-list">
                                                        @foreach ($asesmen->fisik->penyakit_sekarang ?? [] as $ps)
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <p
                                                                    class="fw-bold text-primary m-0 text-decoration-underline">
                                                                    {{ $ps }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="penyakit_dahulu" style="min-width: 200px;">Riwayat Penyakit
                                                Dahulu</label>

                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <div class="bg-secondary-subtle rounded-2 p-3"
                                                        id="penyakitdahulu-list">
                                                        @foreach ($asesmen->fisik->penyakit_dahulu ?? [] as $pd)
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <p
                                                                    class="fw-bold text-primary m-0 text-decoration-underline">
                                                                    {{ $pd }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="efek_samping" style="min-width: 200px;">Efek Samping Yang
                                                Dialami</label>
                                            <input type="text" class="form-control" name="efek_samping"
                                                id="efek_samping" value="{{ $asesmen->fisik->efek_samping }}" disabled>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">5. Terapi Obat dan Injeksi</h5>

                                        <div class="form-group">
                                            <div class="row w-100">
                                                <div class="col-12">
                                                    <table class="table table-bordered table-hover" id="tableTerapiObat">
                                                        <thead>
                                                            <tr align="middle">
                                                                <th>Nama Obat</th>
                                                                <th>Dosis</th>
                                                                <th>Waktu Penggunaan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($asesmen->fisik->terapi_obat ?? [] as $to)
                                                                @php
                                                                    $to = json_decode($to, true);
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $to['nama_obat'] }}</td>
                                                                    <td>{{ $to['dosis'] }}</td>
                                                                    <td>{{ $to['waktu'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">6. Hasil Pemeriksaan Penunjang</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Laboratorium</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="hb" class="form-label">HB</label>
                                                    <input type="text" name="hb" id="hb"
                                                        class="form-control" value="{{ $asesmen->penunjang->hb }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="hbsag" class="form-label">HbsAg</label>
                                                    <input type="text" name="hbsag" id="hbsag"
                                                        class="form-control" value="{{ $asesmen->penunjang->hbsag }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="phospor" class="form-label">Phospor</label>
                                                    <input type="text" name="phospor" id="phospor"
                                                        class="form-control" value="{{ $asesmen->penunjang->phospor }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="fe_serum" class="form-label">Fe Serum</label>
                                                    <input type="text" name="fe_serum" id="fe_serum"
                                                        class="form-control" value="{{ $asesmen->penunjang->fe_serum }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="gol_darah" class="form-label">Gol Darah</label>
                                                    <input type="text" name="gol_darah" id="gol_darah"
                                                        class="form-control" value="{{ $asesmen->penunjang->gol_darah }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="calcium" class="form-label">Calcium</label>
                                                    <input type="text" name="calcium" id="calcium"
                                                        class="form-control" value="{{ $asesmen->penunjang->calcium }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="kalium" class="form-label">Kalium</label>
                                                    <input type="text" name="kalium" id="kalium"
                                                        class="form-control" value="{{ $asesmen->penunjang->kalium }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="natrium" class="form-label">Natrium</label>
                                                    <input type="text" name="natrium" id="natrium"
                                                        class="form-control" value="{{ $asesmen->penunjang->natrium }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="ureum" class="form-label">Ureum</label>
                                                    <input type="text" name="ureum" id="ureum"
                                                        class="form-control" value="{{ $asesmen->penunjang->ureum }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="asam_urat" class="form-label">Asam Urat</label>
                                                    <input type="text" name="asam_urat" id="asam_urat"
                                                        class="form-control" value="{{ $asesmen->penunjang->asam_urat }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="creatinin" class="form-label">Creatinin</label>
                                                    <input type="text" name="creatinin" id="creatinin"
                                                        class="form-control" value="{{ $asesmen->penunjang->creatinin }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="tibc" class="form-label">TIBC</label>
                                                    <input type="text" name="tibc" id="tibc"
                                                        class="form-control" value="{{ $asesmen->penunjang->tibc }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="hcv" class="form-label">Anti HCV</label>
                                                    <input type="text" name="hcv" id="hcv"
                                                        class="form-control" value="{{ $asesmen->penunjang->hcv }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="hiv" class="form-label">Anti HIV</label>
                                                    <input type="text" name="hiv" id="hiv"
                                                        class="form-control" value="{{ $asesmen->penunjang->hiv }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="gula_darah" class="form-label">Gula Darah</label>
                                                    <input type="text" name="gula_darah" id="gula_darah"
                                                        class="form-control"
                                                        value="{{ $asesmen->penunjang->gula_darah }}" disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="lab_lainnya" class="form-label">Lainnya</label>
                                                    <input type="text" name="lab_lainnya" id="lab_lainnya"
                                                        class="form-control"
                                                        value="{{ $asesmen->penunjang->lab_lainnya }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ekg" style="min-width: 200px;">EKG</label>
                                            <input type="text" class="form-control" name="ekg" id="ekg"
                                                value="{{ $asesmen->penunjang->ekg }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="rongent" style="min-width: 200px;">Rongent</label>
                                            <input type="text" class="form-control" name="rongent" id="rongent"
                                                value="{{ $asesmen->penunjang->rongent }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="usg" style="min-width: 200px;">USG</label>
                                            <input type="text" class="form-control" name="usg" id="usg"
                                                value="{{ $asesmen->penunjang->usg }}" disabled>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">7. Deskripsi Hemodialisis</h5>

                                        <div class="form-group">
                                            <label for="jenis_hd" style="min-width: 200px;">Jenis Hemodialisis</label>
                                            <th></th>
                                            <select name="jenis_hd" id="jenis_hd" class="form-select" disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->deskripsi->jenis_hd == 1)>Akut</option>
                                                <option value="2" @selected($asesmen->deskripsi->jenis_hd == 2)>Kronik</option>
                                                <option value="3" @selected($asesmen->deskripsi->jenis_hd == 3)>Pra Operasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="rutin" style="min-width: 200px;">Bila Rutin (x/minggu)</label>
                                            <input type="number" name="rutin" id="rutin" class="form-control"
                                                value="{{ $asesmen->deskripsi->rutin }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="jenis_dialisat" style="min-width: 200px;">Jenis Dialisat</label>
                                            <select name="jenis_dialisat" id="jenis_dialisat" class="form-select"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->deskripsi->jenis_dialisat == 1)>Asetat</option>
                                                <option value="2" @selected($asesmen->deskripsi->jenis_dialisat == 2)>Bicabornat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="suhu_dialisat" style="min-width: 200px;">Suhu Dialisat
                                                (Celcius)</label>
                                            <input type="number" name="suhu_dialisat" id="suhu_dialisat"
                                                class="form-control" value="{{ $asesmen->deskripsi->suhu_dialisat }}"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="akses_vaskular" style="min-width: 200px;">Akses Vaskular</label>
                                            <select name="akses_vaskular" id="akses_vaskular" class="form-select"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->deskripsi->akses_vaskular == 1)>Cimino</option>
                                                <option value="2" @selected($asesmen->deskripsi->akses_vaskular == 2)>Femoral</option>
                                                <option value="3" @selected($asesmen->deskripsi->akses_vaskular == 3)>CDL Jugularis</option>
                                                <option value="4" @selected($asesmen->deskripsi->akses_vaskular == 4)>CDL Subclavia</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="lama_hd" style="min-width: 200px;">Lama HD (jam)</label>
                                            <input type="number" name="lama_hd" id="lama_hd" class="form-control"
                                                value="{{ $asesmen->deskripsi->lama_hd }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Parameter Mesin</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="qb" class="form-label">Kec. Darah (QB)</label>
                                                    <div class="input-group">
                                                        <input type="number" name="qb" id="qb"
                                                            class="form-control" value="{{ $asesmen->deskripsi->qb }}"
                                                            disabled>
                                                        <span class="qb-group-text">ml/menit</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="qd" class="form-label">Kec. Dialisat (QD)</label>
                                                    <div class="input-group">
                                                        <input type="number" name="qd" id="qd"
                                                            class="form-control" value="{{ $asesmen->deskripsi->qd }}"
                                                            disabled>
                                                        <span class="input-group-text">ml/menit</span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="uf_goal" class="form-label">UF Goal</label>
                                                    <div class="input-group">
                                                        <input type="number" name="uf_goal" id="uf_goal"
                                                            class="form-control"
                                                            value="{{ $asesmen->deskripsi->uf_goal }}" disabled>
                                                        <span class="input-group-text">ml</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Heparinisasi</label>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="dosis_awal" class="form-label">Dosis Awal</label>
                                                    <div class="input-group">
                                                        <input type="number" name="dosis_awal" id="dosis_awal"
                                                            class="form-control"
                                                            value="{{ $asesmen->deskripsi->dosis_awal }}" disabled>
                                                        <span class="input-group-text">IU</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="m_kontinyu" class="form-label">Maintenance
                                                        Kontinyu</label>
                                                    <div class="input-group">
                                                        <input type="number" name="m_kontinyu" id="m_kontinyu"
                                                            class="form-control"
                                                            value="{{ $asesmen->deskripsi->m_kontinyu }}" disabled>
                                                        <span class="input-group-text">IU</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="m_intermiten" class="form-label">Maintenance
                                                        Intermiten</label>
                                                    <div class="input-group">
                                                        <input type="number" name="m_intermiten" id="m_intermiten"
                                                            class="form-control"
                                                            value="{{ $asesmen->deskripsi->m_intermiten }}" disabled>
                                                        <span class="input-group-text">IU</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="tanpa_heparin" class="form-label">Tanpa Heparin</label>
                                                    <input type="text" name="tanpa_heparin" id="tanpa_heparin"
                                                        class="form-control"
                                                        value="{{ $asesmen->deskripsi->tanpa_heparin }}" disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="lmwh" class="form-label">LMWH</label>
                                                    <div class="input-group">
                                                        <input type="number" name="lmwh" id="lmwh"
                                                            class="form-control" value="{{ $asesmen->deskripsi->lmwh }}"
                                                            disabled>
                                                        <span class="input-group-text">IU</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Program Profilling</label>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="ultrafiltrasi_mode" class="form-label"
                                                            style="width: 200px">Ultrafiltrasi Mode</label>
                                                        <input type="text" name="ultrafiltrasi_mode"
                                                            id="ultrafiltrasi_mode" class="form-control"
                                                            value="{{ $asesmen->deskripsi->ultrafiltrasi_mode }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="natrium_mode" class="form-label"
                                                            style="width: 200px">Natrium Mode</label>
                                                        <input type="text" name="natrium_mode" id="natrium_mode"
                                                            class="form-control"
                                                            value="{{ $asesmen->deskripsi->natrium_mode }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="bicabornat_mode" class="form-label"
                                                            style="width: 200px">Bicabornat Mode</label>
                                                        <input type="text" name="bicabornat_mode" id="bicabornat_mode"
                                                            class="form-control"
                                                            value="{{ $asesmen->deskripsi->bicabornat_mode }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="fw-semibold mb-4">8. Diagnosis</h5>

                                        @php
                                            // Parse existing diagnosis data from database
                                            $diagnosisBanding = !empty($asesmen->evaluasi->diagnosis_banding)
                                                ? json_decode($asesmen->evaluasi->diagnosis_banding, true)
                                                : [];
                                            $diagnosisKerja = !empty($asesmen->evaluasi->diagnosis_kerja)
                                                ? json_decode($asesmen->evaluasi->diagnosis_kerja, true)
                                                : [];
                                        @endphp

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                @forelse($diagnosisBanding as $index => $diagnosis)
                                                    <div
                                                        class="diagnosis-item d-flex justify-content-between align-items-center mb-2">
                                                        <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                                    </div>
                                                @empty
                                                    <div class="text-muted fst-italic">Belum ada diagnosis banding</div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>

                                            <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                @forelse($diagnosisKerja as $index => $diagnosis)
                                                    <div
                                                        class="diagnosis-item d-flex justify-content-between align-items-center mb-2">
                                                        <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                                    </div>
                                                @empty
                                                    <div class="text-muted fst-italic">Belum ada diagnosis kerja</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">9. Evaluasi</h5>

                                        <div class="form-group">
                                            <label for="evaluasi_medis" style="min-width: 200px;">Evaluasi Medis</label>
                                            <textarea name="evaluasi_medis" id="evaluasi_medis" class="form-control" disabled>{{ $asesmen->evaluasi->evaluasi_medis }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">10. Verifikasi</h5>

                                        <div class="form-group">
                                            <label for="dokter_pelaksana" style="min-width: 200px;">Dokter
                                                Pelaksana</label>
                                            <select name="dokter_pelaksana" id="dokter_pelaksana" class="form-select"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($dokterPelaksana as $item)
                                                    <option value="{{ $item->dokter->kd_dokter }}"
                                                        @selected($item->dokter->kd_dokter == $asesmen->evaluasi->dokter_pelaksana)>{{ $item->dokter->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="dpjp" style="min-width: 200px;">Dokter DPJP</label>
                                            <select name="dpjp" id="dpjp" class="form-select select2" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($dokter as $dok)
                                                    <option value="{{ $dok->kd_dokter }}" @selected($dok->kd_dokter == $asesmen->evaluasi->dpjp)>
                                                        {{ $dok->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="perawat" style="min-width: 200px;">Perawat</label>
                                            <select name="perawat" id="perawat" class="form-select select2" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($perawat as $prwt)
                                                    <option value="{{ $prwt->kd_karyawan }}"
                                                        @selected($prwt->kd_karyawan == $asesmen->evaluasi->perawat)>
                                                        {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            // Tunggu sampai DOM sepenuhnya dimuat
            document.addEventListener('DOMContentLoaded', function() {
                // Event handler untuk tombol tambah keterangan
                document.querySelectorAll('.tambah-keterangan').forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const keteranganDiv = document.getElementById(targetId);
                        const normalCheckbox = this.closest('.pemeriksaan-item').querySelector(
                            '.form-check-input');

                        // Toggle tampilan keterangan
                        if (keteranganDiv.style.display === 'none') {
                            keteranganDiv.style.display = 'block';
                            normalCheckbox.checked = false; // Uncheck normal checkbox
                        } else {
                            keteranganDiv.style.display = 'block';
                        }
                    });
                });

                // Event handler untuk checkbox normal
                document.querySelectorAll('.form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const keteranganDiv = this.closest('.pemeriksaan-item').querySelector(
                            '.keterangan');
                        if (this.checked) {
                            keteranganDiv.style.display = 'none';
                            keteranganDiv.querySelector('input').value = ''; // Reset input value
                        }
                    });
                });
            });

            // Riwayat Penyakit
            $('.btn-add-list').click(function(e) {
                let $this = $(this);
                let inputEl = $this.siblings('#searchInput');
                let valInput = $(inputEl).val();

                if (valInput != '') {
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
                $(selectedListEl).each(function(i, e) {
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

            $(document).on('click', '.btn-delete-list', function(e) {
                let $this = $(this);
                $this.closest('.d-flex').remove();
            });


            // Terapi Obat
            $('#btnSaveTerapiObat').click(function(e) {
                let nama_obat = $('#terapiObatModal #nama_obat').val();
                let dosis = $('#terapiObatModal #dosis').val();
                let waktu = $('#terapiObatModal #waktu').val();

                if (nama_obat == '' || dosis == '' || waktu == '') {
                    showToast('error', 'Inputan terapi obat wajib di isi semua !');
                    return false;
                }

                let valJson = `{"nama_obat": "${nama_obat}", "dosis": "${dosis}", "waktu": "${waktu}"}`;

                $('#tableTerapiObat tbody').append(`<tr>
                                                <td>${nama_obat}</td>
                                                <td>${dosis}</td>
                                                <td>${waktu}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-terapiobat">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <input type='hidden' name='terapi_obat[]' value='${valJson}'>
                                                </td>

                                            </tr>`);

                $('#terapiObatModal').modal('hide');
                $('#terapiObatModal #nama_obat').val('');
                $('#terapiObatModal #dosis').val('');
                $('#terapiObatModal #waktu').val('');
            });

            $(document).on('click', '.btn-delete-terapiobat', function(e) {
                let $this = $(this);
                $this.closest('tr').remove();
            });


            // HITUNG IMT dan LPT
            function hitungImtLpt() {
                let tb = $('#tinggi_badan').val();
                let bb = $('#berat_badan').val();

                if (tb == '') tb = 0;
                if (bb == '') bb = 0;

                let imt = 0;
                let lpt = 0;

                imt = bb / ((tb / 100) ** 2);
                lpt = (tb * bb) / 3600;

                $('#imt').val(imt);
                $('#lpt').val(lpt);
            }



            /*===========================================================
                            DIAGNOSIS KERJA dan BANDING
            ===========================================================*/
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                // Insert suggestions list after input
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Database options
                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};

                // Prepare options array
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data if available
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                    renderDiagnosisList();
                } catch (e) {
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function() {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        // Filter database options
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        // Show suggestions
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        // Hide suggestions if input is empty
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
                        // Render existing options
                        options.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer';
                            suggestionItem.textContent = option.text;
                            suggestionItem.addEventListener('click', () => {
                                addDiagnosis(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!options.some(opt => opt.text.toLowerCase() === inputValue)) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.textContent = `Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addDiagnosis(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.textContent = `Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addDiagnosis(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add diagnosis when plus button is clicked
                addButton.addEventListener('click', function() {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    // Check for duplicates
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
                        // Optional: Show feedback that it's a duplicate
                        alert(`"${diagnosisText}" sudah ada dalam daftar`);
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';

                    diagnosisList.forEach((diagnosis, index) => {
                        const diagnosisItem = document.createElement('div');
                        diagnosisItem.className =
                            'diagnosis-item d-flex justify-content-between align-items-center mb-2';

                        const diagnosisSpan = document.createElement('span');
                        diagnosisSpan.textContent = `${index + 1}. ${diagnosis}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-sm text-danger';
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.type = 'button';
                        deleteButton.addEventListener('click', function() {
                            diagnosisList.splice(index, 1);
                            renderDiagnosisList();
                            updateHiddenInput();
                        });

                        diagnosisItem.appendChild(diagnosisSpan);
                        diagnosisItem.appendChild(deleteButton);
                        listContainer.appendChild(diagnosisItem);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }
            }
        </script>
    @endpush
