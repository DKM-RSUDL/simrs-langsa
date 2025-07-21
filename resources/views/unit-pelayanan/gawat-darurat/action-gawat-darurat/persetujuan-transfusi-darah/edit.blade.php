@extends('layouts.administrator.master')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.persetujuan-transfusi-darah.include')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.persetujuan-transfusi-darah.include-edit')

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
                <div class="d-flex gap-2">
                    <a href="{{ route('persetujuan-transfusi-darah.show', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $persetujuan->id]) }}"
                        class="btn btn-info mb-3">
                        <i class="ti-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ asset('assets/file/F.3_persetujuan_transfusi_darah.pdf') }}" class="btn btn-secondary mb-3"
                        target="_blank" rel="noopener noreferrer">
                        <i class="ti-file-text"></i> Form Edukasi
                    </a>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti-check mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti-alert mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti-alert mr-2"></i>
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="transfusi_form" method="POST"
                action="{{ route('persetujuan-transfusi-darah.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $persetujuan->id]) }}">
                @csrf
                @method('PUT')

                <div class="container-fluid">
                    <!-- Header -->
                    <div class="header rounded">
                        <h5>
                            <i class="fas fa-hospital-alt"></i>
                            EDIT PERSETUJUAN TRANSFUSI DARAH/PRODUK DARAH
                        </h5>
                        <span class="edit-badge">EDIT MODE</span>
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
                                            value="{{ old('tanggal', $persetujuan->tanggal ? $persetujuan->tanggal->format('Y-m-d') : '') }}" required>
                                        @error('tanggal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jam <span class="required">*</span></label>
                                        <input type="time" class="form-control" id="jam" name="jam"
                                        value="{{ $persetujuan->jam_masuk ? \Carbon\Carbon::parse($persetujuan->jam_masuk)->format('H:i') : date('H:i') }}" required>
                                        @error('jam')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Diagnosa <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="diagnosa" name="diagnosa"
                                            value="{{ old('diagnosa', $persetujuan->diagnosa) }}" placeholder="Masukkan diagnosa pasien" required>
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
                                    <input type="radio" id="diri_sendiri" name="persetujuan_untuk" value="diri_sendiri"
                                        {{ old('persetujuan_untuk', $persetujuan->persetujuan_untuk) == 'diri_sendiri' ? 'checked' : '' }} required>
                                    <label for="diri_sendiri" class="radio-label">
                                        <i class="fas fa-user"></i><br>
                                        Diri Sendiri
                                    </label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="keluarga" name="persetujuan_untuk" value="keluarga"
                                        {{ old('persetujuan_untuk', $persetujuan->persetujuan_untuk) == 'keluarga' ? 'checked' : '' }} required>
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

                        <!-- Data Keluarga (Show/Hide berdasarkan pilihan) -->
                        <div id="keluarga-section" class="section-card hidden-section"
                            style="{{ old('persetujuan_untuk', $persetujuan->persetujuan_untuk) == 'keluarga' ? 'display: block;' : 'display: none;' }}">
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
                                            value="{{ old('nama_keluarga', $persetujuan->nama_keluarga) }}" placeholder="Masukkan nama lengkap">
                                        @error('nama_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_keluarga" name="tgl_lahir_keluarga"
                                            value="{{ old('tgl_lahir_keluarga', $persetujuan->tgl_lahir_keluarga ? $persetujuan->tgl_lahir_keluarga->format('Y-m-d') : '') }}">
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
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_keluarga', $persetujuan->alamat_keluarga) }}</textarea>
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
                                            <option value="1" {{ old('jk_keluarga', $persetujuan->jk_keluarga) == '1' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="0" {{ old('jk_keluarga', $persetujuan->jk_keluarga) == '0' ? 'selected' : '' }}>
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
                                            value="{{ old('no_telp_keluarga', $persetujuan->no_telp_keluarga) }}" placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="text" class="form-control" id="no_ktp_keluarga" name="no_ktp_keluarga"
                                            value="{{ old('no_ktp_keluarga', $persetujuan->no_ktp_keluarga) }}"
                                            placeholder="Masukkan nomor KTP/SIM" maxlength="16">
                                        @error('no_ktp_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hubungan dengan pihak yang diwakili <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="hubungan_keluarga" name="hubungan_keluarga"
                                            value="{{ old('hubungan_keluarga', $persetujuan->hubungan_keluarga) }}"
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
                                        <label class="form-label">Pilih Dokter <span class="required">*</span></label>
                                        <select name="dokter" id="dokter" class="form-select select2" required>
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}"
                                                    {{ old('dokter', $persetujuan->dokter) == $item->kd_dokter ? 'selected' : '' }}>
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
                                            value="{{ old('nama_saksi1', $persetujuan->nama_saksi1) }}"
                                            placeholder="Masukkan nama lengkap saksi 1">
                                        @error('nama_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_saksi1" name="tgl_lahir_saksi1"
                                            value="{{ old('tgl_lahir_saksi1', $persetujuan->tgl_lahir_saksi1 ? $persetujuan->tgl_lahir_saksi1->format('Y-m-d') : '') }}">
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
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_saksi1', $persetujuan->alamat_saksi1) }}</textarea>
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
                                            <option value="1" {{ old('jk_saksi1', $persetujuan->jk_saksi1) == '1' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="0" {{ old('jk_saksi1', $persetujuan->jk_saksi1) == '0' ? 'selected' : '' }}>Perempuan</option>
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
                                            value="{{ old('no_telp_saksi1', $persetujuan->no_telp_saksi1) }}"
                                            placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="text" class="form-control" id="no_ktp_saksi1" name="no_ktp_saksi1"
                                            value="{{ old('no_ktp_saksi1', $persetujuan->no_ktp_saksi1) }}"
                                            placeholder="Masukkan nomor KTP/SIM" maxlength="16">
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
                                            value="{{ old('nama_saksi2', $persetujuan->nama_saksi2) }}"
                                            placeholder="Masukkan nama lengkap saksi 2">
                                        @error('nama_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_saksi2" name="tgl_lahir_saksi2"
                                            value="{{ old('tgl_lahir_saksi2', $persetujuan->tgl_lahir_saksi2 ? $persetujuan->tgl_lahir_saksi2->format('Y-m-d') : '') }}">
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
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_saksi2', $persetujuan->alamat_saksi2) }}</textarea>
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
                                            <option value="1" {{ old('jk_saksi2', $persetujuan->jk_saksi2) == '1' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="0" {{ old('jk_saksi2', $persetujuan->jk_saksi2) == '0' ? 'selected' : '' }}>
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
                                            value="{{ old('no_telp_saksi2', $persetujuan->no_telp_saksi2) }}"
                                            placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_saksi2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="text" class="form-control" id="no_ktp_saksi2" name="no_ktp_saksi2"
                                            value="{{ old('no_ktp_saksi2', $persetujuan->no_ktp_saksi2) }}"
                                            placeholder="Masukkan nomor KTP/SIM" maxlength="16">
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
                                    <input type="radio" id="setuju" name="persetujuan" value="setuju"
                                        {{ old('persetujuan', $persetujuan->persetujuan) == 'setuju' ? 'checked' : '' }} required>
                                    <label for="setuju" class="radio-label">
                                        <i class="fas fa-check-circle"></i><br>
                                        <strong>YA, SETUJU</strong>
                                    </label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="tidak_setuju" name="persetujuan" value="tidak_setuju"
                                        {{ old('persetujuan', $persetujuan->persetujuan) == 'tidak_setuju' ? 'checked' : '' }} required>
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
                                        {{ old('yang_menyatakan', $persetujuan->yang_menyatakan) ?: 'Akan terisi otomatis' }}
                                    </div>
                                    <input type="hidden" id="yang_menyatakan" name="yang_menyatakan"
                                        value="{{ old('yang_menyatakan', $persetujuan->yang_menyatakan) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Dokter -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-user-md"></i> Dokter</h6>
                                    <div class="declarant-name" id="dokter-name">
                                        {{ $persetujuan->dokter->nama_lengkap ?? 'Pilih dokter di atas' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Saksi 1 -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-user-tie"></i> Saksi 1</h6>
                                    <div class="declarant-name" id="saksi1-name">
                                        {{ old('nama_saksi1', $persetujuan->nama_saksi1) ?: 'Masukkan nama saksi 1' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Saksi 2 -->
                                <div class="declarant-info">
                                    <h6><i class="fas fa-user-tie"></i> Saksi 2</h6>
                                    <div class="declarant-name" id="saksi2-name">
                                        {{ old('nama_saksi2', $persetujuan->nama_saksi2) ?: 'Masukkan nama saksi 2' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Update -->
                        @if($persetujuan->userEdit)
                        <div class="alert alert-info mt-3">
                            <i class="ti-info-alt mr-2"></i>
                            <strong>Info:</strong> Data ini terakhir diubah oleh
                            <strong>{{ $persetujuan->userEdit->name }}</strong>
                            pada {{ $persetujuan->updated_at ? $persetujuan->updated_at->format('d/m/Y H:i') : '-' }}
                        </div>
                        @endif

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('persetujuan-transfusi-darah.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Persetujuan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
