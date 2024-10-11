<a href="#" class="btn btn-sm {{ $laborPK->status == 1 ? 'btn-primary' : 'btn-info' }}" data-bs-toggle="modal"
    data-bs-target="#laborModal{{ $laborPK->kd_order }}">
    <i class="ti-eye"></i>
</a>

<!-- Tombol Hapus -->
<a href="#" class="mb-2">
    <i class="bi bi-x-circle text-secondary"></i>
</a>

<div class="modal fade" id="laborModal{{ $laborPK->kd_order }}" tabindex="-1"
    aria-labelledby="laborModalLabel{{ $laborPK->kd_order }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('rawat-jalan.lab-patologi-klinik.index', [$laborPK->kd_unit, $laborPK->kd_pasien, $laborPK->tgl_masuk, $laborPK->urut_masuk]) }}" method="post">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="laborModalLabel{{ $laborPK->kd_order }}">
                        Order Pemeriksaan Laboratorium Klinik - KD Order: {{ (int) $laborPK->kd_order }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Informasi Pasien & Unit -->
                        <div class="col-md-4 mb-3"> <!-- Added mb-3 for bottom margin -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Informasi Pasien & Unit</div>
                                <div class="card-body">
                                    <p>
                                        KD Pasien: <span class="fw-bold">{{ $laborPK->kd_pasien }}</span><br>
                                        KD Unit: <span class="fw-bold">{{ $laborPK->unit->nama_unit }}</span><br>
                                        Tanggal Masuk: <span
                                            class="fw-bold">{{ \Carbon\Carbon::parse($laborPK->tgl_masuk)->format('d M Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Dokter & Pemeriksaan -->
                        <div class="col-md-4 mb-3"> <!-- Added mb-3 for bottom margin -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Informasi Dokter & Pemeriksaan</div>
                                <div class="card-body">
                                    <p>
                                        Dokter Pengirim: <span
                                            class="fw-bold">{{ $laborPK->dokter->nama_lengkap }}</span><br>
                                    </p>
                                    <p class="mt-4">
                                        Waktu Permintaan: <span
                                            class="fw-bold">{{ \Carbon\Carbon::parse($laborPK->tgl_order)->format('d M Y H:i') }}</span>
                                    </p>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            Cyto: <span
                                                class="fw-bold">{{ $laborPK->cyto == 1 ? 'YA' : 'Tidak' }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            Puasa: <span
                                                class="fw-bold">{{ $laborPK->puasa == 1 ? 'YA' : 'Tidak' }}</span>
                                        </div>
                                    </div>
                                    <p class="mt-4">
                                        Jadwal Pemeriksaan:
                                        <span class="fw-bold">
                                            {{ $laborPK->jadwal_pemeriksaan
                                                ? \Carbon\Carbon::parse($laborPK->jadwal_pemeriksaan)->format('d M Y H:i')
                                                : '-' }}
                                        </span>
                                    </p>
                                    <p class="mt-4">
                                        Diagnosis: <span class="fw-bold">
                                            {{ $laborPK->diagnosis ?? '-' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Pemeriksaan -->
                        <div class="col-md-4 mb-3"> <!-- Added mb-3 for bottom margin -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Detail Pemeriksaan</div>
                                <div class="card-body">
                                    <h6 class="fw-bold">Daftar Order Pemeriksaan:</h6>
                                    <ol class="p-3" type="1">
                                        @foreach ($laborPK->details as $detail)
                                            <li>
                                                {{ $detail->produk->deskripsi ?? 'Deskripsi tidak tersedia' }}
                                            </li>
                                        @endforeach
                                    </ol>
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
