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
                <h5 class="text-secondary fw-bold">Orientasi Pasien Baru</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.orientasi-pasien-baru.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal"
                                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <!-- Hubungan dengan pasien Section -->
                                        <div class="col-6">
                                            <label class="form-label fw-bold">Hubungan dengan pasien</label>
                                            <div class="row g-2 align-items-center">
                                                <div class="col-auto">
                                                    <select class="form-select" name="hubungan" id="hubungan">
                                                        <option value="">Pilih Hubungan...</option>
                                                        <option value="saya_sendiri">Saya (pasien) sendiri</option>
                                                        <option value="ayah">Ayah</option>
                                                        <option value="ibu">Ibu</option>
                                                        <option value="suami">Suami</option>
                                                        <option value="istri">Istri</option>
                                                        <option value="anak">Anak</option>
                                                        <option value="lainnya">Lainnya</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto" id="lainnya_input" style="display: none;">
                                                    <input type="text" class="form-control" name="hubungan_lainnya" placeholder="Sebutkan...">
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Yang menerima informasi Section -->
                                        <div class="col-6 mt-3">
                                            <label class="form-label fw-bold">Yang menerima informasi</label>
                                            <input type="text" class="form-control" name="nama_penerima" placeholder="Nama dan tanda tangan">
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
                                                    type="checkbox" id="jam_berkunjung" value="jam_berkunjung">
                                                <span>Jam berkunjung</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="peraturan_menunggu_pasien"
                                                    value="peraturan_menunggu_pasien">
                                                <span>Peraturan menunggu pasien</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="dilarang_merokok" value="dilarang_merokok">
                                                <span>Dilarang merokok</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="menyimpan_barang" value="menyimpan_barang">
                                                <span>Menyimpan barang-barang berharga milik pasien / keluarga</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="izin_keluar" value="izin_keluar">
                                                <span>Izin keluar kamar / rumah sakit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tata_tertib[]"
                                                    type="checkbox" id="kebersihan_ruangan" value="kebersihan_ruangan">
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
                                                    type="checkbox" id="bel_pasien" value="bel_pasien">
                                                <span>Bel Pasien</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="tempat_tidur" value="tempat_tidur">
                                                <span>Tempat tidur</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="lemari_baju" value="lemari_baju">
                                                <span>Lemari baju dan nakas (bed side cabinet)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="ac_kipas" value="ac_kipas">
                                                <span>Air Conditioner (AC) / kipas angin</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="peralatan_makan" value="peralatan_makan">
                                                <span>Peralatan makan / meja makan pasien</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="sofa_kursi" value="sofa_kursi">
                                                <span>Sofa dan kursi</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="tv_lampu_kulkas" value="tv_lampu_kulkas">
                                                <span>Televisi/Lampu/Kulkas</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="kamar_mandi" value="kamar_mandi">
                                                <span>Kamar mandi (kloset, dll)</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="fasilitas[]"
                                                    type="checkbox" id="fasilitas_lainnya" value="fasilitas_lainnya">
                                                <span>Lain2</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="fasilitas_lainnya_text" placeholder="Sebutkan...">
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
                                                    type="checkbox" id="dokter_ruangan" value="dokter_ruangan">
                                                <span>Dokter ruangan</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="waktu_visit" value="waktu_visit">
                                                <span>Waktu visit dokter</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="dokter_spesialis" value="dokter_spesialis">
                                                <span>Dokter spesialis</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tenaga_medis[]"
                                                    type="checkbox" id="perawat" value="perawat">
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
                                                    type="checkbox" id="aktivitas_rutin" value="aktivitas_rutin">
                                                <span>Aktifitas rutin (hand over, visite)</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="info_pasien_pulang" value="info_pasien_pulang">
                                                <span>Informasi tentang pasien pulang</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="waktu_pergantian_dinas"
                                                    value="waktu_pergantian_dinas">
                                                <span>Waktu pergantian dinas</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="pemeriksaan_laboratorium"
                                                    value="pemeriksaan_laboratorium">
                                                <span>Pemeriksaan laboratorium</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="pemeriksaan_radiologi"
                                                    value="pemeriksaan_radiologi">
                                                <span>Pemeriksaan radiologi</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegiatan[]"
                                                    type="checkbox" id="kegiatan_lainnya" value="kegiatan_lainnya">
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="kegiatan_lainnya_text" placeholder="Sebutkan...">
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
                                                    type="checkbox" id="nurse_station" value="nurse_station">
                                                <span>Nurse station</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="kamar_mandi_lokasi" value="kamar_mandi">
                                                <span>Kamar mandi</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="musholla" value="musholla">
                                                <span>Musholla</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lokasi[]"
                                                    type="checkbox" id="lokasi_lainnya" value="lokasi_lainnya">
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="lokasi_lainnya_text" placeholder="Sebutkan...">
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
                                                    type="checkbox" id="pulang_rawat" value="pulang_rawat">
                                                <span>Pulang rawat</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pindah_kamar" value="pindah_kamar">
                                                <span>Pindah Kamar</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="selisih_kamar" value="selisih_kamar">
                                                <span>Selisih kamar</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pindah_ruangan" value="pindah_ruangan">
                                                <span>Pindah ruangan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="pindah_rs" value="pindah_rs">
                                                <span>Pindah rumah sakit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="administrasi[]"
                                                    type="checkbox" id="administrasi_lainnya" value="administrasi_lainnya">
                                                <span>Lain-lain</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="administrasi_lainnya_text" placeholder="Sebutkan...">
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
                                                    type="checkbox" id="alat_pendengaran" value="alat_pendengaran">
                                                <span>Alat pendengaran</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="alat_pembayaran" value="alat_pembayaran">
                                                <span>Alat pembayaran</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="contact_lens" value="contact_lens">
                                                <span>Contact lens</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="gigi_palsu" value="gigi_palsu">
                                                <span>Gigi palsu</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="kacamata" value="kacamata">
                                                <span>Kacamata</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="jam_tangan" value="jam_tangan">
                                                <span>Jam tangan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="perhiasan" value="perhiasan">
                                                <span>Perhiasan</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="alat_komunikasi" value="alat_komunikasi">
                                                <span>Alat komunikasi</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="laptop" value="laptop">
                                                <span>Laptop</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="barang_lainnya_1" value="barang_lainnya_1">
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="barang_lainnya_1_text" placeholder="Sebutkan...">
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="barang_lainnya_2" value="barang_lainnya_2">
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="barang_lainnya_2_text" placeholder="Sebutkan...">
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="barang[]"
                                                    type="checkbox" id="barang_lainnya_3" value="barang_lainnya_3">
                                                <span>Lain-lain:</span>
                                                <input type="text" class="form-control form-control-sm ms-2"
                                                    name="barang_lainnya_3_text" placeholder="Sebutkan...">
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
                                                    type="checkbox" id="menutup_pengaman" value="menutup_pengaman">
                                                <span>Selalu menutup pengaman tempat tidur</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="tanggung_jawab_barang"
                                                    value="tanggung_jawab_barang">
                                                <span>Pasien dan keluarga bertanggung jawab penuh atas barang yang dibawa ke
                                                    Rumah Sakit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="barang_tidak_perlu" value="barang_tidak_perlu">
                                                <span>Barang yang tidak berhubungan dengan perawatan sebaiknya tidak perlu
                                                    dibawa</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="informasi_lainnya[]"
                                                    type="checkbox" id="tidak_merekam" value="tidak_merekam">
                                                <span>Tidak merekam / mengambil gambar dilokasi Rumah Sakit tanpa izin pihak
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
                                                    type="checkbox" id="kebakaran_gempa" value="kebakaran_gempa">
                                                <span>Kebakaran, gempa dan bencana lainnya</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="kegawatdaruratan[]"
                                                    type="checkbox" id="jalur_evakuasi" value="jalur_evakuasi">
                                                <span>Jalur evakuasi dan titik kumpul</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-4">                        
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Yang memberikan informasi</label>
                                <input type="text" class="form-control" name="nama_pemberi"
                                    placeholder="Nama dan tanda tangan">
                            </div>
                        </div> --}}
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Show/hide lainnya input field for hubungan dengan pasien
                const lainnyaRadio = document.getElementById('lainnya');
                const lainnyaInput = document.getElementById('lainnya_input');

                if (lainnyaRadio && lainnyaInput) {
                    lainnyaRadio.addEventListener('change', function () {
                        if (this.checked) {
                            lainnyaInput.style.display = 'block';
                        } else {
                            lainnyaInput.style.display = 'none';
                        }
                    });

                    // Check all radio buttons to hide lainnya input if not selected
                    document.querySelectorAll('input[name="hubungan"]').forEach(function (radio) {
                        if (radio.id !== 'lainnya') {
                            radio.addEventListener('change', function () {
                                if (this.checked) {
                                    lainnyaInput.style.display = 'none';
                                }
                            });
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection