@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Edit Asesmen Medis Psiakitri',
                    'description' => 'Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

                {{-- FORM EDIT ASESMEN PSIKIATRI --}}
                <form method="POST"
                    action="{{ route('rawat-inap.asesmen.medis.psikiatri.update', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                        'id' => $id,
                    ]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="px-3">
                        <div>

                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal_masuk"
                                            id="tanggal_masuk"
                                            value="{{ $asesmenPsikiatri ? date('Y-m-d', strtotime($asesmenPsikiatri->waktu_masuk)) : date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                            value="{{ $asesmenPsikiatri ? date('H:i', strtotime($asesmenPsikiatri->waktu_masuk)) : date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kondisi Masuk</label>
                                    <select class="form-select" name="kondisi_masuk">
                                        <option disabled>Pilih</option>
                                        <option value="Mandiri"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->kondisi_masuk == 'Mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="Jalan Kaki"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->kondisi_masuk == 'Jalan Kaki' ? 'selected' : '' }}>
                                            Jalan Kaki</option>
                                        <option value="Kursi Roda"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->kondisi_masuk == 'Kursi Roda' ? 'selected' : '' }}>
                                            Kursi Roda</option>
                                        <option value="Brankar"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->kondisi_masuk == 'Brankar' ? 'selected' : '' }}>
                                            Brankar</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Diagnosis Masuk</label>
                                    <input type="text" class="form-control" name="diagnosis_masuk"
                                        value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->diagnosis_masuk : '' }}">
                                </div>
                            </div>

                            <div class="section-separator" id="pengkajian-keperawatan">
                                <h5 class="section-title">2. Pengkajian Keperawatan</h5>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Anamnesis</label>
                                    <input type="text" class="form-control" name="anamnesis"
                                        placeholder="Masukkan anamnesis" required
                                        value="{{ $asesmen ? $asesmen->anamnesis : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                    <textarea class="form-control" name="keluhan_utama" rows="4"
                                        placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit" required>{{ $asesmenPsikiatri ? $asesmenPsikiatri->keluhan_utama : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Sensorium</label>
                                    <select class="form-select" name="sensorium">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="Compos Mentis"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->sensorium == 'Compos Mentis' ? 'selected' : '' }}>
                                            Compos Mentis</option>
                                        <option value="Apatis"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->sensorium == 'Apatis' ? 'selected' : '' }}>
                                            Apatis</option>
                                        <option value="Somnolen"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->sensorium == 'Somnolen' ? 'selected' : '' }}>
                                            Somnolen</option>
                                        <option value="Sopor"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->sensorium == 'Sopor' ? 'selected' : '' }}>
                                            Sopor</option>
                                        <option value="Coma"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->sensorium == 'Coma' ? 'selected' : '' }}>
                                            Coma</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                placeholder="120" min="70" max="300"
                                                value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->tekanan_darah_sistole : '' }}">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                placeholder="80" min="40" max="150"
                                                value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->tekanan_darah_diastole : '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Suhu (°C)</label>
                                    <input type="text" class="form-control" name="suhu" step="0.1"
                                        placeholder="36.5" min="30" max="45"
                                        value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->suhu : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                    <input type="number" class="form-control" name="respirasi" placeholder="20"
                                        min="10" max="50"
                                        value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->respirasi : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                    <input type="number" class="form-control" name="nadi" placeholder="80"
                                        min="40" max="200"
                                        value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->nadi : '' }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Skala Nyeri (1-10)</label>
                                            <input type="number" class="form-control" name="skala_nyeri"
                                                id="skala_nyeri" min="1" max="10"
                                                placeholder="1-10" value="{{ $asesmenPsikiatri->skala_nyeri }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kategori Nyeri</label>
                                            <input type="text" class="form-control" name="kategori_nyeri"
                                                id="kategori_nyeri" readonly placeholder="Akan terisi otomatis"
                                                value="{{ $asesmenPsikiatri->kategori_nyeri }}">
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
                                        placeholder="Masukkan alat bantu yang digunakan"
                                        value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->alat_bantu : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Cacat Tubuh</label>
                                    <input type="text" class="form-control" name="cacat_tubuh"
                                        placeholder="Sebutkan jenis cacat tubuh"
                                        value="{{ $asesmenPsikiatri ? $asesmenPsikiatri->cacat_tubuh : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">ADL</label>
                                    <select class="form-select" name="adl">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="Mandiri"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->adl == 'Mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="Dibantu"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->adl == 'Dibantu' ? 'selected' : '' }}>
                                            Dibantu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Resiko Jatuh</label>
                                    <select class="form-select" name="resiko_jatuh">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="Ringan"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->resiko_jatuh == 'Ringan' ? 'selected' : '' }}>
                                            Ringan</option>
                                        <option value="Sedang"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->resiko_jatuh == 'Sedang' ? 'selected' : '' }}>
                                            Sedang</option>
                                        <option value="Berat"
                                            {{ $asesmenPsikiatri && $asesmenPsikiatri->resiko_jatuh == 'Berat' ? 'selected' : '' }}>
                                            Berat</option>
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
                                                <td colspan="5" class="text-center text-muted">Tidak ada data
                                                    alergi</td>
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
                                        placeholder="Masukkan riwayat penyakit sekarang">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->riwayat_penyakit_sekarang : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Penyakit Terdahulu</label>
                                    <textarea class="form-control" name="riwayat_penyakit_terdahulu" rows="4"
                                        placeholder="Masukkan riwayat penyakit terdahulu">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->riwayat_penyakit_terdahulu : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Perkembangan Masa Kanak</label>
                                    <textarea class="form-control"
                                        name="riwayat_penyakit_perkembangan_masa_kanak" rows="4"
                                        placeholder="Masukkan riwayat penyakit perkembangan masa kanak">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->riwayat_penyakit_perkembangan_masa_kanak : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Penyakit Masa Dewasa</label>
                                    <input type="text" class="form-control"
                                        name="riwayat_penyakit_masa_dewasa"
                                        placeholder="Masukkan riwayat penyakit masa dewasa"
                                        value="{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->riwayat_penyakit_masa_dewasa : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Kesehatan Keluarga</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                            <!-- Data akan dimuat dari JavaScript -->
                                        </div>
                                        <!-- Hidden input to store the JSON data -->
                                        <input type="hidden" name="riwayat_kesehatan_keluarga"
                                            id="riwayatKesehatanInput">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Terapi yang diberikan</label>
                                    <textarea class="form-control" name="terapi_diberikan" rows="4" placeholder="Masukkan terapi yang diberikan">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->terapi_diberikan : '' }}</textarea>
                                </div>

                            </div>


                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">5. Pemeriksaan Fisik</h5>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Pemeriksaan Psikiatri</label>
                                    <textarea class="form-control" name="pemeriksaan_psikiatri" rows="4"
                                        placeholder="Masukkan pemeriksaan psikiatri">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->pemeriksaan_psikiatri : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Status Internis</label>
                                    <textarea class="form-control" name="status_internis" rows="4" placeholder="Masukkan status internis">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->status_internis : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Status Neorologi</label>
                                    <textarea class="form-control" name="status_neorologi" rows="4" placeholder="Masukkan status neurologi">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->status_neorologi : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Pemeriksaan Penunjang</label>
                                    <textarea class="form-control" name="pemeriksaan_penunjang" rows="4"
                                        placeholder="Masukkan pemeriksaan penunjang">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->pemeriksaan_penunjang : '' }}</textarea>
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
                                        value="{{ $asesmenPsikiatriDtl->diagnosis_banding ?? '[]' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Axis I</label>
                                    <input type="text" class="form-control" name="axis_i"
                                        placeholder="Masukkan Axis I"
                                        value="{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->axis_i : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Axis II</label>
                                    <input type="text" class="form-control" name="axis_ii"
                                        placeholder="Masukkan Axis II"
                                        value="{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->axis_ii : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Axis III</label>
                                    <input type="text" class="form-control" name="axis_iii"
                                        placeholder="Masukkan Axis III"
                                        value="{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->axis_iii : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Axis IV</label>
                                    <input type="text" class="form-control" name="axis_iv"
                                        placeholder="Masukkan Axis IV"
                                        value="{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->axis_iv : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Axis V</label>
                                    <input type="text" class="form-control" name="axis_v"
                                        placeholder="Masukkan Axis V"
                                        value="{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->axis_v : '' }}">
                                </div>

                            </div>

                            <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                <h5 class="fw-semibold mb-4">7. Prognosis dan Therapy</h5>

                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Therapy</label>
                                    <textarea class="form-control" name="therapi" rows="4" placeholder="Masukkan terapi">{{ $asesmenPsikiatriDtl ? $asesmenPsikiatriDtl->therapi : '' }}</textarea>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="text-primary fw-semibold">Prognosis</label>

                                <select class="form-select" name="prognosis">
                                    <option value="">--Pilih Prognosis--</option>
                                    @forelse ($satsetPrognosis as $item)
                                        <option value="{{ $item->prognosis_id }}"
                                            {{ isset($asesmenPsikiatriDtl->prognosis) && $asesmenPsikiatriDtl->prognosis == $item->prognosis_id ? 'selected' : '' }}>
                                            {{ $item->value ?? 'Field tidak ditemukan' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada data</option>
                                    @endforelse
                                </select>
                            </div>


                            <div class="text-end">
                                <x-button-submit>Perbarui</x-button-submit>
                            </div>

                        </div>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection


<!-- Modal for adding family health history -->
<div class="modal fade" id="riwayatKeluargaModal" tabindex="-1" aria-labelledby="riwayatKeluargaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatKeluargaModalLabel">Tambah Riwayat Kesehatan Keluarga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="riwayatInput" class="form-label">Riwayat Kesehatan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="riwayatInput"
                            placeholder="Masukkan riwayat kesehatan">
                        <button class="btn btn-outline-secondary" type="button" id="tambahKeListRiwayat">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Temporary list in modal -->
                <div id="modalRiwayatList" class="d-flex flex-column gap-2">
                    <div id="modalEmptyStateRiwayat"
                        class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                        <p class="mb-0">Belum ada riwayat dalam list sementara</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanRiwayat"
                    data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Input Alergi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                <select class="form-select" id="modal_jenis_alergi">
                                    <option value="">-- Pilih Jenis Alergi --</option>
                                    <option value="Obat">Obat</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Udara">Udara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_alergen" class="form-label">Alergen</label>
                                <input type="text" class="form-control" id="modal_alergen"
                                    placeholder="Contoh: Paracetamol, Seafood, Debu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_reaksi" class="form-label">Reaksi</label>
                                <input type="text" class="form-control" id="modal_reaksi"
                                    placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                <select class="form-select" id="modal_tingkat_keparahan">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                <i class="bi bi-plus"></i> Tambah ke Daftar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Alergi -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                        <span class="badge bg-primary" id="alergiCount">0</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="modalAlergiList">
                                    <!-- Data akan ditampilkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                            <i class="bi bi-info-circle"></i> Belum ada data alergi
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveAlergiData">
                    <i class="bi bi-check"></i> Simpan Data Alergi
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        /* TAMBAHKAN DI CSS SECTION */
        /* TAMBAHKAN DI CSS SECTION */

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-list {
            min-height: 80px;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .diagnosis-item {
            transition: all 0.2s ease;
            border: 1px solid #e3e6f0 !important;
        }

        .diagnosis-item:hover {
            background-color: #f8f9fa !important;
            border-color: #097dd6 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .suggestions-list {
            max-height: 200px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s ease;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item.text-primary:hover {
            background-color: #e3f2fd;
        }

        .input-group-text {
            background-color: white;
            border-color: #ced4da;
        }

        .input-group .form-control {
            border-color: #ced4da;
        }

        .input-group:focus-within .input-group-text {
            border-color: #097dd6;
        }

        .input-group:focus-within .form-control {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        #add-diagnosis-banding,
        #add-diagnosis-kerja {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        #add-diagnosis-banding:hover,
        #add-diagnosis-kerja:hover {
            background-color: #097dd6 !important;
            color: white !important;
        }

        #add-diagnosis-banding:hover .bi-plus-circle,
        #add-diagnosis-kerja:hover .bi-plus-circle {
            color: white !important;
        }

        .diagnosis-item .btn {
            transition: all 0.2s ease;
        }

        .diagnosis-item .btn:hover {
            background-color: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        /* TAMBAHKAN DI CSS SECTION */
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            //====================================================================================//
            // RIWAYAT KESEHATAN KELUARGA - EDIT MODE
            //====================================================================================//

            // Arrays to store the health history
            let riwayatList = [];
            let tempRiwayatList = [];

            // Load existing data from PHP
            try {
                // GANTI dari riwayat_penyakit_keluarga menjadi riwayat_kesehatan_keluarga
                const existingRiwayatKeluarga = @json(json_decode($asesmenPsikiatriDtl->riwayat_kesehatan_keluarga ?? '[]', true));
                console.log('Raw data from PHP:', existingRiwayatKeluarga); // Debug log

                if (Array.isArray(existingRiwayatKeluarga)) {
                    riwayatList = existingRiwayatKeluarga;
                }
            } catch (e) {
                console.log('Data riwayat keluarga tidak valid atau kosong:', e);
                riwayatList = [];
            }

            // Function to update the main UI and hidden input
            function updateRiwayatList() {
                const listContainer = document.getElementById('selectedRiwayatList');
                const hiddenInput = document.getElementById('riwayatKesehatanInput');

                // Clear the current list
                listContainer.innerHTML = '';

                if (riwayatList.length === 0) {
                    const emptyState = document.createElement('div');
                    emptyState.className =
                        'border border-dashed border-secondary rounded p-3 text-center text-muted';
                    emptyState.innerHTML =
                        '<i class="ti-info-circle mb-2"></i><p class="mb-0">Belum ada riwayat kesehatan keluarga yang ditambahkan.</p>';
                    listContainer.appendChild(emptyState);
                } else {
                    // Add each health history to the list
                    riwayatList.forEach((riwayat, index) => {
                        const item = document.createElement('div');
                        item.className =
                            'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                        item.innerHTML = `
                            <span>${riwayat}</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRiwayat(${index})">
                                <i class="ti-trash"></i>
                            </button>
                        `;
                        listContainer.appendChild(item);
                    });
                }

                // Update hidden input with JSON string
                hiddenInput.value = JSON.stringify(riwayatList);
            }

            // Function to update the modal's temporary list
            function updateModalRiwayatList() {
                const modalList = document.getElementById('modalRiwayatList');

                // Clear the current list
                modalList.innerHTML = '';

                if (tempRiwayatList.length === 0) {
                    const modalEmptyState = document.createElement('div');
                    modalEmptyState.className =
                        'border border-dashed border-secondary rounded p-3 text-center text-muted';
                    modalEmptyState.innerHTML = '<p class="mb-0">Belum ada riwayat dalam list sementara</p>';
                    modalList.appendChild(modalEmptyState);
                } else {
                    // Add each health history to the temporary list
                    tempRiwayatList.forEach((riwayat, index) => {
                        const item = document.createElement('div');
                        item.className =
                            'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                        item.innerHTML = `
                            <span>${riwayat}</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeTempRiwayat(${index})">
                                <i class="ti-trash"></i>
                            </button>
                        `;
                        modalList.appendChild(item);
                    });
                }
            }

            // Function to add a new health history to temporary list
            function addToTempRiwayatList() {
                const input = document.getElementById('riwayatInput');
                const riwayat = input.value.trim();

                if (riwayat) {
                    tempRiwayatList.push(riwayat);
                    updateModalRiwayatList();
                    input.value = '';
                    input.focus();
                }
            }

            // Function to save temporary list to main list
            function saveRiwayat() {
                if (tempRiwayatList.length > 0) {
                    riwayatList = [...riwayatList, ...tempRiwayatList];
                    tempRiwayatList = []; // Clear temporary list
                    updateRiwayatList();
                    updateModalRiwayatList();
                }
            }

            // Global functions
            window.removeRiwayat = function(index) {
                riwayatList.splice(index, 1);
                updateRiwayatList();
            };

            window.removeTempRiwayat = function(index) {
                tempRiwayatList.splice(index, 1);
                updateModalRiwayatList();
            };

            // Add event listeners
            document.getElementById('tambahKeListRiwayat').addEventListener('click', addToTempRiwayatList);
            document.getElementById('simpanRiwayat').addEventListener('click', saveRiwayat);

            // Add event listener for enter key in input
            document.getElementById('riwayatInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addToTempRiwayatList();
                }
            });

            // Reset temporary list when modal is opened
            document.getElementById('riwayatKeluargaModal').addEventListener('show.bs.modal', function() {
                tempRiwayatList = [];
                updateModalRiwayatList();
                document.getElementById('riwayatInput').value = '';
            });

            // Initial load
            updateRiwayatList();


            //====================================================================================//
            // SKALA NYERI - EDIT MODE
            //====================================================================================//

            // Function untuk update kategori nyeri otomatis
            document.getElementById('skala_nyeri').addEventListener('input', function() {
                const nilai = parseInt(this.value);
                const kategoriField = document.getElementById('kategori_nyeri');

                if (nilai >= 1 && nilai <= 3) {
                    kategoriField.value = 'Nyeri Ringan';
                } else if (nilai >= 4 && nilai <= 6) {
                    kategoriField.value = 'Nyeri Sedang';
                } else if (nilai >= 7 && nilai <= 9) {
                    kategoriField.value = 'Nyeri Berat';
                } else if (nilai === 10) {
                    kategoriField.value = 'Nyeri Tak Tertahankan';
                } else {
                    kategoriField.value = '';
                }
            });

            // Trigger event untuk set kategori nyeri pada load jika ada nilai
            const initialSkalaNyeri = document.getElementById('skala_nyeri').value;
            if (initialSkalaNyeri) {
                document.getElementById('skala_nyeri').dispatchEvent(new Event('input'));
            }

            //====================================================================================//
            // ALERGI - EDIT MODE
            //====================================================================================//

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Load existing alergi data from PHP
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners untuk alergi
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        alert('Harap isi semua field alergi');
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('Data alergi sudah ada');
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Functions untuk alergi
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Global functions untuk onclick events
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Initial load untuk alergi
            updateMainAlergiTable();
            updateHiddenAlergiInput();

            //====================================================================================//
            // DIAGNOSIS - EDIT MODE
            //====================================================================================//

            // Initialize diagnosis management for both types
            initDiagnosisManagementEdit('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagementEdit('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagementEdit(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                // Insert suggestions list after input
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Database options
                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};

                // Prepare options array
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data from hidden input (existing data)
                let diagnosisList = [];
                try {
                    const existingData = hiddenInput.value;
                    if (existingData && existingData !== '[]') {
                        diagnosisList = JSON.parse(existingData);
                    }
                    renderDiagnosisList();
                } catch (e) {
                    console.log(`Error parsing ${prefix} data:`, e);
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function() {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        // Filter database options
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        // Show suggestions
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        // Hide suggestions if input is empty
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
                        // Render existing options
                        options.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer hover:bg-light';
                            suggestionItem.style.cursor = 'pointer';

                            // Highlight matching text
                            const text = option.text;
                            const lowerText = text.toLowerCase();
                            const lowerInput = inputValue.toLowerCase();
                            const index = lowerText.indexOf(lowerInput);

                            if (index >= 0) {
                                const before = text.substring(0, index);
                                const match = text.substring(index, index + inputValue.length);
                                const after = text.substring(index + inputValue.length);
                                suggestionItem.innerHTML = `${before}<strong>${match}</strong>${after}`;
                            } else {
                                suggestionItem.textContent = text;
                            }

                            suggestionItem.addEventListener('click', () => {
                                addDiagnosis(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!options.some(opt => opt.text.toLowerCase() === inputValue)) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.style.cursor = 'pointer';
                            newOptionItem.innerHTML =
                                `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addDiagnosis(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.style.cursor = 'pointer';
                        newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addDiagnosis(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add diagnosis when plus button is clicked
                addButton.addEventListener('click', function() {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    // Check for duplicates
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';

                        // Show success feedback
                        showFeedback(`"${diagnosisText}" berhasil ditambahkan`, 'success');
                    } else {
                        // Show duplicate feedback
                        showFeedback(`"${diagnosisText}" sudah ada dalam daftar`, 'warning');
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';

                    if (diagnosisList.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'text-muted text-center py-3';
                        emptyMessage.innerHTML =
                            '<i class="bi bi-info-circle me-2"></i>Belum ada diagnosis yang ditambahkan';
                        listContainer.appendChild(emptyMessage);
                    } else {
                        diagnosisList.forEach((diagnosis, index) => {
                            const diagnosisItem = document.createElement('div');
                            diagnosisItem.className =
                                'diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 bg-white rounded border';

                            const diagnosisSpan = document.createElement('span');
                            diagnosisSpan.innerHTML = `<strong>${index + 1}.</strong> ${diagnosis}`;

                            const deleteButton = document.createElement('button');
                            deleteButton.className = 'btn btn-sm text-danger';
                            deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                            deleteButton.type = 'button';
                            deleteButton.title = 'Hapus diagnosis';
                            deleteButton.addEventListener('click', function() {
                                diagnosisList.splice(index, 1);
                                renderDiagnosisList();
                                updateHiddenInput();
                                showFeedback(`Diagnosis "${diagnosis}" berhasil dihapus`, 'info');
                            });

                            diagnosisItem.appendChild(diagnosisSpan);
                            diagnosisItem.appendChild(deleteButton);
                            listContainer.appendChild(diagnosisItem);
                        });
                    }
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }

                function showFeedback(message, type) {
                    // Create feedback element
                    const feedback = document.createElement('div');
                    feedback.className = `alert alert-${type} alert-dismissible fade show mt-2`;
                    feedback.innerHTML = `
                        <small>${message}</small>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    `;

                    // Insert after list container
                    listContainer.parentNode.insertBefore(feedback, listContainer.nextSibling);

                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        if (feedback.parentNode) {
                            feedback.classList.remove('show');
                            setTimeout(() => {
                                if (feedback.parentNode) {
                                    feedback.parentNode.removeChild(feedback);
                                }
                            }, 150);
                        }
                    }, 3000);
                }

                // Initialize with existing data
                console.log(`${prefix} initialized with ${diagnosisList.length} items`);
            }



        });
    </script>
@endpush
