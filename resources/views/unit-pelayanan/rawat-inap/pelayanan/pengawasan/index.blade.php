@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .badge-filled {
            background-color: #28a745;
            color: white;
        }
        .badge-empty {
            background-color: #dc3545;
            color: white;
        }
        .table th {
            background-color: #f8f9fa;
            font-size: 0.85rem;
        }
        .table td {
            font-size: 0.85rem;
        }
        .btn-sm-icon {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
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
                                <a href="#" class="nav-link active" aria-selected="true">Pengawasan Perinatology</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#printModal">
                                        <i class="ti-printer"></i> Print
                                    </button>
                                    <a href="{{ route('rawat-inap.pengawasan-perinatology.create-pengawasan-perinatology', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center">No</th>
                                                    <th rowspan="2" class="text-center">Tanggal/Jam</th>
                                                    <th colspan="3" class="text-center">Informasi Pasien</th>
                                                    <th colspan="5" class="text-center">Observasi</th>
                                                    <th colspan="8" class="text-center">Ventilasi</th>
                                                    <th rowspan="2" class="text-center">Aksi</th>
                                                </tr>
                                                <tr>
                                                    <!-- Informasi Pasien -->
                                                    <th class="text-center">BBL</th>
                                                    <th class="text-center">BBS</th>
                                                    <th class="text-center">Gestasi</th>
                                                    <!-- Observasi -->
                                                    <th class="text-center">Kesadaran</th>
                                                    <th class="text-center">TD/CRT</th>
                                                    <th class="text-center">Nadi</th>
                                                    <th class="text-center">Nafas</th>
                                                    <th class="text-center">Suhu</th>
                                                    <!-- Ventilasi -->
                                                    <th class="text-center">Modus</th>
                                                    <th class="text-center">PEP</th>
                                                    <th class="text-center">Bubble</th>
                                                    <th class="text-center">FI O2</th>
                                                    <th class="text-center">Flow</th>
                                                    <th class="text-center">SPO2</th>
                                                    <th class="text-center">AIR</th>
                                                    <th class="text-center">Suhu Ventilator</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($perinatologyData as $index => $data)
                                                    @php
                                                        $detail = $data->detail ?? null;
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td class="text-center">
                                                            <div>{{ date('d/m/Y', strtotime($data->tgl_implementasi)) }}</div>
                                                            <div class="text-muted">{{ date('H:i', strtotime($data->jam_implementasi)) }}</div>
                                                        </td>
                                                        
                                                        <!-- Informasi Pasien -->
                                                        <td class="text-center">{{ $data->bbl_formatted ?? '-' }}<small class="text-muted"> gr</small></td>
                                                        <td class="text-center">{{ $data->bbs_formatted ?? '-' }}<small class="text-muted"> gr</small></td>
                                                        <td class="text-center">{{ $data->gestasi ?? '-' }}<small class="text-muted"> mgg</small></td>
                                                        
                                                        <!-- Observasi -->
                                                        <td class="text-center">{{ $detail->kesadaran ?? '-' }}</td>
                                                        <td class="text-center">{{ $detail->td_crt ?? '-' }}</td>
                                                        <td class="text-center">{{ $detail->nadi ?? '-' }}<small class="text-muted"> x/mnt</small></td>
                                                        <td class="text-center">{{ $detail->nafas ?? '-' }}<small class="text-muted"> x/mnt</small></td>
                                                        <td class="text-center">{{ $detail->suhu_formatted ?? '-' }}<small class="text-muted"> °C</small></td>
                                                        
                                                        <!-- Ventilasi -->
                                                        <td class="text-center">{{ $detail->modus ?? '-' }}</td>
                                                        <td class="text-center">{{ $detail->pep_formatted ?? '-' }}<small class="text-muted"> cmH2O</small></td>
                                                        <td class="text-center">{{ $detail->bubble ?? '-' }}</td>
                                                        <td class="text-center">{{ $detail->fi_o2_formatted ?? '-' }}<small class="text-muted"> %</small></td>
                                                        <td class="text-center">{{ $detail->flow_formatted ?? '-' }}<small class="text-muted"> L/mnt</small></td>
                                                        <td class="text-center">{{ $detail->spo2 ?? '-' }}<small class="text-muted"> %</small></td>
                                                        <td class="text-center">{{ $detail->air ?? '-' }}</td>
                                                        <td class="text-center">{{ $detail->suhu_ventilator_formatted ?? '-' }}<small class="text-muted"> °C</small></td>
                                                        
                                                        <!-- Aksi -->
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.pengawasan-perinatology.edit-pengawasan-perinatology', [
                                                                    $data->kd_unit, 
                                                                    $data->kd_pasien, 
                                                                    date('Y-m-d', strtotime($data->tgl_masuk)), 
                                                                    $data->urut_masuk,
                                                                    $data->id
                                                                ]) }}" 
                                                                   class="btn btn-warning btn-sm-icon" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <button type="button" 
                                                                        class="btn btn-danger btn-sm-icon" 
                                                                        onclick="confirmDelete({{ $data->id }})" 
                                                                        title="Hapus">
                                                                    <i class="ti-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="19" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="ti-info-alt"></i> Belum ada data pengawasan perinatology
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
@endsection

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">
                    <i class="ti-printer"></i> Print Pengawasan Perinatology
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rawat-inap.pengawasan-perinatology.print-pengawasan-perinatology', [
                $dataMedis->kd_unit, 
                $dataMedis->kd_pasien, 
                date('Y-m-d', strtotime($dataMedis->tgl_masuk)), 
                $dataMedis->urut_masuk
            ]) }}" method="GET" target="_blank" id="printForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                       value="{{ $minDate ? date('Y-m-d', strtotime($minDate)) : '' }}"
                                       min="{{ $minDate ? date('Y-m-d', strtotime($minDate)) : '' }}"
                                       max="{{ $maxDate ? date('Y-m-d', strtotime($maxDate)) : '' }}"
                                       {{ $perinatologyData->count() == 0 ? 'readonly' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                       value="{{ $maxDate ? date('Y-m-d', strtotime($maxDate)) : '' }}"
                                       min="{{ $minDate ? date('Y-m-d', strtotime($minDate)) : '' }}"
                                       max="{{ $maxDate ? date('Y-m-d', strtotime($maxDate)) : '' }}"
                                       {{ $perinatologyData->count() == 0 ? 'readonly' : '' }}>
                            </div>
                        </div>
                    </div>
                    
                    @if($perinatologyData->count() > 0)
                        <div class="alert alert-info">
                            <i class="ti-info-alt"></i> Pilih rentang waktu untuk data yang akan dicetak. 
                            <br><small>Data tersedia dari {{ date('d/m/Y', strtotime($minDate)) }} sampai {{ date('d/m/Y', strtotime($maxDate)) }}</small>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="ti-info-alt"></i> Belum ada data pengawasan perinatology untuk dicetak.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" {{ $perinatologyData->count() == 0 ? 'disabled' : '' }}>
                        <i class="ti-printer"></i> Print
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this data?')) {
                // Create form and submit for deletion
                const form = document.createElement('form');
                form.method = 'POST';
                
                // Gunakan route helper Laravel dengan parameter yang benar
                const baseUrl = '{{ route("rawat-inap.pengawasan-perinatology.destroy-pengawasan-perinatology", [
                    $dataMedis->kd_unit, 
                    $dataMedis->kd_pasien, 
                    date("Y-m-d", strtotime($dataMedis->tgl_masuk)), 
                    $dataMedis->urut_masuk,
                    ":id"
                ]) }}';
                
                form.action = baseUrl.replace(':id', id);
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add DELETE method
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush