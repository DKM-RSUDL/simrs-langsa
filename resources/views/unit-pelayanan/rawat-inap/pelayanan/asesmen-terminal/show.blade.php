@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.show-include')

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4">
                <div class="card sticky-top" style="top: 1rem;">
                    @include('components.patient-card-keperawatan')
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="ti-arrow-left me-2"></i> Kembali
                    </a>
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.terminal.edit', [
                        $dataMedis->kd_unit,
                        $dataMedis->kd_pasien,
                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                        $dataMedis->urut_masuk,
                        $asesmen->id
                    ]) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                </div>

                <!-- Assessment Card -->
                <div class="shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Asesmen Awal dan Ulang Pasien Terminal dan Keluarganya</h5>
                        <small class="d-block mt-1">Isikan asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</small>
                    </div>

                    <div class="card-body">
                        <div class="px-3 mt-2">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">
                                        <i class="fas fa-clipboard-list me-2"></i>
                                        Asesmen Awal dan Ulang Pasien Terminal dan Keluarganya
                                    </h4>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Data Asesmen Keperawatan yang telah disimpan
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form>
                            <div class="px-3">
                                <!-- Data Masuk -->
                                <div class="section-separator form-section">
                                    <h5 class="section-title">
                                        Data Masuk
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Petugas</label>
                                            <input type="text" class="form-control" value="{{ $asesmen->user->name ?? '-' }}" disabled readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Tanggal Masuk</label>
                                            <input type="date" class="form-control" value="{{ $asesmen->rmeAsesmenTerminal->tanggal ?? '' }}" disabled readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jam Masuk</label>
                                            <input type="time" class="form-control" value="{{ $asesmen->rmeAsesmenTerminal->jam_masuk ? date('H:i', strtotime($asesmen->rmeAsesmenTerminal->jam_masuk)) : '-' }}" disabled readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 1 -->
                                <div class="section-separator form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">1</span>
                                        Gejala seperti mau muntah dan kesulitan bernafas
                                    </h5>

                                    <div class="subsection-title">1.1. Kegawatan pernafasan:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->dyspnoe ? 'selected' : '' }}">
                                                    <input type="checkbox" name="dyspnoe" id="dyspnoe" value="1" {{ $asesmen->rmeAsesmenTerminal->dyspnoe ? 'checked' : '' }} disabled>
                                                    <label for="dyspnoe">Dyspnoe</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->nafas_tak_teratur ? 'selected' : '' }}">
                                                    <input type="checkbox" name="nafas_tak_teratur" id="nafas_tak_teratur" value="1" {{ $asesmen->rmeAsesmenTerminal->nafas_tak_teratur ? 'checked' : '' }} disabled>
                                                    <label for="nafas_tak_teratur">Nafas Tak teratur</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->ada_sekret ? 'selected' : '' }}">
                                                    <input type="checkbox" name="ada_sekret" id="ada_sekret" value="1" {{ $asesmen->rmeAsesmenTerminal->ada_sekret ? 'checked' : '' }} disabled>
                                                    <label for="ada_sekret">Ada sekret</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->nafas_cepat_dangkal ? 'selected' : '' }}">
                                                    <input type="checkbox" name="nafas_cepat_dangkal" id="nafas_cepat_dangkal" value="1" {{ $asesmen->rmeAsesmenTerminal->nafas_cepat_dangkal ? 'checked' : '' }} disabled>
                                                    <label for="nafas_cepat_dangkal">Nafas cepat dan dangkal</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->nafas_melalui_mulut ? 'selected' : '' }}">
                                                    <input type="checkbox" name="nafas_melalui_mulut" id="nafas_melalui_mulut" value="1" {{ $asesmen->rmeAsesmenTerminal->nafas_melalui_mulut ? 'checked' : '' }} disabled>
                                                    <label for="nafas_melalui_mulut">Nafas melalui mulut</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->spo2_normal ? 'selected' : '' }}">
                                                    <input type="checkbox" name="spo2_normal" id="spo2_normal" value="1" {{ $asesmen->rmeAsesmenTerminal->spo2_normal ? 'checked' : '' }} disabled>
                                                    <label for="spo2_normal">SpO₂ < normal</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->nafas_lambat ? 'selected' : '' }}">
                                                    <input type="checkbox" name="nafas_lambat" id="nafas_lambat" value="1" {{ $asesmen->rmeAsesmenTerminal->nafas_lambat ? 'checked' : '' }} disabled>
                                                    <label for="nafas_lambat">Nafas lambat</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->mukosa_oral_kering ? 'selected' : '' }}">
                                                    <input type="checkbox" name="mukosa_oral_kering" id="mukosa_oral_kering" value="1" {{ $asesmen->rmeAsesmenTerminal->mukosa_oral_kering ? 'checked' : '' }} disabled>
                                                    <label for="mukosa_oral_kering">Mukosa oral kering</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->tak ? 'selected' : '' }}">
                                                    <input type="checkbox" name="tak" id="tak" value="1" {{ $asesmen->rmeAsesmenTerminal->tak ? 'checked' : '' }} disabled>
                                                    <label for="tak">T.A.K</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title section-separator fw-bold">1.2. Kegawatan Tinus otot:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->mual ? 'selected' : '' }}">
                                                    <input type="checkbox" name="mual" id="mual" value="1" {{ $asesmen->rmeAsesmenTerminal->mual ? 'checked' : '' }} disabled>
                                                    <label for="mual">Mual</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->sulit_menelan ? 'selected' : '' }}">
                                                    <input type="checkbox" name="sulit_menelan" id="sulit_menelan" value="1" {{ $asesmen->rmeAsesmenTerminal->sulit_menelan ? 'checked' : '' }} disabled>
                                                    <label for="sulit_menelan">Sulit menelan</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->inkontinensia_alvi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="inkontinensia_alvi" id="inkontinensia_alvi" value="1" {{ $asesmen->rmeAsesmenTerminal->inkontinensia_alvi ? 'checked' : '' }} disabled>
                                                    <label for="inkontinensia_alvi">Inkontinensia alvi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->penurunan_pergerakan ? 'selected' : '' }}">
                                                    <input type="checkbox" name="penurunan_pergerakan" id="penurunan_pergerakan" value="1" {{ $asesmen->rmeAsesmenTerminal->penurunan_pergerakan ? 'checked' : '' }} disabled>
                                                    <label for="penurunan_pergerakan">Penurunan Pergerakan tubuh</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->distensi_abdomen ? 'selected' : '' }}">
                                                    <input type="checkbox" name="distensi_abdomen" id="distensi_abdomen" value="1" {{ $asesmen->rmeAsesmenTerminal->distensi_abdomen ? 'checked' : '' }} disabled>
                                                    <label for="distensi_abdomen">Distensi Abdomen</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->tak2 ? 'selected' : '' }}">
                                                    <input type="checkbox" name="tak2" id="tak2" value="1" {{ $asesmen->rmeAsesmenTerminal->tak2 ? 'checked' : '' }} disabled>
                                                    <label for="tak2">T.A.K</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->sulit_berbicara ? 'selected' : '' }}">
                                                    <input type="checkbox" name="sulit_berbicara" id="sulit_berbicara" value="1" {{ $asesmen->rmeAsesmenTerminal->sulit_berbicara ? 'checked' : '' }} disabled>
                                                    <label for="sulit_berbicara">Sulit Berbicara</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->inkontinensia_urine ? 'selected' : '' }}">
                                                    <input type="checkbox" name="inkontinensia_urine" id="inkontinensia_urine" value="1" {{ $asesmen->rmeAsesmenTerminal->inkontinensia_urine ? 'checked' : '' }} disabled>
                                                    <label for="inkontinensia_urine">Inkontinensia Urine</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title section-separator fw-bold">1.3. Nyeri:</div>
                                    <div class="radio-group">
                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminal->nyeri ? 'selected' : '' }}">
                                            <input type="radio" name="nyeri" id="nyeri_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminal->nyeri ? 'checked' : '' }} disabled>
                                            <label for="nyeri_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminal->nyeri ? 'selected' : '' }}">
                                            <input type="radio" name="nyeri" id="nyeri_ya" value="1" {{ $asesmen->rmeAsesmenTerminal->nyeri ? 'checked' : '' }} disabled>
                                            <label for="nyeri_ya">Ya</label>
                                        </div>
                                    </div>
                                    @if ($asesmen->rmeAsesmenTerminal->nyeri)
                                        <div class="text-input-group">
                                            <label class="form-label">Keterangan:</label>
                                            <textarea class="form-control" name="nyeri_keterangan" rows="2" disabled readonly>{{ $asesmen->rmeAsesmenTerminal->nyeri_keterangan ?? '' }}</textarea>
                                        </div>
                                    @endif

                                    <div class="subsection-title section-separator fw-bold">1.4. Perlambatan Sirkulasi:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->bercerak_sianosis ? 'selected' : '' }}">
                                                    <input type="checkbox" name="bercerak_sianosis" id="bercerak_sianosis" value="1" {{ $asesmen->rmeAsesmenTerminal->bercerak_sianosis ? 'checked' : '' }} disabled>
                                                    <label for="bercerak_sianosis">Bercak dan sianosis pada ekstremitas</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->gelisah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="gelisah" id="gelisah" value="1" {{ $asesmen->rmeAsesmenTerminal->gelisah ? 'checked' : '' }} disabled>
                                                    <label for="gelisah">Gelisah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->lemas ? 'selected' : '' }}">
                                                    <input type="checkbox" name="lemas" id="lemas" value="1" {{ $asesmen->rmeAsesmenTerminal->lemas ? 'checked' : '' }} disabled>
                                                    <label for="lemas">Lemas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->kulit_dingin ? 'selected' : '' }}">
                                                    <input type="checkbox" name="kulit_dingin" id="kulit_dingin" value="1" {{ $asesmen->rmeAsesmenTerminal->kulit_dingin ? 'checked' : '' }} disabled>
                                                    <label for="kulit_dingin">Kulit dingin dan berkeringat</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->tekanan_darah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="tekanan_darah" id="tekanan_darah" value="1" {{ $asesmen->rmeAsesmenTerminal->tekanan_darah ? 'checked' : '' }} disabled>
                                                    <label for="tekanan_darah">Tekanan Darah menurun Nadi lambat dan lemah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminal->tak3 ? 'selected' : '' }}">
                                                    <input type="checkbox" name="tak3" id="tak3" value="1" {{ $asesmen->rmeAsesmenTerminal->tak3 ? 'checked' : '' }} disabled>
                                                    <label for="tak3">T.A.K</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">2</span>
                                        Faktor-faktor yang meningkatkan dan membangkitkan gejala fisik
                                    </h5>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->melakukan_aktivitas ? 'selected' : '' }}">
                                                    <input type="checkbox" name="melakukan_aktivitas" id="melakukan_aktivitas" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->melakukan_aktivitas ? 'checked' : '' }} disabled>
                                                    <label for="melakukan_aktivitas">Melakukan aktivitas fisik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->pindah_posisi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="pindah_posisi" id="pindah_posisi" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->pindah_posisi ? 'checked' : '' }} disabled>
                                                    <label for="pindah_posisi">Pindah posisi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-input-group">
                                            <label class="form-label">Lainnya:</label>
                                            <textarea class="form-control" name="faktor_lainnya" rows="2" disabled readonly>{{ $asesmen->rmeAsesmenTerminalFmo->faktor_lainnya ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">3</span>
                                        Manajemen gejala saat ini dan respon pasien
                                    </h5>

                                    <div class="subsection-title">Masalah keperawatan:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_mual ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_mual" id="masalah_mual" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_mual ? 'checked' : '' }} disabled>
                                                    <label for="masalah_mual">Mual</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_perubahan_persepsi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_perubahan_persepsi" id="masalah_perubahan_persepsi" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_perubahan_persepsi ? 'checked' : '' }} disabled>
                                                    <label for="masalah_perubahan_persepsi">Perubahan persepsi sensori</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_pola_nafas ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_pola_nafas" id="masalah_pola_nafas" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_pola_nafas ? 'checked' : '' }} disabled>
                                                    <label for="masalah_pola_nafas">Pola Nafas tidak efektif</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_konstipasi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_konstipasi" id="masalah_konstipasi" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_konstipasi ? 'checked' : '' }} disabled>
                                                    <label for="masalah_konstipasi">Konstipasi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_bersihan_jalan_nafas ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_bersihan_jalan_nafas" id="masalah_bersihan_jalan_nafas" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_bersihan_jalan_nafas ? 'checked' : '' }} disabled>
                                                    <label for="masalah_bersihan_jalan_nafas">Bersihan jalan nafas tidak efektif</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_defisit_perawatan ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_defisit_perawatan" id="masalah_defisit_perawatan" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_defisit_perawatan ? 'checked' : '' }} disabled>
                                                    <label for="masalah_defisit_perawatan">Defisit perawatan diri</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_nyeri_akut ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_nyeri_akut" id="masalah_nyeri_akut" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_nyeri_akut ? 'checked' : '' }} disabled>
                                                    <label for="masalah_nyeri_akut">Nyeri akut</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalFmo->masalah_nyeri_kronis ? 'selected' : '' }}">
                                                    <input type="checkbox" name="masalah_nyeri_kronis" id="masalah_nyeri_kronis" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_nyeri_kronis ? 'checked' : '' }} disabled>
                                                    <label for="masalah_nyeri_kronis">Nyeri Kronis</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 4 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">4</span>
                                        Orientasi spiritual pasien dan keluarga
                                    </h5>

                                    <div class="subsection-title">Apakah perlu pelayanan spiritual?</div>
                                    <div class="radio-group">
                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_pelayanan_spiritual" id="spiritual_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual ? 'checked' : '' }} disabled>
                                            <label for="spiritual_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_pelayanan_spiritual" id="spiritual_ya" value="1" {{ $asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual ? 'checked' : '' }} disabled>
                                            <label for="spiritual_ya">Ya, oleh:</label>
                                        </div>
                                    </div>

                                    @if ($asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual)
                                        <div class="text-input-group">
                                            <label class="form-label">Keterangan pelayanan spiritual:</label>
                                            <input type="text" class="form-control" name="spiritual_keterangan" value="{{ $asesmen->rmeAsesmenTerminalFmo->spiritual_keterangan ?? '' }}" disabled readonly>
                                        </div>
                                    @endif
                                </div>

                                <!-- Section 5 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">5</span>
                                        urusan dan kebutuhan spiritual pasien dan keluarga seperti putus asa, penderitaan, rasa bersalah atau pengampunan:
                                    </h5>

                                    <div class="subsection-title">Perlu didoakan :</div>
                                    <div class="radio-group">
                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_didoakan ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_didoakan" id="didoakan_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_didoakan ? 'checked' : '' }} disabled>
                                            <label for="didoakan_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->perlu_didoakan ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_didoakan" id="didoakan_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->perlu_didoakan ? 'checked' : '' }} disabled>
                                            <label for="didoakan_ya">Ya</label>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-3">Perlu bimbingan rohani :</div>
                                    <div class="radio-group">
                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_bimbingan_rohani ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_bimbingan_rohani" id="bimbingan_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_bimbingan_rohani ? 'checked' : '' }} disabled>
                                            <label for="bimbingan_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->perlu_bimbingan_rohani ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_bimbingan_rohani" id="bimbingan_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->perlu_bimbingan_rohani ? 'checked' : '' }} disabled>
                                            <label for="bimbingan_ya">Ya</label>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-3">Perlu pendampingan rohani :</div>
                                    <div class="radio-group">
                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_pendampingan_rohani ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_pendampingan_rohani" id="pendampingan_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_pendampingan_rohani ? 'checked' : '' }} disabled>
                                            <label for="pendampingan_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->perlu_pendampingan_rohani ? 'selected' : '' }}">
                                            <input type="radio" name="perlu_pendampingan_rohani" id="pendampingan_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->perlu_pendampingan_rohani ? 'checked' : '' }} disabled>
                                            <label for="pendampingan_ya">Ya</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 6 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">6</span>
                                        Status psikososial dan keluarga
                                    </h5>

                                    <div class="subsection-title fw-bold">6.1. Apakah ada orang yang ingin dihubungi saat ini?</div>
                                    <div class="radio-group">
                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->orang_dihubungi ? 'selected' : '' }}">
                                            <input type="radio" name="orang_dihubungi" id="orang_dihubungi_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->orang_dihubungi ? 'checked' : '' }} disabled>
                                            <label for="orang_dihubungi_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->orang_dihubungi ? 'selected' : '' }}">
                                            <input type="radio" name="orang_dihubungi" id="orang_dihubungi_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->orang_dihubungi ? 'checked' : '' }} disabled>
                                            <label for="orang_dihubungi_ya">Ya siapa:</label>
                                        </div>
                                    </div>

                                    @if ($asesmen->rmeAsesmenTerminalUsk->orang_dihubungi)
                                    <div class="text-input-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama:</label>
                                                <input type="text" class="form-control" name="nama_dihubungi" value="{{ $asesmen->rmeAsesmenTerminalUsk->nama_dihubungi ?? '' }}" disabled readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Hubungan dengan pasien sebagai:</label>
                                                <input type="text" class="form-control" name="hubungan_pasien" value="{{ $asesmen->rmeAsesmenTerminalUsk->hubungan_pasien ?? '' }}" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Dinama:</label>
                                                <input type="text" class="form-control" name="dinama" value="{{ $asesmen->rmeAsesmenTerminalUsk->dinama ?? '' }}" disabled readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Telp/HP:</label>
                                                <input type="text" class="form-control" name="no_telp_hp" value="{{ $asesmen->rmeAsesmenTerminalUsk->no_telp_hp ?? '' }}" disabled readonly>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="subsection-title section-separator fw-bold">6.2. Bagaimana rencana perawatan selanjutnya?</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->tetap_dirawat_rs ? 'selected' : '' }}">
                                                    <input type="checkbox" name="tetap_dirawat_rs" id="tetap_dirawat_rs" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->tetap_dirawat_rs ? 'checked' : '' }} disabled>
                                                    <label for="tetap_dirawat_rs">Tetap dirawat di RS</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->dirawat_rumah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="dirawat_rumah" id="dirawat_rumah" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->dirawat_rumah ? 'checked' : '' }} disabled>
                                                    <label for="dirawat_rumah">Dirawat di rumah</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Apakah lingkungan rumah sudah disiapkan?</label>
                                                    <div class="radio-group mt-2">
                                                        <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->lingkungan_rumah_siap ? 'selected' : '' }}">
                                                            <input type="radio" name="lingkungan_rumah_siap" id="lingkungan_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->lingkungan_rumah_siap ? 'checked' : '' }} disabled>
                                                            <label for="lingkungan_ya">Ya</label>
                                                        </div>
                                                        <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->lingkungan_rumah_siap ? 'selected' : '' }}">
                                                            <input type="radio" name="lingkungan_rumah_siap" id="lingkungan_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->lingkungan_rumah_siap ? 'checked' : '' }} disabled>
                                                            <label for="lingkungan_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <label class="form-label">Jika Ya, apakah ada yang mampu merawat pasien di rumah?</label>
                                            <div class="radio-group mt-2">
                                                <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah ? 'selected' : '' }}">
                                                    <input type="radio" name="mampu_merawat_rumah" id="mampu_merawat_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah ? 'checked' : '' }} disabled>
                                                    <label for="mampu_merawat_ya">Ya, oleh:</label>
                                                </div>
                                                @if ($asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah)
                                                    <div class="text-input-group">
                                                        <label class="form-label">siapa:</label>
                                                        <input type="text" class="form-control" name="perawat_rumah_oleh" value="{{ $asesmen->rmeAsesmenTerminalUsk->perawat_rumah_oleh ?? '' }}" disabled readonly>
                                                    </div>
                                                @endif
                                                <div class="mt-2 radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah ? 'selected' : '' }}">
                                                    <input type="radio" name="mampu_merawat_rumah" id="mampu_merawat_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah ? 'checked' : '' }} disabled>
                                                    <label for="mampu_merawat_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <label class="form-label">Jika tidak, apakah perlu difasilitasi RS (Home Care)?</label>
                                            <div class="radio-group mt-2">
                                                <div class="radio-item {{ $asesmen->rmeAsesmenTerminalUsk->perlu_home_care ? 'selected' : '' }}">
                                                    <input type="radio" name="perlu_home_care" id="home_care_ya" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->perlu_home_care ? 'checked' : '' }} disabled>
                                                    <label for="home_care_ya">Ya</label>
                                                </div>
                                                <div class="radio-item {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_home_care ? 'selected' : '' }}">
                                                    <input type="radio" name="perlu_home_care" id="home_care_tidak" value="0" {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_home_care ? 'checked' : '' }} disabled>
                                                    <label for="home_care_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title section-separator fw-bold">6.3. Reaksi pasien atas penyakitnya</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="fw-bold">Asesmen informasi</span>
                                            <div class="checkbox-group mt-2">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_menyangkal ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_menyangkal" id="reaksi_menyangkal" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_menyangkal ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_menyangkal">Menyangkal</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_marah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_marah" id="reaksi_marah" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_marah ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_marah">Marah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_takut ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_takut" id="reaksi_takut" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_takut ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_takut">Takut</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkbox-group mt-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_sedih_menangis ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_sedih_menangis" id="reaksi_sedih_menangis" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_sedih_menangis ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_sedih_menangis">Sedih / menangis</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_rasa_bersalah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_rasa_bersalah" id="reaksi_rasa_bersalah" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_rasa_bersalah ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_rasa_bersalah">Rasa bersalah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_ketidak_berdayaan ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_ketidak_berdayaan" id="reaksi_ketidak_berdayaan" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_ketidak_berdayaan ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_ketidak_berdayaan">Ketidak berdayaan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Masalah keperawatan:</label>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_anxietas ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_anxietas" id="reaksi_anxietas" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_anxietas ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_anxietas">Anxietas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_distress_spiritual ? 'selected' : '' }}">
                                                    <input type="checkbox" name="reaksi_distress_spiritual" id="reaksi_distress_spiritual" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_distress_spiritual ? 'checked' : '' }} disabled>
                                                    <label for="reaksi_distress_spiritual">Distress Spiritual</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title section-separator fw-bold">6.4. Reaksi keluarga atas penyakit pasien:</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="fw-bold">Asesmen informasi</span>
                                            <div class="checkbox-group mt-2">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_marah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_marah" id="keluarga_marah" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_marah ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_marah">Marah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_gangguan_tidur ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_gangguan_tidur" id="keluarga_gangguan_tidur" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_gangguan_tidur ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_gangguan_tidur">Gangguan tidur</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_penurunan_konsentrasi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_penurunan_konsentrasi" id="keluarga_penurunan_konsentrasi" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_penurunan_konsentrasi ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_penurunan_konsentrasi">Penurunan Konsentrasi</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_ketidakmampuan_memenuhi_peran ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_ketidakmampuan_memenuhi_peran" id="keluarga_ketidakmampuan_memenuhi_peran" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_ketidakmampuan_memenuhi_peran ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_ketidakmampuan_memenuhi_peran">Ketidakmampuan memenuhi peran yang diharapkan</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_kurang_berkomunikasi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_kurang_berkomunikasi" id="keluarga_kurang_berkomunikasi" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_kurang_berkomunikasi ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_kurang_berkomunikasi">Keluarga kurang berkomunikasi dengan pasien</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkbox-group mt-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_leth_lelah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_leth_lelah" id="keluarga_leth_lelah" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_leth_lelah ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_leth_lelah">Letih/lelah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_rasa_bersalah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_rasa_bersalah" id="keluarga_rasa_bersalah" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_rasa_bersalah ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_rasa_bersalah">Rasa bersalah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_perubahan_pola_komunikasi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_perubahan_pola_komunikasi" id="keluarga_perubahan_pola_komunikasi" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_perubahan_pola_komunikasi ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_perubahan_pola_komunikasi">Perubahan kebiasaan pola komunikasi</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_kurang_berpartisipasi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="keluarga_kurang_berpartisipasi" id="keluarga_kurang_berpartisipasi" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_kurang_berpartisipasi ? 'checked' : '' }} disabled>
                                                    <label for="keluarga_kurang_berpartisipasi">Keluarga kurang berpartisipasi membuat keputusan dalam perawatan pasien</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Masalah keperawatan:</label>
                                        <div class="checkbox-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->masalah_koping_individu_tidak_efektif ? 'selected' : '' }}">
                                                        <input type="checkbox" name="masalah_koping_individu_tidak_efektif" id="masalah_koping_individu_tidak_efektif" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->masalah_koping_individu_tidak_efektif ? 'checked' : '' }} disabled>
                                                        <label for="masalah_koping_individu_tidak_efektif">Koping individu tidak efektif</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->masalah_distress_spiritual ? 'selected' : '' }}">
                                                        <input type="checkbox" name="masalah_distress_spiritual" id="masalah_distress_spiritual" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->masalah_distress_spiritual ? 'checked' : '' }} disabled>
                                                        <label for="masalah_distress_spiritual">Distress Spiritual</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 7 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">7</span>
                                        Kebutuhan dukungan atau kelonggaran pelayanan bagi pasien, keluarga dan pemberi pelayanan lain:
                                    </h5>

                                    <div class="checkbox-group">
                                        <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->pasien_perlu_didampingi ? 'selected' : '' }}">
                                            <input type="checkbox" name="pasien_perlu_didampingi" id="pasien_perlu_didampingi" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->pasien_perlu_didampingi ? 'checked' : '' }} disabled>
                                            <label for="pasien_perlu_didampingi">Pasien perlu didampingi keluarga</label>
                                        </div>
                                        <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_dapat_mengunjungi_luar_waktu ? 'selected' : '' }}">
                                            <input type="checkbox" name="keluarga_dapat_mengunjungi_luar_waktu" id="keluarga_dapat_mengunjungi_luar_waktu" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_dapat_mengunjungi_luar_waktu ? 'checked' : '' }} disabled>
                                            <label for="keluarga_dapat_mengunjungi_luar_waktu">Keluarga dapat mengunjungi pasien di luar waktu berkunjung</label>
                                        </div>
                                        <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalUsk->sahabat_dapat_mengunjungi ? 'selected' : '' }}">
                                            <input type="checkbox" name="sahabat_dapat_mengunjungi" id="sahabat_dapat_mengunjungi" value="1" {{ $asesmen->rmeAsesmenTerminalUsk->sahabat_dapat_mengunjungi ? 'checked' : '' }} disabled>
                                            <label for="sahabat_dapat_mengunjungi">Sahabat dapat mengunjungi pasien di luar waktu berkunjung</label>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Lainnya:</label>
                                        <textarea class="form-control" name="kebutuhan_dukungan_lainnya" rows="3" disabled readonly>{{ $asesmen->rmeAsesmenTerminalUsk->kebutuhan_dukungan_lainnya ?? '' }}</textarea>
                                    </div>
                                </div>

                                <!-- Section 8 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">8</span>
                                        Apakah ada kebutuhan akan alternatif atau tingkat pelayanan lain:
                                    </h5>

                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->alternatif_tidak ? 'selected' : '' }}">
                                                    <input type="checkbox" name="alternatif_tidak" id="alternatif_tidak" value="0" {{ $asesmen->rmeAsesmenTerminalAf->alternatif_tidak ? 'checked' : '' }} disabled>
                                                    <label for="alternatif_tidak">Tidak</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->alternatif_autopsi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="alternatif_autopsi" id="alternatif_autopsi" value="1" {{ $asesmen->rmeAsesmenTerminalAf->alternatif_autopsi ? 'checked' : '' }} disabled>
                                                    <label for="alternatif_autopsi">Autopsi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->alternatif_donasi_organ ? 'selected' : '' }}">
                                                    <input type="checkbox" name="alternatif_donasi_organ" id="alternatif_donasi_organ" value="1" {{ $asesmen->rmeAsesmenTerminalAf->alternatif_donasi_organ ? 'checked' : '' }} disabled>
                                                    <label for="alternatif_donasi_organ">Donasi Organ:</label>
                                                </div>
                                                @if ($asesmen->rmeAsesmenTerminalAf->alternatif_donasi_organ)
                                                <div class="text-input-group mt-2">
                                                    <input type="text" class="form-control" name="donasi_organ_detail" value="{{ $asesmen->rmeAsesmenTerminalAf->donasi_organ_detail ?? '' }}" disabled readonly>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Lainnya:</label>
                                        <textarea class="form-control" name="alternatif_pelayanan_lainnya" rows="3" disabled readonly>{{ $asesmen->rmeAsesmenTerminalAf->alternatif_pelayanan_lainnya ?? '' }}</textarea>
                                    </div>
                                </div>

                                <!-- Section 9 -->
                                <div class="form-section section-separator">
                                    <h5 class="section-title">
                                        <span class="section-number">9</span>
                                        Faktor resiko bagi keluarga yang ditinggalkan
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="fw-bold">Asesmen informasi</span>
                                            <div class="checkbox-group mt-2">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_marah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_marah" id="faktor_resiko_marah" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_marah ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_marah">Marah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_depresi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_depresi" id="faktor_resiko_depresi" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_depresi ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_depresi">Depresi</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_rasa_bersalah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_rasa_bersalah" id="faktor_resiko_rasa_bersalah" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_rasa_bersalah ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_rasa_bersalah">Rasa bersalah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_perubahan_kebiasaan ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_perubahan_kebiasaan" id="faktor_resiko_perubahan_kebiasaan" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_perubahan_kebiasaan ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_perubahan_kebiasaan">Perubahan kebiasaan pola komunikasi</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_tidak_mampu_memenuhi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_tidak_mampu_memenuhi" id="faktor_resiko_tidak_mampu_memenuhi" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_tidak_mampu_memenuhi ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_tidak_mampu_memenuhi">Tidak mampu memenuhi peran yang diharapkan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkbox-group mt-4">
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_leth_lelah ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_leth_lelah" id="faktor_resiko_leth_lelah" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_leth_lelah ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_leth_lelah">Letih/lelah</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_gangguan_tidur ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_gangguan_tidur" id="faktor_resiko_gangguan_tidur" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_gangguan_tidur ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_gangguan_tidur">Gangguan tidur</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_sedih_menangis ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_sedih_menangis" id="faktor_resiko_sedih_menangis" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_sedih_menangis ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_sedih_menangis">Sedih/menangis</label>
                                                </div>
                                                <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_penurunan_konsentrasi ? 'selected' : '' }}">
                                                    <input type="checkbox" name="faktor_resiko_penurunan_konsentrasi" id="faktor_resiko_penurunan_konsentrasi" value="1" {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_penurunan_konsentrasi ? 'checked' : '' }} disabled>
                                                    <label for="faktor_resiko_penurunan_konsentrasi">Penurunan konsentrasi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Masalah keperawatan:</label>
                                        <div class="checkbox-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->masalah_koping_keluarga_tidak_efektif ? 'selected' : '' }}">
                                                        <input type="checkbox" name="masalah_koping_keluarga_tidak_efektif" id="masalah_koping_keluarga_tidak_efektif" value="1" {{ $asesmen->rmeAsesmenTerminalAf->masalah_koping_keluarga_tidak_efektif ? 'checked' : '' }} disabled>
                                                        <label for="masalah_koping_keluarga_tidak_efektif">Koping keluarga tidak efektif</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkbox-item {{ $asesmen->rmeAsesmenTerminalAf->masalah_distress_spiritual_keluarga ? 'selected' : '' }}">
                                                        <input type="checkbox" name="masalah_distress_spiritual_keluarga" id="masalah_distress_spiritual_keluarga" value="1" {{ $asesmen->rmeAsesmenTerminalAf->masalah_distress_spiritual_keluarga ? 'checked' : '' }} disabled>
                                                        <label for="masalah_distress_spiritual_keluarga">Distress Spiritual</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
