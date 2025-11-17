@extends('layouts.administrator.master')

@push('css')
    <style>
        /* Efek readonly */
        .form-readonly input:not(.vital-sign-section input):not([type="checkbox"]),
        .form-readonly select:not(.vital-sign-section select),
        .form-readonly textarea:not(.vital-sign-section textarea) {
            pointer-events: none;
            opacity: 0.65;
            background-color: #f8f9fa !important;
            transition: all 0.2s ease;
        }

        /* Checkbox: tetap tampilkan checked, tapi non-interaktif */
        .form-readonly input[type="checkbox"]:not(.vital-sign-section input) {
            pointer-events: none;
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Label checkbox tetap terlihat normal */
        .form-readonly .form-check-label {
            opacity: 1 !important;
            cursor: not-allowed;
            user-select: none;
        }

        /* Tombol selain Edit */
        .form-readonly button:not(#btnEdit),
        .form-readonly [type="submit"] {
            pointer-events: none;
            opacity: 0.5;
        }

        /* Tombol Edit tetap aktif */
        .form-readonly #btnEdit {
            pointer-events: auto;
            opacity: 1;
        }

        /* Label tetap normal */
        .form-readonly label {
            opacity: 1 !important;
        }

        /* Vital Sign: dikontrol via JS, tidak dikecualikan di CSS */
        /* Dihapus pengecualian CSS agar ikut aturan readonly */
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                @include('components.navigation')

                <div>
                    <form method="POST"
                        action="{{ route('show-triase.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, 'id' => $data->id]) }}"
                        enctype="multipart/form-data" id="triaseForm" class="form-readonly">
                        @csrf
                        @method('PUT')

                        <x-content-card>

                            {{-- HEADER --}}
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <div>
                                    <h5 class="m-0 fw-bold">Triase Pasien Gawat Darurat (Skala ATS)</h5>
                                    <small class="text-muted">Edit pasien triase masuk.</small>
                                </div>
                                <button type="button" id="btnEdit" class="btn btn-primary">Edit</button>
                            </div>

                            <div class="card shadow-sm border-0 mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            <i class="bi bi-person-check-fill text-success fs-3"></i>
                                        </div>
                                        <div>
                                            <label class="fw-bold text-secondary mb-0 d-block">Dokter Triase</label>
                                            <p class="mb-0 fs-6">{{ $data->dokter->nama }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">

                                {{-- VITAL SIGN --}}
                                <div class="col-12 vital-sign-section">
                                    <div class="card-header border-bottom bg-light">
                                        <p class="m-0 fw-bold">Vital Sign</p>
                                    </div>
                                    <div class="card-body">

                                        {{-- BARIS 1 --}}
                                        <div class="row g-3 mt-1">
                                            <div class="col-md-3">
                                                <label for="sistole" class="form-label">TD (Sistole)</label>
                                                <input type="number" class="form-control" name="sistole" id="sistole"
                                                    value="{{ old('sistole', $vitalSign['sistole'] ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="diastole" class="form-label">TD (Diastole)</label>
                                                <input type="number" class="form-control" name="diastole" id="diastole"
                                                    value="{{ old('diastole', $vitalSign['diastole'] ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="nadi" class="form-label">Nadi (x/mnt)</label>
                                                <input type="number" class="form-control" name="nadi" id="nadi"
                                                    value="{{ old('nadi', $vitalSign['nadi'] ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="respiration" class="form-label">Resp (x/mnt)</label>
                                                <input type="number" class="form-control" name="respiration"
                                                    id="respiration"
                                                    value="{{ old('respiration', $vitalSign['respiration'] ?? '') }}">
                                            </div>
                                        </div>

                                        {{-- BARIS 2 --}}
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-2">
                                                <label for="suhu" class="form-label">Suhu °C</label>
                                                <input type="text" class="form-control" name="suhu" id="suhu"
                                                    value="{{ old('suhu', $vitalSign['suhu'] ?? '') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="spo2_tanpa_o2" class="form-label">SpO2 (tanpa O2)</label>
                                                <input type="number" class="form-control" name="spo2_tanpa_o2"
                                                    id="spo2_tanpa_o2"
                                                    value="{{ old('spo2_tanpa_o2', $vitalSign['spo2_tanpa_o2'] ?? '') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="spo2_dengan_o2" class="form-label">SpO2 (dengan O2)</label>
                                                <input type="number" class="form-control" name="spo2_dengan_o2"
                                                    id="spo2_dengan_o2"
                                                    value="{{ old('spo2_dengan_o2', $vitalSign['spo2_dengan_o2'] ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="tinggi_badan" class="form-label">TB (cm)</label>
                                                <input type="number" class="form-control" name="tinggi_badan"
                                                    id="tinggi_badan"
                                                    value="{{ old('tinggi_badan', $vitalSign['tinggi_badan'] ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="berat_badan" class="form-label">BB (Kg)</label>
                                                <input type="number" class="form-control" name="berat_badan"
                                                    id="berat_badan"
                                                    value="{{ old('berat_badan', $vitalSign['berat_badan'] ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- END VITAL SIGN --}}

                                <div class="col-md-6 triase-label-section">
                                    <div class="card-header border-bottom">
                                        <p class="m-0 fw-bold">Air Way</p>
                                    </div>

                                    <div class="card-body">

                                        @php
                                            $airways = [
                                                ['Bebas', 'false-emergency-check', 'airway_bebas'],
                                                ['Ancaman', 'emergency-check', 'airway_ancaman'],
                                                ['Sumbatan', 'resusitasi-check', 'airway_sumbatan'],
                                                ['Tidak ada tanda-tanda kehidupan', 'doa-check', 'airway_mati'],
                                            ];

                                            $airwaySelected = $data->triase['air_way'] ?? [];
                                        @endphp

                                        @foreach ($airways as [$label, $class, $id])
                                            <div class="form-check mt-2">
                                                <input type="checkbox" class="form-check-input {{ $class }}"
                                                    name="airway[]" value="{{ $label }}"
                                                    id="{{ $id }}"
                                                    {{ in_array($label, $airwaySelected) ? 'checked' : '' }}>

                                                <label class="form-check-label" for="{{ $id }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                {{-- END AIRWAY --}}

                                {{-- BREATHING --}}
                                <div class="col-md-6 triase-label-section">
                                    <div class="card-header border-bottom">
                                        <p class="m-0 fw-bold">Breathing</p>
                                    </div>

                                    <div class="card-body">

                                        @php
                                            $breathings = [
                                                ['Normal', 'false-emergency-check', 'breathing_normal'],
                                                ['Mengi', 'urgent-check', 'breathing_Mengi'],
                                                ['Takipnoe', 'emergency-check', 'breathing_takipnoe'],
                                                ['RR > 20 X/mnt', 'emergency-check', 'breathing_rr'],
                                                ['Henti Nafas', 'resusitasi-check', 'breathing_henti_nafas'],
                                                ['Bradipnoe', 'resusitasi-check', 'breathing_bradipnoe'],
                                                ['Tidak ada denyut nadi', 'doa-check', 'breathing_mati'],
                                            ];
                                        @endphp

                                        @foreach ($breathings as [$label, $class, $id])
                                            <div class="form-check mt-2">
                                                <input type="checkbox" class="form-check-input {{ $class }}"
                                                    name="breathing[]" value="{{ $label }}"
                                                    id="{{ $id }}"
                                                    @if (in_array($label, $data->triase['breathing'] ?? [])) checked @endif>

                                                <label class="form-check-label" for="{{ $id }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                {{-- END BREATHING --}}

                                {{-- CIRCULATION --}}
                                <div class="col-md-6 triase-label-section">
                                    <div class="card-header border-bottom">
                                        <p class="m-0 fw-bold">Circulation</p>
                                    </div>

                                    <div class="card-body">

                                        @php
                                            $circulations = [
                                                ['Nadi Kuat', 'false-emergency-check'],
                                                ['Frekuensi Normal', 'false-emergency-check'],
                                                ['TD sistole 90-159 mmHg', 'false-emergency-check'],
                                                ['TD sistole >= 160 atau <= 90', 'urgent-check'],
                                                ['Nadi Lemah', 'emergency-check'],
                                                ['Bradikardia', 'emergency-check'],
                                                ['Takikardi', 'emergency-check'],
                                                ['Pucat', 'emergency-check'],
                                                ['CRT > 2 detik', 'emergency-check'],
                                                ['Tanda-tanda dehidrasi sedang-berat', 'emergency-check'],
                                                ['Suhu > 40 C', 'emergency-check'],
                                                ['Henti Jantung / Ketiadaan Sirkulasi', 'resusitasi-check'],
                                                ['Nadi tak teraba', 'resusitasi-check'],
                                                ['Sianosis', 'resusitasi-check'],
                                            ];
                                        @endphp

                                        @foreach ($circulations as [$label, $class])
                                            @php $id = Str::slug($label); @endphp
                                            <div class="form-check mt-2">
                                                <input type="checkbox" class="form-check-input {{ $class }}"
                                                    name="circulation[]" value="{{ $label }}"
                                                    id="{{ $id }}"
                                                    @if (in_array($label, $data->triase['circulation'] ?? [])) checked @endif>

                                                <label class="form-check-label" for="{{ $id }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                {{-- END CIRCULATION --}}

                                {{-- DISABILITY --}}
                                <div class="col-md-6 triase-label-section">
                                    <div class="card-header border-bottom">
                                        <p class="m-0 fw-bold">Disability</p>
                                    </div>

                                    <div class="card-body">

                                        @php
                                            $disabilities = [
                                                ['Sadar', 'false-emergency-check'],
                                                ['GCS 15', 'false-emergency-check'],
                                                ['GCS >= 12', 'urgent-check'],
                                                ['GCS 9-12', 'emergency-check'],
                                                ['Gelisah', 'emergency-check'],
                                                ['Nyeri Dada', 'emergency-check'],
                                                ['Hemiparese Akut', 'emergency-check'],
                                                ['GCS < 9', 'resusitasi-check'],
                                                ['Tidak ada respon', 'resusitasi-check'],
                                                ['Kejang', 'resusitasi-check'],
                                            ];
                                        @endphp

                                        @foreach ($disabilities as [$label, $class])
                                            @php $id = Str::slug($label); @endphp
                                            <div class="form-check mt-2">
                                                <input type="checkbox" class="form-check-input {{ $class }}"
                                                    name="disability[]" value="{{ $label }}"
                                                    id="{{ $id }}"
                                                    @if (in_array($label, $data->triase['disability'] ?? [])) checked @endif>

                                                <label class="form-check-label" for="{{ $id }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                {{-- TRIAGE RESULT --}}
                                @php
                                    $triaseColor = [
                                        'FALSE EMERGENCY (60 menit)' => 'btn-success',
                                        'URGENT (30 menit)' => 'btn-warning',
                                        'EMERGENCY (10 menit)' => 'btn-danger',
                                        'RESUSITASI (segera)' => 'btn-danger',
                                        'DOA' => 'btn-dark',
                                    ];
                                    $currentTriase = old('ket_triase', $data->hasil_triase ?? '');
                                    $btnClass = $triaseColor[$currentTriase] ?? 'btn-secondary';
                                @endphp

                                <div class="col-12">
                                    <div class="d-flex align-items-center w-100">
                                        <p class="fw-medium text-primary m-0 text-nowrap">Kesimpulan Triase :</p>
                                        <button type="button" id="triaseStatusLabel"
                                            class="btn ms-3 w-100 {{ $btnClass }}" data-bs-toggle="modal"
                                            data-bs-target="#kodeTriaseModal">
                                            {{ $currentTriase ?: 'Belum Ditentukan' }}
                                        </button>

                                        <input type="hidden" name="kd_triase" id="kd_triase"
                                            value="{{ old('kd_triase', $data->kode_triase ?? '') }}">
                                        <input type="hidden" name="ket_triase" id="ket_triase"
                                            value="{{ $currentTriase }}">
                                    </div>
                                </div>

                            </div> <!-- END ROW -->

                            <div class="mt-4 d-none text-end" id="editActions">
                                <x-button-submit />
                            </div>
                        </x-content-card>
                    </form>
                </div>
            </x-content-card>
        </div>
    </div>

    <!-- Modal Konfirmasi Batal Edit -->
    <div class="modal fade" id="modalBatalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="m-0 fs-5">Perubahan akan dibatalkan. Lanjutkan?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="cancelNo" data-bs-dismiss="modal">
                        Tidak
                    </button>
                    <button type="button" class="btn btn-primary" id="cancelYes">
                        Ya, Batalkan
                    </button>
                </div>

            </div>
        </div>
    </div>
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.triase.modal')

    @push('js')
        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.triase.manage.index')
        <script>
            $(document).ready(function() {

                $('.triase-label-section .form-check-input').prop('disabled', true);

                const $form = $("#triaseForm");
                const $btnEdit = $("#btnEdit");
                const $editActions = $("#editActions");
                let isEditing = false;

                // Simpan state awal form
                const initialFormState = $form.serialize();

                // Kontrol Vital Sign
                const $vitalInputs = $(
                    ".vital-sign-section input, .vital-sign-section select, .vital-sign-section textarea");

                function toggleVitalSign(editable) {
                    $vitalInputs.each(function() {
                        const $el = $(this);
                        if (editable) {
                            $el.prop('disabled', false)
                                .css({
                                    'pointer-events': '',
                                    'opacity': '',
                                    'background-color': ''
                                });
                        } else {
                            $el.prop('disabled', true)
                                .css({
                                    'pointer-events': 'none',
                                    'opacity': '0.65',
                                    'background-color': '#f8f9fa'
                                });
                        }
                    });
                }

                // Awal: Vital Sign disabled
                toggleVitalSign(false);

                $btnEdit.on("click", function() {
                    isEditing = !isEditing;

                    if (isEditing) {
                        // Masuk ke mode edit
                        $form.removeClass("form-readonly");
                        $editActions.removeClass("d-none");
                        $btnEdit.text("Cancel Edit").removeClass("btn-primary").addClass("btn-secondary");
                        $('.triase-label-section .form-check-input').prop('disabled', false);

                        // Aktifkan Vital Sign
                        toggleVitalSign(true);

                    } else {
                        // Keluar mode edit
                        if (initialFormState !== $form.serialize()) {
                            const modal = new bootstrap.Modal(document.getElementById("modalBatalEdit"));
                            modal.show();

                            $("#cancelYes").off().on("click", function() {

                                location.reload();

                                // Reset form ke state awal
                                const params = new URLSearchParams(initialFormState);
                                $form.find("input, select, textarea").each(function() {
                                    const $el = $(this);
                                    const name = $el.attr("name");
                                    if (!name) return;

                                    if ($el.is(":checkbox")) {
                                        const values = params.getAll(name);
                                        $el.prop("checked", values.includes($el.val()));
                                    } else {
                                        $el.val(params.get(name) || "");
                                    }


                                });

                                $('#triaseStatusLabel')
                                    .removeClass(
                                        'btn-primary btn-secondary btn-success btn-danger btn-warning btn-info btn-light btn-dark'
                                    )
                                    .addClass('{{ $triaseColor[$currentTriase] }}');

                                // Kembali ke readonly
                                $form.addClass("form-readonly");
                                $editActions.addClass("d-none");
                                $btnEdit.text("Edit").removeClass("btn-secondary").addClass(
                                    "btn-primary");
                                $('.triase-label-section .form-check-input').prop('disabled', true);
                                toggleVitalSign(false); // Vital Sign kembali disabled

                                modal.hide();
                            });

                            $("#cancelNo").off().on("click", function() {
                                isEditing = true;
                                $form.removeClass("form-readonly");
                                $editActions.removeClass("d-none");
                                $btnEdit.text("Cancel Edit").removeClass("btn-primary").addClass(
                                    "btn-secondary");
                                toggleVitalSign(true); // Tetap aktif
                            });

                        } else {
                            // Tidak ada perubahan
                            $form.addClass("form-readonly");
                            $editActions.addClass("d-none");
                            $btnEdit.text("Edit").removeClass("btn-secondary").addClass("btn-primary");
                            toggleVitalSign(false); // Vital Sign kembali disabled
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
