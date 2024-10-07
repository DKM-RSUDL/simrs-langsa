{{-- resources/views/tabs/resep.blade.php --}}

<div>
    {{-- Filter Tabel: Episode, Tanggal Pemberian Obat, Radio Button, dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center m-3 flex-wrap">

        <!-- Wrapper untuk Tanggal dan Radio Button di Sebelah Kiri -->
        <div class="d-flex align-items-center flex-wrap">
            <div class="mb-2 me-3">
                <label class="form-label" style="font-size: 15px; font-weight: bold;"> {{ \Carbon\Carbon::now()->translatedFormat('l, d-m-Y') }}</label>
            </div>
        </div>

        <!-- Tombol "Tambah" di Sebelah Kanan -->
        <div class="mt-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahResep" type="button" aria-label="Tambah Resep Baru">
                <i class="ti-plus"></i> Tambah
            </button>
        </div>

    </div>

    {{-- Tabel E-Resep Obat & BMHP --}}
    <div class="table-responsive">
        <table class="table table-bordered" id="tabelResep">
            <thead>
                <tr>
                    <th>#Order</th>
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
            @forelse ($riwayatObat as $resep)
                @php
                    $cara_pakai_parts = explode(',', $resep->cara_pakai);
                    $frekuensi = trim($cara_pakai_parts[0] ?? '');
                    $dosis = trim($cara_pakai_parts[1] ?? '');
                    $keterangan = trim($cara_pakai_parts[2] ?? '');

                    switch($resep->status) {
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
                    <td>{{ (int)$resep->id_mrresep }}</td>    
                    <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                    <td>{{ $dosis }}</td>
                    <td>{{ $frekuensi }}</td>
                    <td>{{ (int)$resep->jumlah ?? 'Tidak ada informasi' }}</td>
                    <td>{{ $keterangan }}</td>
                    <td>{{ $resep->ket }}</td>
                    <td>{{ $resep->nama_dokter }}</td>
                    <td class="{{ $statusClass }}">
                        {!! $statusIcon !!} {{ $statusText }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data resep obat untuk hari ini.</td>
                </tr>
            @endforelse
        </tbody>
        </table>
    </div>
    <div id="pesanKosong" class="alert alert-info d-none">Tidak ada data resep obat.</div>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.modalresep')
