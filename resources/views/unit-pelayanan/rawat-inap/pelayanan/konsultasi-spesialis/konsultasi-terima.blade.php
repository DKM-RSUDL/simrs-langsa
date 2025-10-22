@component(
        'unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.container',
        [
                'active' => 2,
                'dataMedis' => $dataMedis,
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
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

                @if ($item->status == 0)
                        {{-- Jika status Dikirim, tampilkan tombol Edit dan Hapus --}}
                        <td>
                                <div class="d-flex gap-2 justify-content-center" role="group">
                                        <button class="btn btn-sm btn-warning btn-edit-konsultasi" data-id="{{ $item->id }}"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                        </button>
                                </div>
                        </td>
                @else
                        {{-- Jika status bukan Dikirim (misalnya Diterima), tampilkan indikator bahwa aksi tidak tersedia --}}
                        <td class="text-center text-muted">
                                <em>-</em>
                        </td>
                @endif

        </tr>
@endforeach


@push('js')
        <script src="{{ asset('js/helpers/confirm.js') }}"></script>
        <script>
                $(document).on('click', '.btn-edit-konsultasi', function () {
                        const id = $(this).data('id');
                        console.log(id);
                        baseUrl = "{{ route('rawat-inap.konsultasi-spesialis.edit', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, 'id' => 'ID']) }}";
                        baseUrl = baseUrl.replace('ID', id)
                        location.href = baseUrl;
                })
        </script>
@endpush

@endcomponent