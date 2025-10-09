@php
    // Define a single variable to check if the user is a specialist doctor
    $isDokterSpesialis = Auth::user()->can('is-dokter-spesialis');
@endphp

<div class="d-grid gap-2">
    @canany(['is-gizi', 'is-admin'])
        <button class="btn mb-2 btn-primary" id="directToGizi">
            <i class="ti-plus"></i> Tambah
        </button>
    @endcanany

    @cannot('is-gizi')
    <button class="btn mb-2 btn-primary" data-bs-toggle="modal" data-bs-target="#addCpptModal" type="button">
        <i class="ti-plus"></i> Tambah
    </button>
    @endcannot
</div>

{{-- START: ADD CPPT MODAL --}}
<div class="modal fade" id="addCpptModal" tabindex="-1" aria-labelledby="addCpptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-inap.cppt.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post" id="formAddCppt">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCpptModalLabel">Catatan Perkembangan Pasien Terintegrasi (CPPT)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Kolom Kiri - S (Subjective) -->
                        <div class="{{ $isDokterSpesialis ? 'col-12' : 'col-md-7' }}">

                            <!-- Tanggal dan Jam Masuk -->
                            <div class="border rounded p-3 bg-light">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold mb-0">Tanggal & Jam Masuk</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex gap-3">
                                            <input type="date" class="form-control" name="tanggal_masuk"
                                                id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                value="{{ date('H:i') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- S (SUBJECTIVE) - Anamnesis/Keluhan Utama -->
                            <div class="mt-4">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'S (SUBJECTIVE)' : 'S (SUBJECTIVE) - Anamnesis/Keluhan Utama' }}
                                </h6>
                                <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis"
                                    id="anamnesis" rows="3" required>{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>

                            <!-- S (SUBJECTIVE) - Skala Nyeri (Hanya untuk Non-Dokter Spesialis) -->
                            @if(!$isDokterSpesialis)
                                <div class="mt-4">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">S (SUBJECTIVE) - Skala Nyeri
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="d-flex flex-column h-100">
                                                <input type="number" name="skala_nyeri"
                                                    class="form-control @error('skala_nyeri') is-invalid @enderror" min="0"
                                                    max="10" id="skala_nyeri"
                                                    value="{{ old('skala_nyeri', $lastCpptData['skala_nyeri'] ?? 0) }}">
                                                @error('skala_nyeri')
                                                    <div class="invalid-feedback">{{ $error }}</div>
                                                @enderror
                                                <button type="button" class="btn btn-sm btn-success mt-2"
                                                    id="skalaNyeriBtn">Tidak Nyeri</button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Gambar Skala Nyeri"
                                                class="img-fluid rounded border">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Hidden input for skala_nyeri untuk role tertentu -->
                            @if($isDokterSpesialis || Auth::user()->can('is-gizi'))
                                <input type="hidden" name="skala_nyeri"
                                    value="{{ old('skala_nyeri', $lastCpptData['skala_nyeri'] ?? 0) }}">
                            @endif

                            <!-- S (SUBJECTIVE) - Detail Nyeri -->
                            @if(!$isDokterSpesialis)
                                <div class="mt-4">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">S (SUBJECTIVE) - Detail Nyeri
                                    </h6>

                                    <!-- Lokasi dan Durasi -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="lokasi" class="form-label">Lokasi</label>
                                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                                name="lokasi" id="lokasi"
                                                value="{{ old('lokasi', $lastCpptData['lokasi'] ?? '') }}"
                                                placeholder="Lokasi">
                                            @error('lokasi')
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="durasi" class="form-label">Durasi</label>
                                            <input type="text" class="form-control @error('durasi') is-invalid @enderror"
                                                name="durasi" id="durasi" placeholder="Durasi"
                                                value="{{ old('durasi', $lastCpptData['durasi'] ?? '') }}">
                                            @error('durasi')
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Pemberat dan Peringan -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="pemberat" class="form-label">Pemberat</label>
                                            <select class="form-select @error('pemberat') is-invalid @enderror"
                                                name="pemberat" id="pemberat">
                                                <option value="">--Pilih--</option>
                                                @foreach ($faktorPemberat as $pemberat)
                                                    <option value="{{ $pemberat->id }}" @selected(old('pemberat', $lastCpptData['pemberat_id'] ?? '') == $pemberat->id)>
                                                        {{ $pemberat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pemberat')
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="peringan" class="form-label">Peringan</label>
                                            <select class="form-select @error('peringan') is-invalid @enderror"
                                                name="peringan" id="peringan">
                                                <option value="">--Pilih--</option>
                                                @foreach ($faktorPeringan as $peringan)
                                                    <option value="{{ $peringan->id }}" @selected(old('peringan', $lastCpptData['peringan_id'] ?? '') == $peringan->id)>
                                                        {{ $peringan->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('peringan')
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kualitas dan Frekuensi Nyeri -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="kualitas_nyeri" class="form-label">Kualitas</label>
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
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="frekuensi_nyeri" class="form-label">Frekuensi</label>
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
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Menjalar dan Jenis Nyeri -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="menjalar" class="form-label">Menjalar</label>
                                            <select class="form-select @error('menjalar') is-invalid @enderror"
                                                name="menjalar" id="menjalar">
                                                <option value="">--Pilih--</option>
                                                @foreach ($menjalar as $mjlr)
                                                    <option value="{{ $mjlr->id }}" @selected(old('menjalar', $lastCpptData['menjalar_id'] ?? '') == $mjlr->id)>
                                                        {{ $mjlr->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('menjalar')
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jenis_nyeri" class="form-label">Jenis</label>
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
                                                <div class="invalid-feedback">{{ $error }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Hidden inputs for Detail Nyeri untuk Dokter Spesialis -->
                                <input type="hidden" name="lokasi"
                                    value="{{ old('lokasi', $lastCpptData['lokasi'] ?? '') }}">
                                <input type="hidden" name="durasi"
                                    value="{{ old('durasi', $lastCpptData['durasi'] ?? '') }}">
                                <input type="hidden" name="pemberat"
                                    value="{{ old('pemberat', $lastCpptData['pemberat_id'] ?? '') }}">
                                <input type="hidden" name="peringan"
                                    value="{{ old('peringan', $lastCpptData['peringan_id'] ?? '') }}">
                                <input type="hidden" name="kualitas_nyeri"
                                    value="{{ old('kualitas_nyeri', $lastCpptData['kualitas_nyeri_id'] ?? '') }}">
                                <input type="hidden" name="frekuensi_nyeri"
                                    value="{{ old('frekuensi_nyeri', $lastCpptData['frekuensi_nyeri_id'] ?? '') }}">
                                <input type="hidden" name="menjalar"
                                    value="{{ old('menjalar', $lastCpptData['menjalar_id'] ?? '') }}">
                                <input type="hidden" name="jenis_nyeri"
                                    value="{{ old('jenis_nyeri', $lastCpptData['jenis_nyeri_id'] ?? '') }}">
                            @endif
                        </div>

                        <!-- Kolom Kanan - O, A, P -->
                        <div class="{{ $isDokterSpesialis ? 'col-12' : 'col-md-5' }}">

                            <!-- O (OBJECTIVE) - Tanda Vital (Hanya untuk Non-Dokter Spesialis) -->
                            @if(!$isDokterSpesialis)
                                <div class="mb-4" style="{{ Auth::user()->can('is-gizi') ? 'display: none;' : '' }}">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">O (OBJECTIVE) - Tanda Vital
                                    </h6>
                                    <div class="row g-3">
                                        @foreach ($tandaVital as $item)
                                            @php
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
                            @endif

                            <!-- Hidden inputs for tanda_vital untuk Dokter Spesialis -->
                            @if($isDokterSpesialis)
                                @foreach ($tandaVital as $item)
                                    @php
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
                                    <input type="hidden" name="tanda_vital[]" value="{{ $vitalValue }}">
                                @endforeach
                            @endif

                            <!-- O (OBJECTIVE) - Pemeriksaan Fisik -->
                            <div class="mb-4" hidden= {{ $isDokterSpesialis ? true : false }}>
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'O (OBJECTIVE)' : 'O (OBJECTIVE) - Pemeriksaan Fisik' }}
                                </h6>
                                <textarea class="form-control @error('pemeriksaan_fisik') is-invalid @enderror"
                                    name="pemeriksaan_fisik" id="pemeriksaan_fisik"
                                    rows="4">{{ old('pemeriksaan_fisik') }}</textarea>
                                @error('pemeriksaan_fisik')
                                    <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>

                            <!-- O (OBJECTIVE) - Data Objektif Lainnya -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'O (OBJECTIVE)' : 'O (OBJECTIVE) - Data Objektif Lainnya' }}
                                </h6>
                                <textarea class="form-control @error('data_objektif') is-invalid @enderror"
                                    name="data_objektif" id="data_objektif"
                                    rows="4">{{ old('data_objektif') }}</textarea>
                                @error('data_objektif')
                                    <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>

                            <!-- A (ASSESSMENT) - Asesmen/Diagnosis -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-primary mb-0 border-bottom pb-2">
                                        {{ $isDokterSpesialis ? 'A (ASSESSMENT)' : 'A (ASSESSMENT) - Asesmen/Diagnosis' }}
                                    </h6>
                                    @include('unit-pelayanan.rawat-inap.pelayanan.cppt.create-diagnosis')
                                </div>
                                <div class="bg-light rounded p-3 border" id="diagnoseList">
                                    <!-- Daftar diagnosis akan ditampilkan di sini -->
                                </div>
                            </div>

                            <!-- P (PLANNING) - Planning/Rencana Tatalaksana -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'P (PLANNING)' : 'P (PLANNING) - Rencana Tatalaksana' }}
                                </h6>
                                <textarea class="form-control @error('planning') is-invalid @enderror" name="planning"
                                    id="planning" rows="4">{{ old('planning') }}</textarea>
                                @error('planning')
                                    <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- P (PLANNING) - Instruksi PPA (Hanya untuk Non-Dokter Spesialis) -->
                    @if(!$isDokterSpesialis)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="border rounded">
                                    <div class="bg-primary text-white p-3">
                                        <h6 class="mb-0">
                                            <i class="bi bi-clipboard-plus me-2"></i>
                                            P (PLANNING) - Instruksi PPA
                                        </h6>
                                    </div>
                                    <div class="p-3">
                                        <!-- Form Input untuk ADD Modal -->
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label for="instruksi_ppa_search_input" class="form-label fw-bold">
                                                    <i class="bi bi-person-badge text-primary me-1"></i>Pilih PPA
                                                </label>
                                                <div class="position-relative">
                                                    <input type="text" id="instruksi_ppa_search_input" class="form-control"
                                                        placeholder="Ketik nama PPA untuk mencari..." autocomplete="off">
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
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END: ADD CPPT MODAL --}}


{{-- START: EDIT CPPT MODAL --}}
<div class="modal fade" id="editCpptModal" tabindex="-1" aria-labelledby="editCpptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-inap.cppt.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post" id="formEditCppt">
                @csrf
                @method('put')

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editCpptModalLabel">Edit Catatan Perkembangan Pasien Terintegrasi (CPPT)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="{{ $isDokterSpesialis ? 'col-12' : 'col-md-7' }}">
                            {{-- ====================== S (SUBJECTIVE) ====================== --}}
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'S (SUBJECTIVE)' : 'S (SUBJECTIVE) - Anamnesis / Keluhan Utama' }}
                                </h6>
                                <input type="hidden" name="tgl_cppt">
                                <input type="hidden" name="urut_cppt">
                                <input type="hidden" name="urut_total_cppt">
                                <input type="hidden" name="unit_cppt">
                                <input type="hidden" name="no_transaksi">

                                <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis"
                                    id="anamnesis" rows="3" required>{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>

                            @if(!$isDokterSpesialis)
                                {{-- S (SUBJECTIVE) - Skala Nyeri --}}
                                <div class="mb-4"  >
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">S (SUBJECTIVE) - Skala Nyeri
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="d-flex flex-column h-100">
                                                <input type="number" name="skala_nyeri"
                                                    class="form-control @error('skala_nyeri') is-invalid @enderror" min="0"
                                                    max="10" id="skala_nyeri"
                                                    value="{{ old('skala_nyeri', $lastCpptData['skala_nyeri'] ?? 0) }}">
                                                @error('skala_nyeri')
                                                    <div class="invalid-feedback">{{ $error }}</div>
                                                @enderror
                                                <button type="button" class="btn btn-sm btn-success mt-2"
                                                    id="skalaNyeriBtn">Tidak Nyeri</button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Gambar Skala Nyeri"
                                                class="img-fluid rounded border">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- Hidden input for skala_nyeri to prevent null -->
                            @if($isDokterSpesialis || Auth::user()->can('is-gizi'))
                                <input type="hidden" name="skala_nyeri"
                                    value="{{ old('skala_nyeri', $lastCpptData['skala_nyeri'] ?? 0) }}">
                                {{-- S (SUBJECTIVE) - Detail Nyeri --}}
                            @endif
                            @if(!$isDokterSpesialis)
                                <div class="mt-4">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">S (SUBJECTIVE) - Detail Nyeri
                                    </h6>

                                    <!-- Lokasi dan Durasi -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="lokasi" class="form-label">Lokasi</label>
                                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                                name="lokasi" id="lokasi"
                                                value="{{ old('lokasi', $lastCpptData['lokasi'] ?? '') }}"
                                                placeholder="Lokasi">
                                            @error('lokasi')
                                                <div class="invalid-feedback">
                                                    {{ $error }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="durasi" class="form-label">Durasi</label>
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

                                    <!-- Pemberat dan Peringan -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="pemberat" class="form-label">Pemberat</label>
                                            <select class="form-select @error('pemberat') is-invalid @enderror"
                                                name="pemberat" id="pemberat">
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
                                        <div class="col-md-6">
                                            <label for="peringan" class="form-label">Peringan</label>
                                            <select class="form-select @error('peringan') is-invalid @enderror"
                                                name="peringan" id="peringan">
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

                                    <!-- Kualitas dan Frekuensi Nyeri -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="kualitas_nyeri" class="form-label">Kualitas</label>
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
                                        <div class="col-md-6">
                                            <label for="frekuensi_nyeri" class="form-label">Frekuensi</label>
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

                                    <!-- Menjalar dan Jenis Nyeri -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="menjalar" class="form-label">Menjalar</label>
                                            <select class="form-select @error('menjalar') is-invalid @enderror"
                                                name="menjalar" id="menjalar">
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
                                        <div class="col-md-6">
                                            <label for="jenis_nyeri" class="form-label">Jenis</label>
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
                            @else
                                <!-- Hidden inputs for Detail Nyeri when isDokterSpesialis is true -->
                                <input type="hidden" name="lokasi"
                                    value="{{ old('lokasi', $lastCpptData['lokasi'] ?? '') }}">
                                <input type="hidden" name="durasi"
                                    value="{{ old('durasi', $lastCpptData['durasi'] ?? '') }}">
                                <input type="hidden" name="pemberat"
                                    value="{{ old('pemberat', $lastCpptData['pemberat_id'] ?? '') }}">
                                <input type="hidden" name="peringan"
                                    value="{{ old('peringan', $lastCpptData['peringan_id'] ?? '') }}">
                                <input type="hidden" name="kualitas_nyeri"
                                    value="{{ old('kualitas_nyeri', $lastCpptData['kualitas_nyeri_id'] ?? '') }}">
                                <input type="hidden" name="frekuensi_nyeri"
                                    value="{{ old('frekuensi_nyeri', $lastCpptData['frekuensi_nyeri_id'] ?? '') }}">
                                <input type="hidden" name="menjalar"
                                    value="{{ old('menjalar', $lastCpptData['menjalar_id'] ?? '') }}">
                                <input type="hidden" name="jenis_nyeri"
                                    value="{{ old('jenis_nyeri', $lastCpptData['jenis_nyeri_id'] ?? '') }}">
                            @endif
                        </div>

                        {{-- ====================== KOLOM KANAN - O, A, P ====================== --}}
                        <div class="{{ $isDokterSpesialis ? 'col-12' : 'col-md-5' }}">
                            @if(!$isDokterSpesialis)
                                {{-- O (OBJECTIVE) - Tanda Vital --}}
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">O (OBJECTIVE) - Tanda Vital
                                    </h6>
                                    <div class="row g-3">
                                        @foreach ($tandaVital as $item)
                                            @php
                                                $kondisi = strtolower(trim($item->kondisi));
                                                $vitalValue = '';
                                                if (isset($vitalSignData) && !empty($vitalSignData)) {
                                                    if (str_contains($kondisi, 'nadi')) {
                                                        $vitalValue = $vitalSignData['nadi'] ?? '';
                                                    } elseif (str_contains($kondisi, 'sistole')) {
                                                        $vitalValue = $vitalSignData['sistole'] ?? '';
                                                    } elseif (str_contains($kondisi, 'diastole') || str_contains($kondisi, 'distole')) {
                                                        $vitalValue = $vitalSignData['diastole'] ?? '';
                                                    } elseif (str_contains($kondisi, 'tinggi badan') || str_contains($kondisi, 'tinggi')) {
                                                        $vitalValue = $vitalSignData['tinggi_badan'] ?? '';
                                                    } elseif (str_contains($kondisi, 'berat badan') || str_contains($kondisi, 'berat')) {
                                                        $vitalValue = $vitalSignData['berat_badan'] ?? '';
                                                    } elseif (str_contains($kondisi, 'respiration rate') || str_contains($kondisi, 'respiration')) {
                                                        $vitalValue = $vitalSignData['respiration'] ?? '';
                                                    } elseif (str_contains($kondisi, 'suhu')) {
                                                        $vitalValue = $vitalSignData['suhu'] ?? '';
                                                    } elseif (str_contains($kondisi, 'spo2 tanpa') || str_contains($kondisi, 'sensorium')) {
                                                        $vitalValue = $vitalSignData['spo2_tanpa_o2'] ?? '';
                                                    } elseif (str_contains($kondisi, 'spo2 dengan') || str_contains($kondisi, 'golongan darah')) {
                                                        $vitalValue = $vitalSignData['spo2_dengan_o2'] ?? '';
                                                    }
                                                }
                                            @endphp

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
                                                            id="kondisi{{ $item->id_kondisi }}" value="{{ $vitalValue }}">
                                                    </div>
                                                @else
                                                    <input type="hidden" name="tanda_vital[]" id="kondisi{{ $item->id_kondisi }}"
                                                        value="{{ $vitalValue }}">
                                                @endif
                                            @else
                                                <div class="col-md-4">
                                                    <label for="kondisi{{ $item->id_kondisi }}"
                                                        class="form-label">{{ $item->kondisi }}</label>
                                                    <input type="text" name="tanda_vital[]" class="form-control"
                                                        id="kondisi{{ $item->id_kondisi }}" value="{{ $vitalValue }}">
                                                </div>
                                            @endcanany
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Hidden inputs for tanda_vital for dokter spesialis to prevent null -->
                            @endif

                            @if($isDokterSpesialis)

                                @foreach ($tandaVital as $item)
                                    @php

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
                                    <input type="hidden" name="tanda_vital[]" value="{{ $vitalValue }}">
                                @endforeach
                            @endif

                            {{-- O (OBJECTIVE) - Pemeriksaan Fisik --}}
                            <div class="mb-4" hidden={{ $isDokterSpesialis ? true : false }}>
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'O (OBJECTIVE)' : 'O (OBJECTIVE) - Pemeriksaan Fisik' }}
                                </h6>
                                <textarea class="form-control" name="pemeriksaan_fisik" id="pemeriksaan_fisik"
                                    rows="4">{{ old('pemeriksaan_fisik') }}</textarea>
                            </div>

                            {{-- O (OBJECTIVE) - Data Objektif --}}
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'O (OBJECTIVE)' : 'O (OBJECTIVE) - Data Objektif Lainnya' }}
                                </h6>
                                <textarea class="form-control" name="data_objektif" id="data_objektif"
                                    rows="4">{{ old('data_objektif') }}</textarea>
                            </div>

                            {{-- A (ASSESSMENT) - Asesmen / Diagnosis --}}
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-primary mb-0 border-bottom pb-2">
                                        {{ $isDokterSpesialis ? 'A (ASSESSMENT)' : 'A (ASSESSMENT) - Asesmen / Diagnosis' }}
                                    </h6>
                                    @include('unit-pelayanan.rawat-inap.pelayanan.cppt.edit-diagnosis')
                                </div>
                                <div class="bg-light rounded p-3 border" id="diagnoseList"></div>
                            </div>

                            {{-- P (PLANNING) - Planning / Rencana --}}
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                    {{ $isDokterSpesialis ? 'P (PLANNING)' : 'P (PLANNING) - Rencana Tatalaksana' }}
                                </h6>
                                <textarea class="form-control" name="planning" id="planning"
                                    rows="4">{{ old('planning') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ====================== P (PLANNING) - INSTRUKSI PPA ====================== --}}
                    @if(!$isDokterSpesialis)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="border rounded">
                                    <div class="bg-primary text-white p-3">
                                        <h6 class="mb-0">
                                            <i class="bi bi-clipboard-plus me-2"></i>P (PLANNING) - Instruksi PPA
                                        </h6>
                                    </div>
                                    <div class="p-3">
                                        <!-- Form Input untuk EDIT Modal -->
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label for="edit_instruksi_ppa_search_input" class="form-label fw-bold">
                                                    <i class="bi bi-person-badge text-primary me-1"></i>Pilih PPA
                                                </label>
                                                <!-- Custom searchable dropdown untuk EDIT -->
                                                <div class="position-relative">
                                                    <input type="text" id="edit_instruksi_ppa_search_input"
                                                        class="form-control" placeholder="Ketik nama PPA untuk mencari..."
                                                        autocomplete="off">
                                                    <input type="hidden" id="edit_instruksi_ppa_selected_value"
                                                        name="instruksi_ppa_perawat_select">

                                                    <!-- Dropdown list untuk EDIT -->
                                                    <div id="edit_instruksi_ppa_dropdown"
                                                        class="dropdown-menu w-100 shadow-lg"
                                                        style="display: none; max-height: 250px; overflow-y: auto; position: absolute; top: 100%; z-index: 1000;">
                                                        <!-- Items will be generated by JavaScript -->
                                                    </div>
                                                </div>
                                                <div class="form-text">
                                                    <i class="bi bi-search me-1"></i>Ketik untuk mencari nama PPA
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_instruksi_ppa_text_input" class="form-label fw-bold">
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

                                        <!-- Tabel List Instruksi untuk EDIT Modal -->
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

                                <!-- Hidden inputs untuk EDIT Modal -->
                                <div id="edit_instruksi_ppa_hidden_inputs"></div>
                                <input type="hidden" id="instruksi_ppa_json_input" name="instruksi" value="">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END: EDIT CPPT MODAL --}}

{{-- END: EDIT CPPT MODAL --}}

@push('js')
    <script>
        $(document).ready(() => {
            $('#directToGizi').click(() => {
                location.href = "{{ route('rawat-inap.cppt.cppt-gizi', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
            })
        })
    </script>
@endpush
