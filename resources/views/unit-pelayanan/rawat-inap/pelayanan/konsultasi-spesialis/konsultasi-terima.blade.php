@component(
        'unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.container',
        [
                'active' => 1,
                'dataMedis' => $dataMedis,
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'firstFrame' => true
        ]
)

<div class="px-3">
        <!-- Tabel data konsultasi -->
        <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover" id="rawatDaruratKonsultasiTable">
                        <thead class="table-primary">
                                <tr>
                                        <th width="15%">Tanggal</th>
                                        <th width="20%">Dari PPA</th>
                                        <th width="15%">Konsulen</th>
                                        <th width="25%">Konsul yang diminta</th>
                                        <th width="15%">Status Konsul</th>
                                        <th width="10%">Aksi</th>
                                </tr>
                        </thead>
                        <tbody>
                                <!-- Data Konsultasi 1 -->
                                @foreach ($dataKonsul as $item)
                                        <tr>
                                                <td>{{ $item->tanggal_konsul }}<br><small
                                                                class="text-muted">{{ date('H:i', strtotime($item->jam_konsul)) }}</small>
                                                </td>
                                                <td>{{ $item->dokterPengirim->nama }}<br></td>
                                                <td>{{ $item->spesialis->spesialisasi }}</td>
                                                <td>
                                                        <p class="m-0">{{$item->catatan}}</p>
                                                </td>
                                                <td>
                                                        <span class="badge bg-info">Dikirim</span>
                                                </td>
                                                <td>
                                                        <div class="d-flex gap-2 justify-content-center" role="group">
                                                                <button class="btn btn-sm btn-warning btn-edit-konsultasi"
                                                                        data-id="{{ $item->id }}" title="Edit">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger btn-delete-konsultasi"
                                                                        title="Hapus">
                                                                        <i class="bi bi-trash"></i>
                                                                </button>
                                                        </div>
                                                </td>
                                        </tr>
                                @endforeach
                        </tbody>
                </table>
        </div>
</div>


@push('js')
        <script>
                $(document).on('click', '.btn-edit-konsultasi', function () {
                        const id = $(this).data('id');
                        console.log(id);
                        baseUrl = "{{ route('rawat-inap.konsultasi-spesialis.edit', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk,'id'=>'ID']) }}";
                        baseUrl = baseUrl.replace('ID',id)
                        location.href = baseUrl;
                })

        </script>
@endpush

@endcomponent