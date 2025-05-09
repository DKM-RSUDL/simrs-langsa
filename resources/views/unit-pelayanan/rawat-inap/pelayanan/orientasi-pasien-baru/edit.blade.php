@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Detail Orientasi Pasien Baru</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.orientasi-pasien-baru.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $orientasiPasienBaru->id]) }}"
                    method="post">
                    @csrf
                    @method('put')

                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal"
                                               value="{{ old('tanggal', $orientasiPasienBaru->tanggal ?? date('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label fw-bold">Hubungan dengan pasien</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-group">
                                                    <select class="form-select" name="hubungan" id="hubungan">
                                                        <option value="">Pilih Hubungan...</option>
                                                        <option value="saya_sendiri" {{ $orientasiPasienBaru->hubungan === 'saya_sendiri' ? 'selected' : '' }}>
                                                            Saya (pasien) sendiri</option>
                                                        <option value="ayah" {{ $orientasiPasienBaru->hubungan === 'ayah' ? 'selected' : '' }}>Ayah</option>
                                                        <option value="ibu" {{ $orientasiPasienBaru->hubungan === 'ibu' ? 'selected' : '' }}>Ibu</option>
                                                        <option value="suami" {{ $orientasiPasienBaru->hubungan === 'suami' ? 'selected' : '' }}>Suami</option>
                                                        <option value="istri" {{ $orientasiPasienBaru->hubungan === 'istri' ? 'selected' : '' }}>Istri</option>
                                                        <option value="anak" {{ $orientasiPasienBaru->hubungan === 'anak' ? 'selected' : '' }}>Anak</option>
                                                        <option value="lainnya" {{ $orientasiPasienBaru->hubungan === 'lainnya' ? 'selected' : '' }}>
                                                            Lainnya</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="lainnya_input" style="display: none;">
                                                    <input type="text" class="form-control" name="hubungan_lainnya"
                                                        value="{{ $orientasiPasienBaru->hubungan_lainnya ?? '' }}"
                                                        placeholder="Sebutkan...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Yang menerima informasi</label>
                                                <input type="text" class="form-control" name="nama_penerima"
                                                    value="{{ $orientasiPasienBaru->nama_penerima ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tata Tertib Rumah Sakit -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-clipboard-check text-primary me-2"></i>
                                    1. Tata tertib Rumah Sakit
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="jam_berkunjung" value="jam_berkunjung" {{ is_array($orientasiPasienBaru->tata_tertib) && in_array('jam_berkunjung', $orientasiPasienBaru->tata_tertib) ? 'checked' : '' }}>
                                                <span>Jam berkunjung</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="peraturan_menunggu_pasien"
                                                    value="peraturan_menunggu_pasien" {{ is_array($orientasiPasienBaru->tata_tertib) && in_array('peraturan_menunggu_pasien', $orientasiPasienBaru->tata_tertib) ? 'checked' : '' }}>
                                                <span>Peraturan menunggu pasien</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="dilarang_merokok" value="dilarang_merokok" {{ is_array($orientasiPasienBaru->tata_tertib) && in_array('dilarang_merokok', $orientasiPasienBaru->tata_tertib) ? 'checked' : '' }}>
                                                <span>Dilarang merokok</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="menyimpan_barang" value="menyimpan_barang" {{ is_array($orientasiPasienBaru->tata_tertib) && in_array('menyimpan_barang', $orientasiPasienBaru->tata_tertib) ? 'checked' : '' }}>
                                                <span>Menyimpan barang-barang berharga milik pasien / keluarga</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="izin_keluar" value="izin_keluar" {{ is_array($orientasiPasienBaru->tata_tertib) && in_array('izin_keluar', $orientasiPasienBaru->tata_tertib) ? 'checked' : '' }}>
                                                <span>Izin keluar kamar / rumah sakit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="kebersihan_ruangan" value="kebersihan_ruangan" {{ is_array($orientasiPasienBaru->tata_tertib) && in_array('kebersihan_ruangan', $orientasiPasienBaru->tata_tertib) ? 'checked' : '' }}>
                                                <span>Kebersihan dan kerapian ruangan</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penggunaan Fasilitas Ruangan -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-hospital text-primary me-2"></i>
                                    2. Penggunaan Fasilitas Ruangan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="bel_pasien" value="bel_pasien" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('bel_pasien', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Bel Pasien</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="tempat_tidur" value="tempat_tidur" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('tempat_tidur', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Tempat tidur</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="lemari_baju" value="lemari_baju" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('lemari_baju', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Lemari baju dan nakas (bed side cabinet)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="ac_kipas" value="ac_kipas" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('ac_kipas', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Air Conditioner (AC) / kipas angin</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="peralatan_makan" value="peralatan_makan" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('peralatan_makan', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Peralatan makan / meja makan pasien</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="sofa_kursi" value="sofa_kursi" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('sofa_kursi', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Sofa dan kursi</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="tv_lampu_kulkas" value="tv_lampu_kulkas" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('tv_lampu_kulkas', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Televisi/Lampu/Kulkas</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="kamar_mandi" value="kamar_mandi" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('kamar_mandi', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Kamar mandi (kloset, dll)</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="fasilitas_lainnya" value="fasilitas_lainnya" {{ is_array($orientasiPasienBaru->fasilitas) && in_array('fasilitas_lainnya', $orientasiPasienBaru->fasilitas) ? 'checked' : '' }}>
                                                <span>Lain2</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="fasilitas_lainnya_text"
                                                    value="{{ $orientasiPasienBaru->fasilitas_lainnya_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tenaga Medis yang merawat -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-person-badge text-primary me-2"></i>
                                    3. Tenaga Medis yang merawat
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="dokter_ruangan" value="dokter_ruangan" {{ is_array($orientasiPasienBaru->tenaga_medis) && in_array('dokter_ruangan', $orientasiPasienBaru->tenaga_medis) ? 'checked' : '' }}>
                                                <span>Dokter ruangan</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="waktu_visit" value="waktu_visit" {{ is_array($orientasiPasienBaru->tenaga_medis) && in_array('waktu_visit', $orientasiPasienBaru->tenaga_medis) ? 'checked' : '' }}>
                                                <span>Waktu visit dokter</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="dokter_spesialis" value="dokter_spesialis" {{ is_array($orientasiPasienBaru->tenaga_medis) && in_array('dokter_spesialis', $orientasiPasienBaru->tenaga_medis) ? 'checked' : '' }}>
                                                <span>Dokter spesialis</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="perawat" value="perawat" {{ is_array($orientasiPasienBaru->tenaga_medis) && in_array('perawat', $orientasiPasienBaru->tenaga_medis) ? 'checked' : '' }}>
                                                <span>Perawat</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan ruangan -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    4. Kegiatan ruangan, meliputi:
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="aktivitas_rutin" value="aktivitas_rutin" {{ is_array($orientasiPasienBaru->kegiatan) && in_array('aktivitas_rutin', $orientasiPasienBaru->kegiatan) ? 'checked' : '' }}>
                                                <span>Aktifitas rutin (hand over, visite)</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="info_pasien_pulang" value="info_pasien_pulang" {{ is_array($orientasiPasienBaru->kegiatan) && in_array('info_pasien_pulang', $orientasiPasienBaru->kegiatan) ? 'checked' : '' }}>
                                                <span>Informasi tentang pasien pulang</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="waktu_pergantian_dinas"
                                                    value="waktu_pergantian_dinas" {{ is_array($orientasiPasienBaru->kegiatan) && in_array('waktu_pergantian_dinas', $orientasiPasienBaru->kegiatan) ? 'checked' : '' }}>
                                                <span>Waktu pergantian dinas</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="pemeriksaan_laboratorium"
                                                    value="pemeriksaan_laboratorium" {{ is_array($orientasiPasienBaru->kegiatan) && in_array('pemeriksaan_laboratorium', $orientasiPasienBaru->kegiatan) ? 'checked' : '' }}>
                                                <span>Pemeriksaan laboratorium</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="pemeriksaan_radiologi" value="pemeriksaan_radiologi"
                                                    {{ is_array($orientasiPasienBaru->kegiatan) && in_array('pemeriksaan_radiologi', $orientasiPasienBaru->kegiatan) ? 'checked' : '' }}>
                                                <span>Pemeriksaan radiologi</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="kegiatan_lainnya" value="kegiatan_lainnya" {{ is_array($orientasiPasienBaru->kegiatan) && in_array('kegiatan_lainnya', $orientasiPasienBaru->kegiatan) ? 'checked' : '' }}>
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="kegiatan_lainnya_text"
                                                    value="{{ $orientasiPasienBaru->kegiatan_lainnya_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi di ruang perawatan -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    5. Lokasi di ruang perawatan dan sekitarnya
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="nurse_station" value="nurse_station" {{ is_array($orientasiPasienBaru->lokasi) && in_array('nurse_station', $orientasiPasienBaru->lokasi) ? 'checked' : '' }}>
                                                <span>Nurse station</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="kamar_mandi_lokasi" value="kamar_mandi" {{ is_array($orientasiPasienBaru->lokasi) && in_array('kamar_mandi', $orientasiPasienBaru->lokasi) ? 'checked' : '' }}>
                                                <span>Kamar mandi</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="musholla" value="musholla" {{ is_array($orientasiPasienBaru->lokasi) && in_array('musholla', $orientasiPasienBaru->lokasi) ? 'checked' : '' }}>
                                                <span>Musholla</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="lokasi_lainnya" value="lokasi_lainnya" {{ is_array($orientasiPasienBaru->lokasi) && in_array('lokasi_lainnya', $orientasiPasienBaru->lokasi) ? 'checked' : '' }}>
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="lokasi_lainnya_text"
                                                    value="{{ $orientasiPasienBaru->lokasi_lainnya_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Administrasi tentang Pasien -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                    6. Administrasi tentang Pasien yang akan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pulang_rawat" value="pulang_rawat" {{ is_array($orientasiPasienBaru->administrasi) && in_array('pulang_rawat', $orientasiPasienBaru->administrasi) ? 'checked' : '' }}>
                                                <span>Pulang rawat</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pindah_kamar" value="pindah_kamar" {{ is_array($orientasiPasienBaru->administrasi) && in_array('pindah_kamar', $orientasiPasienBaru->administrasi) ? 'checked' : '' }}>
                                                <span>Pindah Kamar</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="selisih_kamar" value="selisih_kamar" {{ is_array($orientasiPasienBaru->administrasi) && in_array('selisih_kamar', $orientasiPasienBaru->administrasi) ? 'checked' : '' }}>
                                                <span>Selisih kamar</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pindah_ruangan" value="pindah_ruangan" {{ is_array($orientasiPasienBaru->administrasi) && in_array('pindah_ruangan', $orientasiPasienBaru->administrasi) ? 'checked' : '' }}>
                                                <span>Pindah ruangan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pindah_rs" value="pindah_rs" {{ is_array($orientasiPasienBaru->administrasi) && in_array('pindah_rs', $orientasiPasienBaru->administrasi) ? 'checked' : '' }}>
                                                <span>Pindah rumah sakit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="administrasi_lainnya" value="administrasi_lainnya"
                                                    {{ is_array($orientasiPasienBaru->administrasi) && in_array('administrasi_lainnya', $orientasiPasienBaru->administrasi) ? 'checked' : '' }}>
                                                <span>Lain-lain</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="administrasi_lainnya_text"
                                                    value="{{ $orientasiPasienBaru->administrasi_lainnya_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Barang-barang yang dibawa pasien -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-briefcase text-primary me-2"></i>
                                    7. Barang-barang yang dibawa pasien
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="alat_pendengaran" value="alat_pendengaran" {{ is_array($orientasiPasienBaru->barang) && in_array('alat_pendengaran', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Alat pendengaran</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="alat_pembayaran" value="alat_pembayaran" {{ is_array($orientasiPasienBaru->barang) && in_array('alat_pembayaran', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Alat pembayaran</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="contact_lens" value="contact_lens" {{ is_array($orientasiPasienBaru->barang) && in_array('contact_lens', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Contact lens</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="gigi_palsu" value="gigi_palsu" {{ is_array($orientasiPasienBaru->barang) && in_array('gigi_palsu', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Gigi palsu</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="kacamata" value="kacamata" {{ is_array($orientasiPasienBaru->barang) && in_array('kacamata', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Kacamata</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="jam_tangan" value="jam_tangan" {{ is_array($orientasiPasienBaru->barang) && in_array('jam_tangan', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Jam tangan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="perhiasan" value="perhiasan" {{ is_array($orientasiPasienBaru->barang) && in_array('perhiasan', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Perhiasan</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="alat_komunikasi" value="alat_komunikasi" {{ is_array($orientasiPasienBaru->barang) && in_array('alat_komunikasi', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Alat komunikasi</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="laptop" value="laptop" {{ is_array($orientasiPasienBaru->barang) && in_array('laptop', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Laptop</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="barang_lainnya_1" value="barang_lainnya_1" {{ is_array($orientasiPasienBaru->barang) && in_array('barang_lainnya_1', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="barang_lainnya_1_text"
                                                    value="{{ $orientasiPasienBaru->barang_lainnya_1_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="barang_lainnya_2" value="barang_lainnya_2" {{ is_array($orientasiPasienBaru->barang) && in_array('barang_lainnya_2', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="barang_lainnya_2_text"
                                                    value="{{ $orientasiPasienBaru->barang_lainnya_2_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="barang_lainnya_3" value="barang_lainnya_3" {{ is_array($orientasiPasienBaru->barang) && in_array('barang_lainnya_3', $orientasiPasienBaru->barang) ? 'checked' : '' }}>
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="barang_lainnya_3_text"
                                                    value="{{ $orientasiPasienBaru->barang_lainnya_3_text ?? '' }}"
                                                    placeholder="Sebutkan...">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi lainnya -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                    8. Informasi lainnya
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="menutup_pengaman" value="menutup_pengaman" {{ is_array($orientasiPasienBaru->informasi_lainnya) && in_array('menutup_pengaman', $orientasiPasienBaru->informasi_lainnya) ? 'checked' : '' }}>
                                                <span>Selalu menutup pengaman tempat tidur</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="tanggung_jawab_barang" value="tanggung_jawab_barang"
                                                    {{ is_array($orientasiPasienBaru->informasi_lainnya) && in_array('tanggung_jawab_barang', $orientasiPasienBaru->informasi_lainnya) ? 'checked' : '' }}>
                                                <span>Pasien dan keluarga bertanggung jawab penuh atas barang yang
                                                    dibawa ke
                                                    Rumah Sakit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="barang_tidak_perlu" value="barang_tidak_perlu" {{ is_array($orientasiPasienBaru->informasi_lainnya) && in_array('barang_tidak_perlu', $orientasiPasienBaru->informasi_lainnya) ? 'checked' : '' }}>
                                                <span>Barang yang tidak berhubungan dengan perawatan sebaiknya tidak
                                                    perlu
                                                    dibawa</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="tidak_merekam" value="tidak_merekam" {{ is_array($orientasiPasienBaru->informasi_lainnya) && in_array('tidak_merekam', $orientasiPasienBaru->informasi_lainnya) ? 'checked' : '' }}>
                                                <span>Tidak merekam / mengambil gambar dilokasi Rumah Sakit tanpa izin
                                                    pihak
                                                    Rumah Sakit</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kegawatdaruratan -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-exclamation-triangle-fill text-primary me-2"></i>
                                    9. Kegawatdaruratan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegawatdaruratan[]"
                                                    type="checkbox" id="kebakaran_gempa" value="kebakaran_gempa" {{ is_array($orientasiPasienBaru->kegawatdaruratan) && in_array('kebakaran_gempa', $orientasiPasienBaru->kegawatdaruratan) ? 'checked' : '' }}>
                                                <span>Kebakaran, gempa dan bencana lainnya</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegawatdaruratan[]"
                                                    type="checkbox" id="jalur_evakuasi" value="jalur_evakuasi" {{ is_array($orientasiPasienBaru->kegawatdaruratan) && in_array('jalur_evakuasi', $orientasiPasienBaru->kegawatdaruratan) ? 'checked' : '' }}>
                                                <span>Jalur evakuasi dan titik kumpul</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Show/hide lainnya input field for hubungan dengan pasien based on pre-selected value
                const hubunganSelect = document.getElementById('hubungan');
                const lainnyaInput = document.getElementById('lainnya_input');

                if (hubunganSelect && lainnyaInput) {
                    if (hubunganSelect.value === 'lainnya') {
                        lainnyaInput.style.display = 'block';
                    } else {
                        lainnyaInput.style.display = 'none';
                    }
                }
            });
        </script>
    @endpush
@endsection