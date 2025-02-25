@extends('layouts.administrator.master')

@section('content')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.show-include')
<div class="row">
    <div class="col-md-3">
        @include('components.patient-card-keperawatan')
    </div>

    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div>
                {{-- @if ($asesmen->kategori == 1 && $asesmen->sub_kategori == 5) --}}
                    <a href="javascript:void(0);"
                    class="btn btn-outline-primary"
                    data-id="{{ $asesmen->id }}"
                    data-kd-unit="{{ $asesmen->kd_unit }}"
                    data-kd-pasien="{{ $asesmen->pasien->kd_pasien }}"
                    data-tgl-masuk="{{ \Carbon\Carbon::parse($asesmen->tgl_masuk)->format('Y-m-d') }}"
                    data-urut-masuk="{{ $asesmen->urut_masuk }}"
                    onclick="printPDF(this)">
                    <i class="bi bi-printer"></i>
                        Print PDF
                    </a>
                {{-- @endif --}}

            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Data Asesmen Awal Medis THT</h5>
                <p>Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
            </div>
            <div class="card-body">
                <!-- Informasi Dasar -->
                <div class="mb-4">

                    <!-- 1. Data masuk -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>1. Data masuk</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Petugas :</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->user->name ?? '-' }}
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Dan Jam Masuk :</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ date('d M Y H:i', strtotime($asesmen->rmeAsesmenTht->tgl_masuk)) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">kondisi Masuk :</label>
                                            <p class="form-control-plaintext border-bottom">
                                                @if ($asesmen->rmeAsesmenTht->kondisi_masuk == 1)
                                                Mandiri
                                                @elseif($asesmen->rmeAsesmenTht->kondisi_masuk == 2)
                                                Kursi Roda
                                                @elseif($asesmen->rmeAsesmenTht->kondisi_masuk == 3)
                                                Brankar
                                                @else
                                                Tidak Diketahui
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ruang :</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenTht->ruang == 1 ? 'Ya' : 'Tidak' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Anamnesis -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>2. Anamnesis</h5>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Anamnesis :</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenTht->anamnesis_anamnesis ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Pemeriksaan fisik -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>3. Pemeriksaan fisik</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tek. Darah (mmHg) :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Sistole :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['darah_sistole'] ?? '-' }}
                                                    mmHg</span>
                                                <br>
                                                <span>Diastole :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['darah_diastole'] ?? '-' }}
                                                    mmHg</span>
                                            </p>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nadi (Per Menit) :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['nadi']
                                                ?? '-' }}
                                                Menit
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nafas (Per Menit) :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['nafas'] ?? '-' }}
                                                Menit
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Suhu (C) :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['suhu']
                                                ?? '-' }}
                                                °C
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Sensorium :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['sensorium'] ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">KU/KP/KG :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['ku_kp_kg'] ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">AVPU :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                @php
                                                $avpu = json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['avpu'] ?? null;
                                                $avpuOptions = [
                                                '0' => 'Sadar Baik/Alert : 0',
                                                '1' => 'Berespon dengan kata-kata/Voice: 1',
                                                '2' => 'Hanya berespon jika dirangsang nyeri/pain: 2',
                                                '3' => 'Pasien tidak sadar/unresponsive: 3',
                                                '4' => 'Gelisah atau bingung: 4',
                                                '5' => 'Acute Confusional States: 5'
                                                ];
                                                @endphp
                                                {{ $avpuOptions[$avpu] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Pemeriksaan Fisik Koprehensif Laringoskopi Indirex</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pangkal Lidah :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['pangkal_lidah'] ?? '-' }}
                                            </p>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tonsil Lidah :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['tonsil_lidah'] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Epiglotis :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['epiglotis'] ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pita Suara :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                true
                                                )[0]['pita_suara'] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Daun Telinga</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nanah :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['daun_telinga_nanah_kana'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['daun_telinga_nanah_kiri'] ?? '-' }}</span>
                                            </p>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Darah :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['daun_telinga_darah_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['daun_telinga_darah_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Lainnya :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['daun_telinga_lainnya_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['daun_telinga_lainnya_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Liang Telinga</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Darah :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_darah_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_darah_kiri'] ?? '-' }}</span>
                                            </p>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nanah :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_nanah_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_nanah_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Berbau :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_berbau_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_berbau_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Lainnya :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_lainnya_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['liang_telinga_lainnya_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Tes Pendengaran</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Renne Tes :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_renne_res_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_renne_res_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Weber Tes :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_weber_tes_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_weber_tes_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Schwabach Test :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_schwabach_test_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_schwabach_test_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bebisik :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_bebisik_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['tes_pendengaran_bebisik_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Paranatal Sinus Senus Frontalis</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nyeri Tekan :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['senus_frontalis_nyeri_tekan_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['senus_frontalis_nyeri_tekan_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Transluminasi :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['senus_frontalis_transluminasi_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['senus_frontalis_transluminasi_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Sinus Maksinasi</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nyeri Tekan :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['sinus_maksinasi_nyari_tekan_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['sinus_maksinasi_nyari_tekan_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Transluminasi :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['sinus_maksinasi_transluminasi_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['sinus_maksinasi_transluminasi_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Rhinoscopi Anterior</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nyeri Tekan :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_anterior_cavun_nasi_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_anterior_cavun_nasi_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Konka Inferior :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_anterior_konka_inferior_kanan'] ?? '-'
                                                    }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_anterior_konka_inferior_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Septum Nasi :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_anterior_septum_nasi_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_anterior_septum_nasi_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Rhinoscopi Pasterior</h5>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Septum Nasi :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_pasterior_septum_nasi_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['rhinoscopi_pasterior_septum_nasi_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Meatus Nasi</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Superior :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['meatus_nasi_superior_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['meatus_nasi_superior_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Media :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['meatus_nasi_media_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['meatus_nasi_media_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inferior :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['meatus_nasi_inferior_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['meatus_nasi_inferior_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Membran Tympani</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Warna :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['membran_tympani_warna_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['membran_tympani_warna_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Perforasi :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['membran_tympani_perforasi_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['membran_tympani_perforasi_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">lainnya :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['membran_tympani_lainnya_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['membran_tympani_lainnya_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Hidung</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bentuk :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_bentuk_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_bentuk_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Luka :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_luka_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_luka_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bisul :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_bisul_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_bisul_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fissare :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>Kanan :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_fissare_kanan'] ?? '-' }}</span>
                                                <br>
                                                <span>Kiri :
                                                    {{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['hidung_fissare_kiri'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Antropometri</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tinggi Badan :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>{{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['antropometri_tinggi_badan'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Berat Badan :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>{{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['antropometr_berat_badan'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Indeks Massa Tubuh (IMT) :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>{{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['antropometri_imt'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Luas Permukaan Tubuh (LPT) :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                <span>{{ json_decode(
                                                    $asesmen->rmeAsesmenThtPemeriksaanFisik,
                                                    true
                                                    )[0]['antropometri_lpt'] ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <h5>Pemeriksaan Fisik</h5>
                                        <p class="mb-3 small bg-info text-white rounded-3 p-2">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka
                                            pemeriksaan tidak dilakukan.
                                        </p>
                                    </div>
                                    {{-- {{ $asesmen->pemeriksaanFisik ?? '-' }} --}}

                                    @php
                                    $pemeriksaanFisikData = json_decode($asesmen->pemeriksaanFisik, true) ?: [];

                                    $totalItems = count($pemeriksaanFisikData);
                                    $halfCount = ceil($totalItems / 2);
                                    $firstColumn = array_slice($pemeriksaanFisikData, 0, $halfCount);
                                    $secondColumn = array_slice($pemeriksaanFisikData, $halfCount);
                                    @endphp

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @foreach ($firstColumn as $item)
                                                @php
                                                $status = $item['is_normal'] ?? null;
                                                $keterangan = $item['keterangan'] ?? null;

                                                $namaItem = "Keterangan : " . $item['keterangan'];
                                                @endphp
                                                <div
                                                    class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                    <span>{{ $namaItem }}</span>

                                                    <div class="d-flex align-items-center">
                                                        @if ($status == '0' || $status == 0)
                                                        <span class="badge bg-warning text-dark me-2">Tidak
                                                            Normal</span>
                                                        @elseif ($status == '1' || $status == 1)
                                                        <span class="badge bg-success me-2">Normal</span>
                                                        @else
                                                        <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>

                                            <div class="col-md-6">
                                                @foreach ($secondColumn as $item)
                                                @php
                                                $status = $item['is_normal'] ?? null;
                                                $keterangan = $item['keterangan'] ?? null;

                                                // Disini Anda perlu mendapatkan nama item fisik
                                                $namaItem = "Keterangan : " . $item['keterangan'];
                                                @endphp
                                                <div
                                                    class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                    <span>{{ $namaItem }}</span>

                                                    <div class="d-flex align-items-center">
                                                        @if ($status == '0' || $status == 0)
                                                        <span class="badge bg-warning text-dark me-2">Tidak
                                                            Normal</span>
                                                        @elseif ($status == '1' || $status == 1)
                                                        <span class="badge bg-success me-2">Normal</span>
                                                        @else
                                                        <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- 4. Riwayat Kesehatan -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>4. Riwayat Kesehatan</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Penyakit Yang Pernah Diderita :</label>
                                            @php
                                            $penyakit =
                                            json_decode(
                                            $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_kesehatan_penyakit_diderita'],
                                            true
                                            );
                                            @endphp

                                            @if(!empty($penyakit))
                                            <ol>
                                                @foreach($penyakit as $item)
                                                <li class="me-2">{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                            @else
                                            <span class="text-muted">Tidak ada</span>
                                            @endif
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Riwayat Penyakit Keluarga :</label>
                                            @php
                                            $Keluarga =
                                            json_decode(
                                            $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_kesehatan_penyakit_keluarga'],
                                            true
                                            );
                                            @endphp

                                            @if(!empty($Keluarga))
                                            <ol>
                                                @foreach($Keluarga as $item)
                                                <li class="me-2">{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                            @else
                                            <span class="text-muted">Tidak ada</span>
                                            @endif
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Riwayat Penggunaan Obat -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>5. Riwayat Penggunaan Obat</h5>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Riwayat Penggunaan Obat :</label>
                                            @php
                                            $riwayatObat =
                                            json_decode(
                                            $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_penggunaan_obat'],
                                            true
                                            );
                                            @endphp

                                            @if(!empty($riwayatObat))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Obat</th>
                                                            <th>Dosis</th>
                                                            <th>Frekuensi</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($riwayatObat as $obat)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $obat['namaObat'] ?? '-' }}</td>
                                                            <td>{{ ($obat['dosis'] ?? '-') . ' ' . ($obat['satuan'] ??
                                                                '') }}
                                                            </td>
                                                            <td>{{ $obat['frekuensi'] ?? '-' }}</td>
                                                            <td>{{ $obat['keterangan'] ?? '-' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Alergi -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>6. Alergi</h5>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Alergi :</label>
                                            @php
                                            $riwayatAlergi =
                                            json_decode(
                                            $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['alergi'],
                                            true
                                            );
                                            @endphp

                                            @if(!empty($riwayatAlergi))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Alergen</th>
                                                            <th>Reaksi</th>
                                                            <th>Severe</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($riwayatAlergi as $aler)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $aler['alergen'] ?? '-' }}</td>
                                                            <td>{{ ($aler['reaksi'] ?? '-') . ' ' . ($obat['satuan'] ??
                                                                '') }}
                                                            </td>
                                                            <td>{{ $aler['severe'] ?? '-' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Hasil Pemeriksaan Penunjang -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>7. Hasil Pemeriksaan Penunjang</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Darah :</label>
                                                <div class="form-control-plaintext border-bottom p-2">
                                                    @if($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah)
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                        $filePath = 'storage/uploads/gawat-inap/asesmen-tht/' .
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah;
                                                        $fileExtension =
                                                        pathinfo(
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah,
                                                        PATHINFO_EXTENSION
                                                        );
                                                        $isPdf = strtolower($fileExtension) === 'pdf';
                                                        @endphp

                                                        <div class="file-preview me-3">
                                                            @if($isPdf)
                                                            <div class="pdf-icon"
                                                                style="font-size: 48px; color: #dc3545;">
                                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                                            </div>
                                                            @else
                                                            <img src="{{ asset($filePath) }}"
                                                                alt="Hasil Pemeriksaan Urine" class="img-thumbnail"
                                                                style="max-width: 150px; cursor: pointer;"
                                                                onclick="window.open('{{ asset($filePath) }}', '_blank')">
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <div class="action-buttons mt-2">
                                                        <a href="{{ asset($filePath) }}" class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                            <i class="bi bi-eye-fill me-1"></i> Lihat Lengkap
                                                        </a>
                                                        <a href="{{ asset($filePath) }}"
                                                            class="btn btn-sm btn-secondary ms-2" download>
                                                            <i class="bi bi-download me-1"></i> Unduh
                                                        </a>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Urine :</label>
                                                <div class="form-control-plaintext border-bottom p-2">
                                                    @if($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine)
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                        $filePath = 'storage/uploads/gawat-inap/asesmen-tht/' .
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine;
                                                        $fileExtension =
                                                        pathinfo(
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine,
                                                        PATHINFO_EXTENSION
                                                        );
                                                        $isPdf = strtolower($fileExtension) === 'pdf';
                                                        @endphp

                                                        <div class="file-preview me-3">
                                                            @if($isPdf)
                                                            <div class="pdf-icon"
                                                                style="font-size: 48px; color: #dc3545;">
                                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                                            </div>
                                                            @else
                                                            <img src="{{ asset($filePath) }}"
                                                                alt="Hasil Pemeriksaan Urine" class="img-thumbnail"
                                                                style="max-width: 150px; cursor: pointer;"
                                                                onclick="window.open('{{ asset($filePath) }}', '_blank')">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="action-buttons mt-2">
                                                        <a href="{{ asset($filePath) }}" class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                            <i class="bi bi-eye-fill me-1"></i> Lihat Lengkap
                                                        </a>
                                                        <a href="{{ asset($filePath) }}"
                                                            class="btn btn-sm btn-secondary ms-2" download>
                                                            <i class="bi bi-download me-1"></i> Unduh
                                                        </a>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rontgent :</label>
                                                <div class="form-control-plaintext border-bottom p-2">
                                                    @if($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_rontgent)
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                        $filePath = 'storage/uploads/gawat-inap/asesmen-tht/' .
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_rontgent;
                                                        $fileExtension =
                                                        pathinfo(
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_rontgent,
                                                        PATHINFO_EXTENSION
                                                        );
                                                        $isPdf = strtolower($fileExtension) === 'pdf';
                                                        @endphp

                                                        <div class="file-preview me-3">
                                                            @if($isPdf)
                                                            <div class="pdf-icon"
                                                                style="font-size: 48px; color: #dc3545;">
                                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                                            </div>
                                                            @else
                                                            <img src="{{ asset($filePath) }}"
                                                                alt="Hasil Pemeriksaan Urine" class="img-thumbnail"
                                                                style="max-width: 150px; cursor: pointer;"
                                                                onclick="window.open('{{ asset($filePath) }}', '_blank')">
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <div class="action-buttons mt-2">
                                                        <a href="{{ asset($filePath) }}" class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                            <i class="bi bi-eye-fill me-1"></i> Lihat Lengkap
                                                        </a>
                                                        <a href="{{ asset($filePath) }}"
                                                            class="btn btn-sm btn-secondary ms-2" download>
                                                            <i class="bi bi-download me-1"></i> Unduh
                                                        </a>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Histopatology :</label>
                                                <div class="form-control-plaintext border-bottom p-2">
                                                    @if($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_histopatology)
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                        $filePath = 'storage/uploads/gawat-inap/asesmen-tht/' .
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_histopatology;
                                                        $fileExtension =
                                                        pathinfo(
                                                        $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_histopatology,
                                                        PATHINFO_EXTENSION
                                                        );
                                                        $isPdf = strtolower($fileExtension) === 'pdf';
                                                        @endphp

                                                        <div class="file-preview me-3">
                                                            @if($isPdf)
                                                            <div class="pdf-icon"
                                                                style="font-size: 48px; color: #dc3545;">
                                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                                            </div>
                                                            @else
                                                            <img src="{{ asset($filePath) }}"
                                                                alt="Hasil Pemeriksaan Urine" class="img-thumbnail"
                                                                style="max-width: 150px; cursor: pointer;"
                                                                onclick="window.open('{{ asset($filePath) }}', '_blank')">
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <div class="action-buttons mt-2">
                                                        <a href="{{ asset($filePath) }}" class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                            <i class="bi bi-eye-fill me-1"></i> Lihat Lengkap
                                                        </a>
                                                        <a href="{{ asset($filePath) }}"
                                                            class="btn btn-sm btn-secondary ms-2" download>
                                                            <i class="bi bi-download me-1"></i> Unduh
                                                        </a>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- 8. Discharge Planning -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>8. Discharge Planning</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis medis :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_diagnosis_medis'] ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Usia lanjut :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                @php
                                                $usiaLanjut = json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_usia_lanjut'] ?? '-';
                                                if ($usiaLanjut == 1) {
                                                echo 'Ya';
                                                } elseif ($usiaLanjut == 0) {
                                                echo 'Tidak';
                                                } else {
                                                echo '-';
                                                }
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Hambatan mobilisasi :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                @php
                                                $mobilisasi = json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_hambatan_mobilisasi'] ?? '-';
                                                if ($mobilisasi == 1) {
                                                echo 'Ya';
                                                } elseif ($mobilisasi == 0) {
                                                echo 'Tidak';
                                                } else {
                                                echo '-';
                                                }
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Membutuhkan pelayanan medis berkelanjutan
                                                :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                @php
                                                $layananMedisLanjutan =
                                                json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_layanan_medis_lanjutan'] ?? '-';
                                                if ($layananMedisLanjutan == 1) {
                                                echo 'Ya';
                                                } elseif ($layananMedisLanjutan == 0) {
                                                echo 'Tidak';
                                                } else {
                                                echo '-';
                                                }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ketergantungan dengan orang lain dalam
                                                aktivitas harian :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                @php
                                                $tergantungOrangLain =
                                                json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_tergantung_orang_lain'] ?? '-';
                                                if ($tergantungOrangLain == 1) {
                                                echo 'Ya';
                                                } elseif ($tergantungOrangLain == 0) {
                                                echo 'Tidak';
                                                } else {
                                                echo '-';
                                                }
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Perkiraan lama hari dirawat :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_lama_dirawat'] ?? '-' }}
                                                Hari
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Rencana Pulang :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_rencana_pulang'] ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ json_decode(
                                                $asesmen->rmeAsesmenThtDischargePlanning,
                                                true
                                                )[0]['dp_kesimpulan'] ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Diagnosis -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>9. Diagnosis</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Banding :</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding,
                                                apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>
                                            @php
                                            $diagnosisBanding =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['diagnosis_banding']
                                            ?? '[]', true);
                                            @endphp

                                            @if(!empty($diagnosisBanding))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($diagnosisBanding as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Kerja :</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>
                                            @php
                                            $diagnosisKerja =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['diagnosis_kerja']
                                            ?? '[]', true);
                                            @endphp

                                            @if(!empty($diagnosisKerja))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($diagnosisKerja as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Implementasi -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>10. Implementasi</h5>
                                    <p>Rencana Penatalaksanaan dan Pengobatan</p>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                        rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Observasi :</label>
                                            @php
                                            $observasi =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['observasi'] ??
                                            '[]', true);
                                            @endphp

                                            @if(!empty($observasi))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($observasi as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Terapeutik :</label>
                                            @php
                                            $terapeutik =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['terapeutik'] ??
                                            '[]', true);
                                            @endphp

                                            @if(!empty($terapeutik))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($terapeutik as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Edukasi :</label>
                                            @php
                                            $edukasi =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['edukasi'] ??
                                            '[]', true);
                                            @endphp

                                            @if(!empty($edukasi))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($edukasi as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kolaborasi :</label>
                                            @php
                                            $kolaborasi =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['kolaborasi'] ??
                                            '[]', true);
                                            @endphp

                                            @if(!empty($kolaborasi))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($kolaborasi as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Prognosis :</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan
                                                Prognosis yang tidak ditemukan.</small>
                                            @php
                                            $prognosis =
                                            json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['prognosis'] ??
                                            '[]', true);
                                            @endphp

                                            @if(!empty($prognosis))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Diagnosis Banding</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($prognosis as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $diagnosis }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="form-control-plaintext border-bottom">
                                                <span class="text-muted">Tidak ada</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 11. Evaluasi -->
                    <div class="tab-pane fade show">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5>11. Evaluasi</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis medis :</label>
                                            <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenTht->evaluasi_evaluasi_keperawatan ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
