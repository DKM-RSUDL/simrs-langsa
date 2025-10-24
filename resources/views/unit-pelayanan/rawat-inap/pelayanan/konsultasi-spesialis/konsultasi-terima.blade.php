@component(
        'unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.container',
        [
                'active' => 2,
                'dataMedis' => $dataMedis,
                'kd_unit' => $dataMedis->kd_unit,
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => $dataMedis->tgl_masuk,
                'urut_masuk' => $dataMedis->urut_masuk,
                'isTerima' => $isTerima,
                'firstFrame' => false
        ]
)

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
                        <p class="m-0">{{$item->respon_konsul}}</p>
                </td>
                <td class="d-flex justify-content-center align-items-center" colspan="{{ $item->status == 1 ? 3 : 0 }}">
                        @php
                                $status = null;
                                $style = null;

                                switch ($item->status) {
                                        case 0:
                                                $status = 'Diterima';
                                                $style = 'bg-info';
                                                break;

                                        case 1:
                                                $status = 'Dijawab';
                                                $style = 'bg-success';
                                                break;

                                        default:
                                                $status = 'Tidak Diketahui';
                                                $style = 'bg-secondary';
                                                break;
                                }
                        @endphp
                        <span class="badge {{ $style }}">{{ $status }}</span>
                </td>

                {{-- Jika status Dikirim, tampilkan tombol Edit dan Hapus --}}
                <td>
                        <div class="d-flex gap-2 justify-content-center" role="group">
                                <form
                                        action="{{ route('rawat-inap.konsultasi-spesialis.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, 'id' => $item->id]) }}">
                                        @method('get')
                                        <button class="btn btn-sm btn-warning btn-edit-konsultasi" data-id="{{ $item->id }}"
                                                title="Edit" name="category" value="Terima">
                                                <i class="bi bi-pencil-square"></i>
                                        </button>
                                </form>
                        </div>
                </td>

        </tr>
@endforeach


@push('js')
        <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush

@endcomponent