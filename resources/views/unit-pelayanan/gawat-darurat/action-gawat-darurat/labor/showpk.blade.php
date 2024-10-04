<!-- Button to trigger modal -->
<button type="button" class="btn btn-sm {{ $laborPK->status == 1 ? 'btn-primary' : 'btn-info' }}" data-bs-toggle="modal"
    data-bs-target="#laborModal{{ $laborPK->kd_order }}">
    @if ($laborPK->status == 1)
        Edit
    @else
        <i class="bi bi-eye-fill"></i>
    @endif
</button>

<!-- Modal untuk setiap baris -->
<div class="modal fade" id="laborModal{{ $laborPK->kd_order }}" tabindex="-1"
    aria-labelledby="laborModalLabel{{ $laborPK->kd_order }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('labor.index', [$laborPK->kd_pasien, $laborPK->tgl_masuk]) }}" method="post">
                @csrf

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="laborModalLabel{{ $laborPK->kd_order }}">
                        Order Pemeriksaan Laboratorium Klinik - KD Order: {{ $laborPK->kd_order }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Patient and Unit Information -->
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Informasi Pasien & Unit</div>
                                <div class="card-body">
                                    <p>
                                        KD Pasien: <span class="fw-bold">{{ $laborPK->kd_pasien }}</span> <br>
                                        KD Unit: <span class="fw-bold">{{ $laborPK->kd_unit }}</span> <br>
                                        Tanggal Masuk: <span class="fw-bold">{{ \Carbon\Carbon::parse($laborPK->tgl_masuk)->format('d M Y H:i') }}</span> <br>
                                        Urut Masuk: <span class="fw-bold">{{ $laborPK->urut_masuk }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor and Examination Information -->
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Informasi Dokter & Pemeriksaan</div>
                                <div class="card-body">
                                    <p>
                                        Dokter Pengirim: <span class="fw-bold">{{ $laborPK->dokter->nama }}</span>
                                    </p>
                                    <p>
                                        Waktu Permintaan: <span class="fw-bold">{{ \Carbon\Carbon::parse($laborPK->tgl_order)->format('d M Y H:i') }}</span>
                                    </p>
                                    <p>
                                        Cyto: <span class="fw-bold">{{ $laborPK->cyto == 1 ? 'YA' : 'Tidak' }}</span><br>
                                        Puasa: <span class="fw-bold">{{ $laborPK->puasa == 1 ? 'YA' : 'Tidak' }}</span>
                                    </p>
                                    <p>
                                        Jadwal Pemeriksaan: <span class="fw-bold">{{ \Carbon\Carbon::parse($laborPK->jadwal_pemeriksaan)->format('d M Y H:i') }}</span>
                                    </p>
                                    <p>
                                        Diagnosis: <span class="fw-bold">{{ $laborPK->diagnosis }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Examination Details -->
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Detail Pemeriksaan</div>
                                <div class="card-body">
                                    @if (!empty($laborPK->details) && isset($laborPK->details[0]))
                                        <p>Jumlah: <span class="fw-bold">{{ $laborPK->details[0]['jumlah'] }}</span></p>
                                        <p>Urut: <span class="fw-bold">{{ $laborPK->details[0]['urut'] }}</span></p>
                                        <p>Kategori: <span class="fw-bold">{{ $laborPK->details[0]['kd_produk'] }}</span></p>
                                        <p>Nama Produk: <span class="fw-bold">{{ $laborPK->details[0]['kd_produk'] }}</span></p>
                                    @else
                                        <p>Detail pemeriksaan tidak tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    @if ($laborPK->status == 1)
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>
