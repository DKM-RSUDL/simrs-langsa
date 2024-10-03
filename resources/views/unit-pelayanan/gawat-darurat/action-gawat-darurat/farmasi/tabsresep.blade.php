{{-- resources/views/tabs/resep.blade.php --}}

<div>
    {{-- Filter Tabel: Episode, Tanggal Pemberian Obat, Radio Button, dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center m-3 flex-wrap">

        <!-- Wrapper untuk Tanggal dan Radio Button di Sebelah Kiri -->
        <div class="d-flex align-items-center flex-wrap">
            <!-- Tanggal Pemberian Obat -->
            <div class="mb-2 me-3">
                <label class="form-label">Tgl</label>
            </div>

            <!-- Radio Button untuk status obat -->
            <div class="d-flex align-items-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="status_obat" id="diberikan_obat" value="diberikan"
                        checked>
                    <label class="form-check-label" for="diberikan_obat">
                        Diberikan Obat -tes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status_obat" id="tidak_diberikan_obat"
                        value="tidak_diberikan">
                    <label class="form-check-label" for="tidak_diberikan_obat">
                        Tidak Diberikan Obat
                    </label>
                </div>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan diisi melalui JavaScript -->
            </tbody>
        </table>
    </div>
    <div id="pesanKosong" class="alert alert-info d-none">Tidak ada data resep obat.</div>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.modalresep')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabelResep = document.getElementById('tabelResep');
    const pesanKosong = document.getElementById('pesanKosong');
    
    function updateTabelVisibility() {
        if (tabelResep.getElementsByTagName('tr').length <= 1) {
            tabelResep.classList.add('d-none');
            pesanKosong.classList.remove('d-none');
        } else {
            tabelResep.classList.remove('d-none');
            pesanKosong.classList.add('d-none');
        }
    }

    // Panggil fungsi ini setelah memuat data atau menambah/menghapus baris
    updateTabelVisibility();
});
</script>
