@extends('layouts.administrator.master')

@section('content')

    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form method="POST" enctype="multipart/form-data" action="{{ route('rawat-inap.asesmen.medis.medis-anak.update', [
                'kd_unit' => request()->route('kd_unit'),
                'kd_pasien' => request()->route('kd_pasien'),
                'tgl_masuk' => request()->route('tgl_masuk'),
                'urut_masuk' => request()->route('urut_masuk'),
                'id' => $asesmen->id
            ]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="card">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <h4 class="header-asesmen"><span class="text-warning">Edit</span> Asesmen Pengkajian Awal Medis Pasien Anak</h4>
                                    <p class="text-muted">
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- FORM ASESMEN -->
                        <div class="px-3">
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal"
                                        value="{{ $asesmen->tanggal ? date('Y-m-d', strtotime($asesmen->tanggal)) : date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk"
                                        value="{{ $asesmen->jam_masuk ? \Carbon\Carbon::parse($asesmen->jam_masuk)->format('H:i') : date('H:i') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator" id="">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Anamnesis</label>
                                    <textarea class="form-control" name="anamnesis" rows="3" placeholder="Anamnesis">{{ $asesmen->anamnesis ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Keluhan Utama</label>
                                    <textarea class="form-control" name="keluhan_utama" rows="3"
                                        placeholder="Keluhan utama pasien">{{ $asesmen->keluhan_utama ?? '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat penyakit terdahulu</label>
                                    <textarea class="form-control" name="riwayat_penyakit_terdahulu" rows="4"
                                        placeholder="Riwayat penyakit terdahulu">{{ $asesmen->riwayat_penyakit_terdahulu ?? '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat penyakit dalam keluarga</label>
                                    <textarea class="form-control" name="riwayat_penyakit_keluarga" rows="4"
                                        placeholder="Riwayat penyakit dalam keluarga">{{ $asesmen->riwayat_penyakit_keluarga ?? '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Keadaan umum</label>
                                    <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4"
                                        placeholder="Riwayat penyakit sekarang">{{ $asesmen->riwayat_penyakit_sekarang ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="section-separator" id="riwayatObat">
                                <h5 class="section-title">3. Riwayat Penggunaan Obat</h5>

                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openObatModal">
                                    <i class="ti-plus"></i> Tambah
                                </button>

                                <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData"
                                    value="{{ old('riwayat_penggunaan_obat', isset($asesmen) && $asesmen->riwayat_penggunaan_obat ? (is_array($asesmen->riwayat_penggunaan_obat) ? json_encode($asesmen->riwayat_penggunaan_obat) : $asesmen->riwayat_penggunaan_obat) : '[]') }}">

                                <div class="table-responsive">
                                    <table class="table" id="createRiwayatObatTable">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Dosis</th>
                                                <th>Aturan Pakai</th>
                                                @if(!($readonly ?? false))
                                                <th></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table content will be dynamically populated -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @push('modals')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.modal-create-obat')
                            @endpush

                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">4. Alergi</h5>
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                    id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
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
                                                <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.modal-create-alergi')
                                @endpush
                            </div>


                            <div class="section-separator" id="riwayat-pengobatan">
                                <h5 class="section-title">5. Status present</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran</label>
                                    <select class="form-select" name="kesadaran">
                                        <option value="" {{ old('kesadaran', $asesmen->kesadaran ?? '') === '' ? 'selected' : '' }} disabled>--Pilih--</option>
                                        <option value="Compos Mentis" {{ old('kesadaran', $asesmen->kesadaran ?? '') === 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis</option>
                                        <option value="Apatis" {{ old('kesadaran', $asesmen->kesadaran ?? '') === 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                        <option value="Sopor" {{ old('kesadaran', $asesmen->kesadaran ?? '') === 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                        <option value="Coma" {{ old('kesadaran', $asesmen->kesadaran ?? '') === 'Coma' ? 'selected' : '' }}>Coma</option>
                                        <option value="Somnolen" {{ old('kesadaran', $asesmen->kesadaran ?? '') === 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">GCS</label>
                                    <div class="input-group">
                                        @php
                                            // Ambil data GCS dari database
                                            $gcsValue = '';
                                            if (isset($asesmen) && $asesmen) {
                                                // Periksa apakah vital_sign sudah array atau masih string JSON
                                                $vitalSigns = is_array($asesmen->vital_sign)
                                                    ? $asesmen->vital_sign
                                                    : (is_string($asesmen->vital_sign) ? json_decode($asesmen->vital_sign, true) : []);
                                                $gcsValue = $vitalSigns['gcs'] ?? '';
                                            }
                                        @endphp

                                        <input type="text" class="form-control" name="vital_sign[gcs]" id="gcsInput"
                                            value="{{ old('vital_sign.gcs', $gcsValue) }}"
                                            placeholder="Contoh: 15 E4 V5 M6" readonly>

                                        <button type="button" class="btn btn-outline-primary"
                                            onclick="openGCSModal()" title="Buka Kalkulator GCS">
                                            <i class="ti-calculator"></i> Hitung GCS
                                        </button>
                                    </div>
                                </div>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.edit-gcs-modal')
                                @endpush

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">

                                        <div class="flex-grow-1">
                                            <label class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="sistole"
                                                placeholder="Sistole" value="{{ $asesmen->sistole ?? '' }}">
                                        </div>

                                        <div class="flex-grow-1">
                                            <label class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="diastole"
                                                placeholder="Diastole" value="{{ $asesmen->diastole ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (x/menit)</label>
                                    <input type="number" class="form-control" name="nadi"
                                        placeholder="Nadi" value="{{ $asesmen->nadi ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Suhu (C)</label>
                                    <input type="text" class="form-control" name="suhu"
                                        placeholder="Suhu" value="{{ $asesmen->suhu ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">RR (x/menit)</label>
                                    <input type="number" class="form-control" name="rr"
                                        placeholder="rr" value="{{ $asesmen->rr ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Berat Badan Kg</label>
                                    <input type="number" class="form-control" name="berat_badan"
                                        placeholder="Berat Badan" value="{{ $asesmen->berat_badan ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Tinggi Badan Cm</label>
                                    <input type="number" class="form-control" name="tinggi_badan"
                                        placeholder="Tinggi Badan" value="{{ $asesmen->tinggi_badan ?? '' }}">
                                </div>

                            </div>

                            <!-- 6. Pemeriksaan Fisik -->
                        <div class="section-separator" id="pemeriksaan-fisik">
                            <h5 class="section-title">6. Pemeriksaan Fisik</h5>
                            <div class="card-body">
                                @php
                                    // Ambil data asesmen fisik
                                    $fisik = $asesmen->asesmenMedisAnakFisik ?? new \App\Models\RmeAsesmenMedisAnakFisik();

                                    // Parse JSON untuk field kulit dan kuku
                                    $kulit = $fisik->kulit ?? [];
                                    $kuku = $fisik->kuku ?? [];
                                @endphp

                                <!-- 1. Kepala -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">1. Kepala</h6>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">a. Bentuk:</label>
                                        <input type="text" class="form-control" name="kepala_bentuk" placeholder="Isi keterangan bentuk"
                                            value="{{ old('kepala_bentuk', $fisik->kepala_bentuk ?? '') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">b. UUB:</label>
                                        <input type="text" class="form-control" name="kepala_uub" placeholder="Isi keterangan UUB"
                                            value="{{ old('kepala_uub', $fisik->kepala_uub ?? '') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">c. Rambut:</label>
                                        <input type="text" class="form-control" name="kepala_rambut" placeholder="Isi keterangan rambut"
                                            value="{{ old('kepala_rambut', $fisik->kepala_rambut ?? '') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">d. Lain-lain:</label>
                                        <input type="text" class="form-control" name="kepala_lain" placeholder="Isi keterangan lain-lain"
                                            value="{{ old('kepala_lain', $fisik->kepala_lain ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 2. Mata -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">2. Mata</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kondisi mata:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="mata_pucat" id="mata_pucat" value="1"
                                                    {{ old('mata_pucat', $fisik->mata_pucat ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mata_pucat">Pucat</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="mata_ikterik" id="mata_ikterik" value="1"
                                                {{ old('mata_ikterik', $fisik->mata_ikterik ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mata_ikterik">Ikterik</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pupil:</label>
                                        <select class="form-select" name="pupil_isokor">
                                            <option value="" {{ old('pupil_isokor', $fisik->pupil_isokor ?? '') === '' ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="Isokor" {{ old('pupil_isokor', $fisik->pupil_isokor ?? '') === 'Isokor' ? 'selected' : '' }}>Isokor</option>
                                            <option value="Anisokor" {{ old('pupil_isokor', $fisik->pupil_isokor ?? '') === 'Anisokor' ? 'selected' : '' }}>Anisokor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Refleks Cahaya:</label>
                                        <input type="text" class="form-control" name="refleks_cahaya" placeholder="( ... / ... )"
                                            value="{{ old('refleks_cahaya', $fisik->refleks_cahaya ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Refleks Kornea:</label>
                                        <input type="text" class="form-control" name="refleks_kornea" placeholder="( ... / ... )"
                                            value="{{ old('refleks_kornea', $fisik->refleks_kornea ?? '') }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Lain-lain:</label>
                                        <input type="text" class="form-control" name="mata_lain" placeholder="Isi keterangan lain-lain mata"
                                            value="{{ old('mata_lain', $fisik->mata_lain ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 3. Hidung -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">3. Hidung</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nafas cuping hidung:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="nafas_cuping" id="nafas_cuping_ya" value="ya"
                                                    {{ old('nafas_cuping', $fisik->nafas_cuping ? 'ya' : 'tidak') === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nafas_cuping_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="nafas_cuping" id="nafas_cuping_tidak" value="tidak"
                                                    {{ old('nafas_cuping', $fisik->nafas_cuping ? 'ya' : 'tidak') === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nafas_cuping_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Lain-lain:</label>
                                        <input type="text" class="form-control" name="hidung_lain" placeholder="Isi keterangan lain-lain hidung"
                                            value="{{ old('hidung_lain', $fisik->hidung_lain ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 4. Telinga -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">4. Telinga</h6>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="telinga_cairan" id="telinga_cairan_ya" value="ya"
                                                {{ old('telinga_cairan', $fisik->telinga_cairan ? 'ya' : 'tidak') === 'ya' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="telinga_cairan_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="telinga_cairan" id="telinga_cairan_tidak" value="tidak"
                                                {{ old('telinga_cairan', $fisik->telinga_cairan ? 'ya' : 'tidak') === 'tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="telinga_cairan_tidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Lain-lain:</label>
                                        <input type="text" class="form-control" name="telinga_lain" placeholder="Isi keterangan lain-lain telinga"
                                            value="{{ old('telinga_lain', $fisik->telinga_lain ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 5. Mulut -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">5. Mulut</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bibir/lidah sianosis:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mulut_sianosis" id="mulut_sianosis_ya" value="ya"
                                                    {{ old('mulut_sianosis', $fisik->mulut_sianosis ? 'ya' : 'tidak') === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mulut_sianosis_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mulut_sianosis" id="mulut_sianosis_tidak" value="tidak"
                                                    {{ old('mulut_sianosis', $fisik->mulut_sianosis ? 'ya' : 'tidak') === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mulut_sianosis_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Lidah:</label>
                                        <input type="text" class="form-control" name="mulut_lidah" placeholder="Isi keterangan lidah"
                                            value="{{ old('mulut_lidah', $fisik->mulut_lidah ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tenggorokan:</label>
                                        <input type="text" class="form-control" name="mulut_tenggorokan" placeholder="Isi keterangan tenggorokan"
                                            value="{{ old('mulut_tenggorokan', $fisik->mulut_tenggorokan ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Lain-lain:</label>
                                        <input type="text" class="form-control" name="mulut_lain" placeholder="Isi keterangan lain-lain mulut"
                                            value="{{ old('mulut_lain', $fisik->mulut_lain ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 6. Leher -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">6. Leher</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pembesaran Kelenjar Getah Bening:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="leher_kelenjar" id="leher_kelenjar_ya" value="ya"
                                                    {{ old('leher_kelenjar', $fisik->leher_kelenjar ? 'ya' : 'tidak') === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="leher_kelenjar_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="leher_kelenjar" id="leher_kelenjar_tidak" value="tidak"
                                                    {{ old('leher_kelenjar', $fisik->leher_kelenjar ? 'ya' : 'tidak') === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="leher_kelenjar_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Peningkatan Tekanan Vena Jugular:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="leher_vena" id="leher_vena_ya" value="ya"
                                                    {{ old('leher_vena', $fisik->leher_vena ? 'ya' : 'tidak') === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="leher_vena_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="leher_vena" id="leher_vena_tidak" value="tidak"
                                                    {{ old('leher_vena', $fisik->leher_vena ? 'ya' : 'tidak') === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="leher_vena_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Lain-lain:</label>
                                        <input type="text" class="form-control" name="leher_lain" placeholder="Isi keterangan lain-lain leher"
                                            value="{{ old('leher_lain', $fisik->leher_lain ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 7. Thoraks -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">7. Thoraks</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">a. Bentuk:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="thoraks_bentuk[]" id="thoraks_simetris" value="simetris"
                                                    {{ old('thoraks_simetris', $fisik->thoraks_simetris ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="thoraks_simetris">Simetris</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="thoraks_bentuk[]" id="thoraks_asimetris" value="asimetris"
                                                    {{ old('thoraks_asimetris', $fisik->thoraks_asimetris ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="thoraks_asimetris">Asimetris</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">c. Paru - Retraksi:</label>
                                        <input type="text" class="form-control" name="thoraks_retraksi" placeholder="Isi keterangan retraksi"
                                            value="{{ old('thoraks_retraksi', $fisik->thoraks_retraksi ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">b. Jantung - HR:</label>
                                        <input type="text" class="form-control" name="thoraks_hr" placeholder="Heart Rate"
                                            value="{{ old('thoraks_hr', $fisik->thoraks_hr ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Merintih:</label>
                                        <input type="text" class="form-control" name="thoraks_merintih" placeholder="Isi keterangan merintih"
                                            value="{{ old('thoraks_merintih', $fisik->thoraks_merintih ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bunyi jantung:</label>
                                        <input type="text" class="form-control" name="thoraks_bunyi_jantung" placeholder="Bunyi jantung"
                                            value="{{ old('thoraks_bunyi_jantung', $fisik->thoraks_bunyi_jantung ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">RR:</label>
                                        <input type="text" class="form-control" name="thoraks_rr" placeholder="Respiratory Rate"
                                            value="{{ old('thoraks_rr', $fisik->thoraks_rr ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Murmur:</label>
                                        <input type="text" class="form-control" name="thoraks_murmur" placeholder="Isi keterangan murmur"
                                            value="{{ old('thoraks_murmur', $fisik->thoraks_murmur ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Suara pernafasan:</label>
                                        <input type="text" class="form-control" name="thoraks_suara_nafas" placeholder="Suara pernafasan"
                                            value="{{ old('thoraks_suara_nafas', $fisik->thoraks_suara_nafas ?? '') }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Suara nafas tambahan:</label>
                                        <input type="text" class="form-control" name="thoraks_suara_tambahan" placeholder="Suara nafas tambahan"
                                            value="{{ old('thoraks_suara_tambahan', $fisik->thoraks_suara_tambahan ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 8. Abdomen -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">8. Abdomen</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">a. Distensi:</label>
                                        <input type="text" class="form-control" name="abdomen_distensi" placeholder="Isi keterangan distensi"
                                            value="{{ old('abdomen_distensi', $fisik->abdomen_distensi ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">b. Bising usus:</label>
                                        <input type="text" class="form-control" name="abdomen_bising_usus" placeholder="Isi keterangan bising usus"
                                            value="{{ old('abdomen_bising_usus', $fisik->abdomen_bising_usus ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">c. Venekasi:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="abdomen_venekasi" id="abdomen_venekasi_ya" value="ya"
                                                    {{ old('abdomen_venekasi', $fisik->abdomen_venekasi ? 'ya' : 'tidak') === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="abdomen_venekasi_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="abdomen_venekasi" id="abdomen_venekasi_tidak" value="tidak"
                                                    {{ old('abdomen_venekasi', $fisik->abdomen_venekasi ? 'ya' : 'tidak') === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="abdomen_venekasi_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">d. Hepar:</label>
                                        <input type="text" class="form-control" name="abdomen_hepar" placeholder="Hepar"
                                            value="{{ old('abdomen_hepar', $fisik->abdomen_hepar ?? '') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Lien:</label>
                                        <input type="text" class="form-control" name="abdomen_lien" placeholder="Lien"
                                            value="{{ old('abdomen_lien', $fisik->abdomen_lien ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 9. Genetalia -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">9. Genetalia</h6>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="genetalia" id="genetalia_laki" value="laki-laki"
                                                    {{ old('genetalia', $fisik->genetalia ?? '') === 'laki-laki' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="genetalia_laki">Laki-laki</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="genetalia" id="genetalia_perempuan" value="perempuan"
                                                    {{ old('genetalia', $fisik->genetalia ?? '') === 'perempuan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="genetalia_perempuan">Perempuan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="genetalia" id="genetalia_ambigus" value="ambigus"
                                                    {{ old('genetalia', $fisik->genetalia ?? '') === 'ambigus' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="genetalia_ambigus">Ambigus</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- 10. Anus -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">10. Anus</h6>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" name="anus_keterangan" placeholder="Isi keterangan anus"
                                            value="{{ old('anus_keterangan', $fisik->anus_keterangan ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 11. Ekstremitas -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">11. Ekstremitas</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Waktu pengisian Kapiler:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kapiler" id="kapiler_2" value="< 2"
                                                    {{ old('kapiler', $fisik->kapiler ?? '') === '< 2' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kapiler_2">< 2"</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kapiler" id="kapiler_lebih2" value=">2"
                                                    {{ old('kapiler', $fisik->kapiler ?? '') === '>2' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kapiler_lebih2">>2"</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Refleks:</label>
                                        <input type="text" class="form-control" name="ekstremitas_refleks" placeholder="Isi keterangan refleks"
                                            value="{{ old('ekstremitas_refleks', $fisik->ekstremitas_refleks ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 12. Kulit -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">12. Kulit</h6>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kulit[]" id="kulit_pucat" value="pucat"
                                                    {{ in_array('pucat', (array) old('kulit', $kulit)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kulit_pucat">Pucat</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kulit[]" id="kulit_ptekie" value="ptekie"
                                                    {{ in_array('ptekie', (array) old('kulit', $kulit)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kulit_ptekie">Ptekie</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kulit[]" id="kulit_ekimosis" value="ekimosis"
                                                    {{ in_array('ekimosis', (array) old('kulit', $kulit)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kulit_ekimosis">Ekimosis</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kulit[]" id="kulit_ikterik" value="ikterik"
                                                    {{ in_array('ikterik', (array) old('kulit', $kulit)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kulit_ikterik">Ikterik</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kulit[]" id="kulit_mottled" value="mottled"
                                                    {{ in_array('mottled', (array) old('kulit', $kulit)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kulit_mottled">Mottled</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kulit[]" id="kulit_sklerema" value="sklerema"
                                                    {{ in_array('sklerema', (array) old('kulit', $kulit)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kulit_sklerema">Sklerema</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Lainnya:</label>
                                        <input type="text" class="form-control" name="kulit_lainnya" placeholder="Isi keterangan lainnya untuk kulit"
                                            value="{{ old('kulit_lainnya', $fisik->kulit_lainnya ?? '') }}">
                                    </div>
                                </div>

                                <hr>

                                <!-- 13. Kuku -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">13. Kuku</h6>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kuku[]" id="kuku_sianosis" value="sianosis"
                                                    {{ in_array('sianosis', (array) old('kuku', $kuku)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kuku_sianosis">Sianosis</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kuku[]" id="kuku_meconium" value="meconium stain"
                                                    {{ in_array('meconium stain', (array) old('kuku', $kuku)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kuku_meconium">Meconium stain</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kuku[]" id="kuku_panjang" value="panjang"
                                                    {{ in_array('panjang', (array) old('kuku', $kuku)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kuku_panjang">Panjang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Lainnya:</label>
                                        <input type="text" class="form-control" name="kuku_lainnya" placeholder="Isi keterangan lainnya untuk kuku"
                                            value="{{ old('kuku_lainnya', $fisik->kuku_lainnya ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="section-separator">
                                <h5 class="section-title">7. Pengkajian Khusus Pediatrik ( < 5 tahun)</h5>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <!-- Riwayat Prenatal -->
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">Riwayat prenatal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="row">
                                                            <!-- Lama Kehamilan -->
                                                            <div class="col-md-6 mb-3">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Lama kehamilan:</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="lama_kehamilan" placeholder="..."
                                                                            value="{{ old('lama_kehamilan', $asesmen->asesmenMedisAnakDtl->lama_kehamilan ?? '') }}">
                                                                            <span class="input-group-text">bln/mggu</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Komplikasi -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label mb-2">Komplikasi:</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="komplikasi" id="komplikasi_tidak" value="0"
                                                                    {{ old('komplikasi', $asesmen->asesmenMedisAnakDtl->komplikasi ?? '0') == '0' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="komplikasi_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check mt-1">
                                                                    <input class="form-check-input" type="radio" name="komplikasi" id="komplikasi_ya" value="1"
                                                                    {{ old('komplikasi', $asesmen->asesmenMedisAnakDtl->komplikasi ?? '0') == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="komplikasi_ya">Ya, tipe: PEB/ DM/ HT/ PP</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!-- Masalah Maternal -->
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label mb-2">Masalah maternal:</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="maternal" id="maternal_tidak" value="0"
                                                                    {{ old('maternal', $asesmen->asesmenMedisAnakDtl->maternal ?? '0') == '0' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="maternal_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check mt-1">
                                                                    <input class="form-check-input" type="radio" name="maternal" id="maternal_ya" value="1"
                                                                    {{ old('maternal', $asesmen->asesmenMedisAnakDtl->maternal ?? '0') == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="maternal_ya">Ya, sebutkan:</label>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <input type="text" class="form-control form-control-sm" name="maternal_keterangan" placeholder="Sebutkan masalah maternal..."
                                                                    value="{{ old('maternal_keterangan', $asesmen->asesmenMedisAnakDtl->maternal_keterangan ?? '') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <!-- Riwayat Natal -->
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">Riwayat Natal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="row">
                                                            <!-- Persalinan -->
                                                            <div class="col-md-4 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="persalinan" id="persalinan" value="1"
                                                                    {{ old('persalinan', $asesmen->asesmenMedisAnakDtl->persalinan ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="persalinan">Persalinan: PV/ SC/ FE/ VE</label>
                                                                </div>
                                                            </div>

                                                            <!-- Penyulit Persalinan -->
                                                            <div class="col-md-4 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="penyulit_persalinan" id="penyulit_persalinan" value="1"
                                                                    {{ old('penyulit_persalinan', $asesmen->asesmenMedisAnakDtl->penyulit_persalinan ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="penyulit_persalinan">Penyulit persalinan</label>
                                                                </div>
                                                            </div>

                                                            <!-- Lainnya -->
                                                            <div class="col-md-4 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="lainnya_sebukan" id="lainnya_sebukan" value="1"
                                                                    {{ old('lainnya_sebukan', $asesmen->asesmenMedisAnakDtl->lainnya_sebukan ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="lainnya_sebukan">Lainnya sebutkan:</label>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <textarea class="form-control form-control-sm" name="lainnya_keterangan" rows="2" placeholder="Sebutkan lainnya..." >{{ old('lainnya_keterangan', $asesmen->asesmenMedisAnakDtl->lainnya_keterangan ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <!-- Riwayat Post Natal -->
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">Riwayat post natal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="row">
                                                            <!-- Prematur -->
                                                            <div class="col-md-4 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="prematur_aterm" id="prematur_aterm" value="1"
                                                                    {{ old('prematur_aterm', $asesmen->asesmenMedisAnakDtl->prematur_aterm ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="prematur_aterm">Prematur/ aterm/ post term</label>
                                                                </div>
                                                            </div>

                                                            <!-- KMK/SMK/BMK -->
                                                            <div class="col-md-4 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="kmk_smk_bmk" id="kmk_smk_bmk" value="1"
                                                                    {{ old('kmk_smk_bmk', $asesmen->asesmenMedisAnakDtl->kmk_smk_bmk ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="kmk_smk_bmk">KMK/ SMK/ BMK</label>
                                                                </div>
                                                            </div>

                                                            <!-- Pasca NICU -->
                                                            <div class="col-md-4 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="pasca_nicu" id="pasca_nicu" value="1"
                                                                    {{ old('pasca_nicu', $asesmen->asesmenMedisAnakDtl->pasca_nicu ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="pasca_nicu">Pasca NICU</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- 8. Riwayat Imunisasi -->
                            <div class="section-separator">
                                <h5 class="section-title">8. Riwayat Imunisasi</h5>
                                <div class="card-body">
                                    @php
                                        // Ambil data riwayat imunisasi dari dtl
                                        $riwayatImunisasi = [];
                                        if (isset($asesmen->asesmenMedisAnakDtl) && $asesmen->asesmenMedisAnakDtl) {
                                            if (is_string($asesmen->asesmenMedisAnakDtl->riwayat_imunisasi)) {
                                                $riwayatImunisasi = json_decode($asesmen->asesmenMedisAnakDtl->riwayat_imunisasi, true) ?: [];
                                            } elseif (is_array($asesmen->asesmenMedisAnakDtl->riwayat_imunisasi)) {
                                                $riwayatImunisasi = $asesmen->asesmenMedisAnakDtl->riwayat_imunisasi;
                                            }
                                        }
                                    @endphp

                                    <!-- Baris 1: Hep B Series -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="border p-3">
                                                <div class="d-flex flex-wrap gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hep_b_ii" value="hep_b_ii"
                                                            {{ in_array('hep_b_ii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hep_b_ii">Hep B II</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hep_b_iii" value="hep_b_iii"
                                                            {{ in_array('hep_b_iii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hep_b_iii">Hep B III</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hep_b_iv" value="hep_b_iv"
                                                            {{ in_array('hep_b_iv', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hep_b_iv">Hep B IV</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hep_b_v" value="hep_b_v"
                                                            {{ in_array('hep_b_v', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hep_b_v">Hep B V</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Baris 2: DPT & BCG -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="border p-3">
                                                <div class="d-flex flex-wrap gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="dpt_ii" value="dpt_ii"
                                                            {{ in_array('dpt_ii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="dpt_ii">DPT II</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="dpt_iii" value="dpt_iii"
                                                            {{ in_array('dpt_iii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="dpt_iii">DPT III</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="bcg" value="bcg"
                                                            {{ in_array('bcg', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bcg">BCG</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Baris 3: Booster -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="border p-3">
                                                <div class="d-flex flex-wrap gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="booster_ii" value="booster_ii"
                                                            {{ in_array('booster_ii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="booster_ii">Booster II</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="booster_iii" value="booster_iii"
                                                            {{ in_array('booster_iii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="booster_iii">Booster III</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Baris 4: HiB Series -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="border p-3">
                                                <div class="d-flex flex-wrap gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hib_ii" value="hib_ii"
                                                            {{ in_array('hib_ii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hib_ii">HiB II</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hib_iii" value="hib_iii"
                                                            {{ in_array('hib_iii', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hib_iii">HiB III</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="hib_iv" value="hib_iv"
                                                            {{ in_array('hib_iv', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hib_iv">HiB IV</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Baris 5: Other Vaccines -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="border p-3">
                                                <div class="d-flex flex-wrap gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="mmr" value="mmr"
                                                            {{ in_array('mmr', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mmr">MMR</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="varilrix" value="varilrix"
                                                            {{ in_array('varilrix', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="varilrix">Varilrix</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="riwayat_imunisasi[]" id="typhim" value="typhim"
                                                            {{ in_array('typhim', old('riwayat_imunisasi', $riwayatImunisasi)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="typhim">Typhim</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 9. Hasil Pemeriksaan Penunjang -->
                            <div class="section-separator">
                                <h5 class="section-title">9. Riwayat tumbuh kembang</h5>
                                <div class="card-body">
                                    <!-- Data Lahir -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Data Kelahiran</h6>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Lahir umur kehamilan:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="lahir_umur_kehamilan" placeholder="Masukkan umur kehamilan"
                                                    value="{{ old('lahir_umur_kehamilan', $asesmen->asesmenMedisAnakDtl->lahir_umur_kehamilan ?? '') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">LK saat lahir:</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" name="lk_saat_lahir" placeholder="Lingkar kepala"
                                                    value="{{ old('lk_saat_lahir', $asesmen->asesmenMedisAnakDtl->lk_saat_lahir ?? '') }}">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">BB saat lahir:</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" name="bb_saat_lahir" placeholder="Berat badan"
                                                    value="{{ old('bb_saat_lahir', $asesmen->asesmenMedisAnakDtl->bb_saat_lahir ?? '') }}">
                                                <span class="input-group-text">gram</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">TB saat lahir:</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" name="tb_saat_lahir" placeholder="Tinggi badan"
                                                    value="{{ old('tb_saat_lahir', $asesmen->asesmenMedisAnakDtl->tb_saat_lahir ?? '') }}">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Riwayat Perawatan -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Riwayat Perawatan</h6>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Pernah dirawat sebelumnya:</label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="pernah_dirawat" id="pernah_dirawat_tidak" value="0"
                                                            {{ old('pernah_dirawat', $asesmen->asesmenMedisAnakDtl->pernah_dirawat ?? '0') == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pernah_dirawat_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="pernah_dirawat" id="pernah_dirawat_ya" value="1"
                                                            {{ old('pernah_dirawat', $asesmen->asesmenMedisAnakDtl->pernah_dirawat ?? '0') == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pernah_dirawat_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small">Tanggal:</label>
                                                    <input type="date" class="form-control form-control-sm" name="tanggal_dirawat"
                                                        value="{{ old('tanggal_dirawat', $asesmen->asesmenMedisAnakDtl->tanggal_dirawat ? $asesmen->asesmenMedisAnakDtl->tanggal_dirawat->format('Y-m-d') : '') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label small">Jam:</label>
                                                    <input type="time" class="form-control form-control-sm" name="jam_dirawat"
                                                    value="{{ $asesmen->asesmenMedisAnakDtl->jam_masuk ? \Carbon\Carbon::parse($asesmen->asesmenMedisAnakDtl->jam_masuk)->format('H:i') : date('H:i') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Jaundice/ RDS/ PJB/ kelainan kongenital:</label>
                                            <textarea class="form-control" name="jaundice_rds_pjb" rows="2" placeholder="Sebutkan jika ada masalah neonatus, jaundice, RDS, PJB, atau kelainan kongenital...">{{ old('jaundice_rds_pjb', $asesmen->asesmenMedisAnakDtl->jaundice_rds_pjb ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Nutrisi -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Riwayat Nutrisi</h6>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">ASI sampai umur:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="asi_sampai_umur" placeholder="Durasi ASI"
                                                    value="{{ old('asi_sampai_umur', $asesmen->asesmenMedisAnakDtl->asi_sampai_umur ?? '') }}">
                                                <span class="input-group-text">mggu/bln</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Pemberian susu formula:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="pemberian_susu_formula" placeholder="Usia mulai susu formula"
                                                    value="{{ old('pemberian_susu_formula', $asesmen->asesmenMedisAnakDtl->pemberian_susu_formula ?? '') }}">
                                                <span class="input-group-text">mggu/bln</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Makanan tambahan umur:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="makanan_tambahan_umur" placeholder="Usia mulai MPASI"
                                                    value="{{ old('makanan_tambahan_umur', $asesmen->asesmenMedisAnakDtl->makanan_tambahan_umur ?? '') }}">
                                                <span class="input-group-text">mggu/bln</span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Milestone Perkembangan -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Milestone Perkembangan Motorik</h6>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Tengkurap:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="tengkurap_bulan" placeholder="Umur"
                                                    value="{{ old('tengkurap_bulan', $asesmen->asesmenMedisAnakDtl->tengkurap_bulan ?? '') }}">
                                                <span class="input-group-text">bulan</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Merangkak:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="merangkak_bulan" placeholder="Umur"
                                                    value="{{ old('merangkak_bulan', $asesmen->asesmenMedisAnakDtl->merangkak_bulan ?? '') }}">
                                                <span class="input-group-text">bulan</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Duduk:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="duduk_bulan" placeholder="Umur"
                                                    value="{{ old('duduk_bulan', $asesmen->asesmenMedisAnakDtl->duduk_bulan ?? '') }}">
                                                <span class="input-group-text">bulan</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Berdiri:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="berdiri_bulan" placeholder="Umur"
                                                    value="{{ old('berdiri_bulan', $asesmen->asesmenMedisAnakDtl->berdiri_bulan ?? '') }}">
                                                <span class="input-group-text">bulan</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tambahan Input untuk Milestone Lainnya -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Catatan Tambahan</h6>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Milestone perkembangan lainnya atau keterangan tambahan:</label>
                                            <textarea class="form-control" name="milestone_lainnya" rows="3" placeholder="Contoh: berjalan pada umur ... bulan, berbicara kata pertama pada umur ... bulan, dll.">{{ old('milestone_lainnya', $asesmen->asesmenMedisAnakDtl->milestone_lainnya ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator">
                                <h5 class="section-title">10. Hasil Pemeriksaan Penunjang</h5>
                                <div class="form-floating">
                                    <textarea class="form-control" name="hasil_laboratorium" placeholder="hasil Laboratorium" id="laboratorium" style="height: 100px">{{ old('hasil_laboratorium', $asesmen->asesmenMedisAnakDtl->hasil_laboratorium ?? '') }}</textarea>
                                    <label for="laboratorium">1. Laboratorium</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <textarea class="form-control" name="hasil_radiologi" placeholder="hasil Radiologi" id="radiologi" style="height: 100px">{{ old('hasil_radiologi', $asesmen->asesmenMedisAnakDtl->hasil_radiologi ?? '') }}</textarea>
                                    <label for="radiologi">2. Radiologi</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <textarea class="form-control" name="hasil_lainnya" placeholder="hasil Lainnya" id="lainnya" style="height: 100px">{{ old('hasil_lainnya', $asesmen->asesmenMedisAnakDtl->hasil_lainnya ?? '') }}</textarea>
                                    <label for="lainnya">3. Lainnya</label>
                                </div>
                            </div>

                            <!-- 7. Diagnosis -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="fw-semibold mb-4">11. Diagnosis</h5>

                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Prognosis</label>

                                    <select class="form-select" name="paru_prognosis">
                                        <option value="" disabled>--Pilih Prognosis--</option>
                                        @forelse ($satsetPrognosis as $item)
                                            <option value="{{ $item->prognosis_id }}"
                                                {{ old('paru_prognosis', $asesmen->asesmenMedisAnakDtl->paru_prognosis ?? '') == $item->prognosis_id ? 'selected' : '' }}>
                                                {{ $item->value ?? 'Field tidak ditemukan' }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>

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
                                        value="{{ old('diagnosis_banding', json_encode($asesmen->asesmenMedisAnakDtl->diagnosis_banding ?? [])) }}">
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
                                    <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                        value="{{ old('diagnosis_kerja', json_encode($asesmen->asesmenMedisAnakDtl->diagnosis_kerja ?? [])) }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Rencana Penatalaksanaan<br> dan Pengobatan</label>
                                    <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                        placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_pengobatan', $asesmen->asesmenMedisAnakDtl->rencana_pengobatan ?? '') }}</textarea>
                                </div>

                            </div>

                            <!-- 12. Perencanaan Pulang Pasien -->
                            <div class="section-separator" id="discharge-planning">
                                <h5 class="section-title">12. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                                <div class="mb-4">
                                    <label class="form-label">Diagnosis medis</label>
                                    <input type="text" class="form-control" name="diagnosis_medis" placeholder="Diagnosis"
                                        value="{{ old('diagnosis_medis', $asesmen->asesmenMedisAnakDtl->diagnosis_medis ?? '') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Usia lanjut (>60 th)</label>
                                    <select class="form-select" name="usia_lanjut">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ old('usia_lanjut', $asesmen->asesmenMedisAnakDtl->usia_lanjut ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ old('usia_lanjut', $asesmen->asesmenMedisAnakDtl->usia_lanjut ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Hambatan mobilitas</label>
                                    <select class="form-select" name="hambatan_mobilisasi">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ old('hambatan_mobilisasi', $asesmen->asesmenMedisAnakDtl->hambatan_mobilisasi ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ old('hambatan_mobilisasi', $asesmen->asesmenMedisAnakDtl->hambatan_mobilisasi ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Membutuhkan pelayanan medis berkelanjutan</label>
                                    <select class="form-select" name="penggunaan_media_berkelanjutan">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="ya" {{ old('penggunaan_media_berkelanjutan', $asesmen->asesmenMedisAnakDtl->penggunaan_media_berkelanjutan ?? '') === 'ya' ? 'selected' : '' }}>Ya</option>
                                        <option value="tidak" {{ old('penggunaan_media_berkelanjutan', $asesmen->asesmenMedisAnakDtl->penggunaan_media_berkelanjutan ?? '') === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Keteraturan dalam mengonsumsi obat dalam aktivitas
                                        harian</label>
                                    <select class="form-select" name="ketergantungan_aktivitas">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="ya" {{ old('ketergantungan_aktivitas', $asesmen->asesmenMedisAnakDtl->ketergantungan_aktivitas ?? '') === 'ya' ? 'selected' : '' }}>Ya</option>
                                        <option value="tidak" {{ old('ketergantungan_aktivitas', $asesmen->asesmenMedisAnakDtl->ketergantungan_aktivitas ?? '') === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Rencana Pulang Khusus</label>
                                    <input type="text" class="form-control" name="rencana_pulang_khusus"
                                        placeholder="Rencana Pulang Khusus"
                                        value="{{ old('rencana_pulang_khusus', $asesmen->asesmenMedisAnakDtl->rencana_pulang_khusus ?? '') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Rencana Lama Perawatan</label>
                                    <input type="text" class="form-control" name="rencana_lama_perawatan"
                                        placeholder="Rencana Lama Perawatan"
                                        value="{{ old('rencana_lama_perawatan', $asesmen->asesmenMedisAnakDtl->rencana_lama_perawatan ?? '') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Rencana Tanggal Pulang</label>
                                    <input type="date" class="form-control" name="rencana_tgl_pulang"
                                        value="{{ old('rencana_tgl_pulang', $asesmen->asesmenMedisAnakDtl->rencana_tgl_pulang ? $asesmen->asesmenMedisAnakDtl->rencana_tgl_pulang->format('Y-m-d') : '') }}">
                                </div>

                                <div class="mt-4">
                                    <label class="form-label">KESIMPULAN</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="alert alert-info d-none">
                                            <!-- Alasan akan ditampilkan di sini -->
                                        </div>
                                        <div class="alert alert-warning d-none">
                                            Membutuhkan rencana pulang khusus
                                        </div>
                                        <div class="alert alert-success">
                                            Tidak membutuhkan rencana pulang khusus
                                        </div>
                                    </div>
                                    <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                        value="{{ old('kesimpulan_planing', $asesmen->asesmenMedisAnakDtl->kesimpulan_planing ?? 'Tidak membutuhkan rencana pulang khusus') }}">
                                </div>

                                <!-- Tombol Reset (Opsional) -->
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary" onclick="resetDischargePlanning()">
                                        Reset Discharge Planning
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle input fields based on radio button selection
        function toggleInputFields(radioName, inputIds, yesValue = 'ya') {
            const radios = document.getElementsByName(radioName);
            const inputs = inputIds.map(id => document.getElementById(id));

            // Initialize state based on current selection
            const selectedValue = Array.from(radios).find(radio => radio.checked)?.value;
            inputs.forEach(input => {
                input.disabled = selectedValue !== yesValue;
                if (selectedValue !== yesValue) {
                    input.value = ''; // Clear input when disabled
                }
            });

            // Add event listeners to radio buttons
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    inputs.forEach(input => {
                        input.disabled = this.value !== yesValue;
                        if (this.value !== yesValue) {
                            input.value = ''; // Clear input when disabled
                            input.classList.remove('is-invalid'); // Remove validation error styling
                        }
                    });
                });
            });
        }

        // Toggle inputs for Merokok
        toggleInputFields('merokok', ['merokok_jumlah', 'merokok_lama']);

        // Toggle inputs for Alkohol
        toggleInputFields('alkohol', ['alkohol_jumlah']);

        // Toggle inputs for Obat-obatan
        toggleInputFields('obat_obatan', ['obat_jenis']);

        // Client-side validation on form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            let errors = [];

            // Check Merokok
            const merokok = document.querySelector('input[name="merokok"]:checked')?.value;
            if (merokok === 'ya') {
                const jumlah = document.getElementById('merokok_jumlah').value;
                const lama = document.getElementById('merokok_lama').value;
                if (!jumlah || jumlah < 0) {
                    errors.push('Jumlah batang/hari harus diisi dan tidak boleh negatif.');
                    document.getElementById('merokok_jumlah').classList.add('is-invalid');
                }
                if (!lama || lama < 0) {
                    errors.push('Lama merokok harus diisi dan tidak boleh negatif.');
                    document.getElementById('merokok_lama').classList.add('is-invalid');
                }
            }

            // Check Alkohol
            const alkohol = document.querySelector('input[name="alkohol"]:checked')?.value;
            if (alkohol === 'ya' && !document.getElementById('alkohol_jumlah').value.trim()) {
                errors.push('Jumlah konsumsi alkohol harus diisi.');
                document.getElementById('alkohol_jumlah').classList.add('is-invalid');
            }

            // Check Obat-obatan
            const obat = document.querySelector('input[name="obat_obatan"]:checked')?.value;
            if (obat === 'ya' && !document.getElementById('obat_jenis').value.trim()) {
                errors.push('Jenis obat-obatan harus diisi.');
                document.getElementById('obat_jenis').classList.add('is-invalid');
            }

            // If there are errors, prevent form submission and show alert
            if (errors.length > 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    html: errors.join('<br>'),
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });


    // Pemeriksaan Fisik - JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle keterangan input based on radio selection
        function toggleKeteranganInput(radioName, keteranganId) {
            const radios = document.getElementsByName(radioName);
            const keteranganInput = document.getElementById(keteranganId);

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '0') { // Tidak Normal
                        keteranganInput.disabled = false;
                        keteranganInput.focus();
                    } else { // Normal
                        keteranganInput.disabled = true;
                        keteranganInput.value = null;
                    }
                });
            });

            // Initialize state saat pertama kali load
            const selectedRadio = Array.from(radios).find(radio => radio.checked);
            if (selectedRadio) {
                if (selectedRadio.value === '0') {
                    keteranganInput.disabled = false;
                } else {
                    keteranganInput.disabled = true;
                    keteranganInput.value = null;
                }
            }
        }

        // Apply toggle functionality ke semua item pemeriksaan fisik
        // Sesuaikan dengan name yang ada di HTML
        toggleKeteranganInput('pengkajian_kepala', 'pengkajian_kepala_keterangan');
        toggleKeteranganInput('pengkajian_mata', 'pengkajian_mata_keterangan');
        toggleKeteranganInput('pengkajian_tht', 'pengkajian_tht_keterangan');
        toggleKeteranganInput('pengkajian_leher', 'pengkajian_leher_keterangan');
        toggleKeteranganInput('pengkajian_mulut', 'pengkajian_mulut_keterangan');
        toggleKeteranganInput('pengkajian_jantung', 'pengkajian_jantung_keterangan');
        toggleKeteranganInput('pengkajian_thorax', 'pengkajian_thorax_keterangan');
        toggleKeteranganInput('pengkajian_abdomen', 'pengkajian_abdomen_keterangan');
        toggleKeteranganInput('pengkajian_tulang_belakang', 'pengkajian_tulang_belakang_keterangan');
        toggleKeteranganInput('pengkajian_sistem_syaraf', 'pengkajian_sistem_syaraf_keterangan');
        toggleKeteranganInput('pengkajian_genetalia', 'pengkajian_genetalia_keterangan');
        toggleKeteranganInput('pengkajian_status_lokasi', 'pengkajian_status_lokasi_keterangan');

        // Function untuk update JSON hidden input based on checkbox selections (jika ada)
        function updateCheckboxJSON(checkboxClass, hiddenInputId) {
            const checkboxes = document.querySelectorAll('.' + checkboxClass);
            const hiddenInput = document.getElementById(hiddenInputId);

            // Cek apakah element ada sebelum diproses
            if (!hiddenInput || checkboxes.length === 0) return;

            function updateJSON() {
                const selectedValues = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedValues.push(checkbox.value);
                    }
                });

                hiddenInput.value = selectedValues.length > 0 ? JSON.stringify(selectedValues) : '';
                console.log(`${hiddenInputId}:`, hiddenInput.value);
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateJSON);
            });

            updateJSON();
        }

        // Apply checkbox JSON functionality (jika diperlukan)
        updateCheckboxJSON('paru-suara-pernafasan', 'paru_suara_pernafasan_json');
        updateCheckboxJSON('paru-suara-tambahan', 'paru_suara_tambahan_json');

        // Form validation sebelum submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validasi tambahan jika diperlukan
                console.log('Form submitted with pemeriksaan fisik data');
            });
        }
    });

    // Skala Nyeri - JavaScript yang disederhanakan
    function initSkalaNyeri() {
        const input = $('input[name="skala_nyeri"]');
        const hiddenInput = $('input[name="skala_nyeri_nilai"]');
        const button = $('#skalaNyeriBtn');

        // Trigger saat pertama kali load
        const initialValue = parseInt(input.val()) || 0;
        updateButton(initialValue);

        // Sinkronkan hidden input dengan input utama
        hiddenInput.val(initialValue);

        // Event handler untuk input utama
        input.on('input change', function() {
            let nilai = parseInt($(this).val()) || 0;

            // Batasi nilai antara 0-10
            nilai = Math.min(Math.max(nilai, 0), 10);
            $(this).val(nilai);

            // Sinkronkan dengan hidden input
            hiddenInput.val(nilai);

            updateButton(nilai);
        });

        // Event handler untuk hidden input (jika diubah manual)
        hiddenInput.on('input change', function() {
            let nilai = parseInt($(this).val()) || 0;

            // Batasi nilai antara 0-10
            nilai = Math.min(Math.max(nilai, 0), 10);
            $(this).val(nilai);

            // Sinkronkan dengan input utama
            input.val(nilai);

            updateButton(nilai);
        });

        // Fungsi untuk update button
        function updateButton(nilai) {
            let buttonClass, textNyeri;

            if (nilai === 0) {
                buttonClass = 'btn-success';
                textNyeri = 'Tidak Nyeri';
            } else if (nilai >= 1 && nilai <= 3) {
                buttonClass = 'btn-success';
                textNyeri = 'Nyeri Ringan';
            } else if (nilai >= 4 && nilai <= 5) {
                buttonClass = 'btn-warning';
                textNyeri = 'Nyeri Sedang';
            } else if (nilai >= 6 && nilai <= 7) {
                buttonClass = 'btn-warning';
                textNyeri = 'Nyeri Berat';
            } else if (nilai >= 8 && nilai <= 9) {
                buttonClass = 'btn-danger';
                textNyeri = 'Nyeri Sangat Berat';
            } else if (nilai >= 10) {
                buttonClass = 'btn-danger';
                textNyeri = 'Nyeri Tak Tertahankan';
            }

            button
                .removeClass('btn-success btn-warning btn-danger')
                .addClass(buttonClass)
                .text(textNyeri);
        }
    }

    // Inisialisasi saat dokumen ready
    $(document).ready(function() {
        initSkalaNyeri();
    });
    </script>
@endpush
