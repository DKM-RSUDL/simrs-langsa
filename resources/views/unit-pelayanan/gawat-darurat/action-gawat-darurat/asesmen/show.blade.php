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
                                            <th class="py-3">Jenis</th>
                                            <th class="py-3">Alergen</th>
                                            <th class="py-3">Reaksi</th>
                                            <th class="py-3">Serve</th>
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

                                        <!-- Respirasi -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Respirasi</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    name="show_vital_sign_resp" readonly>
                                                <span class="input-group-text">x/mnt</span>
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

                                        <!-- GCS -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">GCS</label>
                                            <input type="text" class="form-control bg-light text-center"
                                                name="show_vital_sign_gcs" readonly>
                                        </div>

                                        <!-- AVPU -->
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">AVPU</label>
                                            <input type="text" class="form-control bg-light"
                                                name="show_vital_sign_avpu" readonly>
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
                            <div class="row g-4" id="show_pemeriksaan_fisik_container">
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
                                <!-- Diagnosis akan dirender di sini -->
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
                                            <th>Tanggal dan Jam</th>
                                            <th>Keluhan</th>
                                            <th>Vital Sign</th>
                                            <th>Re-Triase/EWS</th>
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

@push('js')
    <script>
        window.unitPoli = {!! json_encode($unitPoli) !!};

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

                        // **Perbaikan: Pastikan tombol print mengambil ID asesmen yang benar**
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

            // Handle diagnosis format for array data
            const diagnosisContainer = document.querySelector('.diagnosis-list');
            if (Array.isArray(asesmen.show_diagnosis) && asesmen.show_diagnosis.length > 0) {
                const diagnosisList = asesmen.show_diagnosis.map((diagnosis, index) => `
                    <div class="diagnosis-item p-2 mb-2 bg-light rounded">
                        <div class="d-flex align-items-start">
                            <span class="badge bg-primary me-2">${index + 1}</span>
                            <span>${diagnosis}</span>
                        </div>
                    </div>
                `).join('');
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
                `<div class="selected-item"><i class="fas fa-check text-success"></i> ${text}</div>`;

            // Air Way
            if (tindakanData.air_way?.length > 0) {
                $('.show-air-way').html(tindakanData.air_way.map(createItemElement).join(''));
            } else {
                $('.show-air-way').html('<em>Tidak ada tindakan</em>');
            }

            // Breathing
            if (tindakanData.breathing?.length > 0) {
                $('.show-breathing').html(tindakanData.breathing.map(createItemElement).join(''));
            } else {
                $('.show-breathing').html('<em>Tidak ada tindakan</em>');
            }

            // Circulation
            if (tindakanData.circulation?.length > 0) {
                $('.show-circulation').html(tindakanData.circulation.map(createItemElement).join(''));
            } else {
                $('.show-circulation').html('<em>Tidak ada tindakan</em>');
            }
        }

        function handleRiwayatAlergi(alergiData) {
            const tbody = $('#showAlergiTable tbody');
            tbody.empty();

            if (typeof alergiData === 'string') {
                try {
                    alergiData = JSON.parse(alergiData);
                } catch (e) {
                    console.error('Error parsing alergi data:', e);
                    alergiData = null;
                }
            }

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
                        <td>${alergi.jenis || '-'}</td>
                        <td>${alergi.alergen || '-'}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.keparahan || '-'}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleAlatTerpasang(alatTerpasang) {
            const tbody = $('#showAlatTable tbody');
            tbody.empty();

            if (typeof alatTerpasang === 'string') {
                try {
                    alatTerpasang = JSON.parse(alatTerpasang);
                } catch (e) {
                    console.error('Error data:', e);
                    alatTerpasang = null;
                }
            }

            if (!alatTerpasang || alatTerpasang.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
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

            if (typeof vitalSignData === 'string') {
                try {
                    vitalSignData = JSON.parse(vitalSignData);
                } catch (e) {
                    console.error('Error parsing vital sign data:', e);
                    return;
                }
            }

            // Set nilai untuk setiap input
            $('input[name="show_vital_sign_td_sistole"]').val(vitalSignData.td_sistole || '-');
            $('input[name="show_vital_sign_td_diastole"]').val(vitalSignData.td_diastole || '-');
            $('input[name="show_vital_sign_nadi"]').val(vitalSignData.nadi || '-');
            $('input[name="show_vital_sign_resp"]').val(vitalSignData.resp || '-');
            $('input[name="show_vital_sign_suhu"]').val(vitalSignData.suhu || '-');
            $('input[name="show_vital_sign_gcs"]').val(vitalSignData.gcs.total || '-');
            $('input[name="show_vital_sign_avpu"]').val(vitalSignData.avpu || '-');
            $('input[name="show_vital_sign_spo2_tanpa_o2"]').val(vitalSignData.spo2_tanpa_o2 || '-');
            $('input[name="show_vital_sign_spo2_dengan_o2"]').val(vitalSignData.spo2_dengan_o2 || '-');
        }

        function handleAntropometri(AntropometriData) {
            if (typeof AntropometriData === 'string') {
                try {
                    AntropometriData = JSON.parse(AntropometriData);
                } catch (e) {
                    console.error('Error Antropometri data:', e);
                    return;
                }
            }

            $('input[name="show_antropometri_tb"]').val(AntropometriData.tb || '-');
            $('input[name="show_antropometri_bb"]').val(AntropometriData.bb || '-');
            $('input[name="show_antropometri_ling_kepala"]').val(AntropometriData.ling_kepala || '-');
            $('input[name="show_antropometri_lpt"]').val(AntropometriData.lpt || '-');
            $('input[name="show_antropometri_imt"]').val(AntropometriData.imt || '-');

        }

        function handleReTriase(retriaseData) {
            console.log(retriaseData);

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
                // Parse triase JSON if needed
                const vitalSignData = typeof triase.vitalsign_retriase === 'string' ?
                    JSON.parse(triase.vitalsign_retriase) : triase.vitalsign_retriase;

                // Format vital signs
                const formattedVitalSigns = `
                    <ul class="list-unstyled mb-0">
                        ${vitalSignData.td_sistole ? `<li>TD: ${vitalSignData.td_sistole}/${vitalSignData.td_diastole} mmHg</li>` : ''}
                        ${vitalSignData.nadi ? `<li>Nadi: ${vitalSignData.nadi} x/mnt</li>` : ''}
                        ${vitalSignData.resp ? `<li>Resp: ${vitalSignData.resp} x/mnt</li>` : ''}
                        ${vitalSignData.suhu ? `<li>Suhu: ${vitalSignData.suhu}°C</li>` : ''}
                        ${vitalSignData.spo2_tanpa_o2 ? `<li>SpO2 (tanpa O2): ${vitalSignData.spo2_tanpa_o2}%</li>` : ''}
                        ${vitalSignData.spo2_dengan_o2 ? `<li>SpO2 (dengan O2): ${vitalSignData.spo2_dengan_o2}%</li>` : ''}
                        ${vitalSignData.gcs ? `<li>GCS: ${vitalSignData.gcs}</li>` : ''}
                        ${vitalSignData.avpu ? `<li>AVPU: ${vitalSignData.avpu}</li>` : ''}
                    </ul>
                `;

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
                        <td>${triase.tanggal_triase}</td>
                        <td>${triase.anamnesis_retriase  || '-'}</td>
                        <td>${formattedVitalSigns}</td>
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

            // Check if tindakLanjutData exists
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

            // Siapkan content berdasarkan tindak lanjut code
            let additionalInfo = '';

            switch (parseInt(data.tindak_lanjut_code)) {
                case 1: // Rawat Inap
                    // Destructure spri data from data object, ensuring we have access to it
                    const spriData = data.spri || {};
                    
                    let formattedTanggalRanap = '-';
                    let formattedJamRanap = '-';

                    if (spriData.tanggal_ranap) {
                        try {
                            formattedTanggalRanap = new Date(spriData.tanggal_ranap).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                        } catch (e) {
                            console.error('Error formatting tanggal_ranap:', e);
                            formattedTanggalRanap = spriData.tanggal_ranap;
                        }
                    }

                    if (spriData.jam_ranap) {
                        try {
                            formattedJamRanap = new Date(spriData.jam_ranap).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        } catch (e) {
                            console.error('Error formatting jam_ranap:', e);
                            formattedJamRanap = spriData.jam_ranap;
                        }
                    }

                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal Rawat Inap:</label>
                            <p class="mb-0">${formattedTanggalRanap}</p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Jam Rawat Inap:</label>
                            <p class="mb-0">${formattedJamRanap}</p>
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

                case 7: // Kamar Operasi
                    additionalInfo = `
                        <div class="col-12 mt-2">
                            <label class="fw-bold">Kamar Operasi:</label>
                            <p class="mb-0">${data.keterangan || '-'}</p>
                        </div>`;
                    break;

                case 5: // Rujuk RS Lain
                    let transportasiText = '-';
                    switch (data.transportasi_rujuk) {
                        case '1':
                            transportasiText = 'Ambulance';
                            break;
                        case '2':
                            transportasiText = 'Kendaraan Pribadi';
                            break;
                        case '3':
                            transportasiText = 'Lainnya';
                            break;
                    }

                    additionalInfo = `
                        <div class="col-md-4 mt-2">
                            <label class="fw-bold">Tujuan Rujuk:</label>
                            <p class="mb-0">${data.tujuan_rujuk || '-'}</p>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="fw-bold">Alasan Rujuk:</label>
                            <p class="mb-0">${data.alasan_rujuk ? 'Indikasi Medis' : '-'}</p>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="fw-bold">Transportasi:</label>
                            <p class="mb-0">${transportasiText}</p>
                        </div>`;
                    break;

                case 6: // Pulang
                    // Format tanggal pulang
                    let formattedTanggal = '-';
                    if (data.tanggal_pulang) {
                        formattedTanggal = new Date(data.tanggal_pulang).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    }

                    // Format jam pulang
                    let formattedJam = '-';
                    if (data.jam_pulang) {
                        formattedJam = new Date(data.jam_pulang).toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    // Format alasan pulang
                    let alasanPulangText = '-';
                    switch (data.alasan_pulang) {
                        case '1':
                            alasanPulangText = 'Sembuh';
                            break;
                        case '2':
                            alasanPulangText = 'Indikasi Medis';
                            break;
                        case '3':
                            alasanPulangText = 'Permintaan Pasien';
                            break;
                    }

                    // Format kondisi pulang
                    let kondisiPulangText = '-';
                    switch (data.kondisi_pulang) {
                        case '1':
                            kondisiPulangText = 'Mandiri';
                            break;
                        case '2':
                            kondisiPulangText = 'Tidak Mandiri';
                            break;
                    }

                    additionalInfo = `
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Tanggal Pulang:</label>
                            <p class="mb-0">${formattedTanggal}</p>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Jam Pulang:</label>
                            <p class="mb-0">${formattedJam}</p>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Alasan Pulang:</label>
                            <p class="mb-0">${alasanPulangText}</p>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="fw-bold">Kondisi Pulang:</label>
                            <p class="mb-0">${kondisiPulangText}</p>
                        </div>`;
                    break;

                case 8: // Berobat Jalan

                    let tanggalRajal = '-';
                    if (data.tanggal_rajal) {
                        tanggalRajal = new Date(data.tanggal_rajal).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    }

                    const selectedPoli = window.unitPoli ? window.unitPoli.find(poli => poli.kd_unit === data
                        .poli_unit_tujuan) : null;
                    const poliName = selectedPoli ? selectedPoli.nama_unit : data.poli_unit_tujuan;

                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal Berobat:</label>
                            <p class="mb-0">${tanggalRajal}</p>
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
                    let formattedTanggalMeninggal = '-';
                    if (data.tanggal_meninggal) {
                        formattedTanggalMeninggal = new Date(data.tanggal_meninggal).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    }

                    // Format jam meninggal
                    let formattedJamMeninggal = '-';
                    if (data.jam_meninggal) {
                        if (data.jam_meninggal.includes(':')) {
                            formattedJamMeninggal = data.jam_meninggal;
                        } else {
                            formattedJamMeninggal = new Date(data.jam_meninggal).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    }

                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal Meninggal:</label>
                            <p class="mb-0">${formattedTanggalMeninggal}</p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Jam Meninggal:</label>
                            <p class="mb-0">${formattedJamMeninggal}</p>
                        </div>`;
                    break;

                case 11: // DOA 
                    let formattedTanggalDOA = '-';
                    if (data.tanggal_meninggal) {
                        formattedTanggalDOA = new Date(data.tanggal_meninggal).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    }

                    // Format jam DOA
                    let formattedJamDOA = '-';
                    if (data.jam_meninggal) {
                        if (data.jam_meninggal.includes(':')) {
                            formattedJamDOA = data.jam_meninggal;
                        } else {
                            formattedJamDOA = new Date(data.jam_meninggal).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    }

                    additionalInfo = `
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Tanggal DOA:</label>
                            <p class="mb-0">${formattedTanggalDOA}</p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="fw-bold">Jam DOA:</label>
                            <p class="mb-0">${formattedJamDOA}</p>
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
            const container = $('#show_pemeriksaan_fisik_container'); // Updated container ID for 'show'

            container.empty();

            pemeriksaanFisik.forEach(function(item) {
                // Determine checked status based on is_normal value
                const isChecked = item.is_normal === '1' ? 'checked' : '';
                const keterangan = item.keterangan || '';

                // Append item to the pemeriksaan fisik section
                const itemHtml = `
                    <div class="col-md-6 pemeriksaan-item mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">${item.nama_item}</div>
                            <div class="form-check me-2">
                                <input type="checkbox" class="form-check-input" id="show_${item.id_item_fisik}_normal" ${isChecked} disabled>
                                <label class="form-check-label" for="show_${item.id_item_fisik}_normal">${isChecked ? 'Normal' : 'Tidak Normal'}</label>
                            </div>
                            ${keterangan ? `<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#show_keterangan_${item.id_item_fisik}">Lihat Keterangan</button>` : ''}
                        </div>
                        ${keterangan ? `<div id="show_keterangan_${item.id_item_fisik}" class="collapse mt-2"><input type="text" class="form-control" value="${keterangan}" readonly></div>` : ''}
                    </div>
                `;
                container.append(itemHtml);
            });
        }
    </script>
@endpush
