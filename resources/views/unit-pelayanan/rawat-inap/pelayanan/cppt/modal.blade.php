<div class="d-grid gap-2">
    @canany(['is-gizi', 'is-admin'])
    <button class="btn mb-2 btn-primary" id="directToGizi">
        <i class="ti-plus"></i> Tambah
    </button>
    @endcan

    @cannot('is-gizi')
    <button class="btn mb-2 btn-primary" data-bs-toggle="modal" data-bs-target="#addCpptModal" type="button">
        <i class="ti-plus"></i> Tambah
    </button>
    @endcannot
</div>

{{-- START : ADD CPPT MODAL --}}
<div class="modal fade" id="addCpptModal" tabindex="-1" aria-labelledby="addCpptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-inap.cppt.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post" id="formAddCppt">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="addCpptModalLabel">Catatan Perkembangan Pasien Terintegrasi
                        (CPPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <p class="fw-bold">
                                    Anamnesis/ Keluhan Utama
                                    <label for="anamnesis"></label>
                                </p>
                                <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis"
                                    id="anamnesis" required>{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <div class="invalid-feedback">
                                        {{ $error }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <p class="fw-bold">Tanda Vital</p>
                                <div class="row">
                                    @foreach ($tandaVital as $item)
                                        @php
                                            // Mapping kondisi ke field vital sign berdasarkan nama
                                            $vitalValue = '';
                                            if (isset($vitalSignData) && !empty($vitalSignData)) {
                                                $kondisiName = strtolower(trim($item->kondisi));

                                                if (str_contains($kondisiName, 'nadi')) {
                                                    $vitalValue = $vitalSignData['nadi'] ?? '';
                                                } elseif (str_contains($kondisiName, 'sistole')) {
                                                    $vitalValue = $vitalSignData['sistole'] ?? '';
                                                } elseif (str_contains($kondisiName, 'diastole') || str_contains($kondisiName, 'distole')) {
                                                    $vitalValue = $vitalSignData['diastole'] ?? '';
                                                } elseif (str_contains($kondisiName, 'tinggi badan') || str_contains($kondisiName, 'tinggi')) {
                                                    $vitalValue = $vitalSignData['tinggi_badan'] ?? '';
                                                } elseif (str_contains($kondisiName, 'berat badan') || str_contains($kondisiName, 'berat')) {
                                                    $vitalValue = $vitalSignData['berat_badan'] ?? '';
                                                } elseif (str_contains($kondisiName, 'respiration rate') || str_contains($kondisiName, 'respiration')) {
                                                    $vitalValue = $vitalSignData['respiration'] ?? '';
                                                } elseif (str_contains($kondisiName, 'suhu')) {
                                                    $vitalValue = $vitalSignData['suhu'] ?? '';
                                                } elseif (str_contains($kondisiName, 'spo2 tanpa') || str_contains($kondisiName, 'sensorium')) {
                                                    $vitalValue = $vitalSignData['spo2_tanpa_o2'] ?? '';
                                                } elseif (str_contains($kondisiName, 'spo2 dengan') || str_contains($kondisiName, 'golongan darah')) {
                                                    $vitalValue = $vitalSignData['spo2_dengan_o2'] ?? '';
                                                }
                                            }
                                        @endphp

                                        <div class="col-md-4">
                                            <label for="kondisi{{ $item->id_kondisi }}"
                                                class="form-label">{{ $item->kondisi }}</label>
                                            <input type="text" name="tanda_vital[]" class="form-control"
                                                id="kondisi{{ $item->id_kondisi }}" value="{{ $vitalValue }}"
                                                placeholder="Masukkan {{ strtolower($item->kondisi) }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="fw-bold">
                                            Skala Nyeri
                                            <label for="skala_nyeri"></label>
                                        </p>
                                        <input type="number" name="skala_nyeri"
                                            class="form-control @error('skala_nyeri') is-invalid @enderror" min="0"
                                            max="10" id="skala_nyeri"
                                            value="{{ old('skala_nyeri', $lastCpptData['skala_nyeri'] ?? 0) }}">
                                        @error('skala_nyeri')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                        <button type="button" class="btn btn-sm btn-success mt-2"
                                            id="skalaNyeriBtn">Tidak Nyeri</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Descriptive Alt Text"
                                        style="width: 100%; height: auto;">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        name="lokasi" id="lokasi"
                                        value="{{ old('lokasi', $lastCpptData['lokasi'] ?? '') }}" placeholder="Lokasi">
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="durasi" class="col-sm-2 col-form-label">Durasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('durasi') is-invalid @enderror"
                                        name="durasi" id="durasi" placeholder="Durasi"
                                        value="{{ old('durasi', $lastCpptData['durasi'] ?? '') }}">
                                    @error('durasi')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="pemberat" class="col-sm-2 col-form-label">Pemberat</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('pemberat') is-invalid @enderror" name="pemberat"
                                        id="pemberat">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPemberat as $pemberat)
                                            <option value="{{ $pemberat->id }}" @selected(old('pemberat', $lastCpptData['pemberat_id'] ?? '') == $pemberat->id)>
                                                {{ $pemberat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pemberat')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="peringan" class="col-sm-2 col-form-label">Peringan</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('peringan') is-invalid @enderror" name="peringan"
                                        id="peringan">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPeringan as $peringan)
                                            <option value="{{ $peringan->id }}" @selected(old('peringan', $lastCpptData['peringan_id'] ?? '') == $peringan->id)>
                                                {{ $peringan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('peringan')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="kualitas_nyeri" class="col-sm-2 col-form-label">Kualitas</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('kualitas_nyeri') is-invalid @enderror"
                                        name="kualitas_nyeri" id="kualitas_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kualitasNyeri as $kualitas)
                                            <option value="{{ $kualitas->id }}" @selected(old('kualitas_nyeri', $lastCpptData['kualitas_nyeri_id'] ?? '') == $kualitas->id)>
                                                {{ $kualitas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kualitas_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="frekuensi_nyeri" class="col-sm-2 col-form-label">Frekuensi</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('frekuensi_nyeri') is-invalid @enderror"
                                        name="frekuensi_nyeri" id="frekuensi_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($frekuensiNyeri as $frekuensi)
                                            <option value="{{ $frekuensi->id }}" @selected(old('frekuensi_nyeri', $lastCpptData['frekuensi_nyeri_id'] ?? '') == $frekuensi->id)>
                                                {{ $frekuensi->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('frekuensi_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="menjalar" class="col-sm-2 col-form-label">Menjalar</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('menjalar') is-invalid @enderror" name="menjalar"
                                        id="menjalar">
                                        <option value="">--Pilih--</option>
                                        @foreach ($menjalar as $mjlr)
                                            <option value="{{ $mjlr->id }}" @selected(old('menjalar', $lastCpptData['menjalar_id'] ?? '') == $mjlr->id)>
                                                {{ $mjlr->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('menjalar')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="jenis_nyeri" class="col-sm-2 col-form-label">Jenis</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('jenis_nyeri') is-invalid @enderror"
                                        name="jenis_nyeri" id="jenis_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($jenisNyeri as $jenis)
                                            <option value="{{ $jenis->id }}" @selected(old('jenis_nyeri', $lastCpptData['jenis_nyeri_id'] ?? '') == $jenis->id)>
                                                {{ $jenis->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <p class="fw-bold col-sm-5">
                                    Pemeriksaan Fisik
                                    <label for="pemeriksaan_fisik"></label>
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control @error('pemeriksaan_fisik') is-invalid @enderror"
                                            name="pemeriksaan_fisik"
                                            id="pemeriksaan_fisik">{{ old('pemeriksaan_fisik') }}</textarea>
                                        @error('pemeriksaan_fisik')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="fw-bold">
                                        Data Objektif Lainnya
                                        <label for="data_objektif"></label>
                                    </p>
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control @error('data_objektif') is-invalid @enderror"
                                            name="data_objektif"
                                            id="data_objektif">{{ old('data_objektif') }}</textarea>
                                        @error('data_objektif')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-5">Asesmen /Diagnosis</p>
                                <div class="col-sm-6">
                                    <!-- Modal 2 -->
                                    @include('unit-pelayanan.rawat-inap.pelayanan.cppt.create-diagnosis')
                                    <!-- <a href="#" class="btn btn-sm"><i class="bi bi-plus-square"></i>
                                        ICD-10</a> -->
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseList">
                                            <!-- <a href="#" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                                            <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                                            <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br> -->
                                        </div>
                                        <!-- Area untuk menampilkan diagnosis sebelumnya langsung di form test cek-->
                                        {{-- <div id="autoLoadedDiagnoses" class="mb-3" style="display: none;">
                                            <h6 class="fw-bold text-success">
                                                <i class="bi bi-check-circle me-2"></i>Diagnosis Sebelumnya (Otomatis
                                                Dimuat)
                                            </h6>
                                            <div id="autoLoadedDiagnosesList" class="bg-success-subtle rounded-2 p-3">
                                                <!-- Akan diisi otomatis -->
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-12">
                                    Planning/ Rencana Tatalaksana
                                    <label for="planning"></label>
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control @error('planning') is-invalid @enderror"
                                            name="planning" id="planning">{{ old('planning') }}</textarea>
                                        @error('planning')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row mt-3">
                                <div class="checkbox-container">
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_konrol_ulang" name="tindak_lanjut" value="2"
                                            @checked(old('tindak_lanjut')==2) required>
                                        <label for="plan_konrol_ulang">Kontrol ulang, tgl:</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rujuk_internal" name="tindak_lanjut" value="4"
                                            @checked(old('tindak_lanjut')==4) required>
                                        <label for="plan_rujuk_internal">Konsul/Rujuk Internal Ke:</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_selesai" name="tindak_lanjut" value="3"
                                            @checked(old('tindak_lanjut')==3) required>
                                        <label for="plan_selesai">Selesai di Klinik ini</label>
                                    </div>

                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rujuk" name="tindak_lanjut" value="5"
                                            @checked(old('tindak_lanjut')==5) required>
                                        <label for="plan_rujuk">Rujuk RS lain bagian:</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rawat_inap" name="tindak_lanjut" value="1"
                                            @checked(old('tindak_lanjut')==1) required>
                                        <label for="plan_rawat_inap">Rawat Inap</label>
                                    </div>
                                    <div class="input-grou">
                                        @error('tindak_lanjut')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <!-- Perbaikan HTML untuk ADD MODAL - ganti bagian Instruksi PPA di Add Modal -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="bi bi-clipboard-plus me-2"></i>Instruksi PPA
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Form Input untuk ADD Modal (ID yang benar) -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <label for="instruksi_ppa_search_input" class="form-label fw-bold">
                                                <i class="bi bi-person-badge text-primary me-1"></i>Pilih PPA
                                            </label>
                                            <!-- Custom searchable dropdown untuk ADD -->
                                            <div class="position-relative">
                                                <input type="text" id="instruksi_ppa_search_input" class="form-control"
                                                    placeholder="Ketik nama ppa mencari..." autocomplete="off">
                                                <input type="hidden" id="instruksi_ppa_selected_value"
                                                    name="instruksi_ppa_perawat_select">

                                                <!-- Dropdown list untuk ADD -->
                                                <div id="instruksi_ppa_dropdown" class="dropdown-menu w-100 shadow-lg"
                                                    style="display: none; max-height: 250px; overflow-y: auto; position: absolute; top: 100%; z-index: 1000;">
                                                    <!-- Items will be generated by JavaScript -->
                                                </div>
                                            </div>
                                            <div class="form-text">
                                                <i class="bi bi-search me-1"></i>Ketik untuk mencari nama PPA
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="instruksi_ppa_text_input" class="form-label fw-bold">
                                                <i class="bi bi-card-text text-primary me-1"></i>Instruksi
                                            </label>
                                            <textarea id="instruksi_ppa_text_input" class="form-control" rows="2"
                                                placeholder="Masukkan instruksi untuk PPA yang dipilih..."></textarea>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100"
                                                id="instruksi_ppa_tambah_btn">
                                                <i class="bi bi-plus-square me-1"></i>Tambah
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabel List Instruksi untuk ADD Modal -->
                                    <div class="border rounded">
                                        <div
                                            class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                                            <h6 class="mb-0 fw-bold text-primary">
                                                <i class="bi bi-list-check me-2"></i>List Instruksi PPA
                                            </h6>
                                            <span class="badge bg-secondary fs-6"
                                                id="instruksi_ppa_count_badge">0</span>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="8%" class="text-center">No</th>
                                                        <th width="30%">PPA</th>
                                                        <th width="52%">Instruksi</th>
                                                        <th width="10%" class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="instruksi_ppa_table_body">
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-5">
                                                            <i
                                                                class="bi bi-inbox display-4 d-block mb-3 opacity-50"></i>
                                                            <span class="fs-6">Belum ada instruksi yang
                                                                ditambahkan</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden inputs untuk ADD Modal -->
                            <div id="instruksi_ppa_hidden_inputs"></div>
                            <input type="hidden" id="instruksi_ppa_json_input" name="instruksi" value="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END : ADD CPPT MODAL --}}

{{-- START : EDIT CPPT MODAL --}}
<div class="modal fade" id="editCpptModal" tabindex="-1" aria-labelledby="editCpptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-inap.cppt.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post" id="formEditCppt">
                @csrf
                @method('put')

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="editCpptModalLabel">Edit Catatan Perkembangan Pasien
                        Terintegrasi (CPPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            {{-- ====================== ANAMNESIS ====================== --}}
                            <div class="form-group">
                                <p class="fw-bold">Anamnesis / Keluhan Utama</p>
                                <input type="hidden" name="tgl_cppt">
                                <input type="hidden" name="urut_cppt">
                                <input type="hidden" name="urut_total_cppt">
                                <input type="hidden" name="unit_cppt">
                                <input type="hidden" name="no_transaksi">

                                <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis"
                                    id="anamnesis" required>{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>

                            {{-- ====================== TANDA VITAL ====================== --}}
                            <div class="form-group mt-3">
                                <p class="fw-bold">Tanda Vital</p>
                                <div class="row">
                                    @foreach ($tandaVital as $item)
                                        @php
                                            $kondisi = strtolower(trim($item->kondisi));
                                        @endphp

                                        {{-- Jika user GIZI --}}
                                        @canany(['is-gizi', 'is-admin'])
                                            @php
                                                $isHidden = str_contains($kondisi, 'nadi') ||
                                                    str_contains($kondisi, 'respiration') ||
                                                    str_contains($kondisi, 'spo2') ||
                                                    str_contains($kondisi, 'golongan darah') ||
                                                    str_contains($kondisi, 'skala nyeri');
                                            @endphp

                                            @if (!$isHidden)
                                                <div class="col-md-4">
                                                    <label for="kondisi{{ $item->id_kondisi }}"
                                                        class="form-label">{{ $item->kondisi }}</label>
                                                    <input type="text" name="tanda_vital[]" class="form-control"
                                                        id="kondisi{{ $item->id_kondisi }}">
                                                </div>
                                            @else
                                                <input type="hidden" name="tanda_vital[]" id="kondisi{{ $item->id_kondisi }}">
                                            @endif
                                        @endcanany

                                        {{-- Jika BUKAN GIZI --}}
                                        @cannot('is-gizi')
                                        <div class="col-md-4">
                                            <label for="kondisi{{ $item->id_kondisi }}"
                                                class="form-label">{{ $item->kondisi }}</label>
                                            <input type="text" name="tanda_vital[]" class="form-control"
                                                id="kondisi{{ $item->id_kondisi }}">
                                        </div>
                                        @endcannot
                                    @endforeach
                                </div>
                            </div>

                            {{-- ====================== KHUSUS NON-GIZI ====================== --}}
                            @cannot('is-gizi')
                            {{-- Skala Nyeri --}}
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="fw-bold">Skala Nyeri</p>
                                        <input type="number" name="skala_nyeri"
                                            class="form-control @error('skala_nyeri') is-invalid @enderror" min="0"
                                            max="10" id="skala_nyeri" value="{{ old('skala_nyeri') }}">
                                        @error('skala_nyeri')
                                            <div class="invalid-feedback">{{ $error }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-sm btn-success mt-2"
                                            id="skalaNyeriBtn">Tidak Nyeri</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Descriptive Alt Text"
                                        style="width: 100%; height: auto;">
                                </div>
                            </div>

                            {{-- Lokasi & Durasi --}}
                            <div class="row mt-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Lokasi">
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <label for="durasi" class="col-sm-2 col-form-label">Durasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('durasi') is-invalid @enderror"
                                        name="durasi" id="durasi" placeholder="Durasi" value="{{ old('durasi') }}">
                                    @error('durasi')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Faktor Pemberat & Peringan --}}
                            <div class="row mt-3">
                                <label for="pemberat" class="col-sm-2 col-form-label">Pemberat</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('pemberat') is-invalid @enderror" name="pemberat"
                                        id="pemberat">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPemberat as $pemberat)
                                            <option value="{{ $pemberat->id }}" @selected(old('pemberat') == $pemberat->id)>
                                                {{ $pemberat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pemberat')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <label for="peringan" class="col-sm-2 col-form-label">Peringan</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('peringan') is-invalid @enderror" name="peringan"
                                        id="peringan">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPeringan as $peringan)
                                            <option value="{{ $peringan->id }}" @selected(old('peringan') == $peringan->id)>
                                                {{ $peringan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('peringan')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kualitas, Frekuensi, Menjalar, Jenis --}}
                            <div class="row mt-3">
                                <label for="kualitas_nyeri" class="col-sm-2 col-form-label">Kualitas</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="kualitas_nyeri" id="kualitas_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kualitasNyeri as $kualitas)
                                            <option value="{{ $kualitas->id }}"
                                                @selected(old('kualitas_nyeri') == $kualitas->id)>
                                                {{ $kualitas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="frekuensi_nyeri" class="col-sm-2 col-form-label">Frekuensi</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="frekuensi_nyeri" id="frekuensi_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($frekuensiNyeri as $frekuensi)
                                            <option value="{{ $frekuensi->id }}"
                                                @selected(old('frekuensi_nyeri') == $frekuensi->id)>
                                                {{ $frekuensi->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="menjalar" class="col-sm-2 col-form-label">Menjalar</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="menjalar" id="menjalar">
                                        <option value="">--Pilih--</option>
                                        @foreach ($menjalar as $mjlr)
                                            <option value="{{ $mjlr->id }}" @selected(old('menjalar') == $mjlr->id)>
                                                {{ $mjlr->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="jenis_nyeri" class="col-sm-2 col-form-label">Jenis</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="jenis_nyeri" id="jenis_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($jenisNyeri as $jenis)
                                            <option value="{{ $jenis->id }}" @selected(old('jenis_nyeri') == $jenis->id)>
                                                {{ $jenis->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endcannot
                        </div>

                        {{-- ====================== KOLOM KANAN ====================== --}}
                        <div class="col-md-5">
                            {{-- Pemeriksaan Fisik --}}
                            <p class="fw-bold">Pemeriksaan Fisik</p>
                            <div class="bg-secondary-subtle rounded-2">
                                <textarea class="form-control" name="pemeriksaan_fisik"
                                    id="pemeriksaan_fisik">{{ old('pemeriksaan_fisik') }}</textarea>
                            </div>

                            {{-- Data Objektif --}}
                            <p class="fw-bold mt-3">Data Objektif Lainnya</p>
                            <div class="bg-secondary-subtle rounded-2">
                                <textarea class="form-control" name="data_objektif"
                                    id="data_objektif">{{ old('data_objektif') }}</textarea>
                            </div>

                            {{-- Asesmen / Diagnosis --}}
                            <p class="fw-bold mt-3">Asesmen / Diagnosis</p>
                            @include('unit-pelayanan.rawat-inap.pelayanan.cppt.edit-diagnosis')
                            <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseList"></div>

                            {{-- Planning / Rencana --}}
                            <p class="fw-bold mt-3">Planning / Rencana Tatalaksana</p>
                            <div class="bg-secondary-subtle rounded-2">
                                <textarea class="form-control" name="planning"
                                    id="planning">{{ old('planning') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ====================== INSTRUKSI PPA ====================== --}}
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="bi bi-clipboard-plus me-2"></i>Instruksi PPA
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Form Input untuk ADD Modal (ID yang benar) -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <label for="edit_instruksi_ppa_search_input" class="form-label fw-bold">
                                                <i class="bi bi-person-badge text-primary me-1"></i>Pilih PPA
                                            </label>
                                            <!-- Custom searchable dropdown untuk ADD -->
                                            <div class="position-relative">
                                                <input type="text" id="edit_instruksi_ppa_search_input" class="form-control"
                                                    placeholder="Ketik nama ppa mencari..." autocomplete="off">
                                                <input type="hidden" id="edit_instruksi_ppa_selected_value"
                                                    name="instruksi_ppa_perawat_select">

                                                <!-- Dropdown list untuk ADD -->
                                                <div id="edit_instruksi_ppa_dropdown" class="dropdown-menu w-100 shadow-lg"
                                                    style="display: none; max-height: 250px; overflow-y: auto; position: absolute; top: 100%; z-index: 1000;">
                                                    <!-- Items will be generated by JavaScript -->
                                                </div>
                                            </div>
                                            <div class="form-text">
                                                <i class="bi bi-search me-1"></i>Ketik untuk mencari nama PPA
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="instruksi_ppa_text_input" class="form-label fw-bold">
                                                <i class="bi bi-card-text text-primary me-1"></i>Instruksi
                                            </label>
                                            <textarea id="edit_instruksi_ppa_text_input" class="form-control" rows="2"
                                                placeholder="Masukkan instruksi untuk PPA yang dipilih..."></textarea>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100"
                                                id="edit_instruksi_ppa_tambah_btn">
                                                <i class="bi bi-plus-square me-1"></i>Tambah
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabel List Instruksi untuk ADD Modal -->
                                    <div class="border rounded">
                                        <div
                                            class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                                            <h6 class="mb-0 fw-bold text-primary">
                                                <i class="bi bi-list-check me-2"></i>List Instruksi PPA
                                            </h6>
                                            <span class="badge bg-secondary fs-6"
                                                id="edit_instruksi_ppa_count_badge">0</span>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="8%" class="text-center">No</th>
                                                        <th width="30%">PPA</th>
                                                        <th width="52%">Instruksi</th>
                                                        <th width="10%" class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="edit_instruksi_ppa_table_body">
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-5">
                                                            <i
                                                                class="bi bi-inbox display-4 d-block mb-3 opacity-50"></i>
                                                            <span class="fs-6">Belum ada instruksi yang
                                                                ditambahkan</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden inputs untuk ADD Modal -->
                            <div id="edit_instruksi_ppa_hidden_inputs"></div>
                            <input type="hidden" id="instruksi_ppa_json_input" name="instruksi" value="">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END : EDIT CPPT MODAL --}}
@push('js')
    <script>
        $(document).ready(() => {
            $('#directToGizi').click(() => {
                location.href = "{{ route('rawat-inap.cppt.cppt-gizi', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
            })
        })
    </script>
@endpush
