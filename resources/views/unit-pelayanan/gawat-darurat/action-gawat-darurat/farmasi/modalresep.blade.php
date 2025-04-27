<!-- Modal Tambah Resep -->
<div class="modal fade" id="tambahResep" tabindex="-1" aria-labelledby="tambahResepLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div id="modal-overlay" class="modal-overlay"></div>
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahResepLabel">Order Obat</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="resepForm"
                    action="{{ route('farmasi.store', [$dataMedis->pasien->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}"
                    method="post">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">

                            <!-- Side Column (Kiri) -->
                            <div class="col-md-3 border-right" id="sideColumn">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-pills nav-fill" id="obatTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active py-1 px-2" id="nonracikan-tab"
                                                    data-bs-toggle="tab" data-bs-target="#nonracikan" type="button"
                                                    role="tab" aria-controls="nonracikan" aria-selected="true">Non
                                                    Racikan</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-1 px-2" id="racikan-tab" data-bs-toggle="tab"
                                                    data-bs-target="#racikan" type="button" role="tab"
                                                    aria-controls="racikan" aria-selected="false">Racikan</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-1 px-2" id="paket-tab" data-bs-toggle="tab"
                                                    data-bs-target="#paket" type="button" role="tab"
                                                    aria-controls="paket" aria-selected="false">Paket</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-1 px-2" id="prognas-tab" data-bs-toggle="tab"
                                                    data-bs-target="#prognas" type="button" role="tab"
                                                    aria-controls="prognas" aria-selected="false">Prognas</button>
                                            </li>
                                        </ul>

                                        <!-- Tab content -->
                                        <div class="tab-content" id="obatTabContent">
                                            <!-- Non Racikan Tab -->
                                            <div class="tab-pane fade show active" id="nonracikan" role="tabpanel"
                                                aria-labelledby="nonracikan-tab">
                                                <div class="mb-3">
                                                    <label for="dokterPengirim" class="form-label">Dokter Pengirim</label>
                                                    <select class="form-select" id="dokterPengirim" name="kd_dokter" @cannot('is-admin') disabled @endcannot>
                                                        @foreach ($dokters as $dokter)
                                                            <option value="{{ $dokter->kd_dokter }}"
                                                                @selected($dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                                                {{ $dokter->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @cannot('is-admin')
                                                        <input type="hidden" name="kd_dokter" value="{{ auth()->user()->kd_karyawan }}">
                                                    @endcannot
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="tanggalOrder" class="form-label">Tanggal
                                                                Order</label>
                                                            <input type="date" class="form-control" id="tanggalOrder"
                                                                name="tgl_order">
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="jamOrder" class="form-label">Jam</label>
                                                            <input type="time" class="form-control" id="jamOrder"
                                                                name="jam_order">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Aturan Pakai -->
                                                <div class="mb-3 border p-3">
                                                    <div class="mb-3">
                                                        <label for="cariObat" class="form-label">Cari Nama
                                                            Obat</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="cariObat"
                                                                name="nama_obat" placeholder="Ketik nama obat...">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                id="clearObat" style="display:none;">X</button>
                                                        </div>
                                                        <input type="hidden" id="selectedObatId" name="obat_id">
                                                        <div id="obatList" class="list-group mt-2"></div>
                                                    </div>
                                                    <label class="form-label">Aturan Pakai</label>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="frekuensi"
                                                                class="form-label">Frekuensi/interval</label>
                                                            <input type="text" class="form-control" id="frekuensi" placeholder="3 x 1 hari">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="dosis" class="form-label">Dosis Sekali
                                                                Minum</label>
                                                                <input type="text" class="form-control" id="dosis" placeholder="1/2 , 1, 2">
                                                        </div>
                                                        <div class="col md-6">
                                                            <label for="satuanObat" class="form-label">Satuan
                                                                Obat</label>
                                                            <select class="form-select" id="satuanObat">
                                                                <option value="tablet">Tablet</option>
                                                                <option value="kapsul">Kapsul (caps)</option>
                                                                <option value="bungkus">Bungkus (bks)</option>
                                                                <option value="sendok_makan">Sendok makan</option>
                                                                <option value="sendok_teh">Sendok teh</option>
                                                                <option value="tetes">Tetes</option>
                                                                <option value="cc">CC</option>
                                                                <option value="olesan">Olesan</option>
                                                                <option value="taburan">Taburan</option>
                                                                <option value="semprotan">Semprotan</option>
                                                                <option value="kali">Kali</option>
                                                                <option value="ampul">Ampul</option>
                                                                <option value="unit">Unit</option>
                                                                <option value="sub">Sub</option>
                                                            </select>
                                                            <input type="text" id="hargaObat"
                                                                class="form-control d-none" readonly></input>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="jumlah" class="form-label">Jumlah</label>
                                                            <input type="number" class="form-control" id="jumlah"
                                                                value="12">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="sebelumSesudahMakan"
                                                                class="form-label">Sebelum/Sesudah
                                                                Makan</label>
                                                            <select class="form-select" id="sebelumSesudahMakan">
                                                                <option selected>Sesudah Makan</option>
                                                                <option>Sebelum Makan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="aturanTambahan" class="form-label">Aturan
                                                                tambahan</label>
                                                            <textarea class="form-control" id="aturanTambahan" name="cat_racikan"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" id="tambahObatNonRacikan"
                                                    class="btn btn-primary w-100">Tambah Obat Non Racikan</button>
                                            </div>

                                            <!-- Racikan Tab -->
                                            <div class="tab-pane fade" id="racikan" role="tabpanel"
                                                aria-labelledby="racikan-tab">
                                                <p class="text-danger">Form untuk Racikan Belum Tersedia!</p>
                                                {{-- <button type="button" id="tambahObatRacikan" class="btn btn-primary w-100">Tambah Obat Racikan</button> --}}
                                            </div>

                                            <!-- Paket Tab -->
                                            <div class="tab-pane fade" id="paket" role="tabpanel"
                                                aria-labelledby="paket-tab">
                                                <p class="text-danger">Form untuk Paket Belum Tersedia!</p>
                                                {{-- <button type="button" id="tambahObatPaket" class="btn btn-primary w-100">Tambah Obat Paket</button> --}}
                                            </div>

                                            <!-- Prognas Tab -->
                                            <div class="tab-pane fade" id="prognas" role="tabpanel"
                                                aria-labelledby="prognas-tab">
                                                <p class="text-danger">Form untuk Prognas Belum Tersedia!</p>
                                                {{-- <button type="button" id="tambahObatPrognas" class="btn btn-primary w-100">Tambah Obat Prognas</button> --}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Main Content Area (Kanan) -->
                            <div class="col-md-9">
                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab1" type="button" role="tab"
                                            aria-controls="tab1" aria-selected="true">Daftar Order Obat</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab2" type="button" role="tab"
                                            aria-controls="tab2" aria-selected="false">Riwayat Pemberian Obat</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab3-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab3" type="button" role="tab"
                                            aria-controls="tab3" aria-selected="false">Riwayat Alergi</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab4-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab4" type="button" role="tab"
                                            aria-controls="tab4" aria-selected="false">Antopometri</button>
                                    </li>
                                </ul>

                                <!-- Tabs Content -->
                                <div class="tab-content" id="myTabContent">
                                    <!-- Tab 1: Daftar Obat -->
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                        aria-labelledby="tab1-tab">
                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Jenis Obat</th>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Frek</th>
                                                    <th>Qty</th>
                                                    <th>Sebelum/Sesudah Makan</th>
                                                    <th>Ket. Tambahan</th>
                                                    <th>Harga</th>
                                                    <th>Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody id="daftarObatBody"></tbody>
                                        </table>
                                        <div>
                                            <div class="fw-bold">Jumlah Item Obat: 0 </div>
                                            <div class="fw-bold">Total Biaya Obat: Rp. ,-</div>
                                        </div>

                                        <div class="mt-4">
                                            <h5>Catatan Resep (Opsional)</h5>
                                            <div class="form-group">
                                                <textarea class="form-control" id="cat_racikan" rows="3"
                                                    placeholder="Masukkan catatan tambahan untuk resep ini..."></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Tab 2: Riwayat Pemberian Obat -->
                                    <div class="tab-pane fade" id="tab2" role="tabpanel"
                                        aria-labelledby="tab2-tab">
                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr>
                                                    <th>No Order</th>
                                                    <th>Jenis Obat</th>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Frek</th>
                                                    <th>Qty</th>
                                                    <th>Rute</th>
                                                    <th>Sebelum/Sesudah Makan</th>
                                                    <th>Ket. Tambahan</th>
                                                    <th>Dokter</th>
                                                    <th>Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($riwayatObat as $resep)
                                                    @php
                                                        $cara_pakai_parts = explode(',', $resep->cara_pakai);
                                                        $frekuensi = trim($cara_pakai_parts[0] ?? '');
                                                        $keterangan = trim($cara_pakai_parts[1] ?? '');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ (int) $resep->id_mrresep }}</td>
                                                        <td>Jenis Obat</td>
                                                        <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                                                        <td>{{ $resep->jumlah_takaran }}
                                                            {{ Str::title($resep->satuan_takaran) }}</td>
                                                        <td>{{ $frekuensi }}</td>
                                                        <td>{{ (int) $resep->jumlah ?? 'Tidak ada informasi' }}</td>
                                                        <td>Rute</td>
                                                        <td>{{ $keterangan }}</td>
                                                        <td>{{ $resep->ket }}</td>
                                                        <td>{{ $resep->nama_dokter }}</td>
                                                        <td>
                                                            @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.copyobat')
                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center">Tidak ada data resep
                                                            obat.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Tab 3: Riwayat Alergi -->
                                    <div class="tab-pane fade" id="tab3" role="tabpanel"
                                        aria-labelledby="tab3-tab">
                                        <h4 class="mt-3">Riwayat Alergi</h4>
                                        <p>Informasi riwayat alergi pasien akan ditampilkan di sini.</p>
                                    </div>

                                    <!-- Tab 4: Antopometri -->
                                    <div class="tab-pane fade" id="tab4" role="tabpanel"
                                        aria-labelledby="tab4-tab">
                                        <h4 class="mt-3">Antopometri</h4>
                                        <p>Data antopometri pasien akan ditampilkan di sini.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Jumlah dan Total di Footer -->
            <div class="modal-footer justify-content-end">
                <div id="loadingIndicator" class="spinner-border text-primary me-3 d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" id="orderButton" class="btn btn-primary">Order</button>
            </div>

            </form>

        </div>
        <div id="modal-overlay" class="modal-overlay"></div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mendapatkan tanggal saat ini dalam format YYYY-MM-DD
            function getCurrentDate() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Fungsi untuk mendapatkan waktu saat ini dalam format HH:MM
            function getCurrentTime() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            // Set nilai default untuk input tanggal dan jam
            document.getElementById('tanggalOrder').value = getCurrentDate();
            document.getElementById('jamOrder').value = getCurrentTime();
        });
    </script>
@endpush
