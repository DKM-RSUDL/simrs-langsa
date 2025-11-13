@component('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.container', [
    'active' => 1,
    'dataMedis' => $dataMedis,
    'kd_unit' => $dataMedis->kd_unit,
    'kd_pasien' => $dataMedis->kd_pasien,
    'tgl_masuk' => $dataMedis->tgl_masuk,
    'urut_masuk' => $dataMedis->urut_masuk,
    'isTerima' => $isTerima,
    'firstFrame' => true,
])


    @foreach ($dataKonsul as $item)
        <tr>
            <td>{{ $item->tanggal_konsul }}<br><small
                    class="text-muted">{{ date('H:i', strtotime($item->jam_konsul)) }}</small>
            </td>
            <td>{{ $item->dokterPengirim->nama }}<br></td>
            {{-- <td>{{ $item->spesialis->konsul }}</td> --}}
            <td>
                <p class="m-0">{!!  $item->konsul  !!}</p>
            </td>
            <td>
                <p class="m-0">{!!  $item->catatan  !!}</p>
            </td>
            <td>
                <p class="m-0">{{ $item->respon_konsul }}</p>
            </td>
            <td class="d-flex justify-content-center align-items-center" colspan="{{ $item->status == 1 ? 3 : 0 }}">
                @php
                    $status = null;
                    $style = null;

                    switch ($item->status) {
                        case 0:
                            $status = 'Dikirim';
                            $style = 'bg-info';
                            break;

                        case 1:
                            $status = 'Diterima';
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
                @if ($item->status == 0)
                    <div class="d-flex gap-2 justify-content-center" role="group">
                        <button class="btn btn-sm btn-warning btn-edit-konsultasi" data-id="{{ $item->id }}"
                            title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <form
                            action="{{ route('rawat-inap.konsultasi-spesialis.delete', [
                                $dataMedis->kd_unit,
                                $dataMedis->kd_pasien,
                                $dataMedis->tgl_masuk,
                                $dataMedis->urut_masuk,
                                'id' => $item->id,
                            ]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger" data-confirm
                                data-confirm-title="Anda yakin?"
                                data-confirm-text="Data yang dihapus tidak dapat dikembalikan" title="Hapus Konsultasi"
                                aria-label="Hapus Konsultasi">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </td>
        </tr>
    @endforeach

    @php
        $konsulData = $konsulIGD ?? [];
    @endphp

    @foreach ($konsulData as $konsul)
        <tr>
            <td>
                {{ date('d M Y', strtotime($konsul->tgl_konsul)) }}
                {{ date('H:i', strtotime($konsul->jam_konsul)) }}
            </td>
            <td>{{ $konsul->dokterAsal->nama_lengkap }} (IGD)</td>
            <td>{{ $konsul->dokterTujuan->nama_lengkap }}</td>
            <td>
                <p class="fw-bold text-primary m-0">SUBJECTIVE</p>
                <p class="m-0">{{ $konsul->subjective ?? '-' }}</p>
                <br>
                <br>
                <p class="fw-bold text-primary m-0">BACKGROUND</p>
                <p class="m-0">{{ $konsul->background ?? '-' }}</p>
                <br>
                <br>
                <p class="fw-bold text-primary m-0">ASSESSMENT</p>
                <p class="m-0">{{ $konsul->assesment ?? '-' }}</p>
                <br>
                <br>
                <p class="fw-bold text-primary m-0">RECOMENDATION</p>
                <p class="m-0">{{ $konsul->recomendation ?? '-' }}</p>
            </td>
            <td>
                {!! $konsul->instruksi !!}
            </td>
            <td>
                @if (empty($konsul->instruksi))
                    <p class="text-warning fw-bold m-0 p-0" id="konsulenStatusLabel">Di kirim</p>
                @else
                    <p class="text-success fw-bold m-0 p-0" id="konsulenStatusLabel">Di jawab</p>
                @endif
            </td>
            <td>
                <x-table-action>
                    <a href="{{ route('rawat-inap.konsultasi-spesialis.igd.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($konsul->id)]) }}"
                        class="btn btn-sm btn-success btn-print-konsultasi" target="_blank">
                        <i class="fas fa-print"></i>
                    </a>
                </x-table-action>
            </td>
        </tr>
    @endforeach


    @push('js')
        <script src="{{ asset('js/helpers/confirm.js') }}"></script>
        <script>
            $(document).on('click', '.btn-edit-konsultasi', function() {
                const id = $(this).data('id');
                console.log(id);
                baseUrl =
                    "{{ route('rawat-inap.konsultasi-spesialis.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, 'id' => 'ID']) }}";
                baseUrl = baseUrl.replace('ID', id)
                location.href = baseUrl;
            })

            $(document).on('click', '.btn-delete-konsultasi', function() {
                const id = $(this).data('id');
                console.log(id);
                baseUrl =
                    "{{ route('rawat-inap.konsultasi-spesialis.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, 'id' => 'ID']) }}";
                $.ajax({
                    url: baseUrl,
                    type: 'DELETE',
                    process: () => {
                        console.log("proses delete")
                    },
                    success: () => {
                        console.log("delete Berhasil")
                    }
                })
            })
        </script>
    @endpush
@endcomponent
