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

    @include('unit-pelayanan.forensik.pelayanan.pemeriksaan-patologi.include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <h4 class="header-asesmen">Pemeriksaan Forensik Patologi</h4>
                        </div>

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
                                                    name="cara_datang" value="1" @checked($pemeriksaan->cara_datang == '1') disabled>
                                                <label class="form-check-label" for="sendiri">Sendiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="diantar_keluarga"
                                                    name="cara_datang" value="2" @checked($pemeriksaan->cara_datang == '2') disabled>
                                                <label class="form-check-label" for="diantar_keluarga">Diantar
                                                    keluarga</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="ambulance"
                                                    name="cara_datang" value="3" @checked($pemeriksaan->cara_datang == '3') disabled>
                                                <label class="form-check-label" for="ambulance">Ambulance</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="polisi"
                                                    name="cara_datang" value="4" @checked($pemeriksaan->cara_datang == '4') disabled>
                                                <label class="form-check-label" for="polisi">Polisi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="pmi"
                                                    name="cara_datang" value="5" @checked($pemeriksaan->cara_datang == '5') disabled>
                                                <label class="form-check-label" for="pmi">PMI</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="lainnya"
                                                    name="cara_datang" value="99" @checked($pemeriksaan->cara_datang == '99') disabled>
                                                <label class="form-check-label" for="lainnya">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tgl Meninggal</label>
                                        <input type="date" name="tgl_meninggal" id="tgl_meninggal" class="form-control" value="{{ date('Y-m-d', strtotime($pemeriksaan->tgl_meninggal)) }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tgl Diperiksa</label>
                                        <input type="date" name="tgl_pemeriksaan" id="tgl_pemeriksaan" class="form-control" value="{{ date('Y-m-d', strtotime($pemeriksaan->tgl_pemeriksaan)) }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jam Pemeriksaan Awal</label>
                                        <input type="time" name="jam_pemeriksaan" id="jam_pemeriksaan" class="form-control" value="{{ date('H:i', strtotime($pemeriksaan->jam_pemeriksaan)) }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jam Pemeriksaan Akhir</label>
                                        <input type="time" name="jam_pemeriksaan_akhir" id="jam_pemeriksaan_akhir" class="form-control" value="{{ date('H:i', strtotime($pemeriksaan->jam_pemeriksaan_akhir)) }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosis Meninggal</label>
                                        <input type="text" name="diagnosis_meninggal" id="diagnosis_meninggal" class="form-control" value="{{ $pemeriksaan->diagnosis_meninggal }}" disabled>
                                    </div>

                                    <!-- Asal Rujukan -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Asal Rujukan</label>
                                        <input type="text" name="asal_rujukan" id="asal_rujukan" class="form-control" value="{{ $pemeriksaan->asal_rujukan }}" disabled>
                                    </div>

                                    <!-- Jenis Kasus -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Kasus</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="trauma"
                                                        name="jenis_kasus_patologi[]" value="trauma" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('trauma', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="trauma">Trauma</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="non_trauma"
                                                        name="jenis_kasus_patologi[]" value="non_trauma" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('non_trauma', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="non_trauma">Non Trauma</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="penyakit"
                                                        name="jenis_kasus_patologi[]" value="penyakit" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('penyakit', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="penyakit">Penyakit</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="abortus"
                                                        name="jenis_kasus_patologi[]" value="abortus" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('abortus', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="abortus">Abortus</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="kematian_mendadak"
                                                        name="jenis_kasus_patologi[]" value="kematian_mendadak" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('kematian_mendadak', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="kematian_mendadak">Kematian Mendadak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="kesusilaan"
                                                        name="jenis_kasus_patologi[]" value="kesusilaan" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('kesusilaan', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="kesusilaan">Kesusilaan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="asfiksia"
                                                        name="jenis_kasus_patologi[]" value="asfiksia" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('asfiksia', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="asfiksia">Asfiksia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="keracunan"
                                                        name="jenis_kasus_patologi[]" value="keracunan" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('keracunan', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="keracunan">Keracunan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="kasus_lainnya" name="jenis_kasus_patologi[]" value="lainnya" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('lainnya', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label"
                                                        for="kasus_lainnya">Lainnya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="doa"
                                                        name="jenis_kasus_patologi[]" value="doa" @checked(is_array($pemeriksaan->jenis_kasus_patologi) && in_array('doa', $pemeriksaan->jenis_kasus_patologi)) disabled>
                                                    <label class="form-check-label" for="doa">Death On Arrival (DOA)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">2. Identitas Penyidik</h5>


                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nomor</label>
                                        <input type="text" class="form-control" name="nomor_penyidik" value="{{ $pemeriksaan->nomor_penyidik }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama</label>
                                        <input type="text" class="form-control" name="nama_penyidik" value="{{ $pemeriksaan->nama_penyidik }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">NRP</label>
                                        <input type="text" class="form-control" name="nrp_penyidik" value="{{ $pemeriksaan->nrp_penyidik }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tgl_penyidik" value="{{ date('Y-m-d', strtotime($pemeriksaan->tgl_penyidik)) }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Instansi</label>
                                        <input type="text" class="form-control" name="instansi_penyidik" value="{{ $pemeriksaan->instansi_penyidik }}" disabled>
                                    </div>

                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">3. Pemeriksaan Dokter Forensik Klinik</h5>

                                    <!-- Pemeriksaan -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pemeriksaan</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="pemeriksaan_luar"
                                                    name="pemeriksaan[]" value="luar" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('luar', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="pemeriksaan_luar">Pemeriksaan Luar</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="pemeriksaan_dalam"
                                                    name="pemeriksaan[]" value="dalam" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('dalam', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="pemeriksaan_dalam">Pemeriksaan Dalam</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="identifikasi"
                                                    name="pemeriksaan[]" value="identifikasi" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('identifikasi', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="identifikasi">Pemeriksaan Identifikasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="darah"
                                                    name="pemeriksaan[]" value="darah" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('darah', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="darah">Pemeriksaan Sampel Darah</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="urine"
                                                    name="pemeriksaan[]" value="urine" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('urine', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="urine">Pemeriksaan Sampel Urine</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="organ"
                                                    name="pemeriksaan[]" value="organ" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('organ', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="organ">Pemeriksaan Sampel Organ</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="barang_bukti"
                                                    name="pemeriksaan[]" value="barang_bukti" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('barang_bukti', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="barang_bukti">Pemeriksaan/Pemaketan Barang Bukti</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="toksinologi"
                                                    name="pemeriksaan[]" value="toksinologi" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('toksinologi', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="toksinologi">Pemeriksaan Toksikologi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="serologi"
                                                    name="pemeriksaan[]" value="serologi" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('serologi', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="serologi">Pemeriksaan Serologi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="molekuler"
                                                    name="pemeriksaan[]" value="molekuler" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('molekuler', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="molekuler">Pemeriksaan Molekuler</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="kerangka"
                                                    name="pemeriksaan[]" value="kerangka" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('kerangka', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="kerangka">Pemeriksaan Kerangka</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="pemeriksaan_lainnya"
                                                    name="pemeriksaan[]" value="lainnya" @checked(is_array($pemeriksaan->pemeriksaan) && in_array('lainnya', $pemeriksaan->pemeriksaan)) disabled>
                                                <label class="form-check-label" for="pemeriksaan_lainnya">Pemeriksaan Lainnya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- C. Pemeriksaan Umum -->
                                <div class="section-separator">
                                    <h5 class="section-title">4. Pemeriksaan Umum</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Label Jenazah</label>
                                        <input type="text" class="form-control" name="label_jenazah" value="{{ $pemeriksaan->label_jenazah }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penutup Jenazah</label>
                                        <input type="text" class="form-control" name="penutup_jenazah" value="{{ $pemeriksaan->penutup_jenazah }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pembungkus Jenazah</label>
                                        <input type="text" class="form-control" name="pembungkus_jenazah" value="{{ $pemeriksaan->pembungkus_jenazah }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pakaian Jenazah</label>
                                        <input type="text" class="form-control" name="pakaian_jenazah" value="{{ $pemeriksaan->pakaian_jenazah }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perhiasan Jenazah</label>
                                        <input type="text" class="form-control" name="perhiasan_jenazah" value="{{ $pemeriksaan->perhiasan_jenazah }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Benda Disamping Jenazah</label>
                                        <input type="text" class="form-control" name="benda_disamping_jenazah" value="{{ $pemeriksaan->benda_disamping_jenazah }}" disabled>
                                    </div>
                                </div>

                                <!-- D. Pemeriksaan Identitas -->
                                <div class="section-separator">
                                    <h5 class="section-title">5. Pemeriksaan Identitas</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Identitas Umum</label>
                                        <input type="text" class="form-control" name="identitas_umum" value="{{ $pemeriksaan->identitas_umum }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Identitas Khusus</label>
                                        <input type="text" class="form-control" name="identitas_khusus" value="{{ $pemeriksaan->identitas_khusus }}" disabled>
                                    </div>
                                </div>

                                <!-- E. Pemeriksaan Tanatologi -->
                                <div class="section-separator">
                                    <h5 class="section-title">6. Pemeriksaan Tanatologi</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lebam Mayat</label>
                                        <input type="text" class="form-control" name="lebam_mayat" value="{{ $pemeriksaan->lebam_mayat }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kaku Mayat</label>
                                        <input type="text" class="form-control" name="kaku_mayat" value="{{ $pemeriksaan->kaku_mayat }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penurunan Suhu</label>
                                        <input type="text" class="form-control" name="penurunan_suhu" value="{{ $pemeriksaan->penurunan_suhu }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pembusukan</label>
                                        <input type="text" class="form-control" name="pembusukan" value="{{ $pemeriksaan->pembusukan }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perkiraan Lama Kematian</label>
                                        <input type="text" class="form-control" name="lama_kematian" value="{{ $pemeriksaan->lama_kematian }}" disabled>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">7. Kelainan Kelainan Fisik</h5>

                                    <div class="alert alert-info mb-3">
                                        <p class="mb-0 small">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk menambah
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
                                                            $pemeriksaanData = $pemeriksaan->fisik->where('id_item_fisik', $item->id)->first();
                                                            $keterangan = '';
                                                            $isNormal = true;

                                                            if (!empty($pemeriksaanData)) {
                                                            $keterangan = $pemeriksaanData->keterangan;
                                                            $isNormal = $pemeriksaanData->is_normal;
                                                            }
                                                        @endphp

                                                        <div class="pemeriksaan-item">
                                                            <div
                                                                class="d-flex align-items-center border-bottom pb-2">
                                                                <div class="flex-grow-1">{{ $item->nama }}
                                                                </div>
                                                                <div class="form-check me-3">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="{{ $item->id }}-normal"
                                                                        name="{{ $item->id }}-normal" @checked($isNormal) disabled>
                                                                    <label class="form-check-label"
                                                                        for="{{ $item->id }}-normal">Normal</label>
                                                                </div>
                                                                <button
                                                                    class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                    type="button"
                                                                    data-target="{{ $item->id }}-keterangan" disabled>
                                                                    <i class="bi bi-plus"></i>
                                                                </button>
                                                            </div>
                                                            <div class="keterangan mt-2"
                                                                id="{{ $item->id }}-keterangan"
                                                                style="display:{{ $isNormal ? 'none' : 'block' }};">
                                                                <input type="text" class="form-control"
                                                                    name="{{ $item->id }}_keterangan"
                                                                    placeholder="Tambah keterangan jika tidak normal..." value="{{ $keterangan }}" disabled>
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
                                    <h5 class="section-title">8. Penatalaksanaan</h5>

                                    <div class="form-group">
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="autopsi"
                                                    name="penatalaksanaan[]" value="autopsi" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('autopsi', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="autopsi">Autopsi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="tkp"
                                                    name="penatalaksanaan[]" value="tkp" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('tkp', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="tkp">Pemeriksaan di TKP</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="kuburan"
                                                    name="penatalaksanaan[]" value="kuburan" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('kuburan', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="kuburan">Penggalian Kuburan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="visum"
                                                    name="penatalaksanaan[]" value="visum" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('visum', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="visum">Pembuatan Visum Et Repertum</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="sk_medis"
                                                    name="penatalaksanaan[]" value="sk_medis" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('sk_medis', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="sk_medis">Pembuatan Surat Keterangan Medis</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="sk_kematian"
                                                    name="penatalaksanaan[]" value="sk_kematian" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('sk_kematian', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="sk_kematian">Pembuatan Surat Kematian</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="embalming"
                                                    name="penatalaksanaan[]" value="embalming" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('embalming', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="embalming">Pembuatan Surat Embalming</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="bukti"
                                                    name="penatalaksanaan[]" value="bukti" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('bukti', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="bukti">Pemaketan Barang Bukti</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="asuransi"
                                                    name="penatalaksanaan[]" value="asuransi" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('asuransi', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="asuransi">Pembuatan Surat Keterangan Asuransi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="kerangka"
                                                    name="penatalaksanaan[]" value="kerangka" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('kerangka', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="kerangka">Pemeriksaan Indentifikasi Kerangka</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="toksikologi_penatalaksanaan"
                                                    name="penatalaksanaan[]" value="toksikologi" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('toksikologi', $pemeriksaan->penatalaksanaan)) disabled>
                                                <label class="form-check-label" for="toksikologi_penatalaksanaan">Pemeriksaan Toksikologi</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="penatalaksanaan_lainnya" name="penatalaksanaan[]"
                                                        value="lainnya" @checked(is_array($pemeriksaan->penatalaksanaan) && in_array('lainnya', $pemeriksaan->penatalaksanaan)) disabled>
                                                    <label class="form-check-label"
                                                        for="penatalaksanaan_lainnya">Pemeriksaan Lainnya:</label>
                                                </div>
                                                <input type="text" class="form-control"
                                                    name="penatalaksanaan_lainnya" style="width: 300px;" value="{{ $pemeriksaan->penatalaksanaan_lainnya }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keadaan Pulang -->
                                <div class="section-separator">
                                    <h5 class="section-title">9. Keadaan Pulang</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosos Ahli Forensik</label>
                                        <input type="text" class="form-control" name="diagnosos" value="{{ $pemeriksaan->diagnosos }}" disabled>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label style="min-width: 200px;">Dibawa oleh:</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="dibawa_keluarga"
                                                    name="dibawa_oleh" value="1" @checked($pemeriksaan->dibawa_oleh == '1') disabled>
                                                <label class="form-check-label" for="dibawa_keluarga">Keluarga</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="dibawa_kepolisian"
                                                    name="dibawa_oleh" value="2" @checked($pemeriksaan->dibawa_oleh == '2') disabled>
                                                <label class="form-check-label" for="dibawa_kepolisian">Kepolisian</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="dibawa_lainnya"
                                                        name="dibawa_oleh" value="99" @checked($pemeriksaan->dibawa_oleh == '99') disabled>
                                                    <label class="form-check-label"
                                                        for="dibawa_lainnya">Lain-lain:</label>
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
    </div>
@endsection