@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.hemodialisa.component.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Data Berat Badan Kering Pasien Hemodialisis</h4>
                            <a href="{{ route('hemodialisa.pelayanan.berat-badan-kering.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-primary">
                                <i class="ti-plus"></i> Tambah Data
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Tabel Data -->
                        @if ($beratBadanKeringData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Mulai HD</th>
                                            <th>BBK (Kg)</th>
                                            <th>BB Aktual (Kg)</th>
                                            <th>TB (cm)</th>
                                            <th>IMT</th>
                                            <th>Selisih BBK</th>
                                            <th>Status IMT</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($beratBadanKeringData as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{ $data->nama_bulan }} {{ $data->tahun }}
                                                    </span>
                                                </td>
                                                <td>{{ $data->mulai_hd ? $data->mulai_hd->format('d/m/Y') : '-' }}</td>
                                                <td>{{ $data->bbk }}</td>
                                                <td>{{ $data->berat_badan }}</td>
                                                <td>{{ $data->tinggi_badan }}</td>
                                                <td>{{ $data->imt }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $data->warna_selisih }}">
                                                        {{ $data->selisih_bbk > 0 ? '+' : '' }}{{ $data->selisih_bbk }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $data->warna_imt }}">
                                                        {{ $data->status_imt }}
                                                    </span>
                                                </td>
                                                <td>{{ $data->catatan ? Str::limit($data->catatan, 30) : '-' }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-info"
                                                            onclick="showDetail({{ $data->id }})" title="Detail">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="editData({{ $data->id }})" title="Edit">
                                                            <i class="ti-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete({{ $data->id }})" title="Hapus">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="ti-clipboard" style="font-size: 4rem; color: #ccc;"></i>
                                <h5 class="mt-3">Belum Ada Data</h5>
                                <p class="text-muted">Belum ada data berat badan kering untuk pasien ini.</p>
                                <a href="{{ route('hemodialisa.pelayanan.berat-badan-kering.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="ti-plus"></i> Tambah Data Pertama
                                </a>
                            </div>
                        @endif

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body" id="detailContent">
                                        <!-- Content loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Delete -->
                        <form id="deleteForm" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function showDetail(id) {
            // Simple detail display
            const data = @json($beratBadanKeringData);
            const item = data.find(d => d.id == id);

            if (item) {
                // Menangani nilai undefined/null untuk nama_bulan
                const periode = (item.nama_bulan || 'Bulan tidak tersedia') + ' ' + (item.tahun || '');

                // Menangani format tanggal mulai_hd
                let mulaiHd = '-';
                if (item.mulai_hd) {
                    // Jika mulai_hd adalah object dengan properti date
                    if (typeof item.mulai_hd === 'object' && item.mulai_hd.date) {
                        const date = new Date(item.mulai_hd.date);
                        mulaiHd = date.toLocaleDateString('id-ID');
                    }
                    // Jika mulai_hd adalah string tanggal
                    else if (typeof item.mulai_hd === 'string') {
                        const date = new Date(item.mulai_hd);
                        mulaiHd = date.toLocaleDateString('id-ID');
                    }
                    // Jika sudah dalam format yang diinginkan
                    else {
                        mulaiHd = item.mulai_hd;
                    }
                }

                document.getElementById('detailContent').innerHTML = `
            <table class="table table-bordered">
                <tr><td><strong>Periode</strong></td><td>${periode}</td></tr>
                <tr><td><strong>Mulai HD</strong></td><td>${mulaiHd}</td></tr>
                <tr><td><strong>BBK</strong></td><td>${item.bbk || '-'} Kg</td></tr>
                <tr><td><strong>Berat Badan</strong></td><td>${item.berat_badan || '-'} Kg</td></tr>
                <tr><td><strong>Tinggi Badan</strong></td><td>${item.tinggi_badan || '-'} cm</td></tr>
                <tr><td><strong>IMT</strong></td><td>${item.imt || '-'} ${item.status_imt ? '(' + item.status_imt + ')' : ''}</td></tr>
                <tr><td><strong>Selisih BBK</strong></td><td>${item.selisih_bbk !== undefined && item.selisih_bbk !== null ? (item.selisih_bbk > 0 ? '+' : '') + item.selisih_bbk + ' Kg' : '-'}</td></tr>
                <tr><td><strong>Catatan</strong></td><td>${item.catatan || '-'}</td></tr>
            </table>
        `;
                new bootstrap.Modal(document.getElementById('detailModal')).show();
            }
        }

        function editData(id) {
            // Redirect ke halaman edit
            window.location.href = `{{ route('hemodialisa.pelayanan.berat-badan-kering.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}/${id}/edit`;
        }

        function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('hemodialisa.pelayanan.berat-badan-kering.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}/${id}`;
            form.submit();
        }
    }

        // Auto dismiss alerts
        setTimeout(function() {
            document.querySelectorAll('.alert .btn-close').forEach(btn => btn.click());
        }, 3000);
    </script>
@endpush
