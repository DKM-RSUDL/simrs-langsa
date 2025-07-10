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

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
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

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        /* Styling untuk kartu edukasi */
        .edukasi-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .edukasi-card {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .edukasi-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .edukasi-card .form-group {
            margin-bottom: 1.5rem;
        }

        .edukasi-card .form-check {
            margin-bottom: 0.5rem;
        }

        .edukasi-card .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .edukasi-card .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
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
            <form id="edukasiForm" method="POST"
                action="{{ route('paps.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($paps->id)]) }}">
                @csrf
                @method('put')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Edit Pernyataan PAPS</h4>
                            </div>

                            <div class="px-3">

                                <div class="section-separator bg-light p-3">
                                    <p class="fw-bold">PERNYATAAN</p>

                                    <ol class="fw-bold">
                                        <li>
                                            Menyatakan dengan sesungguhnya bahwa saya telah mendapat penjelasan dari dokter/
                                            perawat dan mengerti kemungkinan- kemungkinan bahaya serta resiko yang akan
                                            timbul apabila menghentikan perawatan (pulang paksa) terhadap pasien yang belum
                                            sembuh dari penyakitnya.
                                        </li>
                                        <li>
                                            Memahami dengan dengan sesungguhnya bahwa pembiayaan perawatan mengikuti
                                            ketentuan BPJS Kesehatan tentang pulang APS termasuk tidak dijamin apabila
                                            dirawat kembali.
                                        </li>
                                    </ol>
                                </div>

                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal" style="min-width: 200px;">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('Y-m-d', strtotime($paps->tanggal)) }}" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam" style="min-width: 200px;">Jam</label>
                                        <input type="time" name="jam" id="jam" class="form-control time"
                                            value="{{ date('H:i', strtotime($paps->jam)) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kd_dokter" style="min-width: 200px;">DPJP</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}" @selected($dok->kd_dokter == $paps->kd_dokter)>
                                                    {{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="alasan" style="min-width: 200px;">Alasan Menghentikan
                                            Perawatan</label>
                                        <textarea name="alasan" id="alasan" class="form-control" required>{{ $paps->alasan }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="status_keluarga" style="min-width: 200px;">Status Pasien dgn
                                            Keluarga</label>
                                        <select name="status_keluarga" id="status_keluarga" class="form-select" required>
                                            <option value="">--Pilih--</option>
                                            <option value="1" @selected($paps->status_keluarga == 1)>Diri sendiri</option>
                                            <option value="2" @selected($paps->status_keluarga == 2)>Istri</option>
                                            <option value="3" @selected($paps->status_keluarga == 3)>Suami</option>
                                            <option value="4" @selected($paps->status_keluarga == 4)>Anak</option>
                                            <option value="5" @selected($paps->status_keluarga == 5)>Ayah</option>
                                            <option value="6" @selected($paps->status_keluarga == 6)>Ibu</option>
                                            <option value="7" @selected($paps->status_keluarga == 7)>Lain-lain</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- IDENTITAS KELUARGA --}}
                                <div class="section-separator" id="identitas-keluarga">
                                    <h4 class="fw-semibold">IDENTITAS KELUARGA</h4>

                                    <div class="form-group">
                                        <label for="keluarga_nama" style="min-width: 200px;">Nama</label>
                                        <input type="text" name="keluarga_nama" id="keluarga_nama" class="form-control"
                                            value="{{ $paps->keluarga_nama }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_usia" style="min-width: 200px;">Usia</label>
                                        <input type="number" name="keluarga_usia" id="keluarga_usia" class="form-control"
                                            value="{{ $paps->keluarga_usia }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_jenis_kelamin" style="min-width: 200px;">Jenis
                                            Kelamin</label>
                                        <select name="keluarga_jenis_kelamin" id="keluarga_jenis_kelamin"
                                            class="form-select" required>
                                            <option value="">--Pilih--</option>
                                            <option value="0" @selected($paps->keluarga_jenis_kelamin == 0)>Perempuan</option>
                                            <option value="1" @selected($paps->keluarga_jenis_kelamin == 1)>Laki-Laki</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_alamat" style="min-width: 200px;">Alamat</label>
                                        <textarea name="keluarga_alamat" id="keluarga_alamat" class="form-control" required>{{ $paps->keluarga_alamat }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_ktp" style="min-width: 200px;">No. KTP</label>
                                        <input type="number" name="keluarga_ktp" id="keluarga_ktp" class="form-control"
                                            value="{{ $paps->keluarga_ktp }}" required>
                                    </div>
                                </div>

                                {{-- DIANOSIS --}}
                                <div class="section-separator">
                                    <h4 class="fw-semibold">DIAGNOSIS</h4>

                                    <div id="diagnose-wrap">
                                        @foreach ($paps->detail as $detail)
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="min-width: 200px;">Diagnosis</label>
                                                        <input type="text" name="diagnosis[]" class="form-control"
                                                            value="{{ $detail->diagnosis }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="min-width: 200px;">Risiko</label>
                                                        <input type="text" name="risiko[]" class="form-control"
                                                            value="{{ $detail->risiko }}" required>
                                                    </div>
                                                    <div class="btn-delete-wrap text-end">
                                                        @if ($loop->iteration > 1)
                                                            <button type="button" class="btn btn-sm btn-danger mt-2">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-sm btn-success" id="btn-add-diagnosis">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- SAKSI --}}
                                <div class="section-separator">
                                    <h4 class="fw-semibold">SAKSI</h4>

                                    <div class="form-group">
                                        <label for="saksi_1" style="min-width: 200px;">Nama Saksi 1</label>
                                        <input type="text" name="saksi_1" id="saksi_1" class="form-control"
                                            value="{{ $paps->saksi_1 }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="saksi_2" style="min-width: 200px;">Nama Saksi 2</label>
                                        <input type="text" name="saksi_2" id="saksi_2" class="form-control"
                                            value="{{ $paps->saksi_2 }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
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
            let statusKlg = {{ $paps->status_keluarga }}

            if (statusKlg == 1) {
                $('#identitas-keluarga').hide();
                $('#identitas-keluarga input,select,textarea').prop('required', false);
            }
        });

        $('#btn-add-diagnosis').on('click', function() {
            // Clone the original card row
            var $originalRow = $('#diagnose-wrap .row:first-of-type');
            var $newRow = $originalRow.clone();

            // Add delete button to the cloned card
            var $deleteBtn = $(
                '<button type="button" class="btn btn-sm btn-danger mt-2"><i class="fa-solid fa-trash"></i></button>'
            );

            $newRow.find('.btn-delete-wrap').append($deleteBtn);

            // Add click event to delete button
            $deleteBtn.on('click', function() {
                $(this).closest('.row').remove();
            });

            // Reset form values in the cloned card
            $newRow.find('input').each(function() {
                $(this).val('');
            });

            // Insert the cloned row after the original row
            // $newRow.append($originalRow);
            $('#diagnose-wrap').append($newRow);
        });

        $('#status_keluarga').change(function() {
            let nilai = $(this).val();

            if (nilai == 1) {
                $('#identitas-keluarga').hide();
                $('#identitas-keluarga input,select,textarea').prop('required', false);
            } else {
                $('#identitas-keluarga').show();
                $('#identitas-keluarga input,select,textarea').prop('required', true);
            }
        });

        $('.btn-delete-wrap button').click(function() {
            $(this).closest('.row').remove();
        });
    </script>
@endpush
