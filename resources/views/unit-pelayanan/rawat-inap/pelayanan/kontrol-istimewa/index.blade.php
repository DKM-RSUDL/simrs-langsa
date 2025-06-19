@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        
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
                        <ul class="nav nav-tabs" id="kontrolTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="kontrol-15-tab" data-bs-toggle="tab" 
                                        data-bs-target="#kontrol-15" type="button" role="tab" 
                                        aria-controls="kontrol-15" aria-selected="true">
                                    Kontrol Istimewa per 15 Menit
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="kontrol-jam-tab" data-bs-toggle="tab" 
                                        data-bs-target="#kontrol-jam" type="button" role="tab" 
                                        aria-controls="kontrol-jam" aria-selected="false">
                                    Kontrol Istimewa per Jam
                                </button>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="kontrolTabContent">
                            {{-- TAB 1: Kontrol Istimewa per 15 Menit --}}
                            <div class="tab-pane fade show active" id="kontrol-15" role="tabpanel" 
                                 aria-labelledby="kontrol-15-tab">
                                
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-info me-3" data-bs-toggle="modal" data-bs-target="#printModal15">
                                        <i class="fa fa-print"></i>
                                        Print
                                    </button>

                                    <a href="{{ route('rawat-inap.kontrol-istimewa.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle" style="vertical-align: middle;">
                                                    <th width="100px" rowspan="2">NO</th>
                                                    <th rowspan="2">WAKTU</th>
                                                    <th rowspan="2">PETUGAS</th>
                                                    <th rowspan="2">NADI</th>
                                                    <th rowspan="2">NAFAS</th>
                                                    <th colspan="2">TEK. DARAH</th>
                                                    <th rowspan="2">AKSI</th>
                                                </tr>
                                                <tr align="middle">
                                                    <th>Sistole</th>
                                                    <th>Diastole</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($kontrol as $item)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i', strtotime($item->jam)) }}
                                                            WIB
                                                        </td>
                                                        <td>{{ $item->userCreate->karyawan->gelar_depan . ' ' . str()->title($item->userCreate->karyawan->nama) . ' ' . $item->userCreate->karyawan->gelar_belakang }}
                                                        </td>
                                                        <td>{{ $item->nadi }}</td>
                                                        <td>{{ $item->nafas }}</td>
                                                        <td>{{ $item->sistole }}</td>
                                                        <td>{{ $item->diastole }}</td>
                                                        <td align="middle">
                                                            <a href="{{ route('rawat-inap.kontrol-istimewa.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                                class="btn btn-sm btn-warning mx-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-delete"
                                                                data-bs-target="#deleteModal15"
                                                                data-kontrol="{{ encrypt($item->id) }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-clock fa-3x mb-3"></i>
                                                                <h5>Belum ada data kontrol istimewa per 15 menit</h5>
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

                            {{-- TAB 2: Kontrol Istimewa per Jam --}}
                            <div class="tab-pane fade" id="kontrol-jam" role="tabpanel" 
                                 aria-labelledby="kontrol-jam-tab">
                                
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-info me-3" data-bs-toggle="modal" data-bs-target="#printModalJam">
                                        <i class="fa fa-print"></i>
                                        Print
                                    </button>

                                    <a href="{{ route('rawat-inap.kontrol-istimewa-jam.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-success">
                                                <tr align="middle" style="vertical-align: middle;">
                                                    <th width="50px" rowspan="3">NO</th>
                                                    <th rowspan="3">WAKTU</th>
                                                    <th rowspan="3">PETUGAS</th>
                                                    <th colspan="4">TANDA VITAL</th>
                                                    <th colspan="4">INPUT & OUTPUT</th>
                                                    <th rowspan="3">KETERANGAN</th>
                                                    <th rowspan="3">AKSI</th>
                                                </tr>
                                                <tr align="middle">
                                                    <th rowspan="2">NADI</th>
                                                    <th rowspan="2">NAFAS</th>
                                                    <th colspan="2">TEK. DARAH</th>
                                                    <th rowspan="2">ORAL</th>
                                                    <th rowspan="2">IV</th>
                                                    <th rowspan="2">DIUROSIS</th>
                                                    <th rowspan="2">MUNTAH</th>
                                                </tr>
                                                <tr align="middle">
                                                    <th>Sistole</th>
                                                    <th>Diastole</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($kontrolJam ?? [] as $item)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i', strtotime($item->jam)) }}
                                                            WIB
                                                        </td>
                                                        <td>{{ $item->userCreate->karyawan->gelar_depan . ' ' . str()->title($item->userCreate->karyawan->nama) . ' ' . $item->userCreate->karyawan->gelar_belakang }}
                                                        </td>
                                                        <td>{{ $item->nadi ?? '-' }}</td>
                                                        <td>{{ $item->nafas ?? '-' }}</td>
                                                        <td>{{ $item->sistole ?? '-' }}</td>
                                                        <td>{{ $item->diastole ?? '-' }}</td>
                                                        <td>{{ $item->pemberian_oral ?? '-' }}</td>
                                                        <td>{{ $item->cairan_intra_vena ?? '-' }}</td>
                                                        <td>{{ $item->diurosis ?? '-' }}</td>
                                                        <td>{{ $item->muntah ?? '-' }}</td>
                                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                                        <td align="middle">
                                                            <a href="{{ route('rawat-inap.kontrol-istimewa-jam.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                                class="btn btn-sm btn-warning mx-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-delete-jam"
                                                                data-bs-target="#deleteModalJam"
                                                                data-kontrol="{{ encrypt($item->id) }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="12" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-hourglass fa-3x mb-3"></i>
                                                                <h5>Belum ada data kontrol istimewa per jam</h5>
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

    {{-- Modal Delete per 15 Menit --}}
    <div class="modal fade" id="deleteModal15" tabindex="-1" aria-labelledby="deleteModal15Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModal15Label">Hapus Kontrol Istimewa per 15 Menit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rawat-inap.kontrol-istimewa.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input type="hidden" id="id_kontrol_15" name="id_kontrol">
                        <p>Apakah anda yakin ingin menghapus data kontrol istimewa per 15 menit? Data yang telah dihapus tidak dapat dikembalikan</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete per Jam --}}
    <div class="modal fade" id="deleteModalJam" tabindex="-1" aria-labelledby="deleteModalJamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalJamLabel">Hapus Kontrol Istimewa per Jam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rawat-inap.kontrol-istimewa-jam.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input type="hidden" id="id_kontrol_jam" name="id_kontrol">
                        <p>Apakah anda yakin ingin menghapus data kontrol istimewa per jam? Data yang telah dihapus tidak dapat dikembalikan</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Print per 15 Menit --}}
    <div class="modal fade" id="printModal15" tabindex="-1" aria-labelledby="printModal15Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="printModal15Label">Print Kontrol Istimewa per 15 Menit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rawat-inap.kontrol-istimewa.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="post" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tgl_print_15">Tanggal</label>
                            <input type="text" name="tgl_print" id="tgl_print_15" class="form-control date" required readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Print per Jam --}}
    <div class="modal fade" id="printModalJam" tabindex="-1" aria-labelledby="printModalJamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="printModalJamLabel">Print Kontrol Istimewa per Jam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rawat-inap.kontrol-istimewa-jam.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="post" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tgl_print_jam">Tanggal</label>
                            <input type="text" name="tgl_print" id="tgl_print_jam" class="form-control date" required readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Handler untuk delete per 15 menit
        $('.btn-delete').click(function() {
            let $this = $(this);
            let id = $this.attr('data-kontrol');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_kontrol_15').val(id);
            $(target).modal('show');
        });

        // Handler untuk delete per jam
        $('.btn-delete-jam').click(function() {
            let $this = $(this);
            let id = $this.attr('data-kontrol');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_kontrol_jam').val(id);
            $(target).modal('show');
        });

        // Keep active tab after page refresh
        $(document).ready(function() {
            if (localStorage.getItem('activeKontrolTab')) {
                $('#' + localStorage.getItem('activeKontrolTab')).click();
            }
        });

        // Save active tab to localStorage
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('activeKontrolTab', e.target.id);
        });
    </script>
@endpush