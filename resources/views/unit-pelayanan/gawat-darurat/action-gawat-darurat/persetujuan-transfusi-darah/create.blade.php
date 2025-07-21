@extends('layouts.administrator.master')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.persetujuan-transfusi-darah.include')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.persetujuan-transfusi-darah.include-create')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between">
                <a href="{{ route('persetujuan-transfusi-darah.index', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary mb-3">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ asset('assets/file/F.3_persetujuan_transfusi_darah.pdf') }}" class="btn btn-info mb-3"
                    target="_blank" rel="noopener noreferrer">
                    <i class="ti-file-text"></i> Form Edukasi
                </a>
            </div>

            {{-- Duplicate Warning --}}
            <div id="duplicate-warning" class="alert alert-warning" style="display: none;">
                <i class="ti-alert mr-2"></i>
                <span id="duplicate-message"></span>
            </div>

            <form id="transfusi_form" method="POST"
                action="{{ route('persetujuan-transfusi-darah.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="container-fluid">
                    <!-- Header -->
                    <div class="header rounded">
                        <h5><i class="fas fa-hospital-alt"></i> PERSETUJUAN TRANSFUSI DARAH/PRODUK DARAH</h5>
                    </div>

                    <!-- Form Content -->
                    <div class="form-content">
                        <!-- Data Dasar -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-calendar-alt"></i>
                                Data Dasar
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal <span class="required">*</span></label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                        @error('tanggal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jam <span class="required">*</span></label>
                                        <input type="time" class="form-control" id="jam" name="jam"
                                            value="{{ old('jam', date('H:i')) }}" required>
                                        @error('jam')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Diagnosa <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="diagnosa" name="diagnosa"
                                            value="{{ old('diagnosa') }}" placeholder="Masukkan diagnosa pasien" required>
                                        @error('diagnosa')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Persetujuan -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-check"></i>
                                Persetujuan Untuk
                            </div>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="diri_sendiri" name="persetujuan_untuk" value="diri_sendiri" {{ old('persetujuan_untuk') == 'diri_sendiri' ? 'checked' : '' }} required>
                                    <label for="diri_sendiri" class="radio-label">
                                        <i class="fas fa-user"></i><br>
                                        Diri Sendiri
                                    </label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="keluarga" name="persetujuan_untuk" value="keluarga" {{ old('persetujuan_untuk') == 'keluarga' ? 'checked' : '' }} required>
                                    <label for="keluarga" class="radio-label">
                                        <i class="fas fa-users"></i><br>
                                        Keluarga/Wali
                                    </label>
                                </div>
                            </div>
                            @error('persetujuan_untuk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Data Keluarga (Hidden by default) -->
                        <div id="keluarga-section" class="section-card hidden-section"
                            style="{{ old('persetujuan_untuk') == 'keluarga' ? 'display: block;' : 'display: none;' }}">
                            <div class="section-title">
                                <i class="fas fa-users"></i>
                                Data Keluarga/Wali
                            </div>
                            <small class="fw-bold">Saya yang bertanda tangan di bawah ini :</small>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_keluarga" name="nama_keluarga"
                                            value="{{ old('nama_keluarga') }}" placeholder="Masukkan nama lengkap">
                                        @error('nama_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_keluarga"
                                            name="tgl_lahir_keluarga" value="{{ old('tgl_lahir_keluarga') }}">
                                        @error('tgl_lahir_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_keluarga" name="alamat_keluarga" rows="2"
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_keluarga') }}</textarea>
                                        @error('alamat_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_keluarga" name="jk_keluarga">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1" {{ old('jk_keluarga') == 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="0" {{ old('jk_keluarga') == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jk_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp_keluarga" name="no_telp_keluarga"
                                            value="{{ old('no_telp_keluarga') }}" placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="number" class="form-control" id="no_ktp_keluarga" name="no_ktp_keluarga"
                                            value="{{ old('no_ktp_keluarga') }}" placeholder="Masukkan nomor KTP/SIM" maxlength="16">
                                        @error('no_ktp_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hubungan dengan pihak yang diwakili</label>
                                        <input type="text" class="form-control" id="hubungan_keluarga"
                                            name="hubungan_keluarga" value="{{ old('hubungan_keluarga') }}"
                                            placeholder="Contoh: Suami/Istri/Anak/Orang Tua/Wali">
                                        @error('hubungan_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Edukasi -->
                        <div class="info-box">
                            <div class="info-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Edukasi
                            </div>
                            <p class="mb-3">
                                Telah membaca atau dibacakan keterangan pada <span class="fw-bold">form edukasi transfusi
                                    darah</span> (di halaman belakang) dan telah
                                dijelaskan hal-hal terkait mengenai prosedur transfusi darah yang akan dilakukan terhadap
                                diri saya sendiri /
                                pihak yang saya wakili *), sehingga saya :
                            </p>
                            <ul class="info-list">
                                <li>Memahami alasan saya / pihak yang saya wakili memerlukan darah dan produk darah</li>
                                <li>Memahami risiko yang mungkin terjadi saat atau sesudah pelaksanaan pemberian darah dan
                                    produk darah</li>
                                <li>Memahami alternatif pemberian darah dan produk darah</li>
                            </ul>
                        </div>

                        <!-- Data Dokter -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-md"></i>
                                Data Dokter
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Dokter</label>
                                        <!-- Pastikan ID ini unique dan benar -->
                                        <select name="dokter" id="dokter" class="form-select select2" required>
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}">
                                                    {{ $item->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dokter')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Saksi 1 -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-tie"></i>
                                Data Saksi 1
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_saksi1" name="nama_saksi1"
                                            value="{{ old('nama_saksi1') }}" placeholder="Masukkan nama lengkap saksi 1">
                                        @error('nama_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_saksi1"
                                            name="tgl_lahir_saksi1" value="{{ old('tgl_lahir_saksi1') }}">
                                        @error('tgl_lahir_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_saksi1" name="alamat_saksi1" rows="2"
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_saksi1') }}</textarea>
                                        @error('alamat_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_saksi1" name="jk_saksi1">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1" {{ old('jk_saksi1') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="0" {{ old('jk_saksi1') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jk_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp_saksi1" name="no_telp_saksi1"
                                            value="{{ old('no_telp_saksi1') }}" placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="number" class="form-control" id="no_ktp_saksi1" name="no_ktp_saksi1"
                                            value="{{ old('no_ktp_saksi1') }}" placeholder="Masukkan nomor KTP/SIM" maxlength="16">
                                        @error('no_ktp_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Saksi 2 -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-tie"></i>
                                Data Saksi 2
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_saksi2" name="nama_saksi2"
                                            value="{{ old('nama_saksi2') }}" placeholder="Masukkan nama lengkap saksi 2">
                                        @error('nama_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_saksi2"
                                            name="tgl_lahir_saksi2" value="{{ old('tgl_lahir_saksi2') }}">
                                        @error('tgl_lahir_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_saksi2" name="alamat_saksi2" rows="2"
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_saksi2') }}</textarea>
                                        @error('alamat_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_saksi2" name="jk_saksi2">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1" {{ old('jk_saksi2') == 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="0" {{ old('jk_saksi2') == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jk_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp_saksi2" name="no_telp_saksi2"
                                            value="{{ old('no_telp_saksi2') }}" placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="number" class="form-control" id="no_ktp_saksi2" name="no_ktp_saksi2"
                                            value="{{ old('no_ktp_saksi2') }}" placeholder="Masukkan nomor KTP/SIM" maxlength="16">
                                        @error('no_ktp_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Persetujuan -->
                        <div class="consent-section">
                            <div class="consent-title">
                                <i class="fas fa-question-circle"></i>
                                Apakah Anda menyetujui pemberian darah dan produk darah?
                            </div>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="setuju" name="persetujuan" value="setuju" {{ old('persetujuan') == 'setuju' ? 'checked' : '' }} required>
                                    <label for="setuju" class="radio-label">
                                        <i class="fas fa-check-circle"></i><br>
                                        <strong>YA, SETUJU</strong>
                                    </label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="tidak_setuju" name="persetujuan" value="tidak_setuju" {{ old('persetujuan') == 'tidak_setuju' ? 'checked' : '' }} required>
                                    <label for="tidak_setuju" class="radio-label">
                                        <i class="fas fa-times-circle"></i><br>
                                        <strong>TIDAK SETUJU</strong>
                                    </label>
                                </div>
                            </div>
                            @error('persetujuan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Bagian Tanda Tangan -->
                        <div class="row">
                            <p class="fw-bold">Atas pemberian darah dan produk darah terhadap diri saya sendiri / pihak yang
                                saya wakili. </p>
                            <p>yang bertanda tangan di bawah ini :</p>
                            <div class="col-md-3">
                                <!-- Yang Menyatakan -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-signature"></i> Yang Menyatakan</h6>
                                    <div class="declarant-name" id="declarant-name">
                                        Akan terisi otomatis
                                    </div>
                                    <input type="hidden" id="yang_menyatakan" name="yang_menyatakan"
                                        value="{{ old('yang_menyatakan') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Dokter -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-user-md"></i> Dokter</h6>
                                    <div class="declarant-name" id="dokter-name">
                                        Pilih dokter di atas
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Saksi 1 -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-user-tie"></i> Saksi 1</h6>
                                    <div class="declarant-name" id="saksi1-name">
                                        Masukkan nama saksi 1
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Saksi 2 -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-user-tie"></i> Saksi 2</h6>
                                    <div class="declarant-name" id="saksi2-name">
                                        Masukkan nama saksi 2
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('persetujuan-transfusi-darah.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Persetujuan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

