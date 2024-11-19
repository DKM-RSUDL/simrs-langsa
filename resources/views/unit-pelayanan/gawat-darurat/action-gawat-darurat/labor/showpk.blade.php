<div class="modal fade" id="laborModal{{ str_replace('.', '_', $laborPK->kd_order) }}" tabindex="-1"
    aria-labelledby="laborModalLabel{{ str_replace('.', '_', $laborPK->kd_order) }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('labor.index', [$laborPK->kd_pasien, $laborPK->tgl_masuk]) }}" method="post">
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
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-12 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light fw-bold">Detail Pemeriksaan</div>
                                <div class="card-body">
                                    <h6 class="fw-bold">Daftar Order Pemeriksaan:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Item Test</th>
                                                    <th>Hasil</th>
                                                    <th>Satuan</th>
                                                    <th>Nilai Normal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($laborPK->labResults) && !$laborPK->labResults->isEmpty())
                                                    @foreach ($laborPK->labResults as $namaProduk => $tests)
                                                        <tr class="table-secondary">
                                                            <td colspan="5" class="fw-bold">{{ $namaProduk }}</td>
                                                        </tr>
                                                        @foreach ($tests as $index => $test)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $test['item_test'] }}</td>
                                                                <td>{!! $test['hasil'] !!}</td>
                                                                <td>{{ $test['satuan'] }}</td>
                                                                <td>{{ $test['nilai_normal'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada hasil
                                                            pemeriksaan untuk order ini</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (method_exists($dataLabor, 'links'))
                            {{ $dataLabor->withQueryString()->links() }}
                        @endif

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
