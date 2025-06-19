@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .vital-signs-group {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .additional-fields-group {
            background-color: #f1f8ff;
            border: 1px solid #c7e2ff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .group-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
        }

        .hour-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .hour-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #dee2e6;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .hour-btn:hover {
            border-color: #097dd6;
            background-color: #f8f9fa;
        }

        .hour-btn.active {
            border-color: #097dd6;
            background-color: #097dd6;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="kontrolJamForm" method="POST"
                action="{{ route('rawat-inap.kontrol-istimewa-jam.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($kontrolJam->id)]) }}">
                @csrf
                @method('PUT')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Edit Kontrol Istimewa per Jam</h4>
                            </div>

                            <div class="px-3">
                                {{-- Info Waktu --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ $kontrolJam->tanggal }}" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam">Jam (per jam)</label>
                                        <input type="hidden" name="jam" id="jam" value="{{ date('H:i', strtotime($kontrolJam->jam)) }}">
                                        <div class="hour-selector">
                                            @for ($i = 0; $i < 24; $i++)
                                                @php
                                                    $currentHour = date('H', strtotime($kontrolJam->jam));
                                                @endphp
                                                <button type="button" class="hour-btn {{ $i == $currentHour ? 'active' : '' }}" 
                                                    data-hour="{{ sprintf('%02d', $i) }}">
                                                    {{ sprintf('%02d', $i) }}:00
                                                </button>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                {{-- Vital Signs --}}
                                <div class="vital-signs-group">
                                    <div class="group-title">Tanda-tanda Vital</div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nadi">Nadi (per menit)</label>
                                                <input type="number" class="form-control" id="nadi" name="nadi" 
                                                    value="{{ $kontrolJam->nadi }}" placeholder="contoh: 80">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nafas">Pernafasan (per menit)</label>
                                                <input type="number" class="form-control" id="nafas" name="nafas" 
                                                    value="{{ $kontrolJam->nafas }}" placeholder="contoh: 20">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sistole">Tekanan Darah Sistole (mmHg)</label>
                                                <input type="number" class="form-control" id="sistole" name="sistole" 
                                                    value="{{ $kontrolJam->sistole }}" placeholder="contoh: 120">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="diastole">Tekanan Darah Diastole (mmHg)</label>
                                                <input type="number" class="form-control" id="diastole" name="diastole" 
                                                    value="{{ $kontrolJam->diastole }}" placeholder="contoh: 80">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Input & Output --}}
                                <div class="additional-fields-group">
                                    <div class="group-title">Input & Output</div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pemberian_oral">Pemberian Oral (ml)</label>
                                                <input type="text" class="form-control" id="pemberian_oral" 
                                                    name="pemberian_oral" value="{{ $kontrolJam->pemberian_oral }}" 
                                                    placeholder="contoh: 200 ml">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cairan_intra_vena">Cairan Intra Vena (ml)</label>
                                                <input type="text" class="form-control" id="cairan_intra_vena" 
                                                    name="cairan_intra_vena" value="{{ $kontrolJam->cairan_intra_vena }}" 
                                                    placeholder="contoh: 500 ml">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="diurosis">Diurosis (ml)</label>
                                                <input type="text" class="form-control" id="diurosis" 
                                                    name="diurosis" value="{{ $kontrolJam->diurosis }}" 
                                                    placeholder="contoh: 300 ml">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="muntah">Muntah (ml)</label>
                                                <input type="text" class="form-control" id="muntah" 
                                                    name="muntah" value="{{ $kontrolJam->muntah }}" 
                                                    placeholder="contoh: 50 ml">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" 
                                            rows="3" placeholder="Keterangan tambahan...">{{ $kontrolJam->keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Update</button>
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
        $(document).ready(function() {
            // Hour selector functionality
            $('.hour-btn').click(function() {
                $('.hour-btn').removeClass('active');
                $(this).addClass('active');
                
                let selectedHour = $(this).data('hour');
                $('#jam').val(selectedHour + ':00');
            });

            // Form validation
            $('#kontrolJamForm').on('submit', function(e) {
                let hasVitalSigns = $('#nadi').val() || $('#nafas').val() || 
                                   $('#sistole').val() || $('#diastole').val();
                
                if (!hasVitalSigns) {
                    e.preventDefault();
                    alert('Mohon isi minimal salah satu tanda vital (Nadi, Nafas, atau Tekanan Darah)');
                    return false;
                }
            });
        });
    </script>
@endpush