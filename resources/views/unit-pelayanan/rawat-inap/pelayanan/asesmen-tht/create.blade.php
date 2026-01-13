@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Awal Medis THT',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])
                <form method="POST"
                    action="{{ route('rawat-inap.asesmen.medis.tht.index', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}">
                    @csrf
                    <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                    <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                    <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                    <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                    {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                    <div class="px-3">
                        <div>
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tgl_masuk"
                                            value="{{ date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk"
                                            value="{{ date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">kondisi Masuk</label>
                                    <select class="form-select" name="kondisi_masuk">
                                        <option selected disabled>Pilih</option>
                                        <option value="1">Mandiri</option>
                                        <option value="2">Kursi Roda</option>
                                        <option value="3">Brankar</option>
                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label style="min-width: 200px;">Ruang</label>
                                    <select class="form-select" name="ruang">
                                        <option selected disabled>Pilih</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div> --}}
                            </div>

                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Anamnesis</label>
                                    <textarea class="form-control" name="anamnesis_anamnesis" rows="4" placeholder="keluhan utama pasien"></textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Penyakit Sekarang</label>
                                    <input type="text" class="form-control" name="penyakit_sekarang"
                                        placeholder="Riwayat Penyakit Sekarang">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Penyakit Terhadulu</label>
                                    <input type="text" class="form-control" name="penyakit_terdahulu"
                                        placeholder="Riwayat Penyakit Terdahulu">
                                </div>
                            </div>

                            <div class="section-separator" id="riwayat-penggunaan-obat">
                                <h5 class="section-title">3. Riwayat Penggunaan Obat</h5>
                                <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData">
                                <a href="javascript:void(0)"
                                    class="btn btn-sm btn-outline-secondary text-decoration-none fw-bold ms-3"
                                    id="btn-riwayat-obat">
                                    <i class="bi bi-plus-square"></i> Tambah
                                </a>

                                <div class="table-responsive">
                                    <table class="table" id="createRiwayatObatTable">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Dosis</th>
                                                <th>Waktu Penggunaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table content will be dynamically populated -->
                                        </tbody>
                                    </table>
                                </div>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.moda-riwayat-obat')
                                @endpush
                            </div>

                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">4. Alergi</h5>
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openAlergiModal"
                                    data-bs-toggle="modal" data-bs-target="#alergiModal">
                                    <i class="ti-plus"></i> Tambah Alergi
                                </button>
                                <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="createAlergiTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="20%">Jenis Alergi</th>
                                                <th width="25%">Alergen</th>
                                                <th width="25%">Reaksi</th>
                                                <th width="20%">Tingkat Keparahan</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="no-alergi-row">
                                                <td colspan="5" class="text-center text-muted">Tidak ada data
                                                    alergi</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-create-alergi')
                                @endpush
                            </div>

                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">5. Pemeriksaan fisik</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <input type="number" class="form-control" name="darah_sistole"
                                                placeholder="Sistole"
                                                value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->sistole : '' }}">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="number" class="form-control" name="darah_diastole"
                                                placeholder="Diastole"
                                                value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->diastole : '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                    <input type="number" class="form-control" name="nadi"
                                        placeholder="frekuensi nadi per menit"
                                        value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->nadi : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                    <input type="number" class="form-control" name="nafas"
                                        placeholder="frekuensi nafas per menit"
                                        value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->respiration : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Suhu (C)</label>
                                    <input type="text" class="form-control" name="suhu"
                                        placeholder="suhu dalam celcius"
                                        value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->suhu : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Sensorium</label>
                                    <input type="text" class="form-control" name="sensorium" placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">KU/KP/KG</label>
                                    <input type="text" class="form-control" name="ku_kp_kg" placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">AVPU</label>
                                    <select class="form-select" name="avpu">
                                        <option value="" selected disabled>pilih</option>
                                        <option value="0">Sadar Baik/Alert : 0</option>
                                        <option value="1">Berespon dengan kata-kata/Voice: 1</option>
                                        <option value="2">Hanya berespon jika dirangsang nyeri/pain: 2
                                        </option>
                                        <option value="3">Pasien tidak sadar/unresponsive: 3</option>
                                        <option value="4">Gelisah atau bingung: 4</option>
                                        <option value="5">Acute Confusional States: 5</option>
                                    </select>
                                </div>

                                <h5 class="fw-bold">Pemeriksaan Fisik Koprehensif</h5>
                                <span class="fw-bold mt-4">Daun Telinga</span>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Nanah</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="daun_telinga_nanah_kana"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="daun_telinga_nanah_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <!-- Nanah -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Darah</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="daun_telinga_darah_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="daun_telinga_darah_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <!-- Lainnya -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Lainnya</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="daun_telinga_lainnya_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="daun_telinga_lainnya_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <span class="fw-bold mt-4">Liang Telinga</span>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Darah</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="liang_telinga_darah_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="liang_telinga_darah_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Nanah</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="liang_telinga_nanah_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="liang_telinga_nanah_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Berbau</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="liang_telinga_berbau_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="liang_telinga_berbau_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Lainnya</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="liang_telinga_lainnya_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="liang_telinga_lainnya_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <spam class="my-3 fw-bold">Membran Tympani</spam>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Warna</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="membran_tympani_warna_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="membran_tympani_warna_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Perforasi</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="membran_tympani_perforasi_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="membran_tympani_perforasi_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">lainnya</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="membran_tympani_lainnya_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="membran_tympani_lainnya_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <span class="fw-bold mt-4">Tes Pendengaran</span>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Renne Tes</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_renne_res_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_renne_res_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Weber Tes</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_weber_tes_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_weber_tes_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Schwabach Test</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_schwabach_test_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_schwabach_test_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Bebisik</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_bebisik_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="tes_pendengaran_bebisik_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <spam class="my-3 fw-bold">Rhinoscopi Anterior</spam>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Cavun Nasi</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_anterior_cavun_nasi_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_anterior_cavun_nasi_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Konka Inferior</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_anterior_konka_inferior_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_anterior_konka_inferior_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Septum Nasi</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_anterior_septum_nasi_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_anterior_septum_nasi_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <spam class="my-3 fw-bold">Rhinoscopi Pasterior</spam>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Septum Nasi</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_pasterior_septum_nasi_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_pasterior_septum_nasi_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Superior</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="rhinoscopi_superior_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="rhinoscopi_superior_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">media</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="rhinoscopi_media_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="rhinoscopi_media_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">fasso rossenmuler</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_fasso_rossenmuler_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="rhinoscopi_fasso_rossenmuler_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <p class="my-3 fw-bold">Meatus Nasi</p>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Superior</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="meatus_nasi_superior_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="meatus_nasi_superior_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Media</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="meatus_nasi_media_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="meatus_nasi_media_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Inferior</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="meatus_nasi_inferior_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="meatus_nasi_inferior_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <p class="my-3 fw-bold">Hidung</p>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Bentuk</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="hidung_bentuk_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="hidung_bentuk_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Luka</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="hidung_luka_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="hidung_luka_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Bisul</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="hidung_bisul_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="hidung_bisul_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Fisure</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="hidung_fissare_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="hidung_fissare_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-bold mt-4">Paranatal Sinus</h6>
                                <p class="my-3 fw-bold">Senus Frontalis</p>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Nyeri Tekan</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="senus_frontalis_nyeri_tekan_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="senus_frontalis_nyeri_tekan_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Transluminasi</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="senus_frontalis_transluminasi_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="senus_frontalis_transluminasi_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <p class="my-3 fw-bold">Sinus Maksinasi</p>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Nyari Tekan</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="sinus_maksinasi_nyari_tekan_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="sinus_maksinasi_nyari_tekan_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">Transluminasi</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control"
                                                name="sinus_maksinasi_transluminasi_kanan" placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control"
                                                name="sinus_maksinasi_transluminasi_kiri" placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <span class="fw-bold">Laringoskopi Indirex</span>
                                <div class="form-group mt-4">
                                    <label style="min-width: 200px;">Pangkal Lidah</label>
                                    <input type="text" class="form-control" name="pangkal_lidah"
                                        placeholder="Jelaskan">
                                </div>
                                <div class="form-group mt-3">
                                    <label style="min-width: 200px;">Tonsil Lidah</label>
                                    <input type="text" class="form-control" name="tonsil_lidah"
                                        placeholder="Jelaskan">
                                </div>
                                <div class="form-group mt-3">
                                    <label style="min-width: 200px;">Epiglotis</label>
                                    <input type="text" class="form-control" name="epiglotis" placeholder="Jelaskan">
                                </div>
                                <div class="form-group mt-3">
                                    <label style="min-width: 200px;">Pita Suara</label>
                                    <input type="text" class="form-control" name="pita_suara" placeholder="Jelaskan">
                                </div>

                                <p class="my-3 fw-bold">Plica Vokalis</p>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">bentuk</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="plica_vokalis_bentuk_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="plica_vokalis_bentuk_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-3">warna</label>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Kanan</span>
                                            <input type="text" class="form-control" name="plica_vokalis_warna_kanan"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Kiri</span>
                                            <input type="text" class="form-control" name="plica_vokalis_warna_kiri"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>
                                </div>

                                <p class="my-3 fw-bold">Antropometri</p>

                                <div class="form-group mt-4">
                                    <label style="min-width: 200px;">Tinggi Badan</label>
                                    <input type="text" class="form-control" name="antropometri_tinggi_badan"
                                        value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->tinggi_badan : '' }}">
                                </div>
                                <div class="form-group mt-4">
                                    <label style="min-width: 200px;">Berat Badan</label>
                                    <input type="text" class="form-control" name="antropometr_berat_badan"
                                        value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->berat_badan : '' }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" style="min-width: 200px;">Indeks Massa Tubuh
                                        (IMT)</label>
                                    <div class="flex-grow-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="antropometri_imt" readonly>
                                            <span class="input-group-text text-muted fst-italic">rumus: IMT =
                                                berat
                                                (kg) / tinggi (m) / tinggi (m)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" style="min-width: 200px;">Luas Permukaan Tubuh
                                        (LPT)</label>
                                    <div class="flex-grow-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="antropometri_lpt" readonly>
                                            <span class="input-group-text text-muted fst-italic">rumus: LPT =
                                                tinggi
                                                (m2) x berat (kg) / 3600</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <p class="col-3">
                                        Pemeriksaan Fisik
                                    </p>
                                    <div class="col-9">
                                        <div class="alert alert-info mb-3 mt-4">
                                            <p class="mb-0 small">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Centang normal jika fisik yang dinilai normal, pilih tanda
                                                tambah
                                                untuk
                                                menambah
                                                keterangan fisik yang ditemukan tidak normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak
                                                dilakukan.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="pemeriksaan-fisik">
                                        <h6>Pemeriksaan Fisik</h6>
                                        <p class="text-small">Centang normal jika fisik yang dinilai
                                            normal,
                                            pilih tanda tambah
                                            untuk menambah keterangan fisik yang ditemukan tidak normal.
                                            Jika
                                            tidak dipilih salah satunya, maka pemeriksaan tidak
                                            dilakukan.
                                        </p>
                                        <div class="row">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}
                                                                    </div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ $item->id }}-normal"
                                                                            name="{{ $item->id }}-normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="{{ $item->id }}-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button"
                                                                        data-target="{{ $item->id }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2"
                                                                    id="{{ $item->id }}-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator" id="riwayat-kesehatan">
                                <h5 class="section-title">6. Riwayat Kesehatan</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong class="fw-normal">
                                            Penyakit Yang Pernah Diderita
                                        </strong>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Perbaiki id pada hidden input -->
                                        <input type="hidden" name="riwayat_kesehatan_penyakit_diderita"
                                            id="diagnosisData">

                                        <a href="javascript:void(0)"
                                            class="text-secondary text-decoration-none fw-bold ms-3" id="btn-diagnosis">
                                            <i class="bi bi-plus-square"></i> Tambah
                                        </a>
                                        <div class="bg-light p-3 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;">
                                                <div class="diagnosis-list">
                                                    <!-- Items will be inserted here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @push('modals')
                                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-create-diagnosi')
                                    @endpush
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <strong class="fw-normal">Riwayat Penyakit Keluarga</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Tambahkan hidden input -->
                                        <input type="hidden" name="riwayat_kesehatan_penyakit_keluarga"
                                            id="diagnosisKeluargaData">

                                        <a href="javascript:void(0)"
                                            class="text-secondary text-decoration-none fw-bold ms-3"
                                            id="btn-diagnosis-keluarga">
                                            <i class="bi bi-plus-square"></i> Tambah
                                        </a>
                                        <div class="bg-light p-3 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;">
                                                <div class="diagnosis-list-keluarga">
                                                    <!-- Data akan ditampilkan disini -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @push('modals')
                                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-create-diagnosi-keluarga')
                                    @endpush
                                </div>
                            </div>

                            <div class="section-separator" style="margin-bottom: 2rem;" id="hasil-pemeriksaan-penunjang">
                                <h5 class="fw-semibold mb-4">7. Hasil Laboratorium</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Darah</label>
                                    <input type="text" class="form-control" name="darah" placeholder="darah">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Urine</label>
                                    <input type="text" class="form-control" name="urine" placeholder="urine">
                                </div>
                            </div>


                            <div class="section-separator" style="margin-bottom: 2rem;" id="hasil-pemeriksaan-penunjang">
                                <h5 class="fw-semibold mb-4">8. Hasil Penunjang</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Rontgent</label>
                                    <input type="text" class="form-control" name="rontgent" placeholder="rontgent">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Gistopatology</label>
                                    <input type="text" class="form-control" name="gistopatology"
                                        placeholder="gistopatology">
                                </div>

                                {{-- <div class="mt-4">
                                    @php
                                        $examTypes = [
                                            'darah' => 'Darah',
                                            'urine' => 'Urine',
                                            'rontgent' => 'Rontgent',
                                            'histopatology' => 'Histopatology',
                                        ];
                                    @endphp

                                    @foreach ($examTypes as $key => $label)
                                        <div class="row align-items-center mb-3">
                                            <div class="col-3 col-md-2">
                                                <span class="text-secondary">{{ $label }}</span>
                                            </div>
                                            <div class="col col-md-8">
                                                <div class="border rounded p-2 bg-white">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center flex-grow-1">
                                                            <i class="bi bi-file-text text-primary me-2"></i>
                                                            <div class="file-input-wrapper position-relative w-100">
                                                                <input type="file" class="form-control"
                                                                    name="hasil_pemeriksaan_penunjang_{{ $key }}"
                                                                    id="{{ $key }}File"
                                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                                    data-preview-container="{{ $key }}Preview">
                                                                <div class="file-info small text-muted mt-1"
                                                                    id="{{ $key }}FileInfo">
                                                                    <span>Format: PDF, JPG, PNG (Max 2MB)</span>
                                                                </div>
                                                                @error('hasil_pemeriksaan_penunjang_' . $key)
                                                                    <div class="invalid-feedback d-block">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div id="{{ $key }}Preview" class="preview-container">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div> --}}
                            </div>

                            <div class="section-separator" id="diagnosis">
                                <h5 class="fw-semibold mb-4">9. Diagnosis</h5>


                                <!-- Diagnosis Banding -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        diagnosis banding,
                                        apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan diagnosis banding yang tidak ditemukan.</small>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="diagnosis-banding-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Diagnosis Banding">
                                        <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>

                                    <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                        <!-- Diagnosis items will be added here dynamically -->
                                    </div>

                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                        value="[]">
                                </div>

                                <!-- Diagnosis Kerja -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan diagnosis kerja yang tidak ditemukan.</small>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="diagnosis-kerja-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Diagnosis Kerja">
                                        <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>

                                    <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                        <!-- Diagnosis items will be added here dynamically -->
                                    </div>

                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja" value="[]">
                                </div>
                            </div>

                            <div class="section-separator" id="rencana_pengobatan">
                                <h5 class="fw-semibold mb-4">10. Rencana Penatalaksanaan dan Pengobatan</h5>
                                <textarea class="form-control" name="rencana_penatalaksanaan" rows="4"
                                    placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_penatalaksanaan') }}</textarea>

                            </div>

                            <div class="section-separator" id="prognosis">
                                <h5 class="fw-semibold mb-4">11. Prognosis</h5>
                                <select class="form-select" name="tht_prognosis">
                                    <option value="" selected disabled>--Pilih Prognosis--</option>
                                    @forelse ($satsetPrognosis as $item)
                                        <option value="{{ $item->prognosis_id }}">
                                            {{ $item->value ?? 'Field tidak ditemukan' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada data</option>
                                    @endforelse
                                </select>
                            </div>


                            {{-- <div class="section-separator" style="margin-bottom: 2rem;" id="implementasi">
                                <h5 class="fw-semibold mb-4">10. Implementasi</h5>

                                <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                        Pengobatan</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                        rencana Penatalaksanaan dan Pengobatan kerja yang tidak
                                        ditemukan.</small>
                                </div>

                                <!-- Observasi Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Observasi</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="observasi-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Observasi">
                                        <span class="input-group-text bg-white" id="add-observasi">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="observasi-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="observasi" name="observasi" value="[]">
                                </div>

                                <!-- Terapeutik Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Terapeutik</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="terapeutik-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Terapeutik">
                                        <span class="input-group-text bg-white" id="add-terapeutik">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="terapeutik-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
                                </div>

                                <!-- Edukasi Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Edukasi</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="edukasi-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Edukasi">
                                        <span class="input-group-text bg-white" id="add-edukasi">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="edukasi-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="edukasi" name="edukasi" value="[]">
                                </div>

                                <!-- Kolaborasi Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Kolaborasi</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="kolaborasi-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Kolaborasi">
                                        <span class="input-group-text bg-white" id="add-kolaborasi">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="kolaborasi-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                </div>

                                <!-- Kolaborasi Section -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Prognosis</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan
                                        Prognosis yang tidak ditemukan.</small>
                                    <!-- sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="rencana-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Rencana Penatalaksanaan">
                                        <span class="input-group-text bg-white" id="add-rencana">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>

                                    <div id="rencana-list" class="list-group mb-3">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="rencana_penatalaksanaan" name="prognosis"
                                        value="[]">
                                </div>
                            </div> --}}

                            {{-- <div class="section-separator" style="margin-bottom: 2rem;" id="evaluasi">
                                <h5 class="fw-semibold mb-4">11. Evaluasi</h5>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Tambah Evaluasi Keperawatan</label>
                                    <textarea class="form-control" name="evaluasi_evaluasi_keperawatan" rows="4"
                                        placeholder="Evaluasi Keperawaran"></textarea>
                                </div>
                            </div> --}}


                            <div class="section-separator" style="margin-bottom: 2rem;" id="discharge-planning">
                                <h5 class="fw-semibold mb-4">12. Discharge Planning</h5>

                                <form id="dischargePlanningForm">
                                    {{-- <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Diagnosis medis</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light" id="diagnosisMedis"
                                                name="dp_diagnosis_medis">
                                                <option selected value="Lokalis nyeri">Lokalis nyeri</option>
                                                <option value="Penyakit jantung">Penyakit jantung</option>
                                                <option value="Penyakit paru">Penyakit paru</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Usia lanjut</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light risk-factor" id="usiaLanjut"
                                                name="dp_usia_lanjut">
                                                <option selected value="">--pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Hambatan mobilisasi</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light risk-factor" id="hambatanMobilisasi"
                                                name="dp_hambatan_mobilisasi">
                                                <option selected value="">--pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Membutuhkan pelayanan medis
                                            berkelanjutan</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light risk-factor" id="pelayananMedis"
                                                name="dp_layanan_medis_lanjutan">
                                                <option selected value="">--pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Ketergantungan dengan orang lain
                                            dalam aktivitas harian</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light risk-factor" id="ketergantungan"
                                                name="dp_tergantung_orang_lain">
                                                <option selected value="">--pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="col-md-3 text-secondary">Perkiraan lama hari
                                            dirawat</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="number" id="lamaDirawat" name="dp_lama_dirawat"
                                                    class="form-control bg-light" placeholder="Hari" min="1">
                                                <span class="input-group-text bg-light">Hari</span>
                                            </div>
                                        </div>
                                        <label class="col-md-2 text-secondary text-end">Rencana Pulang</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" id="rencanaPulang" name="dp_rencana_pulang"
                                                    class="form-control bg-light"
                                                    value="{{ \Carbon\Carbon::now()->addDays(7)->format('d M Y') }}">
                                                <span class="input-group-text bg-light date-picker-toggle"
                                                    id="datePickerToggle">
                                                    <i class="bi bi-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2" id="conclusionContainer">
                                        <div class="alert alert-warning mb-2" id="needSpecialPlanAlert"
                                            style="background-color: #fff3cd; display: none;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="dp_kesimpulan"
                                                    id="need_special" value="Membutuhkan rencana pulang khusus" readonly>
                                                <label class="form-check-label" for="need_special">
                                                    Membutuhkan rencana pulang khusus
                                                </label>
                                            </div>
                                        </div>
                                        <div class="alert alert-success mb-2" id="noSpecialPlanAlert"
                                            style="background-color: #d1e7dd; display: none;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="dp_kesimpulan"
                                                    id="no_special" value="Tidak membutuhkan rencana pulang khusus"
                                                    readonly>
                                                <label class="form-check-label" for="no_special">
                                                    Tidak membutuhkan rencana pulang khusus
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Hidden input yang akan selalu terkirim ke database -->
                                        <input type="hidden" id="dp_kesimpulan_hidden" name="dp_kesimpulan"
                                            value="">
                                    </div>

                                    <div id="conclusionSection" class="mt-4 p-3 border rounded"
                                        style="display: none;">
                                        <h6 class="fw-bold">Kesimpulan:</h6>
                                        <p id="conclusionText" class="mb-0"></p>
                                    </div>
                                </form>
                            </div>

                            <div class="text-end">
                                <x-button-submit />
                            </div>

                        </div>
                    </div>

                </form>
        </div>
        </x-content-card>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const dischargeSelects = document.querySelectorAll('.discharge-select');
            const kesimpulanKhusus = document.getElementById('kesimpulan_khusus');
            const kesimpulanTidakKhusus = document.getElementById('kesimpulan_tidak_khusus');
            const kesimpulanValue = document.getElementById('kesimpulan_value');

            function updateKesimpulan() {
                let adaYa = false;
                let semuaTerjawab = true;

                dischargeSelects.forEach(function(select) {
                    const value = select.value;

                    if (!value || value === '') {
                        semuaTerjawab = false;
                    }

                    if (value === 'ya') {
                        adaYa = true;
                    }
                });

                if (semuaTerjawab) {
                    if (adaYa) {
                        kesimpulanKhusus.style.display = 'block';
                        kesimpulanTidakKhusus.style.display = 'none';
                        kesimpulanValue.value = 'membutuhkan_rencana_khusus';
                    } else {
                        kesimpulanKhusus.style.display = 'none';
                        kesimpulanTidakKhusus.style.display = 'block';
                        kesimpulanValue.value = 'tidak_membutuhkan_rencana_khusus';
                    }
                } else {
                    kesimpulanKhusus.style.display = 'none';
                    kesimpulanTidakKhusus.style.display = 'none';
                    kesimpulanValue.value = '';
                }
            }

            dischargeSelects.forEach(function(select) {
                select.addEventListener('change', updateKesimpulan);
            });

            function autoFillDiagnosis() {
                const diagnosisInput = document.getElementById('diagnosis_medis');

                if (window.asesmenData && window.asesmenData.diagnosis) {
                    diagnosisInput.value = window.asesmenData.diagnosis;
                }
            }

            autoFillDiagnosis();

            window.resetDischargePlanning = function() {
                dischargeSelects.forEach(function(select) {
                    select.selectedIndex = 0;
                });
                updateKesimpulan();
            };

            window.setDischargePlanning = function(data) {
                if (data.usia_lanjut) {
                    document.getElementById('usia_lanjut').value = data.usia_lanjut;
                }
                if (data.hambatan_mobilisasi) {
                    document.getElementById('hambatan_mobilisasi').value = data.hambatan_mobilisasi;
                }
                if (data.pelayanan_medis) {
                    document.getElementById('pelayanan_medis_berkelanjutan').value = data.pelayanan_medis;
                }
                if (data.ketergantungan_aktivitas) {
                    document.getElementById('ketergantungan_aktivitas').value = data.ketergantungan_aktivitas;
                }
                if (data.diagnosis_medis) {
                    document.getElementById('diagnosis_medis').value = data.diagnosis_medis;
                }

                updateKesimpulan();
            };

            updateKesimpulan();
        });

        const additionalCSS = `
            .alert {
                padding: 12px;
                margin-bottom: 10px;
                border: 1px solid transparent;
                border-radius: 4px;
                font-weight: 500;
            }

            .alert-warning {
                color: #856404;
                background-color: #fff3cd;
                border-color: #ffeaa7;
            }

            .alert-success {
                color: #155724;
                background-color: #d4edda;
                border-color: #c3e6cb;
            }

            .discharge-select:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .form-group label {
                font-weight: 500;
                margin-bottom: 5px;
            }
        `;

        const styleSheet = document.createElement("style");
        styleSheet.innerText = additionalCSS;
        document.head.appendChild(styleSheet);
    </script>
@endpush
