@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .patient-card .nav-link.active {
            background-color: #0056b3;
            color: #fff;
        }

        .patient-card img.rounded-circle {
            object-fit: cover;
        }

        .tab-content {
            flex-grow: 1;
            width: 350px;
        }
    </style>
@endpush


@section('content')
    <div class="row">
        <!-- Sidebar Pasien -->
        <div class="col-md-3 mb-4">
            @include('components.patient-card')
        </div>

        <!-- Main Content -->
        <div class="col-md-9" id="addCpptModal">
            @include('components.navigation-ranap')

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-clipboard-data me-2 fs-5"></i>
                    <h5 class="mb-0">Catatan Perkembangan Pasien Terintegrasi (CPPT)</h5>
                </div>

                <div class="card-body">
                    @php
                        $urlAction = !empty($isEdit)
                            ? 'rawat-inap.cppt.update'
                            : 'rawat-inap.cppt.store';
                    @endphp

                    <form action="{{ route($urlAction, [
        $dataMedis->kd_unit,
        $dataMedis->kd_pasien,
        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
        $dataMedis->urut_masuk
    ]) }}" id="formAddCppt" method="POST">
                        @csrf
                        @method(!empty($isEdit) ? 'PUT' : 'POST')
                        @if (!empty($isEdit))
                            <input type="hidden" id="tgl_cppt" name="tgl_cppt" value="{{ $cppt['tanggal'] }}">
                            <input type="hidden" id="urut_cppt" name="urut_cppt" value="{{ $cppt['urut'] }}">
                            <input type="hidden" id="urut_total_cppt" name="urut_total_cppt" value="{{ $cppt['urut_total'] }}">
                            <input type="hidden" id="unit_cppt" name="unit_cppt" value="{{ $cppt['kd_unit'] }}">
                            <input type="hidden" id="no_transaksi" name="no_transaksi" value="{{ $cppt['no_transaksi'] }}">
                        @endif
                        <input type="hidden" name="tipe_cppt" value="4">
                        <div class="border rounded p-3 bg-light mt-4">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-0">Tanggal & Jam Masuk</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex gap-3">
                                        <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk"
                                            value="{{ date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                            value="{{ date('H:i') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Kolom Kiri -->
                            <div class="col-md-7">
                                <!-- Asesmen -->
                                <div class="mb-3">
                                    <label for="anamnesis" class="fw-bold mb-2">Asesmen</label>
                                    <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis"
                                        id="anamnesis" rows="3"
                                        required>{{ !empty($isEdit) ? $cppt['anamnesis'] : '' }}</textarea>
                                    @error('anamnesis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Diagnosis -->
                                <div class="row mt-3">
                                    <p class="fw-bold col-sm-5">Diagnosis</p>

                                    <div class="col-sm-6">
                                        <!-- Modal 2 -->
                                        @include('unit-pelayanan.rawat-inap.pelayanan.cppt.create-diagnosis')
                                        {{-- <a href="#" class="btn btn-sm"><i class="bi bi-plus-square"></i>
                                            ICD-10</a> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseList">
                                                {{-- <a href="#" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                                                <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                                                <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanda Vital -->
                                <div class="mb-3">
                                    <label class="fw-bold mb-2">Tanda Vital</label>
                                    <div class="row g-3">
                                        {{-- @php
                                        dd($tandaVital);
                                        @endphp --}}
                                        @foreach ($tandaVital as $item)
                                            @php
                                                $vitalValue = '';
                                                $kondisiName = strtolower(trim($item->kondisi));

                                                if (isset($vitalSignData) && !empty($vitalSignData)) {
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
                                                    } elseif (str_contains($kondisiName, 'spo2 dengan') || str_contains($kondisiName, 'golongan darah')) {
                                                        $vitalValue = $vitalSignData['spo2_dengan_o2'] ?? '';
                                                    } elseif (str_contains($kondisiName, 'sensorium') || str_contains($kondisiName, 'sensorium')) {
                                                        $vitalValue = $vitalSignData['sensorium'] ?? '';
                                                    }
                                                }

                                                // Flag untuk kondisi yang disembunyikan
                                                $isHidden = (
                                                    str_contains($kondisiName, 'nadi') ||
                                                    str_contains($kondisiName, 'respiration') ||
                                                    str_contains($kondisiName, 'spo2') ||
                                                    str_contains($kondisiName, 'golongan darah') ||
                                                    str_contains($kondisiName, 'skala nyeri')
                                                );
                                            @endphp

                                            @if($isHidden)
                                                {{-- Hidden input agar tetap submit --}}
                                                <input type="hidden" name="tanda_vital[]" id="kondisi{{ $item->id_kondisi }}"
                                                    value="{{ $vitalValue }}">
                                            @else
                                                <div class="col-md-4">
                                                    <label for="kondisi{{ $item->id_kondisi }}" class="form-label">
                                                        {{ $item->kondisi }}
                                                    </label>
                                                    <input type="text" name="tanda_vital[]" class="form-control"
                                                        id="kondisi{{ $item->id_kondisi }}" value="{{ $vitalValue }}"
                                                        placeholder="Masukkan {{ strtolower($item->kondisi) }}">
                                                </div>
                                            @endif
                                        @endforeach


                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="pemeriksaan_fisik" class="fw-bold mb-2">Intervensi</label>
                                    <textarea class="form-control @error('pemeriksaan_fisik') is-invalid @enderror"
                                        name="pemeriksaan_fisik" id="pemeriksaan_fisik"
                                        rows="3">{{ !empty($isEdit) ? $cppt['pemeriksaan_fisik'] : '' }}</textarea>
                                    @error('pemeriksaan_fisik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="data_objektif" class="fw-bold mb-2">Monitoring</label>
                                    <textarea class="form-control @error('data_objektif') is-invalid @enderror"
                                        name="data_objektif" id="data_objektif"
                                        rows="3">{{ !empty($isEdit) ? $cppt['obyektif'] : '' }}</textarea>
                                    @error('data_objektif')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="planning" class="fw-bold mb-2">Evaluasi</label>
                                    <textarea class="form-control @error('planning') is-invalid @enderror" name="planning"
                                        id="planning" rows="3">{{ !empty($isEdit) ? $cppt['planning'] : '' }}</textarea>
                                    @error('planning')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Instruksi PPA -->
                        <div class="card mt-4 border-0 shadow-sm">
                            <div
                                class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-clipboard-plus me-2"></i>Instruksi PPA</h6>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Form Input untuk ADD Modal (ID yang benar) -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-4">
                                                    <label for="{{  !empty($isEdit) ? "edit_instruksi_ppa_search_input" : "instruksi_ppa_search_input" }}" class="form-label fw-bold">
                                                        <i class="bi bi-person-badge text-primary me-1"></i>Pilih PPA
                                                    </label>
                                                    <!-- Custom searchable dropdown untuk ADD -->
                                                    <div class="position-relative">
                                                        <input type="text" id="{{  !empty($isEdit) ? "edit_instruksi_ppa_search_input" : "instruksi_ppa_search_input" }}"
                                                            class="form-control" placeholder="Ketik nama ppa mencari..."
                                                            autocomplete="off">
                                                        <input type="hidden" id= "{{ !empty($isEdit) ? "edit_instruksi_ppa_selected_value" : "instruksi_ppa_selected_value" }}"
                                                            name="instruksi_ppa_perawat_select">

                                                        <!-- Dropdown list untuk ADD -->
                                                        <div id="{{!empty($isEdit) ? "edit_instruksi_ppa_dropdown" : "instruksi_ppa_dropdown" }}"
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
                                                    <label for=" {{ !empty($isEdit) ? "edit_instruksi_ppa_text_input" : "instruksi_ppa_text_input" }}"  class="form-label fw-bold">
                                                        <i class="bi bi-card-text text-primary me-1"></i>Instruksi
                                                    </label>
                                                    <textarea id="{{ !empty($isEdit) ? "edit_instruksi_ppa_text_input" : "instruksi_ppa_text_input" }}"  class="form-control" rows="2"
                                                        placeholder="Masukkan instruksi untuk PPA yang dipilih..."></textarea>
                                                </div>

                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-primary w-100"
                                                        id={{ !empty($isEdit) ? "edit_instruksi_ppa_tambah_btn":"instruksi_ppa_tambah_btn" }}>
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
                                                        id="{{!empty($isEdit) ? "edit_instruksi_ppa_count_badge" : "instruksi_ppa_count_badge" }}">0</span>
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
                                                        <tbody
                                                            id="{{ !empty($isEdit) ? 'edit_instruksi_ppa_table_body' : 'instruksi_ppa_table_body' }}">
                                                            @if(!empty($cppt['instruksi_ppa']))
                                                                @foreach ($cppt['instruksi_ppa_nama'] as $index => $item)
                                                                    <tr>
                                                                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <i class="bi bi-person-badge text-primary me-2"></i>
                                                                                <div>
                                                                                    <strong>{{ $item['nama_lengkap'] }}</strong><br>
                                                                                    <small
                                                                                        class="text-muted">{{ $item['ppa'] }}</small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mb-2">{{ $item['instruksi'] }}</div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-danger"
                                                                                onclick="hapusAddInstruksiPpa({{ $item['id'] }})"
                                                                                title="Hapus Instruksi">
                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            @else
                                                                <tr>
                                                                    <td colspan="4" class="text-center text-muted py-5">
                                                                        <i
                                                                            class="bi bi-inbox display-4 d-block mb-3 opacity-50"></i>
                                                                        <span class="fs-6">Belum ada instruksi yang
                                                                            ditambahkan</span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs untuk ADD Modal -->
                                    <div id="{{ !empty($isEdit) ? "edit_instruksi_ppa_hidden_inputs":"instruksi_ppa_hidden_inputs" }}">
                                        @if(!empty($cppt['instruksi_ppa_nama']))
                                            @foreach ($cppt['instruksi_ppa_nama'] as $item)
                                                <input type="hidden" name="perawat_kode[]" value="{{ $item['ppa'] }}">
                                                <input type="hidden" name="perawat_nama[]" value="{{ $item['nama_lengkap'] }}">
                                                <input type="hidden" name="instruksi_text[]" value="{{ $item['instruksi'] }}">
                                            @endforeach

                                        @endif
                                    </div>
                                    <input type="hidden" id="instruksi_ppa_json_input" name="instruksi" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('unit-pelayanan.rawat-inap.pelayanan.cppt.manage.index')
@endpush