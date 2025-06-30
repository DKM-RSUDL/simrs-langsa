@extends('layouts.administrator.master')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
<style>
    :root {
        --primary-color: #097dd6;
        --secondary-color: #2c3e50;
        --bg-light: #f8f9fa;
        --border-radius: 8px;
        --transition: all 0.3s ease;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
        min-width: 180px;
    }

    .header-asesmen {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        text-align: center;
        margin: 1.5rem 0;
    }

    .section-separator {
        border-top: 3px solid var(--primary-color);
        margin: 2rem 0;
        padding-top: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--secondary-color);
        background: var(--bg-light);
        padding: 0.75rem 1rem;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .section-title:hover {
        background: #e9ecef;
    }

    .form-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }

    .form-check {
        padding-left: 2rem;
        transition: var(--transition);
        border-radius: 4px;
    }

    .form-check:hover {
        background-color: #f1f5f9;
    }

    .form-check-input {
        cursor: pointer;
        margin-top: 0.3rem;
    }

    .form-check-label {
        cursor: pointer;
        font-size: 0.95rem;
        margin-left: 0.5rem;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        transition: var(--transition);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .table-edukasi {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .table-edukasi th,
    .table-edukasi td {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .table-edukasi th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        text-align: center;
    }

    .table-edukasi tr:nth-child(even) {
        background-color: var(--bg-light);
    }

    .table-edukasi tr:hover {
        background-color: #e9ecef;
    }

    .form-control-sm {
        height: calc(1.5em + 0.6rem + 2px);
        padding: 0.3rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 6px;
        transition: var(--transition);
    }

    .form-control-sm:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
    }

    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 0.5rem;
        border-radius: 6px;
    }

    .hambatan-details {
        display: none;
        margin-top: 0.5rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: 6px;
        transition: var(--transition);
    }

    .hambatan-details.show {
        display: block;
    }

    .tooltip-icon {
        color: #6c757d;
        margin-left: 0.5rem;
        cursor: help;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .form-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-label {
            min-width: unset;
        }

        .table-edukasi {
            font-size: 0.85rem;
        }

        .table-edukasi th,
        .table-edukasi td {
            padding: 0.5rem;
        }
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-md-3">
        @include('unit-pelayanan.hemodialisa.component.patient-card')
    </div>

    <div class="col-md-9">
        <a href="{{ url()->previous() }}" class="btn">
            <i class="ti-arrow-left"></i> Kembali
        </a>
        <form
            action="{{ route('hemodialisa.pelayanan.edukasi.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $hdFormulirEdukasiPasien->id]) }}"
            method="post">
            @csrf
            @method('put')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">

                            <h4 class="header-asesmen">Edit Formulir Edukasi Pasien dan Keluarga Pasien HD</h4>

                            <div class="section-separator">
                                <h5 class="section-title">1. Data Pasien</h5>

                                @php
                                $tinggalBersamaOptions = [
                                ['value' => 'Anak', 'label' => 'Anak'],
                                ['value' => 'Orang Tua', 'label' => 'Orang Tua'],
                                ['value' => 'Sendiri', 'label' => 'Sendiri'],
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Tinggal Bersama <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Pilih dengan siapa pasien tinggal"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($tinggalBersamaOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tinggal_bersama[]"
                                                value="{{ $option['value'] }}"
                                                id="tinggal_{{ str_replace(' ', '_', strtolower($option['value'])) }}"
                                                {{ in_array($option['value'], $formData['tinggal_bersama']) ? 'checked'
                                                : '' }} disabled>
                                            <label class="form-check-label"
                                                for="tinggal_{{ str_replace(' ', '_', strtolower($option['value'])) }}">{{
                                                $option['label'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                $kemampuanBahasaOptions = [
                                ['value' => 'Indonesia', 'label' => 'Indonesia'],
                                [
                                'value' => 'Daerah',
                                'label' => 'Daerah',
                                'has_detail' => true,
                                'detail_name' =>
                                'bahasa_daerah_detail',
                                'placeholder' => 'Sebutkan'
                                ],
                                [
                                'value' => 'Asing',
                                'label' => 'Asing',
                                'has_detail' => true,
                                'detail_name' =>
                                'bahasa_asing_detail',
                                'placeholder' => 'Sebutkan'
                                ],
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Kemampuan Bahasa <i
                                            class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip"
                                            title="Pilih bahasa yang dikuasai pasien"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($kemampuanBahasaOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input bahasa-checkbox" type="checkbox"
                                                name="kemampuan_bahasa[]" value="{{ $option['value'] }}"
                                                id="bahasa_{{ str_replace(' ', '_', strtolower($option['value'])) }}"
                                                data-target="{{ isset($option['detail_name']) ? $option['detail_name'] : '' }}"
                                                {{ in_array($option['value'], $formData['kemampuan_bahasa']) ? 'checked'
                                                : '' }} disabled>
                                            <label class="form-check-label"
                                                for="bahasa_{{ str_replace(' ', '_', strtolower($option['value'])) }}">{{
                                                $option['label'] }}</label>
                                            @if(isset($option['has_detail']) && $option['has_detail'])
                                            <input type="text" class="form-control form-control-sm ms-2 detail-input"
                                                name="{{ $option['detail_name'] }}" id="{{ $option['detail_name'] }}"
                                                placeholder="{{ $option['placeholder'] }}"
                                                value="{{ $bahasaDetails[$option['detail_name']] ?? '' }}" {{
                                                in_array($option['value'], $formData['kemampuan_bahasa']) ? ''
                                                : 'disabled' }} disabled>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                $perluPenerjemahOptions = [
                                ['value' => '0', 'label' => 'Tidak'],
                                ['value' => '1', 'label' => 'Ya'],
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Perlu Penerjemah <i
                                            class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip"
                                            title="Apakah pasien memerlukan penerjemah?"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($perluPenerjemahOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="perlu_penerjemah"
                                                value="{{ $option['value'] }}"
                                                id="penerjemah_{{ strtolower($option['value']) }}" {{
                                                $formData['perlu_penerjemah']==$option['value'] ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="penerjemah_{{ strtolower($option['value']) }}">{{ $option['label']
                                                }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                $bacaTulisOptions = [
                                ['value' => '1', 'label' => 'Bisa'],
                                ['value' => '0', 'label' => 'Tidak'],
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Baca Tulis <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Apakah pasien dapat membaca dan menulis?"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($bacaTulisOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="baca_tulis"
                                                value="{{ $option['value'] }}"
                                                id="baca_tulis_{{ strtolower($option['value']) }}" {{
                                                $formData['baca_tulis']==$option['value'] ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="baca_tulis_{{ strtolower($option['value']) }}">{{ $option['label']
                                                }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @php
                                $caraEdukasiOptions = [
                                ['value' => 'Lisan', 'label' => 'Lisan'],
                                ['value' => 'Tulisan', 'label' => 'Tulisan'],
                                ['value' => 'Brosur/leaflet', 'label' => 'Brosur/leaflet'],
                                ['value' => 'Audiovisual', 'label' => 'Audiovisual'],
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Cara Edukasi <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Pilih metode edukasi yang digunakan"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($caraEdukasiOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="cara_edukasi[]"
                                                value="{{ $option['value'] }}"
                                                id="cara_{{ str_replace('/', '_', strtolower($option['value'])) }}" {{
                                                in_array($option['value'], $formData['cara_edukasi']) ? 'checked' : ''
                                                }} disabled>
                                            <label class="form-check-label"
                                                for="cara_{{ str_replace('/', '_', strtolower($option['value'])) }}">{{
                                                $option['label'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                $hambatanStatusOptions = [
                                ['value' => '1', 'label' => 'Ada'],
                                ['value' => '0', 'label' => 'Tidak'],
                                ];
                                $hambatanOptions = [
                                'Gangguan pendengaran',
                                'Gangguan emosi',
                                'Motivasi kurang/buruk',
                                'Memori hilang',
                                'Secara fisiologis tidak mampu belajar',
                                'Perokok aktif/pasif',
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Hambatan <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Pilih apakah ada hambatan yang dialami pasien"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($hambatanStatusOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hambatan_status"
                                                value="{{ $option['value'] }}"
                                                id="hambatan_status_{{ strtolower($option['value']) }}" {{
                                                $formData['hambatan_status']==$option['value'] ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="hambatan_status_{{ strtolower($option['value']) }}">{{
                                                $option['label'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="hambatan-details" id="hambatan-details"
                                        style="{{ $formData['hambatan_status'] == '1' ? 'display: block;' : 'display: none;' }}">
                                        <div class="checkbox-group">
                                            @foreach($hambatanOptions as $hambatan)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="hambatan[]"
                                                    value="{{ $hambatan }}"
                                                    id="hambatan_{{ str_replace(' ', '_', strtolower($hambatan)) }}" {{
                                                    in_array($hambatan, $formData['hambatan']) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label"
                                                    for="hambatan_{{ str_replace(' ', '_', strtolower($hambatan)) }}">{{
                                                    $hambatan }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @php
                                $ketersediaanEdukasiOptions = [
                                ['value' => '1', 'label' => 'Ya'],
                                ['value' => '0', 'label' => 'Tidak'],
                                ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Ketersediaan Menerima Edukasi <i
                                            class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip"
                                            title="Apakah pasien bersedia menerima edukasi?"></i></label>
                                    <div class="checkbox-group">
                                        @foreach($ketersediaanEdukasiOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ketersediaan_edukasi"
                                                value="{{ $option['value'] }}"
                                                id="ketersediaan_{{ strtolower($option['value']) }}" {{
                                                $formData['ketersediaan_edukasi']==$option['value'] ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="ketersediaan_{{ strtolower($option['value']) }}">{{
                                                $option['label'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: KEBUTUHAN EDUKASI --}}
                            <div class="section-separator">
                                <h5 class="section-title">2. Kebutuhan Edukasi</h5>
                                <div class="form-group">
                                    <div class="checkbox-group">
                                        @php
                                        $selectedKebutuhanEdukasi = isset($formData['kebutuhan_edukasi']) ?
                                        $formData['kebutuhan_edukasi'] : [];
                                        @endphp

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_hak_berpartisipasi_pada_proses_pelayanan"
                                                id="kebutuhan_hak_berpartisipasi_pada_proses_pelayanan" {{
                                                in_array( 'kebutuhan_hak_berpartisipasi_pada_proses_pelayanan' ,
                                                $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_hak_berpartisipasi_pada_proses_pelayanan">Hak
                                                berpartisipasi
                                                pada proses pelayanan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_prosedur_pemeriksaan_penunjang"
                                                id="kebutuhan_prosedur_pemeriksaan_penunjang" {{
                                                in_array( 'kebutuhan_prosedur_pemeriksaan_penunjang' ,
                                                $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_prosedur_pemeriksaan_penunjang">Prosedur pemeriksaan
                                                penunjang</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya"
                                                id="kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya" {{
                                                in_array( 'kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya'
                                                , $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya">Kondisi
                                                kesehatan, daignosis, dan penatalaksanaannya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_proses_pemberian_informed_concent"
                                                id="kebutuhan_proses_pemberian_informed_concent" {{
                                                in_array( 'kebutuhan_proses_pemberian_informed_concent' ,
                                                $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_proses_pemberian_informed_concent">Proses pemberian
                                                informed
                                                concent</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_diet_dan_nutrisi" id="kebutuhan_diet_dan_nutrisi" {{
                                                in_array('kebutuhan_diet_dan_nutrisi', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_diet_dan_nutrisi">Diet dan
                                                nutrisi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya"
                                                id="kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya"
                                                {{
                                                in_array( 'kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya'
                                                , $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya">Pengguanaan
                                                obat secara efektif dan aman serta efek samping serta
                                                interaksinya.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_penggunaan_alat_medis_yang_aman"
                                                id="kebutuhan_penggunaan_alat_medis_yang_aman" {{
                                                in_array( 'kebutuhan_penggunaan_alat_medis_yang_aman' ,
                                                $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_penggunaan_alat_medis_yang_aman">Penggunaan alat medis
                                                yang
                                                aman</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_manajemen_nyeri" id="kebutuhan_manajemen_nyeri" {{
                                                in_array('kebutuhan_manajemen_nyeri', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_manajemen_nyeri">Manajemen
                                                nyeri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_teknik_rehabilitasi" id="kebutuhan_teknik_rehabilitasi"
                                                {{ in_array('kebutuhan_teknik_rehabilitasi', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_teknik_rehabilitasi">Teknik
                                                rehabilitasi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_cuci_tangan_yang_benar"
                                                id="kebutuhan_cuci_tangan_yang_benar" {{
                                                in_array('kebutuhan_cuci_tangan_yang_benar', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_cuci_tangan_yang_benar">Cuci
                                                tangan yang benar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_bahaya_merokok" id="kebutuhan_bahaya_merokok" {{
                                                in_array('kebutuhan_bahaya_merokok', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_bahaya_merokok">Bahaya
                                                merokok</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_rujukan_edukasi" id="kebutuhan_rujukan_edukasi" {{
                                                in_array('kebutuhan_rujukan_edukasi', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_rujukan_edukasi">Rujukan
                                                edukasi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_perawatan_av_shunt" id="kebutuhan_perawatan_av_shunt"
                                                {{ in_array('kebutuhan_perawatan_av_shunt', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_perawatan_av_shunt">Perawatan
                                                AV-Shunt</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_perawatan_cdl" id="kebutuhan_perawatan_cdl" {{
                                                in_array('kebutuhan_perawatan_cdl', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="kebutuhan_perawatan_cdl">Perawatan
                                                CDL</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_kepatuhan_minum_obat"
                                                id="kebutuhan_kepatuhan_minum_obat" {{
                                                in_array('kebutuhan_kepatuhan_minum_obat', $selectedKebutuhanEdukasi)
                                                ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_kepatuhan_minum_obat">Kepatuhan
                                                minum obat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_edukasi[]"
                                                value="kebutuhan_perawatan_luka_akses_femoralis"
                                                id="kebutuhan_perawatan_luka_akses_femoralis" {{
                                                in_array( 'kebutuhan_perawatan_luka_akses_femoralis' ,
                                                $selectedKebutuhanEdukasi ) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label"
                                                for="kebutuhan_perawatan_luka_akses_femoralis">Perawatan luka akses
                                                femoralis.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 3: RENCANA EDUKASI --}}
                            <div class="section-separator">
                                <h5 class="section-title">3. Edukasi Pasien</h5>

                                @php
                                    $hasilVerifikasiOptions = [
                                        'Sudah mengerti',
                                        'Re-demonstrasi',
                                        'Re-edukasi',
                                    ];
                                @endphp

                                {{-- FORM EDUKASI NORMAL (19 TOPIK) - SEMUA DISABLED --}}
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    @foreach($topikEdukasiList as $index => $topik)
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header {{ isset($edukasiData[$topik]) ? 'bg-success text-white' : 'bg-light' }}">
                                                {{ $topik }}
                                                @if(isset($edukasiData[$topik]))
                                                    <i class="fas fa-check-circle float-end"></i>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_{{ $index + 1 }}" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[{{ $topik }}][tgl_jam]"
                                                        id="tgl_jam_{{ $index + 1 }}"
                                                        value="{{ $edukasiData[$topik]['tgl_jam'] ?? '' }}"
                                                        disabled readonly>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach($hasilVerifikasiOptions as $hasil)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="edukasi[{{ $topik }}][hasil_verifikasi]"
                                                                value="{{ $hasil }}"
                                                                id="verifikasi_{{ $index + 1 }}_{{ str_replace([' ', '-'], '_', strtolower($hasil)) }}"
                                                                {{ (isset($edukasiData[$topik]['hasil_verifikasi']) && $edukasiData[$topik]['hasil_verifikasi'] == $hasil) ? 'checked' : '' }}
                                                                disabled>
                                                            <label class="form-check-label"
                                                                for="verifikasi_{{ $index + 1 }}_{{ str_replace([' ', '-'], '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_{{ $index + 1 }}" class="form-label">Tgl Rencana Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[{{ $topik }}][tgl_reedukasi]"
                                                        id="tgl_reedukasi_{{ $index + 1 }}"
                                                        value="{{ $edukasiData[$topik]['tgl_reedukasi'] ?? '' }}"
                                                        disabled readonly>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="edukator_{{ $index + 1 }}" class="form-label">Edukator</label>
                                                    <select class="form-control select2" style="width: 100%"
                                                        name="edukasi[{{ $topik }}][edukator_kd]"
                                                        id="edukator_{{ $index + 1 }}"
                                                        disabled>
                                                        <option value="">Pilih Edukator</option>
                                                        @foreach($perawat as $staff)
                                                        <option value="{{ $staff->kd_karyawan }}"
                                                            {{ (isset($edukasiData[$topik]['edukator_kd']) && $edukasiData[$topik]['edukator_kd'] == $staff->kd_karyawan) ? 'selected' : '' }}>
                                                            {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                            ({{ $staff->profesi ?? 'Perawat' }})
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="pasien_nama_{{ $index + 1 }}" class="form-label">Pasien/Keluarga 
                                                        <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i>
                                                    </label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[{{ $topik }}][pasien_nama]"
                                                        id="pasien_nama_{{ $index + 1 }}" 
                                                        placeholder="Nama Keluarga"
                                                        value="{{ $edukasiData[$topik]['pasien_nama'] ?? '' }}"
                                                        disabled readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    // Enable/disable detail inputs based on checkbox state
        document.addEventListener('DOMContentLoaded', function () {
            // Handle bahasa checkbox change
            document.querySelectorAll('.bahasa-checkbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const targetName = this.getAttribute('data-target');
                    if (targetName) {
                        const targetInput = document.getElementById(targetName);
                        if (targetInput) {
                            if (this.checked) {
                                targetInput.disabled = false;
                                targetInput.focus();
                            } else {
                                targetInput.disabled = true;
                                targetInput.value = '';
                            }
                        }
                    }
                });
            });
        });

        // Toggle hambatan details based on radio selection
        const hambatanRadios = document.querySelectorAll('input[name="hambatan_status"]');
        const hambatanDetails = document.getElementById('hambatan-details');
        hambatanRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                hambatanDetails.classList.toggle('show', radio.value === '1');
                if (radio.value !== '1') {
                    document.querySelectorAll('input[name="hambatan[]"]').forEach(cb => cb.checked = false);
                }
            });
        });

        // bagian ke 2
        document.addEventListener('DOMContentLoaded', function () {
            // Handle bahasa checkbox change
            document.querySelectorAll('.bahasa-checkbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const targetName = this.getAttribute('data-target');
                    if (targetName) {
                        const targetInput = document.getElementById(targetName);
                        if (targetInput) {
                            if (this.checked) {
                                targetInput.disabled = false;
                                targetInput.focus();
                            } else {
                                targetInput.disabled = true;
                                targetInput.value = '';
                            }
                        }
                    }
                });
            });

            // Toggle hambatan details based on radio selection
            const hambatanRadios = document.querySelectorAll('input[name="hambatan_status"]');
            const hambatanDetails = document.getElementById('hambatan-details');
            hambatanRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === '1') {
                        hambatanDetails.style.display = 'block';
                    } else {
                        hambatanDetails.style.display = 'none';
                        document.querySelectorAll('input[name="hambatan[]"]').forEach(cb => cb.checked = false);
                    }
                });
            });
        });        
</script>
@endpush
