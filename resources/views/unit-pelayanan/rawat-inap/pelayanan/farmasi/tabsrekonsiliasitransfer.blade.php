<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">
            <div class="col-md-2">
                <input type="date" name="start_date" id="startDateTransfer" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" id="endDateTransfer" class="form-control" placeholder="S.d Tanggal">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInputTransfer" class="form-control" placeholder="Cari" aria-label="Cari">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRekonsiliasiTransfer" type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.modalrekonsiliasitransfer')
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="rekonsiliasiTransferTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frekuensi</th>
                    <th>Cara Pemberian</th>
                    <th>Tindak Lanjut oleh DPJP</th>
                    <th>Perubahan Aturan Pakai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($rekonsiliasiObatTransfer->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach ($rekonsiliasiObatTransfer as $index => $obat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->dosis }}</td>
                            <td>{{ $obat->frekuensi }}</td>
                            <td>{{ $obat->keterangan }}</td>
                            <td>
                                @if ($obat->tindak_lanjut == 1)
                                    <span class="badge bg-success">Lanjut aturan pakai sama</span>
                                @elseif ($obat->tindak_lanjut == 2)
                                    <span class="badge bg-warning">Lanjut aturan pakai berubah</span>
                                @else
                                    <span class="badge bg-danger">Stop</span>
                                @endif
                            </td>
                            <td>{{ $obat->perubahanpakai ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit-rekonsiliasi-transfer me-1" 
                                    data-id="{{ $obat->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="mt-2 btn btn-sm btn-danger btn-delete-rekonsiliasi-transfer" 
                                    data-id="{{ $obat->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>