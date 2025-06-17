@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .shift-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
        }
        
        .shift-1 {
            background-color: #28a745;
            color: white;
        }
        
        .shift-2 {
            background-color: #ffc107;
            color: #212529;
        }
        
        .shift-3 {
            background-color: #6f42c1;
            color: white;
        }
        
        .balance-positive {
            color: #28a745;
            font-weight: 600;
        }
        
        .balance-negative {
            color: #dc3545;
            font-weight: 600;
        }
        
        .balance-zero {
            color: #6c757d;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-ranap')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#" class="nav-link active" aria-selected="true">Intake Output Cairan</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="{{ route('rawat-inap.intake-cairan.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-success me-2" target="_blank">
                                        <i class="fa fa-print"></i> Print
                                    </a>

                                    <a href="{{ route('rawat-inap.intake-cairan.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle">
                                                    <th width="50px">No</th>
                                                    <th>Tanggal</th>
                                                    <th>Shift</th>
                                                    <th>Intake (ml)</th>
                                                    <th>Output (ml)</th>
                                                    <th>Balance (ml)</th>
                                                    <th>Petugas</th>
                                                    <th width="120px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($intakeData as $intake)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td align="middle">{{ date('d M Y', strtotime($intake->tanggal)) }}</td>
                                                        <td align="middle">
                                                            <span class="badge shift-badge shift-{{ $intake->shift }}">
                                                                {{ $intake->shift_name }}
                                                            </span>
                                                        </td>
                                                        <td align="center">
                                                            <small class="d-block">
                                                                IUFD: {{ number_format($intake->intake_iufd ?? 0) }}<br>
                                                                Minum: {{ number_format($intake->intake_minum ?? 0) }}<br>
                                                                Makan: {{ number_format($intake->intake_makan ?? 0) }}<br>
                                                                NGT: {{ number_format($intake->intake_ngt ?? 0) }}
                                                            </small>
                                                            <strong>{{ number_format($intake->total_intake ?? 0) }}</strong>
                                                        </td>
                                                        <td align="center">
                                                            <small class="d-block">
                                                                Urine: {{ number_format($intake->output_urine ?? 0) }}<br>
                                                                Muntah: {{ number_format($intake->output_muntah ?? 0) }}<br>
                                                                Drain: {{ number_format($intake->output_drain ?? 0) }}<br>
                                                                IWL: {{ number_format($intake->output_iwl ?? 0) }}
                                                            </small>
                                                            <strong>{{ number_format($intake->total_output ?? 0) }}</strong>
                                                        </td>
                                                        <td align="center">
                                                            @php
                                                                $balance = ($intake->balance_cairan ?? 0);
                                                            @endphp
                                                            <span class="
                                                                @if($balance > 0) balance-positive
                                                                @elseif($balance < 0) balance-negative
                                                                @else balance-zero
                                                                @endif
                                                            ">
                                                                {{ $balance > 0 ? '+' : '' }}{{ number_format($balance) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="small">
                                                                {{ $intake->userCreate->karyawan->gelar_depan ?? '' }} 
                                                                {{ str()->title($intake->userCreate->karyawan->nama ?? $intake->userCreate->name ?? 'Unknown') }} 
                                                                {{ $intake->userCreate->karyawan->gelar_belakang ?? '' }}
                                                            </div>
                                                        </td>
                                                        <td align="middle">
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ route('rawat-inap.intake-cairan.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($intake->id)]) }}"
                                                                    class="btn btn-success" title="Lihat">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-inap.intake-cairan.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($intake->id)]) }}"
                                                                    class="btn btn-warning" title="Edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <button class="btn btn-danger btn-delete"
                                                                    data-bs-target="#deleteModal"
                                                                    data-intake="{{ encrypt($intake->id) }}"
                                                                    data-tanggal="{{ date('d/m/Y', strtotime($intake->tanggal)) }}"
                                                                    data-shift="{{ $intake->shift_name }}"
                                                                    title="Hapus">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-clipboard fa-3x mb-3"></i>
                                                                <h5>Belum ada data intake output cairan</h5>
                                                                <p>Klik tombol "Tambah" untuk menambah data baru</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Intake Output</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form
                    action="{{ route('rawat-inap.intake-cairan.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" id="id_intake" name="id_intake">
                        <p>Apakah anda yakin ingin menghapus data intake output cairan untuk:</p>
                        <div id="deleteInfo" class="alert alert-warning">
                            <strong>Tanggal:</strong> <span id="deleteTanggal"></span><br>
                            <strong>Shift:</strong> <span id="deleteShift"></span>
                        </div>
                        <p class="text-muted small">Data yang telah dihapus tidak dapat dikembalikan</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.btn-delete').click(function() {
            let $this = $(this);
            let id = $this.attr('data-intake');
            let tanggal = $this.attr('data-tanggal');
            let shift = $this.attr('data-shift');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_intake').val(id);
            $(target).find('#deleteTanggal').text(tanggal);
            $(target).find('#deleteShift').text(shift);
            $(target).modal('show');
        });
    </script>
@endpush