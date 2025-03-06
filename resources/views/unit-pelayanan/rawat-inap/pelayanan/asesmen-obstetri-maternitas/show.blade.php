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
                    <a href="javascript:void(0);" class="btn btn-outline-primary" data-id="{{ $asesmen->id }}"
                        data-kd-unit="{{ $asesmen->kd_unit }}" data-kd-pasien="{{ $asesmen->pasien->kd_pasien }}"
                        data-tgl-masuk="{{ \Carbon\Carbon::parse($asesmen->tgl_masuk)->format('Y-m-d') }}"
                        data-urut-masuk="{{ $asesmen->urut_masuk }}" onclick="printPDF(this)">
                        <i class="bi bi-printer"></i>
                        Print PDF
                    </a>
                    {{-- @endif --}}

                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Asesmen Awal Medis Obstetri</h5>
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
                                                    {{ date('d M Y H:i', strtotime($asesmen->asesmenObstetri->tgl_masuk)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pemeriksaan antenatal di RS Langsa
                                                    :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->asesmenObstetri->antenatal_rs == 0)
                                                        Tidak
                                                    @elseif($asesmen->asesmenObstetri->antenatal_rs == 1)
                                                        Ya
                                                    @else
                                                        Tidak Diketahui
                                                    @endif
                                                    <br>
                                                    berapa kali :
                                                    {{ $asesmen->asesmenObstetri->antenatal_rs_count }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pemeriksaan antenatal di tempat lain
                                                    :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->asesmenObstetri->antenatal_lain == 0)
                                                        Tidak
                                                    @elseif($asesmen->asesmenObstetri->antenatal_lain == 1)
                                                        Ya
                                                    @else
                                                        Tidak Diketahui
                                                    @endif
                                                    <br>
                                                    berapa kali :
                                                    {{ $asesmen->asesmenObstetri->antenatal_lain_count }}
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
                                                <label class="form-label fw-bold">Petugas :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenObstetri->anamnesis_anamnesis ?? '-' }}
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
                                                <label class="form-label fw-bold">Keadaan Umum :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->keadaan_umum ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nadi (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->nadi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Suhu (C) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->suhu ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">AVPU :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $avpuOptions = [
                                                            0 => 'Sadar Baik/Alert : 0',
                                                            1 => 'Berespon dengan kata-kata/Voice: 1',
                                                            2 => 'Hanya berespon jika dirangsang nyeri/pain: 2',
                                                            3 => 'Pasien tidak sadar/unresponsive: 3',
                                                            4 => 'Gelisah atau bingung: 4',
                                                            5 => 'Acute Confusional States: 5',
                                                        ];
                                                        $kesadaran =
                                                            $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran;
                                                    @endphp
                                                    {{ $avpuOptions[$kesadaran] ?? '-' }}
                                                </p>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tek Darah (mmHg) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    Sistole :
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->tekanan_darah_sistole ?? '-' }}
                                                    <br>
                                                    Diastole :
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->tekanan_darah_sistole ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pernafasan (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->pernafasan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesadaran :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <h6>Pemeriksaan Fisik Komprehensif</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Posisi Janin :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Fundus Uteri (Cm) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_tinggi_fundus ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Presentasi Janin :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <h6>Kontraksi (HIS)</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Frekuensi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_frekuensi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Irama :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Letak Janin :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Sikap Janin :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <h6>Denyut Jantung Janin (DJJ)</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Frekuensi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_frekuensi ?? '-' }}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Irama :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <h6>Serviks</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Frekuensi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Station :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_penurunan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Posisi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_posisi ?? '-' }}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Station :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pembukaan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_pembukaan ?? '-' }}
                                                    <br> jam:
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_jam_pembukaan
                                                        ? \Carbon\Carbon::parse($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_jam_pembukaan)->format('H:i')
                                                        : '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Irama :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <h6>Panggul</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Promontorium :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Line Terminalis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lengkung Sakrum :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_lengkung_sakrum ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Simpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_simpulan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Selaput Ketuban :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_selaput_ketuban ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Presentasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_presentasi ?? '-' }}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Spina Ischiadika :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Arkus Pubis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_arkus_pubis ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Dinding Samping :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_dinding_samping ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pembukaan (Cm) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_pembukaan_cm ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Air Ketuban :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_air_ketuban ?? '-' }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <h6>Antropometri</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_tinggi_badan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Indeks Massa Tubuh (IMT) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_imt ?? '-' }}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berat Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometr_berat_badan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Luas Permukaan Tubuh (LPT) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_lpt ?? '-' }}
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
                                        <div class="col-12">
                                            <div class="row">
                                                @php
                                                    $pemeriksaanFisikData = $asesmen->pemeriksaanFisik;
                                                    $itemFisikNames = [];
                                                    foreach ($itemFisik as $item) {
                                                        $itemFisikNames[$item->id] = $item->nama;
                                                    }

                                                    $totalItems = count($pemeriksaanFisikData);
                                                    $halfCount = ceil($totalItems / 2);
                                                    $firstColumn = $pemeriksaanFisikData->take($halfCount);
                                                    $secondColumn = $pemeriksaanFisikData->skip($halfCount);
                                                @endphp
                                                <div class="col-md-6">
                                                    @foreach ($firstColumn as $item)
                                                        @php
                                                            $status = $item->is_normal;
                                                            $keterangan = $item->keterangan;
                                                            $itemId = $item->id_item_fisik;
                                                            $namaItem = $itemFisikNames[$itemId] ?? 'Item #' . $itemId;
                                                        @endphp
                                                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                            <span>{{ $namaItem }}</span>
                                                            <div class="d-flex align-items-center">
                                                                @if ($status == '0' || $status == 0)
                                                                    <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                                @elseif ($status == '1' || $status == 1)
                                                                    <span class="badge bg-success me-2">Normal</span>
                                                                @else
                                                                    <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if ($keterangan && ($status == '0' || $status == 0))
                                                            <div class="mt-1 mb-2">
                                                                <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col-md-6">
                                                    @foreach ($secondColumn as $item)
                                                        @php
                                                            $status = $item->is_normal;
                                                            $keterangan = $item->keterangan;
                                                            $itemId = $item->id_item_fisik;
                                                            $namaItem = $itemFisikNames[$itemId] ?? 'Item #' . $itemId;
                                                        @endphp
                                                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                            <span>{{ $namaItem }}</span>
                                                            <div class="d-flex align-items-center">
                                                                @if ($status == '0' || $status == 0)
                                                                    <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                                @elseif ($status == '1' || $status == 1)
                                                                    <span class="badge bg-success me-2">Normal</span>
                                                                @else
                                                                    <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if ($keterangan && ($status == '0' || $status == 0))
                                                            <div class="mt-1 mb-2">
                                                                <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- 4. Status Nyeri -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>4. Status Nyeri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->jenis_skala_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->kesimpulan_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Durasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->durasi_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Frekuensi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kualitas :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Faktor peringan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->faktor_peringan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nilai Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->skala_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lokasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->lokasi_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->jenis_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Menjalar :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->menjalar ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Faktor pemberat :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriStatusNyeri->faktor_pemberat ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Efek Nyeri :</label>
                                                @if ($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                                <p class="form-control-plaintext border-bottom">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Riwayat Kesehatan -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>5. Riwayat Kesehatan</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status Obstetri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    Gravid :
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->gravid ?? '-' }}
                                                    <br>
                                                    Partus :
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->partus ?? '-' }}
                                                    <br>
                                                    Abortus :
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->abortus ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lama Haid :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->lama_haid ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Usia Kehamilan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->usia_kehamilan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Efek Nyeri :</label>
                                                @if ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                                <p class="form-control-plaintext border-bottom"></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Penambahan BB Selama Hamil (Kg) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->penambahan_bb ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Dukungan Sosial :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pendamping :</label>
                                                @if ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                                <p class="form-control-plaintext border-bottom"></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Rawat Inap :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap ?? '-' }}
                                                    @endif
                                                    <br>
                                                    Tanggal :
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->tanggal_rawat ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Penyakit Keluarga :</label>
                                                @if ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                                <p class="form-control-plaintext border-bottom"></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Obstetrik :</label>
                                                @if ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik)
                                                    <table class="table table-sm table-bordered ms-3">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Kehamilan</th>
                                                            <th>Persalinan</th>
                                                            <th>Nifas</th>
                                                            <th>Tgl Lahir</th>
                                                            <th>Anak</th>
                                                            <th>Tempat</th>
                                                        </tr>
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik, true) as $riwayat)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $riwayat['keadaanKehamilan'] }}</td>
                                                                <td>{{ $riwayat['caraPersalinan'] }}</td>
                                                                <td>{{ $riwayat['keadaanNifas'] }}</td>
                                                                <td>{{ $riwayat['tanggalLahir'] }}</td>
                                                                <td>{{ $riwayat['keadaanAnak'] }}</td>
                                                                <td>{{ $riwayat['tempatDanPenolong'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Siklus :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->siklus ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hari Pertama Haid Terakhir :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->hari_pht ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Perkawinan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->perkawinan_kali ?? '-' }}
                                                    kali
                                                    <br> Tahun :
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->perkawinan_usia ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kebiasaan Ibu Sewaktu Hamil :</label>
                                                @if ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                                <p class="form-control-plaintext border-bottom"></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kehamilan Diinginkan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pengambilan Keputusan :</label>
                                                @if ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                                <p class="form-control-plaintext border-bottom"></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Eliminasi (Defekasi) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->eliminasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Konsumsi Obat-Obatan (Jika Ada) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat ?? '-' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pemeriksaan antenatal di tempat lain
                                                    :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain == 1)
                                                        Ya
                                                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain == 0)
                                                        Tidak
                                                    @else
                                                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain ?? '-' }}
                                                    @endif
                                                    <br>
                                                    berapa kali :
                                                    {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->berapa_kali ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Hasil Pemeriksaan Penunjang -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>6. Hasil Pemeriksaan Penunjang</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Darah :</label>
                                                    <div class="form-control-plaintext border-bottom p-2">
                                                        @if ($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_darah)
                                                            <div class="d-flex align-items-center">
                                                                <div class="action-buttons mt-2">
                                                                    <a href="{{ asset('storage/' . $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_darah) }}"
                                                                        class="btn btn-sm btn-primary" target="_blank">
                                                                        <i class="bi bi-eye-fill me-1"></i> Lihat Lengkap
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Tidak ada file</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Urine :</label>
                                                    <div class="form-control-plaintext border-bottom p-2">
                                                        @if ($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_urine)
                                                            <div class="d-flex align-items-center">
                                                                <div class="action-buttons mt-2">
                                                                    <a href="{{ asset('storage/' . $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_urine) }}"
                                                                        class="btn btn-sm btn-primary" target="_blank">
                                                                        <i class="bi bi-eye-fill me-1"></i> Lihat Lengkap
                                                                    </a>
                                                                </div>
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
                                                        @if ($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_rontgent)
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="action-buttons mt-2">
                                                                        <a href="{{ asset('storage/' . $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_rontgent) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target="_blank">
                                                                            <i class="bi bi-eye-fill me-1"></i> Lihat
                                                                            Lengkap
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Tidak ada file</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Histopatology :</label>
                                                    <div class="form-control-plaintext border-bottom p-2">
                                                        @if ($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_histopatology)
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="action-buttons mt-2">
                                                                        <a href="{{ asset('storage/' . $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_histopatology) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target="_blank">
                                                                            <i class="bi bi-eye-fill me-1"></i> Lihat
                                                                            Lengkap
                                                                        </a>
                                                                    </div>
                                                                </div>
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

                        <!-- 7. Diagnosis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>7. Diagnosis</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Banding :</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk
                                                    mencari
                                                    diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                    keterangan diagnosis banding yang tidak ditemukan.</small>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Kerja :</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk
                                                    mencari
                                                    diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                    keterangan diagnosis kerja yang tidak ditemukan.</small>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Implementasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>8. Implementasi</h5>
                                        <p>Rencana Penatalaksanaan dan Pengobatan</p>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                            rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Observasi :</label>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Terapeutik :</label>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Edukasi :</label>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kolaborasi :</label>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Prognosis :</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk
                                                    mencari
                                                    Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                    keterangan
                                                    Prognosis yang tidak ditemukan.</small>
                                                @if ($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->prognosis)
                                                    <ul class="ms-3">
                                                        @foreach (json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->prognosis, true) as $efek)
                                                            <li>{{ $efek }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Evaluasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>9. Evaluasi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis medis :</label>
                                                <p class="form-control-plaintext form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenObstetri->evaluasi_evaluasi ?? '-' }}
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
