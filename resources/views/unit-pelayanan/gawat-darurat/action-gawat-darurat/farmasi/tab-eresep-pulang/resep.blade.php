<div class="d-flex flex-column gap-4">
    @include('components.page-header', [
        'title' => 'Daftar Resep Pulang',
        'description' => 'Daftar data resep pulang pasien gawat darurat.',
    ])

    <div class="text-end">
        <a href="{{ route('farmasi.order-obat-e-resep-pulang', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}"
            class="btn btn-primary" aria-label="Tambah Resep Baru">
            <i class="ti-plus"></i> Tambah
        </a>
    </div>

    {{-- Tabel E-Resep Obat Pulang --}}
    <div class="table-responsive">
        <table class="table table-bordered" id="tabelResepPulang">
            <thead>
                <tr>
                    <th>#Order</th>
                    <th>Tanggal Order</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frekuensi</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Ket. Tambahan</th>
                    <th>Dokter</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatObatHariIniPulang as $resep)
                    @php
                        $cara_pakai_parts = explode(',', $resep->cara_pakai);
                        $frekuensi = trim($cara_pakai_parts[0] ?? '');
                        $keterangan = trim($cara_pakai_parts[1] ?? '');

                        switch ($resep->status) {
                            case 0:
                                $statusText = 'Menunggu';
                                $statusIcon = '<i class="bi bi-hourglass text-warning"></i>';
                                $statusClass = 'text-warning';
                                break;
                            case 1:
                                $statusText = 'Sedang diracik';
                                $statusIcon = '<i class="bi bi-gear-fill text-primary"></i>';
                                $statusClass = 'text-primary';
                                break;
                            case 2:
                                $statusText = 'Selesai diracik';
                                $statusIcon = '<i class="bi bi-check-circle text-success"></i>';
                                $statusClass = 'text-success';
                                break;
                            case 3:
                                $statusText = 'Sudah diambil';
                                $statusIcon = '<i class="bi bi-bag-check-fill text-info"></i>';
                                $statusClass = 'text-info';
                                break;
                            case 99:
                                $statusText = 'Resep dibatalkan';
                                $statusIcon = '<i class="bi bi-x-circle text-danger"></i>';
                                $statusClass = 'text-danger';
                                break;
                            default:
                                $statusText = 'Status tidak diketahui';
                                $statusIcon = '<i class="bi bi-question-circle text-secondary"></i>';
                                $statusClass = 'text-secondary';
                        }
                    @endphp

                    <tr>
                        <td>{{ (int) $resep->id_mrresep }}</td>
                        <td>{{ \Carbon\Carbon::parse($resep->tgl_order)->format('d-m-Y H:i') }}</td>
                        <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                        <td>{{ $resep->jumlah_takaran }} {{ Str::title($resep->satuan_takaran) }}</td>
                        <td>{{ $frekuensi }}</td>
                        <td>{{ (int) $resep->jumlah ?? 'Tidak ada informasi' }}</td>
                        <td>{{ $keterangan }}</td>
                        <td>{{ $resep->ket }}</td>
                        <td>{{ $resep->nama_dokter }}</td>
                        <td class="{{ $statusClass }}">
                            {!! $statusIcon !!} {{ $statusText }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data resep pulang untuk hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
