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

    @include('unit-pelayanan.forensik.pelayanan.pemeriksaan-klinik.include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Pemeriksaan Forensik Klinik',
                    'description' =>
                        'Tambah data Pemeriksaan Forensik Klinik dengan mengisi formulir di bawah ini.',
                ])
                <form
                    action="{{ route('forensik.unit.pelayanan.pemeriksaan-klinik.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="d-flex justify-content-center">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Pemeriksaan</label>
                                            <input type="date" name="tgl_pemeriksaan" id="tgl_pemeriksaan"
                                                class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="time" name="jam_pemeriksaan" id="jam_pemeriksaan"
                                                class="form-control" value="{{ date('H:i') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                            <div class="px-3">
                                <div>
                                    <div class="section-separator">
                                        <h5 class="section-title">1. Identitas Pasien/Korban/Jenazah</h5>
                                        <!-- Cara Datang -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Cara Datang</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="sendiri"
                                                        name="cara_datang" value="1">
                                                    <label class="form-check-label" for="sendiri">Sendiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="diantar_keluarga"
                                                        name="cara_datang" value="2">
                                                    <label class="form-check-label" for="diantar_keluarga">Diantar
                                                        keluarga</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="ambulance"
                                                        name="cara_datang" value="3">
                                                    <label class="form-check-label" for="ambulance">Ambulance</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="polisi"
                                                        name="cara_datang" value="4">
                                                    <label class="form-check-label" for="polisi">Polisi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="pmi"
                                                        name="cara_datang" value="5">
                                                    <label class="form-check-label" for="pmi">PMI</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="lainnya"
                                                        name="cara_datang" value="99">
                                                    <label class="form-check-label" for="lainnya">Lainnya</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Asal Rujukan -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Asal Rujukan</label>
                                            <input type="text" name="asal_rujukan" id="asal_rujukan"
                                                class="form-control">
                                        </div>


                                        <!-- Jenis Kasus -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Kasus</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="d-flex flex-wrap gap-3">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="laka_lantas"
                                                            name="jenis_kasus" value="1">
                                                        <label class="form-check-label" for="laka_lantas">Laka
                                                            lantas</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="pemukulan"
                                                            name="jenis_kasus" value="2">
                                                        <label class="form-check-label" for="pemukulan">Pemukulan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kesusilaan"
                                                            name="jenis_kasus" value="3">
                                                        <label class="form-check-label"
                                                            for="kesusilaan">Kesusilaan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kdrt"
                                                            name="jenis_kasus" value="4">
                                                        <label class="form-check-label" for="kdrt">KDRT</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="keracunan"
                                                            name="jenis_kasus" value="5">
                                                        <label class="form-check-label" for="keracunan">Keracunan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kasus_lainnya"
                                                            name="jenis_kasus" value="99">
                                                        <label class="form-check-label"
                                                            for="kasus_lainnya">Lainnya</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">2. Identitas Penyidik</h5>


                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nomor</label>
                                            <input type="text" class="form-control" name="nomor_penyidik">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nama</label>
                                            <input type="text" class="form-control" name="nama_penyidik">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">NRP</label>
                                            <input type="text" class="form-control" name="nrp_penyidik">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal</label>
                                            <input type="date" class="form-control" name="tgl_penyidik">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Instansi</label>
                                            <input type="text" class="form-control" name="instansi_penyidik">
                                        </div>

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Pemeriksaan Dokter Forensik Klinik</h5>

                                        <!-- Pemeriksaan -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemeriksaan</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="pemeriksaan_umum"
                                                        name="pemeriksaan[]" value="pemeriksaan_umum">
                                                    <label class="form-check-label"
                                                        for="pemeriksaan_umum">Pemeriksaan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="sampel_darah"
                                                        name="pemeriksaan[]" value="sampel_darah">
                                                    <label class="form-check-label" for="sampel_darah">Pemeriksaan
                                                        sampel
                                                        darah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="barang_bukti"
                                                        name="pemeriksaan[]" value="barang_bukti">
                                                    <label class="form-check-label"
                                                        for="barang_bukti">Pemeriksaan/Pemaketan
                                                        Barang Bukti</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="toksikologi"
                                                        name="pemeriksaan[]" value="toksikologi">
                                                    <label class="form-check-label" for="toksikologi">Pemeriksaan
                                                        toksikologi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="molekuler"
                                                        name="pemeriksaan[]" value="molekuler">
                                                    <label class="form-check-label" for="molekuler">Pemeriksaan
                                                        molekuler</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="foto_rontgen"
                                                        name="pemeriksaan[]" value="foto_rontgen">
                                                    <label class="form-check-label" for="foto_rontgen">Foto
                                                        rontgent</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="ct_scan"
                                                        name="pemeriksaan[]" value="ct_scan">
                                                    <label class="form-check-label" for="ct_scan">Pemeriksaan
                                                        CT-Scan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="pemeriksaan_lainnya" name="pemeriksaan[]" value="lainnya">
                                                    <label class="form-check-label"
                                                        for="pemeriksaan_lainnya">Lainnya</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Anamnesis -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anamnesis</label>
                                            <textarea class="form-control" name="anamnesis"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat kesadaran</label>
                                            <input type="text" class="form-control" name="kesadaran">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Denyut nadi</label>
                                            <input type="number" class="form-control" name="nadi">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pernafasan</label>
                                            <input type="number" class="form-control" name="nafas">
                                        </div>

                                        <div class="form-group align-items-center">
                                            <label style="min-width: 200px;">Tekanan darah</label>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <label for="sistole" class="form-label">Sistole</label>
                                                    <input type="number" class="form-control" name="sistole"
                                                        id="sistole">
                                                </div>
                                                <div class="">
                                                    <label for="diastole" class="form-label">Diastole</label>
                                                    <input type="number" class="form-control" name="diastole"
                                                        id="diastole">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suhu badan</label>
                                            <input type="text" class="form-control" name="suhu">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemeriksaan lain-lain</label>
                                            <textarea class="form-control" name="pemeriksaan_lain"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Kelainan Kelainan Fisik</h5>

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

                                    <!-- Penatalaksanaan -->
                                    <div class="section-separator">
                                        <h5 class="section-title">F. Penatalaksanaan</h5>

                                        <div class="form-group">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="visum"
                                                        name="penatalaksanaan[]" value="visum">
                                                    <label class="form-check-label" for="visum">Pembuatan Visum et
                                                        repertum</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="surat_medik"
                                                        name="penatalaksanaan[]" value="surat_medik">
                                                    <label class="form-check-label" for="surat_medik">Pembuatan surat
                                                        keterangan medik</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="surat_asuransi"
                                                        name="penatalaksanaan[]" value="surat_asuransi">
                                                    <label class="form-check-label" for="surat_asuransi">Pembuatan
                                                        surat
                                                        keterangan asuransi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="toksikologi_penata" name="penatalaksanaan[]"
                                                        value="toksikologi">
                                                    <label class="form-check-label" for="toksikologi_penata">Pemeriksaan
                                                        Toksikologi</label>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="penatalaksanaan_lainnya" name="penatalaksanaan[]"
                                                            value="lainnya">
                                                        <label class="form-check-label"
                                                            for="penatalaksanaan_lainnya">Pemeriksaan Lainnya:</label>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        name="penatalaksanaan_lainnya">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keadaan Pulang -->
                                    <div class="section-separator">
                                        <h5 class="section-title">G. Keadaan Pulang</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosos Ahli Forensik</label>
                                            <input type="text" class="form-control" name="diagnosos">
                                        </div>

                                        <div class="form-group mt-3">
                                            <label style="min-width: 200px;">Dibawa oleh:</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="dibawa_keluarga"
                                                        name="dibawa_oleh" value="1">
                                                    <label class="form-check-label" for="dibawa_keluarga">Keluarga</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="dibawa_kepolisian"
                                                        name="dibawa_oleh" value="2">
                                                    <label class="form-check-label"
                                                        for="dibawa_kepolisian">Kepolisian</label>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            id="dibawa_lainnya" name="dibawa_oleh" value="99">
                                                        <label class="form-check-label"
                                                            for="dibawa_lainnya">Lain-lain:</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal</label>
                                            <input type="date" class="form-control" name="tgl_pulang">
                                        </div>

                                    </div>

                                    <div class="text-end">
                                        <x-button-submit />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </x-content-card>
        </div>
    </div>
@endsection
