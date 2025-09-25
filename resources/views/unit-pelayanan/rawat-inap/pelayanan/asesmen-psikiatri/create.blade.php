@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Medis Psiakitri</h4>
                                    <p>
                                        Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN KEPERAWATAN PSIKATRI --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.medis.psikiatri.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kondisi Masuk</label>
                                            <select class="form-select" name="kondisi_masuk">
                                                <option selected disabled>Pilih</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Jalan Kaki">Jalan Kaki</option>
                                                <option value="Kursi Roda">Kursi Roda</option>
                                                <option value="Brankar">Brankar</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Masuk</label>
                                            <input type="text" class="form-control" name="diagnosis_masuk">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pengkajian-keperawatan">
                                        <h5 class="section-title">2. Pengkajian Keperawatan</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Anamnesis</label>
                                            <input type="text" class="form-control" name="anamnesis"
                                                placeholder="Masukkan anamnesis" required>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="4"
                                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Sensorium</label>
                                            <select class="form-select" name="sensorium">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Compos Mentis">Compos Mentis</option>
                                                <option value="Apatis">Apatis</option>
                                                <option value="Somnolen">Somnolen</option>
                                                <option value="Sopor">Sopor</option>
                                                <option value="Coma">Coma</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Sistole</label>
                                                    <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                        placeholder="120" min="70" max="300">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Diastole</label>
                                                    <input type="number" class="form-control"
                                                        name="tekanan_darah_diastole" placeholder="80" min="40"
                                                        max="150">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Suhu (°C)</label>
                                            <input type="text" class="form-control" name="suhu" step="0.1"
                                                placeholder="36.5" min="30" max="45">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                            <input type="number" class="form-control" name="respirasi" placeholder="20"
                                                min="10" max="50">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                            <input type="number" class="form-control" name="nadi" placeholder="80"
                                                min="40" max="200">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 220px;">Skala Nyeri (1-10)</label>
                                                    <input type="number" class="form-control" name="skala_nyeri"
                                                        id="skala_nyeri" min="1" max="10"
                                                        placeholder="1-10">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 220px;">Kategori Nyeri</label>
                                                    <input type="text" class="form-control" name="kategori_nyeri"
                                                        id="kategori_nyeri" readonly placeholder="Akan terisi otomatis">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="text-center">
                                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                        alt="Skala Nyeri Visual" class="img-fluid mb-3"
                                                        style="max-height: 200px;">
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                        alt="Skala Nyeri Numerik" class="img-fluid"
                                                        style="max-height: 150px;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Alat bantu yang digunakan</label>
                                            <input type="text" class="form-control" name="alat_bantu"
                                                placeholder="Masukkan alat bantu yang digunakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Cacat Tubuh</label>
                                            <input type="text" class="form-control" name="cacat_tubuh" placeholder="Sebutkan jenis cacat tubuh">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">ADL</label>
                                            <select class="form-select" name="adl">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Dibantu">Dibantu</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Resiko Jatuh</label>
                                            <select class="form-select" name="resiko_jatuh">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ringan">Ringan</option>
                                                <option value="Sedang">Sedang</option>
                                                <option value="Berat">Berat</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">3. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                        <th width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pengkajian-medis">
                                        <h5 class="section-title">4. Pengkajian Medis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit Sekarang</label>
                                            <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4"
                                                placeholder="Masukkan riwayat penyakit sekarang"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit Terdahulu</label>
                                            <textarea class="form-control" name="riwayat_penyakit_terdahulu" rows="4"
                                                placeholder="Masukkan riwayat penyakit terdahulu"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Perkembangan Masa Kanak</label>
                                            <textarea class="form-control" name="riwayat_perkembangan_masa_kanak"
                                                rows="4" placeholder="Masukkan riwayat perkembangan masa kanak"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit Masa Dewasa</label>
                                            <input type="text" class="form-control" name="riwayat_penyakit_masa_dewasa"
                                                placeholder="Masukkan riwayat penyakit masa dewasa">
                                        </div>

                                         <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Kesehatan Keluarga</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyStateRiwayat" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada riwayat kesehatan keluarga yang ditambahkan.</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="riwayat_kesehatan_keluarga" id="riwayatKesehatanInput">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Terapi yang diberikan</label>
                                            <textarea class="form-control" name="terapi_diberikan"
                                                rows="4" placeholder="Masukkan terapi yang diberikan"></textarea>
                                        </div>

                                    </div>


                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">5. Pemeriksaan Fisik</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Pemeriksaan Psikiatri</label>
                                            <textarea class="form-control" name="pemeriksaan_psikiatri"
                                                rows="4" placeholder="Masukkan pemeriksaan psikiatri"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Status Internis</label>
                                            <textarea class="form-control" name="status_internis"
                                                rows="4" placeholder="Masukkan status internis"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Status Neorologi</label>
                                            <textarea class="form-control" name="status_neorologi"
                                                rows="4" placeholder="Masukkan status neurologi"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Pemeriksaan Penunjang</label>
                                            <textarea class="form-control" name="pemeriksaan_penunjang"
                                                rows="4" placeholder="Masukkan pemeriksaan penunjang"></textarea>
                                        </div>

                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="fw-semibold mb-4">6. Diagnosis</h5>

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-banding-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Banding">
                                                <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>

                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                value="[]">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Axis I</label>
                                            <input type="text" class="form-control" name="axis_i" placeholder="Masukkan Axis I">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Axis II</label>
                                            <input type="text" class="form-control" name="axis_ii" placeholder="Masukkan Axis II">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Axis III</label>
                                            <input type="text" class="form-control" name="axis_iii" placeholder="Masukkan Axis III">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Axis IV</label>
                                            <input type="text" class="form-control" name="axis_iv" placeholder="Masukkan Axis IV">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Axis V</label>
                                            <input type="text" class="form-control" name="axis_v" placeholder="Masukkan Axis V">
                                        </div>

                                    </div>

                                    <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                        <h5 class="fw-semibold mb-4">7. Prognosis dan Therapy</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Therapi</label>
                                            <textarea class="form-control" name="therapi"
                                                rows="4" placeholder="Masukkan terapi"></textarea>
                                        </div>

                                    </div>

                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Prognosis</label>

                                        <select class="form-select" name="prognosis">
                                            <option value="">--Pilih Prognosis--</option>
                                            @forelse ($satsetPrognosis as $item)
                                                <option value="{{ $item->prognosis_id }}">
                                                    {{ $item->value ?? 'Field tidak ditemukan' }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Tidak ada data</option>
                                            @endforelse
                                        </select>
                                    </div>


                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-check"></i> Simpan
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.modal-create-alergi')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.modal-riwayatkeluarga')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.include')
