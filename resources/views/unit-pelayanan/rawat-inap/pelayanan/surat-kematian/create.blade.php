@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.4rem;
        }

        .required::after {
            color: #dc3545;
            margin-left: 0.3rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a3c34;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.5rem 1.5rem;
            border-radius: 0.4rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-outline-secondary {
            padding: 0.4rem 1rem;
            border-radius: 0.4rem;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .invalid-feedback {
            font-size: 0.85rem;
        }

        .row.g-3 {
            margin-bottom: 0.5rem;
        }

        .section-separator {
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            border-top: 1px solid #e9ecef;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a3c34;
            margin-bottom: 1rem;
        }

        .add-field-btn {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            border-radius: 0.4rem;
            padding: 0.3rem 0.75rem;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .add-field-btn:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .remove-field-btn {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            border-radius: 0.4rem;
            padding: 0.3rem 0.75rem;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .remove-field-btn:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        .diagnosis-container {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.4rem;
            margin-bottom: 1rem;
        }

        .diagnosis-field {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .diagnosis-field:last-child {
            border-bottom: none;
        }

        .field-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        {{-- Patient Card Column --}}
        <div class="col-md-3">
            @include('components.patient-card', ['dataMedis' => $dataMedis])
        </div>

        {{-- Form Column --}}
        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Form Tambah Surat Kematian Pasien',
                    'description' => 'Lengkapi data berikut untuk membuat surat kematian pasien.',
                ])
                {{-- The Form --}}
                <form
                    action="{{ route('rawat-inap.surat-kematian.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="POST">
                    @csrf

                    {{-- Section 1: Data Kematian --}}
                    <div class="section-separator" id="data-kematian">
                        <div class="row g-3">
                            {{-- Tanggal Kematian --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_kematian" class="form-label required">Tanggal Kematian</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_kematian') is-invalid @enderror"
                                        id="tanggal_kematian" name="tanggal_kematian"
                                        value="{{ old('tanggal_kematian', date('Y-m-d')) }}" required>
                                    @error('tanggal_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jam Kematian --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_kematian" class="form-label required">Jam Kematian</label>
                                    <input type="time" class="form-control @error('jam_kematian') is-invalid @enderror"
                                        id="jam_kematian" name="jam_kematian" value="{{ old('jam_kematian', date('H:i')) }}"
                                        required>
                                    @error('jam_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            {{-- Dokter --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dokter" class="form-label required">Dokter</label>
                                    <select class="form-control select2 @error('dokter') is-invalid @enderror"
                                        id="dokter" name="dokter" required>
                                        <option value="">Pilih Dokter</option>
                                        @foreach ($dataDokter as $dokter)
                                            <option value="{{ $dokter->kd_dokter }}"
                                                {{ old('dokter') == $dokter->kd_dokter ? 'selected' : '' }}>
                                                {{ $dokter->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row g-3">
                            {{-- Tempat Kematian --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_kematian" class="form-label required">Tempat Kematian</label>
                                    <input type="text"
                                        class="form-control @error('tempat_kematian') is-invalid @enderror"
                                        id="tempat_kematian" name="tempat_kematian" value="{{ old('tempat_kematian') }}"
                                        required>
                                    @error('tempat_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kab/Kota --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kab_kota" class="form-label">Kabupaten/Kota</label>
                                    <input type="text" class="form-control @error('kab_kota') is-invalid @enderror"
                                        id="kab_kota" name="kab_kota" value="{{ old('kab_kota') }}">
                                    @error('kab_kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label required">Umur</label>
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <input type="number"
                                                class="form-control @error('umur_tahun') is-invalid @enderror"
                                                id="umur_tahun" name="umur_tahun" value="{{ old('umur_tahun') }}"
                                                placeholder="Tahun" min="0">
                                            @error('umur_tahun')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number"
                                                class="form-control @error('umur_bulan') is-invalid @enderror"
                                                id="umur_bulan" name="umur_bulan" value="{{ old('umur_bulan') }}"
                                                placeholder="Bulan" min="0" max="11">
                                            @error('umur_bulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number"
                                                class="form-control @error('umur_hari') is-invalid @enderror" id="umur_hari"
                                                name="umur_hari" value="{{ old('umur_hari') }}" placeholder="Hari"
                                                min="0" max="30">
                                            @error('umur_hari')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number"
                                                class="form-control @error('umur_jam') is-invalid @enderror" id="umur_jam"
                                                name="umur_jam" value="{{ old('umur_jam') }}" placeholder="Jam/Menit"
                                                min="0">
                                            @error('umur_jam')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Diagnosis Penyebab Kematian --}}
                    <div class="section-separator" id="diagnosis-penyebab-kematian">
                        <h6 class="section-title">Diagnosis Penyebab Kematian</h6>
                        <div class="diagnosis-container">
                            <div class="form-group">
                                <label class="form-label required">I. Penyakit atau keadaan yang langsung mengakibatkan
                                    kematian</label>
                                <div id="penyakit-sebab-container">
                                    {{-- Initial Diagnosis Field --}}
                                    <div class="row g-2 diagnosis-field align-items-end" data-field-id="1">
                                        <div class="col-md-4">
                                            <input type="text"
                                                class="form-control @error('diagnosa_1') is-invalid @enderror"
                                                id="diagnosa_1" name="diagnosa_1" value="{{ old('diagnosa_1') }}"
                                                placeholder="Diagnosa" required>
                                            @error('diagnosa_1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text"
                                                class="form-control @error('akibat_1') is-invalid @enderror"
                                                id="akibat_1" name="akibat_1" value="{{ old('akibat_1') }}"
                                                placeholder="Disebabkan atau akibat dari">
                                            @error('akibat_1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text"
                                                class="form-control @error('lama_diagnosa_1') is-invalid @enderror"
                                                id="lama_diagnosa_1" name="lama_diagnosa_1"
                                                value="{{ old('lama_diagnosa_1') }}" placeholder="Lamanya (kira-kira)">
                                            @error('lama_diagnosa_1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1 field-actions">
                                            <button type="button" class="btn add-field-btn" id="add-field-btn">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label class="form-label">II. Penyakit-penyakit lain yang mempengaruhi pula kematian
                                    itu, tetapi tidak ada hubungannya dengan penyakit-penyakit diatas</label>
                                <div id="penyakit-lain-container">
                                    <div class="row g-2 diagnosis-field align-items-end" data-field-id="other_2">
                                        <div class="col-md-5">
                                            <input type="text"
                                                class="form-control @error('penyakit_lain_2') is-invalid @enderror"
                                                id="penyakit_lain_2" name="penyakit_lain_2"
                                                value="{{ old('penyakit_lain_2') }}"
                                                placeholder="Disamping penyakit-penyakit tersebut, Diatas terdapat pula penyakit">
                                            @error('penyakit_lain_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('lama_penyakit_lain_2') is-invalid @enderror"
                                                id="lama_penyakit_lain_2" name="lama_penyakit_lain_2"
                                                value="{{ old('lama_penyakit_lain_2') }}"
                                                placeholder="Lamanya (kira-kira)">
                                            @error('lama_penyakit_lain_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1 field-actions">
                                            <button type="button" class="btn add-field-btn" id="add-other-field-btn">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="text-end">
                        <x-button-submit />
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Section I: Variables for the primary diagnosis fields
            const container = document.getElementById('penyakit-sebab-container');
            let counter = 1;

            // Section II: Variables for "other diseases" fields
            const otherContainer = document.getElementById('penyakit-lain-container');
            let otherCounter = 2; // Starting from 2 as there's already one field

            // Add new diagnosis field for Section I
            document.getElementById('add-field-btn').addEventListener('click', function() {
                counter++;
                const newRow = document.createElement('div');
                newRow.className = 'row g-2 diagnosis-field align-items-end';
                newRow.setAttribute('data-field-id', counter);
                newRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" class="form-control" id="diagnosa_${counter}" name="diagnosa_${counter}" placeholder="Diagnosa">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="akibat_${counter}" name="akibat_${counter}" placeholder="Disebabkan atau akibat dari">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" id="lama_diagnosa_${counter}" name="lama_diagnosa_${counter}" placeholder="Lamanya (kira-kira)">
            </div>
            <div class="col-md-1 field-actions">
                <button type="button" class="btn remove-field-btn" data-field-id="${counter}">
                    <i class="ti-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(newRow);
            });

            // Add new field for Section II (Penyakit lain)
            document.querySelector('#penyakit-lain-container .add-field-btn').addEventListener('click', function() {
                otherCounter++;
                const newRow = document.createElement('div');
                newRow.className = 'row g-2 diagnosis-field align-items-end';
                newRow.setAttribute('data-field-id', `other_${otherCounter}`);
                newRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" id="penyakit_lain_${otherCounter}" name="penyakit_lain_${otherCounter}" placeholder="Disamping penyakit-penyakit tersebut, Diatas terdapat pula penyakit">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="lama_penyakit_lain_${otherCounter}" name="lama_penyakit_lain_${otherCounter}" placeholder="Lamanya (kira-kira)">
            </div>
            <div class="col-md-1 field-actions">
                <button type="button" class="btn remove-field-btn" data-field-id="other_${otherCounter}">
                    <i class="ti-trash"></i>
                </button>
            </div>
        `;
                otherContainer.appendChild(newRow);
            });

            // Remove diagnosis field for both sections using event delegation
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-field-btn')) {
                    const button = e.target.closest('.remove-field-btn');
                    const fieldId = button.getAttribute('data-field-id');

                    // Determine which container to use
                    const targetContainer = fieldId.startsWith('other_') ? otherContainer : container;
                    const fieldRow = targetContainer.querySelector(`[data-field-id="${fieldId}"]`);

                    // Don't allow removal of the first field in each section
                    if ((fieldId !== '1') && (fieldId !== 'other_2')) {
                        fieldRow.remove();
                    }
                }
            });
        });
    </script>
@endpush
