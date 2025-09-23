<!-- Modal -->
<div class="modal fade" id="showasesmenModal" tabindex="-1" aria-labelledby="showasesmenLabel" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0">
                <!-- Header Section -->
                <div class="border-bottom bg-light p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <h5 class="mb-0">{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</h5>
                                <span class="badge bg-primary">
                                    {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                                <span class="badge bg-secondary">
                                    {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Tahun
                                </span>
                            </div>
                            <div class="mt-1 text-muted small">
                                <i class="bi bi-person-vcard me-1"></i>No. RM: {{ $dataMedis->kd_pasien }} |
                                <i class="bi bi-calendar-event me-1"></i>Tgl Masuk:
                                {{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y H:i') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <a id="btnPrintAsesmen" href="#" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-printer"></i> Print
                                </a>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-4">
                    <!-- Tindakan Resusitasi -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-activity text-primary me-2"></i>Tindakan Resusitasi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 33.33%">Air Way</th>
                                            <th class="text-center" style="width: 33.33%">Breathing</th>
                                            <th class="text-center" style="width: 33.33%">Circulation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="show-air-way py-3"></td>
                                            <td class="show-breathing py-3"></td>
                                            <td class="show-circulation py-3"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Anamnesis & Riwayat Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-clipboard2-pulse text-primary me-2"></i>Anamnesis & Riwayat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Keluhan/Anamnesis -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-chat-right-text text-primary me-1"></i>
                                            Keluhan/Anamnesis
                                        </label>
                                        <textarea class="form-control bg-light" rows="3" name="anamnesis" readonly></textarea>
                                    </div>
                                </div>
                                <!-- Riwayat Penyakit -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-journal-medical text-primary me-1"></i>
                                            Riwayat Penyakit
                                        </label>
                                        <textarea class="form-control bg-light" rows="3" name="riwayat_penyakit" readonly></textarea>
                                    </div>
                                </div>
                                <!-- Riwayat Penyakit Keluarga -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-people text-primary me-1"></i>
                                            Riwayat Penyakit Keluarga
                                        </label>
                                        <textarea class="form-control bg-light" rows="3" name="riwayat_penyakit_keluarga" readonly></textarea>
                                    </div>
                                </div>
                                <!-- Riwayat Pengobatan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-capsule text-primary me-1"></i>
                                            Riwayat Pengobatan
                                        </label>
                                        <textarea class="form-control bg-light" rows="3" name="riwayat_pengobatan" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Alergi -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-exclamation-triangle text-primary me-2"></i>Riwayat Alergi
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="showAlergiTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3">Jenis Alergi</th>
                                            <th class="py-3">Nama Alergi</th>
                                            <th class="py-3">Reaksi</th>
                                            <th class="py-3">Tingkat Keparahan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Vital Sign & Antropometri -->
                    <div class="row g-4 mb-4">
                        <!-- Vital Sign -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white py-3">
                                    <h6 class="card-title mb-0 fw-bold">
                                        <i class="bi bi-heart-pulse text-primary me-2"></i>Vital Sign
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Tekanan Darah -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Tekanan Darah</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_td_sistole" readonly>
                                                <span class="input-group-text">/</span>
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_td_diastole" readonly>
                                                <span class="input-group-text">mmHg</span>
                                            </div>
                                        </div>

                                        <!-- Nadi -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Nadi</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_nadi" readonly>
                                                <span class="input-group-text">x/mnt</span>
                                            </div>
                                        </div>

                                        <!-- RR (Respiratory Rate) - ADDED -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">RR</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_rr" readonly>
                                                <span class="input-group-text">x/mnt</span>
                                            </div>
                                        </div>

                                        <!-- GCS -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">GCS</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_gcs" readonly>
                                                <span class="input-group-text">Total</span>
                                            </div>
                                        </div>

                                        <!-- Suhu -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Suhu</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_suhu" readonly>
                                                <span class="input-group-text">°C</span>
                                            </div>
                                        </div>

                                        <!-- SpO2 -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">SpO2 (tanpa O2)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_spo2_tanpa_o2" readonly>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">SpO2 (dengan O2)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_spo2_dengan_o2" readonly>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Antropometri -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white py-3">
                                    <h6 class="card-title mb-0 fw-bold">
                                        <i class="bi bi-rulers text-primary me-2"></i>Antropometri
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- TB -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Tinggi Badan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_antropometri_tb" readonly>
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>

                                        <!-- BB -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Berat Badan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_antropometri_bb" readonly>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </div>

                                        <!-- Lingkar Kepala -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Lingkar Kepala</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_antropometri_ling_kepala" readonly>
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>

                                        <!-- LPT -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">LPT</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_antropometri_lpt" readonly>
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>

                                        <!-- IMT -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">IMT</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_antropometri_imt" readonly>
                                                <span class="input-group-text">kg/m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skala Nyeri -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-emoji-frown text-primary me-2"></i>Skala Nyeri Visual Analog
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Skala Nyeri"
                                        class="img-fluid rounded shadow-sm mb-3">
                                </div>
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <!-- Skala Nyeri -->
                                        <div class="col-md-4">
                                            <label class="form-label small fw-semibold">Skala Nyeri</label>
                                            <input type="text" class="form-control bg-light text-center"
                                                name="show_skala_nyeri" readonly>
                                        </div>
                                        <!-- Lokasi -->
                                        <div class="col-md-8">
                                            <label class="form-label small fw-semibold">Lokasi Nyeri</label>
                                            <input type="text" class="form-control bg-light" name="show_lokasi"
                                                readonly>
                                        </div>
                                        <!-- Durasi -->
                                        <div class="col-12">
                                            <label class="form-label small fw-semibold">Durasi</label>
                                            <input type="text" class="form-control bg-light" name="show_durasi"
                                                readonly>
                                        </div>
                                        <!-- Karakteristik -->
                                        <div class="col-12">
                                            <label class="form-label small fw-semibold">Karakteristik Nyeri</label>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small">Manjalar</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="show_menjalar" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Frekuensi</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="show_frekuensi" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Kualitas</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="show_kualitas" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Efek Nyeri</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="show_efek_nyeri" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Faktor Pemberat</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="show_faktor_pemberat" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Faktor Peringan</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="show_faktor_peringan" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pemeriksaan Fisik -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-clipboard2-pulse text-primary me-2"></i>Pemeriksaan Fisik
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3" id="show_pemeriksaan_fisik_container">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Pemeriksaan Penunjang -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-clipboard2-data text-primary me-2"></i>Pemeriksaan Penunjang
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Laboratorium -->
                            <div class="mb-4">
                                <h6 class="fw-semibold d-flex align-items-center gap-2 mb-3">
                                    <img src="{{ asset('assets/img/icons/test_tube.png') }}" style="width: 24px">
                                    Laboratorium
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-hover border">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Pemeriksaan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($laborData as $data)
                                                <tr>
                                                    <td>{{ $data['Tanggal-Jam'] }}</td>
                                                    <td>{{ $data['Nama pemeriksaan'] }}</td>
                                                    <td>
                                                        @if ($data['Status'] == 'Diorder')
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="bi bi-clock me-1"></i>Diorder
                                                            </span>
                                                        @elseif($data['Status'] == 'Selesai')
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle me-1"></i>Selesai
                                                            </span>
                                                        @else
                                                            {{ $data['Status'] }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-3">
                                                        <em>Tidak ada data laboratorium</em>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Radiologi -->
                            <div>
                                <h6 class="fw-semibold d-flex align-items-center gap-2 mb-3">
                                    <img src="{{ asset('assets/img/icons/microbeam_radiation_therapy.png') }}"
                                        style="width: 24px">
                                    Radiologi
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-hover border">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Tanggal dan Jam</th>
                                                <th>Nama Pemeriksaan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($radiologiData as $rad)
                                                <tr>
                                                    <td>{{ $rad['Tanggal-Jam'] }}</td>
                                                    <td>{{ $rad['Nama Pemeriksaan'] }}</td>
                                                    <td>{!! $rad['Status'] !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-3">
                                                        <em>Tidak ada data radiologi</em>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- E-Resep -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/img/icons/pill.png') }}" style="width: 24px">
                                E-Resep
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Obat</th>
                                            <th>Dosis</th>
                                            <th>Cara Pemberian</th>
                                            <th>PPA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($riwayatObat as $resep)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($resep->tgl_order)->format('d M Y H:i') }}
                                                </td>
                                                <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                                                <td>{{ $resep->jumlah_takaran }}
                                                    {{ Str::title($resep->satuan_takaran) }}</td>
                                                <td>{{ explode(',', $resep->cara_pakai)[1] ?? '' }}</td>
                                                <td>{{ $resep->nama_dokter }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-3">
                                                    <em>Tidak ada Resep Obat</em>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnosis -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-clipboard2-check text-primary me-2"></i>Diagnosis
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="diagnosis-list">
                                <!-- Diagnosis akan dirender di sini oleh JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Observasi Lanjutan/Re-Triase -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-clock-history text-primary me-2"></i>Observasi Lanjutan/Re-Triase
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="ShowreTriaseTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 20%">Tanggal dan Jam</th>
                                            <th style="width: 25%">Keluhan</th>
                                            <th style="width: 35%">Vital Sign</th>
                                            <th style="width: 20%">Re-Triase/EWS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Alat yang Terpasang -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-tools text-primary me-2"></i>Alat yang Terpasang
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="showAlatTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Alat yang terpasang</th>
                                            <th>Lokasi</th>
                                            <th>Ket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Kondisi Pasien -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-person-lines-fill text-primary me-2"></i>Kondisi Pasien sebelum
                                meninggalkan IGD
                            </h6>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control bg-light" rows="3" name="show_kondisi_pasien" readonly></textarea>
                        </div>
                    </div>

                    <!-- Tindak Lanjut -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-arrow-right-circle text-primary me-2"></i>Tindak Lanjut Pelayanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="showTindakLanjutInfo" class="bg-light rounded p-3">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        /* Custom styles untuk modal */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Style untuk badges dan alerts */
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }

        /* Style untuk tables */
        .table> :not(caption)>*>* {
            padding: 0.75rem 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .02);
        }

        /* Style untuk inputs */
        .form-control:read-only {
            background-color: #f8f9fa;
            cursor: default;
        }

        .form-control:read-only:focus {
            box-shadow: none;
        }

        /* Style untuk cards */
        .card {
            border: none;
            transition: box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        /* Style untuk section titles */
        .section-title {
            font-size: 1rem;
            color: #344767;
        }

        /* Style untuk icons */
        .bi {
            line-height: 1;
            vertical-align: -0.125em;
        }

        /* Style untuk vital signs display */
        .vital-signs-container ul {
            margin-bottom: 0;
            padding-left: 0;
            list-style: none;
        }

        .vital-signs-container li {
            margin-bottom: 0.25rem;
        }

        /* Custom style untuk Tindak Lanjut card */
        #showTindakLanjutInfo .card {
            background-color: transparent;
            border: 1px solid rgba(0, 0, 0, .125);
        }

        /* Style untuk pemeriksaan fisik items */
        .pemeriksaan-item {
            border: 1px solid rgba(0, 0, 0, .125);
            padding: 0.5rem;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }

        .pemeriksaan-item:last-child {
            margin-bottom: 0;
        }

        /* Style untuk read-only inputs */
        input[readonly],
        textarea[readonly] {
            background-color: #f8f9fa !important;
            opacity: 1 !important;
        }

        /* Style untuk modal dialog */
        .modal-xl {
            max-width: 80%;
        }

        @media (max-width: 992px) {
            .modal-xl {
                max-width: 100%;
                margin: 0.5rem;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        window.unitPoli = {!! json_encode($unitPoli) !!};
        window.itemFisik = {!! json_encode($itemFisik) !!};

        function showAsesmen(id) {
            const button = event.target.closest('button');
            const url = button.dataset.url;
            const modal = new bootstrap.Modal(document.getElementById('showasesmenModal'));

            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log('Success Response:', response);
                    Swal.close();
                    if (response.status === 'success') {
                        handleTindakanResusitasi(response.data.asesmen.tindakan_resusitasi);
                        handleTextareaData(response.data.asesmen);
                        handleRiwayatAlergi(response.data.asesmen.riwayat_alergi);
                        handleVitalSign(response.data.asesmen.vital_sign);
                        handleAntropometri(response.data.asesmen.antropometri);
                        handleReTriase(response.data.asesmen.retriase_data);
                        handleAlatTerpasang(response.data.asesmen.alat_terpasang);
                        handleTindakLanjut(response.data.asesmen.tindaklanjut);
                        handlePemeriksaanFisik(response.data.asesmen.pemeriksaan_fisik);

                        // Set URL print button
                        let btnPrint = document.getElementById('btnPrintAsesmen');
                        btnPrint.href =
                            `/unit-pelayanan/gawat-darurat/pelayanan/${response.data.dataMedis.kd_pasien}/${response.data.dataMedis.tgl_masuk.split(' ')[0]}/asesmen/${id}/print`;

                        modal.show();
                    } else {
                        Swal.fire('Error', 'Data tidak ditemukan', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error Response:', xhr.responseJSON);
                    Swal.close();
                    Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan saat memuat data',
                        'error');
                }
            });
        }

        function handleTextareaData(asesmen) {
            $('textarea[name="anamnesis"]').val(asesmen.anamnesis || '-');
            $('textarea[name="riwayat_penyakit"]').val(asesmen.riwayat_penyakit || '-');
            $('textarea[name="riwayat_penyakit_keluarga"]').val(asesmen.riwayat_penyakit_keluarga || '-');
            $('textarea[name="riwayat_pengobatan"]').val(asesmen.riwayat_pengobatan || '-');
            $('input[name="show_skala_nyeri"]').val(asesmen.show_skala_nyeri || '-');
            $('input[name="show_lokasi"]').val(asesmen.show_lokasi || '-');
            $('input[name="show_durasi"]').val(asesmen.show_durasi || '-');
            $('input[name="show_menjalar"]').val(asesmen.show_menjalar || '-');
            $('input[name="show_frekuensi"]').val(asesmen.show_frekuensi || '-');
            $('input[name="show_kualitas"]').val(asesmen.show_kualitas || '-');
            $('input[name="show_faktor_pemberat"]').val(asesmen.show_faktor_pemberat || '-');
            $('input[name="show_faktor_peringan"]').val(asesmen.show_faktor_peringan || '-');
            $('input[name="show_efek_nyeri"]').val(asesmen.show_efek_nyeri || '-');
            $('textarea[name="show_kondisi_pasien"]').val(asesmen.show_kondisi_pasien || '-');

            // Handle diagnosis dengan parsing yang benar
            const diagnosisContainer = document.querySelector('.diagnosis-list');
            let diagnosisData = [];

            // Parse diagnosis data
            if (asesmen.show_diagnosis) {
                try {
                    // Jika data sudah berupa array
                    if (Array.isArray(asesmen.show_diagnosis)) {
                        diagnosisData = asesmen.show_diagnosis;
                    }
                    // Jika data berupa string JSON
                    else if (typeof asesmen.show_diagnosis === 'string') {
                        diagnosisData = JSON.parse(asesmen.show_diagnosis);
                    }
                } catch (e) {
                    console.error('Error parsing diagnosis data:', e);
                    diagnosisData = [];
                }
            }

            // Tampilkan diagnosis
            if (Array.isArray(diagnosisData) && diagnosisData.length > 0) {
                const diagnosisList = diagnosisData.map((diagnosis, index) => {
                    // Handle berbagai format data diagnosis
                    let diagnosisText = '';
                    if (typeof diagnosis === 'string') {
                        diagnosisText = diagnosis;
                    } else if (diagnosis && diagnosis.nama) {
                        diagnosisText = diagnosis.nama;
                    } else if (diagnosis && diagnosis.text) {
                        diagnosisText = diagnosis.text;
                    } else {
                        diagnosisText = 'Diagnosis tidak valid';
                    }

                    return `
                        <div class="diagnosis-item p-2 mb-2 bg-light rounded">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-primary me-2">${index + 1}</span>
                                <span>${diagnosisText}</span>
                            </div>
                        </div>
                    `;
                }).join('');
                diagnosisContainer.innerHTML = diagnosisList;
            } else {
                diagnosisContainer.innerHTML = '<div class="text-center text-muted"><em>Tidak ada diagnosis</em></div>';
            }
        }

        function handleTindakanResusitasi(tindakanData) {
            if (!tindakanData) {
                $('.show-air-way, .show-breathing, .show-circulation').html('<em>Tidak ada tindakan</em>');
                return;
            }

            const createItemElement = (text) =>
                `<div class="selected-item mb-1"><i class="bi bi-check text-success me-2"></i> ${text}</div>`;

            // Air Way
            if (Array.isArray(tindakanData.air_way) && tindakanData.air_way.length > 0) {
                $('.show-air-way').html(tindakanData.air_way.map(createItemElement).join(''));
            } else {
                $('.show-air-way').html('<em>Tidak ada tindakan</em>');
            }

            // Breathing
            if (Array.isArray(tindakanData.breathing) && tindakanData.breathing.length > 0) {
                $('.show-breathing').html(tindakanData.breathing.map(createItemElement).join(''));
            } else {
                $('.show-breathing').html('<em>Tidak ada tindakan</em>');
            }

            // Circulation
            if (Array.isArray(tindakanData.circulation) && tindakanData.circulation.length > 0) {
                $('.show-circulation').html(tindakanData.circulation.map(createItemElement).join(''));
            } else {
                $('.show-circulation').html('<em>Tidak ada tindakan</em>');
            }
        }

        function handleRiwayatAlergi(alergiData) {
            const tbody = $('#showAlergiTable tbody');
            tbody.empty();

            // Data alergi sudah berupa array dari controller (dari tabel RmeAlergiPasien)
            if (!alergiData || alergiData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada data alergi</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alergiData.forEach(function(alergi) {
                const row = `
                    <tr>
                        <td>${alergi.jenis_alergi || '-'}</td>
                        <td>${alergi.nama_alergi || '-'}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.tingkat_keparahan || '-'}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleAlatTerpasang(alatTerpasang) {
            const tbody = $('#showAlatTable tbody');
            tbody.empty();

            if (!alatTerpasang || alatTerpasang.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="3" class="text-center">
                            <em>Tidak ada data Alat Terpasang</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alatTerpasang.forEach(function(alat) {
                const row = `
                    <tr>
                        <td>${alat.nama || '-'}</td>
                        <td>${alat.lokasi || '-'}</td>
                        <td>${alat.keterangan || '-'}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleVitalSign(vitalSignData) {
            if (!vitalSignData) {
                return;
            }

            // Set nilai untuk setiap input
            $('input[name="show_vital_sign_td_sistole"]').val(vitalSignData.td_sistole || '-');
            $('input[name="show_vital_sign_td_diastole"]').val(vitalSignData.td_diastole || '-');
            $('input[name="show_vital_sign_nadi"]').val(vitalSignData.nadi || '-');

            // Add RR field (missing in original)
            $('input[name="show_vital_sign_rr"]').val(vitalSignData.rr || '-');

            // Fix temperature field - use 'temp' instead of 'suhu'
            $('input[name="show_vital_sign_suhu"]').val(vitalSignData.temp || vitalSignData.suhu || '-');

            // Handle GCS dengan aman
            let gcsValue = '-';
            if (vitalSignData.gcs) {
                if (typeof vitalSignData.gcs === 'object' && vitalSignData.gcs.total) {
                    gcsValue = vitalSignData.gcs.total;
                } else if (typeof vitalSignData.gcs === 'string' || typeof vitalSignData.gcs === 'number') {
                    gcsValue = vitalSignData.gcs;
                }
            }
            $('input[name="show_vital_sign_gcs"]').val(gcsValue);

            $('input[name="show_vital_sign_avpu"]').val(vitalSignData.avpu || '-');
            $('input[name="show_vital_sign_spo2_tanpa_o2"]').val(vitalSignData.spo2_tanpa_o2 || '-');
            $('input[name="show_vital_sign_spo2_dengan_o2"]').val(vitalSignData.spo2_dengan_o2 || '-');
        }

        function handleAntropometri(antropometriData) {
            if (!antropometriData) {
                return;
            }

            $('input[name="show_antropometri_tb"]').val(antropometriData.tb || '-');
            $('input[name="show_antropometri_bb"]').val(antropometriData.bb || '-');
            $('input[name="show_antropometri_ling_kepala"]').val(antropometriData.ling_kepala || '-');
            $('input[name="show_antropometri_lpt"]').val(antropometriData.lpt || '-');
            $('input[name="show_antropometri_imt"]').val(antropometriData.imt || '-');
        }

        function handleReTriase(retriaseData) {
            const tbody = $('#ShowreTriaseTable tbody');
            tbody.empty();

            if (!retriaseData || retriaseData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada data re-triase</em>
                        </td>
                    </tr>
                `);
                return;
            }

            retriaseData.forEach(function(triase) {
                // Parse vital sign JSON
                let vitalSignData = {};
                if (triase.vitalsign_retriase) {
                    try {
                        vitalSignData = typeof triase.vitalsign_retriase === 'string' ?
                            JSON.parse(triase.vitalsign_retriase) :
                            triase.vitalsign_retriase;
                    } catch (e) {
                        console.error('Error parsing vital sign:', e);
                        vitalSignData = {};
                    }
                }

                // Format vital signs
                const formatVitalSigns = (data) => {
                    const items = [];
                    if (data.td_sistole && data.td_diastole) items.push(
                        `TD: ${data.td_sistole}/${data.td_diastole} mmHg`);
                    if (data.nadi) items.push(`Nadi: ${data.nadi} x/mnt`);
                    if (data.rr) items.push(`RR: ${data.rr} x/mnt`);
                    if (data.temp) items.push(`Suhu: ${data.temp}°C`);
                    if (data.spo2_tanpa_o2) items.push(`SpO2 (tanpa O2): ${data.spo2_tanpa_o2}%`);
                    if (data.spo2_dengan_o2) items.push(`SpO2 (dengan O2): ${data.spo2_dengan_o2}%`);
                    if (data.gcs) items.push(`GCS: ${data.gcs}`);

                    return items.length > 0 ?
                        `<ul class="list-unstyled mb-0">${items.map(item => `<li>${item}</li>`).join('')}</ul>` :
                        '-';
                };

                // Get triase status style
                const getTriaseClass = (kodeTriase) => {
                    switch (parseInt(kodeTriase)) {
                        case 5:
                            return 'bg-dark text-white';
                        case 4:
                            return 'bg-danger text-white';
                        case 3:
                            return 'bg-danger text-white';
                        case 2:
                            return 'bg-warning text-dark';
                        case 1:
                            return 'bg-success text-white';
                        default:
                            return 'bg-secondary text-white';
                    }
                };

                const row = `
                    <tr>
                        <td>${triase.tanggal_triase || '-'}</td>
                        <td>${triase.anamnesis_retriase || '-'}</td>
                        <td>${formatVitalSigns(vitalSignData)}</td>
                        <td>
                            <span class="badge ${getTriaseClass(triase.kode_triase)}">
                                ${triase.hasil_triase || '-'}
                            </span>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleTindakLanjut(tindakLanjutData) {
            const container = $('#showTindakLanjutInfo');
            container.empty();

            // Check if tindakLanjutData exists and is an array
            if (!tindakLanjutData || !Array.isArray(tindakLanjutData) || tindakLanjutData.length === 0) {
                container.html(`
                    <div class="alert alert-info">
                        <em>Tidak ada data tindak lanjut</em>
                    </div>
                `);
                return;
            }

            // Get the first tindak lanjut data
            const data = tindakLanjutData[0];
            let additionalInfo = '';

            switch (parseInt(data.tindak_lanjut_code)) {
                case 1: // Rawat Inap
                    const spriData = data.spri || {};
                    const formatDate = (dateStr) => {
                        if (!dateStr) return '-';
                        try {
                            return new Date(dateStr).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                        } catch (e) {
                            return dateStr;
                        }
                    };

                    const formatTime = (timeStr) => {
                        if (!timeStr) return '-';
                        try {
                            return new Date(timeStr).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        } catch (e) {
                            return timeStr;
                        }
                    };

                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal Rawat Inap:</label>
                            <p class="mb-0">${formatDate(spriData.tanggal_ranap)}</p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Jam Rawat Inap:</label>
                            <p class="mb-0">${formatTime(spriData.jam_ranap)}</p>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Keluhan Utama:</label>
                            <p class="mb-0">${spriData.keluhan_utama || '-'}</p>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Jalannya Penyakit:</label>
                            <p class="mb-0">${spriData.jalannya_penyakit || '-'}</p>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Hasil Pemeriksaan:</label>
                            <p class="mb-0">${spriData.hasil_pemeriksaan || '-'}</p>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Diagnosis:</label>
                            <p class="mb-0">${spriData.diagnosis || '-'}</p>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Tindakan:</label>
                            <p class="mb-0">${spriData.tindakan || '-'}</p>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Anjuran:</label>
                            <p class="mb-0">${spriData.anjuran || '-'}</p>
                        </div>`;
                    break;

                case 5: // Rujuk RS Lain
                    const transportasiOptions = {
                        '1': 'Ambulance',
                        '2': 'Kendaraan Pribadi',
                        '3': 'Lainnya'
                    };
                    additionalInfo = `
                        <div class="col-md-4 mt-2">
                            <label class="fw-bold">Tujuan Rujuk:</label>
                            <p class="mb-0">${data.tujuan_rujuk || '-'}</p>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="fw-bold">Alasan Rujuk:</label>
                            <p class="mb-0">${data.alasan_rujuk || '-'}</p>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="fw-bold">Transportasi:</label>
                            <p class="mb-0">${transportasiOptions[data.transportasi_rujuk] || '-'}</p>
                        </div>`;
                    break;

                case 6: // Pulang
                    const formatDateSimple = (dateStr) => {
                        if (!dateStr) return '-';
                        try {
                            return new Date(dateStr).toLocaleDateString('id-ID');
                        } catch (e) {
                            return dateStr;
                        }
                    };

                    const alasanPulangOptions = {
                        '1': 'Sembuh',
                        '2': 'Indikasi Medis',
                        '3': 'Permintaan Pasien'
                    };
                    const kondisiPulangOptions = {
                        '1': 'Mandiri',
                        '2': 'Tidak Mandiri'
                    };

                    additionalInfo = `
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Tanggal Pulang:</label>
                            <p class="mb-0">${formatDateSimple(data.tanggal_pulang)}</p>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Jam Pulang:</label>
                            <p class="mb-0">${data.jam_pulang || '-'}</p>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Alasan Pulang:</label>
                            <p class="mb-0">${alasanPulangOptions[data.alasan_pulang] || '-'}</p>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Kondisi Pulang:</label>
                            <p class="mb-0">${kondisiPulangOptions[data.kondisi_pulang] || '-'}</p>
                        </div>`;
                    break;

                case 8: // Berobat Jalan
                    const selectedPoli = window.unitPoli ? window.unitPoli.find(poli => poli.kd_unit === data
                        .poli_unit_tujuan) : null;
                    const poliName = selectedPoli ? selectedPoli.nama_unit : data.poli_unit_tujuan;

                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal Berobat:</label>
                            <p class="mb-0">${data.tanggal_rajal ? new Date(data.tanggal_rajal).toLocaleDateString('id-ID') : '-'}</p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Poli Tujuan:</label>
                            <p class="mb-0">${poliName || '-'}</p>
                        </div>`;
                    break;

                case 9: // Menolak Rawat Inap
                    additionalInfo = `
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Alasan Menolak:</label>
                            <p class="mb-0">${data.keterangan || '-'}</p>
                        </div>`;
                    break;

                case 10: // Meninggal Dunia
                case 11: // DOA
                    const label = parseInt(data.tindak_lanjut_code) === 10 ? 'Meninggal' : 'DOA';
                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal ${label}:</label>
                            <p class="mb-0">${data.tanggal_meninggal ? new Date(data.tanggal_meninggal).toLocaleDateString('id-ID') : '-'}</p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Jam ${label}:</label>
                            <p class="mb-0">${data.jam_meninggal || '-'}</p>
                        </div>`;
                    break;

                default:
                    additionalInfo = `
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Keterangan:</label>
                            <p class="mb-0">${data.keterangan || '-'}</p>
                        </div>`;
                    break;
            }

            const infoBox = `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="fw-bold">Tindak Lanjut:</label>
                                <div class="mt-2">
                                    <span class="badge bg-primary">
                                        ${data.tindak_lanjut_name || '-'}
                                    </span>
                                </div>
                            </div>
                            ${additionalInfo}
                        </div>
                    </div>
                </div>
            `;
            container.html(infoBox);
        }

        function handlePemeriksaanFisik(pemeriksaanFisik) {
            const container = $('#show_pemeriksaan_fisik_container');
            container.empty();

            // Ambil data item fisik dari window global yang sudah di-set dari controller
            const allItemsFisik = window.itemFisik || [];

            if (allItemsFisik.length === 0) {
                container.html('<div class="col-12 text-center text-muted"><em>Data item fisik tidak tersedia</em></div>');
                return;
            }

            // Buat map dari data pemeriksaan yang ada
            const pemeriksaanMap = {};
            if (pemeriksaanFisik && pemeriksaanFisik.length > 0) {
                pemeriksaanFisik.forEach(function(item) {
                    pemeriksaanMap[item.id_item_fisik] = item;
                });
            }

            // Tampilkan semua item fisik dalam layout yang lebih compact
            allItemsFisik.forEach(function(itemFisik) {
                // Cek apakah item ini ada di data pemeriksaan
                const pemeriksaanData = pemeriksaanMap[itemFisik.id];

                // Default nilai
                let isNormal = '1'; // Default normal
                let statusText = 'Normal';
                let statusIcon = 'bi-check-circle';
                let statusClass = 'text-success';
                let keterangan = '';

                // Jika ada data pemeriksaan, gunakan data tersebut
                if (pemeriksaanData) {
                    isNormal = pemeriksaanData.is_normal;
                    statusText = pemeriksaanData.is_normal === '1' ? 'Normal' : 'Tidak Normal';
                    statusIcon = pemeriksaanData.is_normal === '1' ? 'bi-check-circle' : 'bi-exclamation-triangle';
                    statusClass = pemeriksaanData.is_normal === '1' ? 'text-success' : 'text-danger';
                    keterangan = pemeriksaanData.keterangan || '';
                }

                // Create compact item HTML
                const itemHtml = `
                    <div class="col-md-4 mb-2">
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
                            <div class="d-flex align-items-center">
                                <i class="bi ${statusIcon} ${statusClass} me-2"></i>
                                <span class="small fw-medium">${itemFisik.nama}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <span class="badge badge-sm ${isNormal === '1' ? 'bg-success' : 'bg-danger'}">${statusText}</span>
                                ${keterangan ? `<button class="btn btn-sm btn-link p-0 text-muted" type="button" data-bs-toggle="collapse" data-bs-target="#show_keterangan_${itemFisik.id}" title="Lihat keterangan">
                                                        <i class="bi bi-info-circle" style="font-size: 0.875rem;"></i>
                                                    </button>` : ''}
                            </div>
                        </div>
                        ${keterangan ? `
                                                <div id="show_keterangan_${itemFisik.id}" class="collapse mt-1">
                                                    <div class="alert alert-warning py-2 px-3 mb-0 small">
                                                        <strong>Keterangan:</strong> ${keterangan}
                                                    </div>
                                                </div>
                                            ` : ''}
                    </div>
                `;
                container.append(itemHtml);
            });
        }
    </script>
@endpush
