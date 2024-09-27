{{-- resources/views/tabs/resep.blade.php --}}

<div>
    {{-- Filter Tabel: Episode, Tanggal Pemberian Obat, Radio Button, dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center m-3">
        
        <!-- Wrapper untuk Tanggal dan Radio Button di Sebelah Kiri -->
        <div class="d-flex align-items-center">
            <!-- Tanggal Pemberian Obat -->
            <p id="tanggal_pemberian_obat" class="mb-0 me-3">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </p>

            <!-- Radio Button untuk status obat -->
            <div class="d-flex align-items-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="status_obat" id="diberikan_obat" value="diberikan" checked>
                    <label class="form-check-label" for="diberikan_obat">
                        Diberikan Obat
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status_obat" id="tidak_diberikan_obat" value="tidak_diberikan">
                    <label class="form-check-label" for="tidak_diberikan_obat">
                        Tidak Diberikan Obat
                    </label>
                </div>
            </div>
        </div>

        <!-- Tombol "Tambah" di Sebelah Kanan -->
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailPasienModal" type="button">
                <i class="ti-plus"></i> Tambah
            </button>
        </div>

    </div>

    {{-- Tabel E-Resep Obat & BMHP --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#Order</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Frek</th>
                <th>QTY</th>
                <th>Keterangan</th>
                <th>Ket. Tambahan</th>
                <th>Dokter</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
        </tbody>
    </table>
</div>
