@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.status-fungsional.include')
@include('unit-pelayanan.rawat-inap.pelayanan.status-fungsional.include-edit')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.status-fungsional.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary resiko_jatuh__btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            {{-- Duplicate Warning --}}
            <div id="duplicate-warning" class="alert alert-warning" style="display: none;">
                <i class="ti-alert mr-2"></i>
                <span id="duplicate-message"></span>
            </div>

            <form id="barthel_form" method="POST"
                action="{{ route('rawat-inap.status-fungsional.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $statusFungsional->id]) }}">
                @csrf
                @method('PUT')

                <div class="resiko_jatuh__fade-in">
                    <div class="resiko_jatuh__header-asesmen text-center">
                        <h4 class="mb-2">
                            <i class="ti-pencil mr-2"></i>
                            EDIT PENILAIAN STATUS FUNGSIONAL
                        </h4>
                        <small>(BERDASARKAN PENILAIAN BARTHEL INDEX)</small>
                    </div>

                    <!-- Data Dasar -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-calendar mr-2"></i> Data Masuk</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control resiko_jatuh__form-control" id="tanggal" name="tanggal"
                                        value="{{ old('tanggal', $statusFungsional->tanggal) }}" required>
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Jam</label>
                                    <input type="time" class="form-control resiko_jatuh__form-control" id="jam" name="jam"
                                        value="{{ $statusFungsional->jam_masuk ? \Carbon\Carbon::parse($statusFungsional->jam_masuk)->format('H:i') : date('H:i') }}" required>
                                    @error('jam')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Type</label>
                                    <select name="nilai_skor" id="nilai_skor" class="form-control resiko_jatuh__form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="1" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 1 ? 'selected' : '' }}>Sebelum Sakit</option>
                                        <option value="2" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 2 ? 'selected' : '' }}>Saat Masuk</option>
                                        <option value="3" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 3 ? 'selected' : '' }}>Minggu I di RS</option>
                                        <option value="4" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 4 ? 'selected' : '' }}>Minggu II di RS</option>
                                        <option value="5" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 5 ? 'selected' : '' }}>Minggu III di RS</option>
                                        <option value="6" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 6 ? 'selected' : '' }}>Minggu IV di RS</option>
                                        <option value="7" {{ old('nilai_skor', $statusFungsional->nilai_skor) == 7 ? 'selected' : '' }}>Saat Pulang</option>
                                    </select>
                                    @error('nilai_skor')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penilaian Status Fungsional -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-list-ol mr-2"></i> PENILAIAN STATUS FUNGSIONAL</h5>

                        <!-- 1. Mengendalikan BAB -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">1. Mengendalikan rangsang defekasi (BAB):</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bab">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bab" id="bab_0" value="0" {{ old('bab', $statusFungsional->bab) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bab_0">
                                    Tak terkendali/ tak teratur (perlu pencahar)
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bab">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bab" id="bab_1" value="1" {{ old('bab', $statusFungsional->bab) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bab_1">
                                    Kadang-kadang tak terkendali
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bab">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bab" id="bab_2" value="2" {{ old('bab', $statusFungsional->bab) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bab_2">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            @error('bab')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 2. Mengendalikan BAK -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">2. Mengendalikan rangsang berkemih (BAK):</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bak">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bak" id="bak_0" value="0" {{ old('bak', $statusFungsional->bak) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bak_0">
                                    Tak terkendali pakai kateter
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bak">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bak" id="bak_1" value="1" {{ old('bak', $statusFungsional->bak) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bak_1">
                                    Kadang-kadang tak terkendali (1x 24 jam)
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bak">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bak" id="bak_2" value="2" {{ old('bak', $statusFungsional->bak) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bak_2">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            @error('bak')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 3. Membersihkan Diri -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">3. Membersihkan diri (cuci muka, sisir rambut, sikat gigi):</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="grooming">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="membersikan_diri" id="grooming_0" value="0" {{ old('membersikan_diri', $statusFungsional->membersihkan_diri) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="grooming_0">
                                    Butuh pertolongan orang lain
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="grooming">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="membersikan_diri" id="grooming_1" value="1" {{ old('membersikan_diri', $statusFungsional->membersihkan_diri) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="grooming_1">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            @error('membersikan_diri')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 4. Penggunaan Toilet -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">4. Penggunaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihkan, menyiram):</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="toilet">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="penggunaan_jamban" id="toilet_0" value="0" {{ old('penggunaan_jamban', $statusFungsional->penggunaan_jamban) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="toilet_0">
                                    Tergantung pertolongan orang lain
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="toilet">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="penggunaan_jamban" id="toilet_1" value="1" {{ old('penggunaan_jamban', $statusFungsional->penggunaan_jamban) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="toilet_1">
                                    Perlu pertolongan pada beberapa kegiatan tetapi dapat mengerjakan sendiri kegiatan yang lain
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="toilet">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="penggunaan_jamban" id="toilet_2" value="2" {{ old('penggunaan_jamban', $statusFungsional->penggunaan_jamban) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="toilet_2">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            @error('penggunaan_jamban')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 5. Makan -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">5. Makan:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="feeding">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="makan" id="feeding_0" value="0" {{ old('makan', $statusFungsional->makan) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="feeding_0">
                                    Tidak mampu
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="feeding">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="makan" id="feeding_1" value="1" {{ old('makan', $statusFungsional->makan) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="feeding_1">
                                    Perlu ditolong memotong makanan
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="feeding">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="makan" id="feeding_2" value="2" {{ old('makan', $statusFungsional->makan) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="feeding_2">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            @error('makan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 6. Berpindah -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">6. Berubah sikap dari berbaring ke duduk:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="transfer">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berubah_sikap" id="transfer_0" value="0" {{ old('berubah_sikap', $statusFungsional->berubah_sikap) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="transfer_0">
                                    Tidak mampu
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="transfer">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berubah_sikap" id="transfer_1" value="1" {{ old('berubah_sikap', $statusFungsional->berubah_sikap) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="transfer_1">
                                    Perlu banyak bantuan untuk bisa duduk (2 orang)
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="transfer">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berubah_sikap" id="transfer_2" value="2" {{ old('berubah_sikap', $statusFungsional->berubah_sikap) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="transfer_2">
                                    Bantuan (2 orang)
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="transfer">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berubah_sikap" id="transfer_3" value="3" {{ old('berubah_sikap', $statusFungsional->berubah_sikap) == 3 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="transfer_3">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 3</span>
                                </label>
                            </div>
                            @error('berubah_sikap')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 7. Mobilitas -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">7. Berpindah/berjalan:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="mobility">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpindah" id="mobility_0" value="0" {{ old('berpindah', $statusFungsional->berpindah) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="mobility_0">
                                    Tidak mampu
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="mobility">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpindah" id="mobility_1" value="1" {{ old('berpindah', $statusFungsional->berpindah) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="mobility_1">
                                    Bisa (pindah) dengan kursi roda
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="mobility">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpindah" id="mobility_2" value="2" {{ old('berpindah', $statusFungsional->berpindah) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="mobility_2">
                                    Berjalan dengan bantuan 1 orang
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="mobility">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpindah" id="mobility_3" value="3" {{ old('berpindah', $statusFungsional->berpindah) == 3 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="mobility_3">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 3</span>
                                </label>
                            </div>
                            @error('berpindah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 8. Berpakaian -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">8. Memakai baju:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="dressing">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpakaian" id="dressing_0" value="0" {{ old('berpakaian', $statusFungsional->berpakaian) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="dressing_0">
                                    Tergantung orang lain
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="dressing">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpakaian" id="dressing_1" value="1" {{ old('berpakaian', $statusFungsional->berpakaian) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="dressing_1">
                                    Sebagian dibantu (misal mengancing baju)
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="dressing">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="berpakaian" id="dressing_2" value="2" {{ old('berpakaian', $statusFungsional->berpakaian) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="dressing_2">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            @error('berpakaian')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 9. Naik Turun Tangga -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">9. Naik turun tangga:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="stairs">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="naik_turun_tangga" id="stairs_0" value="0" {{ old('naik_turun_tangga', $statusFungsional->naik_turun_tangga) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="stairs_0">
                                    Tidak mampu
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="stairs">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="naik_turun_tangga" id="stairs_1" value="1" {{ old('naik_turun_tangga', $statusFungsional->naik_turun_tangga) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="stairs_1">
                                    Butuh pertolongan
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="stairs">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="naik_turun_tangga" id="stairs_2" value="2" {{ old('naik_turun_tangga', $statusFungsional->naik_turun_tangga) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="stairs_2">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 2</span>
                                </label>
                            </div>
                            @error('naik_turun_tangga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 10. Mandi -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">10. Mandi:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bathing">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="mandi" id="bathing_0" value="0" {{ old('mandi', $statusFungsional->mandi) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bathing_0">
                                    Tergantung orang lain
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bathing">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="mandi" id="bathing_1" value="1" {{ old('mandi', $statusFungsional->mandi) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label" for="bathing_1">
                                    Mandiri
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor: 1</span>
                                </label>
                            </div>
                            @error('mandi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Hasil Skor -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-stats-up mr-2"></i> Hasil Penilaian</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card resiko_jatuh__card resiko_jatuh__result-card bg-light">
                                    <div class="card-body">
                                        <h5>SKOR TOTAL</h5>
                                        <div id="barthel_skorTotal" class="resiko_jatuh__score-total">{{ old('skor_total', $statusFungsional->skor_total) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card resiko_jatuh__card resiko_jatuh__result-card" id="barthel_kategori">
                                    <div class="card-body">
                                        <h5>Kategori</h5>
                                        <h4 id="barthel_kategoriText">{{ old('kategori', $statusFungsional->kategori) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="skor_total" id="barthel_skorTotalInput" value="{{ old('skor_total', $statusFungsional->skor_total) }}">
                        <input type="hidden" name="kategori" id="barthel_kategoriInput" value="{{ old('kategori', $statusFungsional->kategori) }}">
                        @error('skor_total')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @error('kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('rawat-inap.status-fungsional.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            class="btn btn-secondary me-2">
                            <i class="ti-arrow-left mr-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary resiko_jatuh__btn-primary" id="barthel_simpan">
                            <i class="ti-save mr-2"></i> Update
                        </button>
                    </div>
                </div>
            </form>

            <!-- Keterangan -->
            <div class="resiko_jatuh__section-separator mt-3">
                <h5><i class="ti-info mr-2"></i> Keterangan</h5>
                <div class="row">
                    <div class="col-md-12">
                        <div class="resiko_jatuh__keterangan-box">
                            <h6 class="resiko_jatuh__keterangan-title"><strong>Kategori Skor:</strong></h6>
                            <ul class="resiko_jatuh__keterangan-list">
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-success mr-2">Mandiri</span>
                                    <strong>20</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-info mr-2">Ketergantungan Ringan</span>
                                    <strong>12-19</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-warning mr-2">Ketergantungan Sedang</span>
                                    <strong>9-11</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-danger mr-2">Ketergantungan Berat</span>
                                    <strong>5-8</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-danger mr-2">Ketergantungan Total</span>
                                    <strong>0-4</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection