@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="#" class="btn btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Asesmen Keperawatan Anak</h5>
                    <p class="mb-0">Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
                </div>
                <div class="card-body">
                    <!-- Informasi Dasar -->
                    <div class="mb-4">
                        <!-- 1. Data masuk -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>1. Data masuk</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Petugas :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->user->name ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tanggal Dan Jam Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ date('d M Y H:i', strtotime($asesmen->waktu_asesmen)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Cara Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->cara_masuk ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kasus Trauma :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Anamnesis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>2. Anamnesis</h5>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Anamnesis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->anamnesis ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Keluhan Utama :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->keluhan_utama ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Kesehatan Sekarang :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->riwayat_kesehatan_sekarang ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Pemeriksaan fisik -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>3. Pemeriksaan fisik</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tek. Darah (mmHg) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    Sistole: {{ $asesmen->rmeAsesmenKepAnakFisik->sistole ?? '-' }} mmHg<br>
                                                    Diastole: {{ $asesmen->rmeAsesmenKepAnakFisik->diastole ?? '-' }} mmHg
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nadi (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->nadi ?? '-' }} x/menit
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nafas (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->nafas ?? '-' }} x/menit
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Suhu (C) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->suhu ?? '-' }} °C
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Saturasi O2 :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    Tanpa bantuan:
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->spo2_tanpa_bantuan ?? '-' }}%<br>
                                                    Dengan bantuan:
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->spo2_dengan_bantuan ?? '-' }}%
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h5>Kesadaran & Status Mental</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesadaran :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">GCS :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->gcs ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Penglihatan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $penglihatan =
                                                            $asesmen->rmeAsesmenKepAnakFisik->penglihatan ?? null;
                                                        $penglihatanOptions = [
                                                            '1' => 'Baik',
                                                            '2' => 'Rusak',
                                                            '3' => 'Alat Bantu',
                                                        ];
                                                    @endphp
                                                    {{ $penglihatanOptions[$penglihatan] ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pendengaran :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $pendengaran =
                                                            $asesmen->rmeAsesmenKepAnakFisik->pendengaran ?? null;
                                                        $pendengaranOptions = [
                                                            '1' => 'Baik',
                                                            '2' => 'Rusak',
                                                            '3' => 'Alat Bantu',
                                                        ];
                                                    @endphp
                                                    {{ $pendengaranOptions[$pendengaran] ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <h5>Status Komunikasi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Bicara :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $bicara = $asesmen->rmeAsesmenKepAnakFisik->bicara ?? null;
                                                        $bicaraOptions = [
                                                            '1' => 'Normal',
                                                            '2' => 'Gangguan',
                                                        ];
                                                    @endphp
                                                    {{ $bicaraOptions[$bicara] ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Refleks Menelan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $refleksMenelan =
                                                            $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan ?? null;
                                                        $refleksMenelanOptions = [
                                                            '1' => 'Normal',
                                                            '2' => 'Sulit',
                                                            '3' => 'Rusak',
                                                        ];
                                                    @endphp
                                                    {{ $refleksMenelanOptions[$refleksMenelan] ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pola Tidur :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $polaTidur =
                                                            $asesmen->rmeAsesmenKepAnakFisik->pola_tidur ?? null;
                                                        $polaTidurOptions = [
                                                            '1' => 'Normal',
                                                            '2' => 'Masalah',
                                                        ];
                                                    @endphp
                                                    {{ $polaTidurOptions[$polaTidur] ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Luka :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $luka = $asesmen->rmeAsesmenKepAnakFisik->luka ?? null;
                                                        $lukaOptions = [
                                                            '1' => 'Normal',
                                                            '2' => 'Gangguan',
                                                            '3' => 'Tidak Ada Luka',
                                                        ];
                                                    @endphp
                                                    {{ $lukaOptions[$luka] ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <h5>Status Eliminasi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Defekasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $defekasi = $asesmen->rmeAsesmenKepAnakFisik->defekasi ?? null;
                                                        $defekasiOptions = [
                                                            '1' => 'Tidak Ada',
                                                            '2' => 'Ada, Normal',
                                                            '3' => 'Konsitipasi',
                                                            '4' => 'Inkontinesia Alvi',
                                                        ];
                                                    @endphp
                                                    {{ $defekasiOptions[$defekasi] ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Miksi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $miksi = $asesmen->rmeAsesmenKepAnakFisik->miksi ?? null;
                                                        $miksiOptions = [
                                                            '1' => 'Normal',
                                                            '2' => 'Retensio',
                                                            '3' => 'Inkontinesia Urine',
                                                        ];
                                                    @endphp
                                                    {{ $miksiOptions[$miksi] ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Gastrointestinal :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $gastro =
                                                            $asesmen->rmeAsesmenKepAnakFisik->gastroentestinal ?? null;
                                                        $gastroOptions = [
                                                            '1' => 'Normal',
                                                            '2' => 'Nausea',
                                                            '3' => 'Muntah',
                                                        ];
                                                    @endphp
                                                    {{ $gastroOptions[$gastro] ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <h5>Riwayat Kelahiran & Perkembangan</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lahir Umur Kehamilan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->lahir_umur_kehamilan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">ASI Sampai Umur :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->asi_Sampai_Umur ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Alasan Berhenti Menyusui :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->alasan_berhenti_menyusui ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Masalah Neonatus :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->masalah_neonatus ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kelainan Kongenital :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->kelainan_kongenital ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tengkurap :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->tengkurap ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Merangkak :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->merangkak ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Duduk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->duduk ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berdiri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->berdiri ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Anthropometry section -->
                                    <div class="row mt-4">
                                        <h5>Antropometri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->tinggi_badan ?? '-' }} cm
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berat Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->berat_badan ?? '-' }} kg
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lingkar Kepala :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->lingkar_kepala ?? '-' }} cm
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">IMT :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->imt ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">LPT :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakFisik->lpt ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pemeriksaan Fisik Komprehensif -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Pemeriksaan Fisik</h5>
                                            <p class="mb-3 small bg-info text-white rounded-3 p-2">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Hasil pemeriksaan fisik menyeluruh. Status pemeriksaan ditandai sebagai
                                                Normal jika tidak ditemukan kelainan pada saat pemeriksaan.
                                            </p>
                                        </div>

                                        @php
                                            $pemeriksaanFisikData = $asesmen->pemeriksaanFisik ?? collect([]);
                                            $totalItems = $pemeriksaanFisikData->count();
                                            $halfCount = ceil($totalItems / 2);
                                            $firstColumn = $pemeriksaanFisikData->take($halfCount);
                                            $secondColumn = $pemeriksaanFisikData->skip($halfCount);
                                        @endphp

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @foreach ($firstColumn as $item)
                                                        <div
                                                            class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                            <span
                                                                class="fw-medium">{{ $item->itemFisik->nama ?? '' }}</span>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if ($item->is_normal)
                                                                    <span class="badge bg-success">Normal</span>
                                                                @else
                                                                    @if ($item->keterangan)
                                                                        <span class="badge bg-warning text-dark">Tidak
                                                                            Normal</span>
                                                                        <span
                                                                            class="text-muted small">{{ $item->keterangan }}</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Tidak
                                                                            Diperiksa</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="col-md-6">
                                                    @foreach ($secondColumn as $item)
                                                        <div
                                                            class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                            <span
                                                                class="fw-medium">{{ $item->itemFisik->nama ?? '' }}</span>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if ($item->is_normal)
                                                                    <span class="badge bg-success">Normal</span>
                                                                @else
                                                                    @if ($item->keterangan)
                                                                        <span class="badge bg-warning text-dark">Tidak
                                                                            Normal</span>
                                                                        <span
                                                                            class="text-muted small">{{ $item->keterangan }}</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Tidak
                                                                            Diperiksa</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- 4. Status Nyeri -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>4. Status Nyeri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisSkala =
                                                            $asesmen->rmeAsesmenKepAnakStatusNyeri->jenis_skala_nyeri ??
                                                            '';
                                                        $skalaText = '';
                                                        switch ($jenisSkala) {
                                                            case 1:
                                                                $skalaText = 'Numeric Rating Scale (NRS)';
                                                                break;
                                                            case 2:
                                                                $skalaText =
                                                                    'Face, Legs, Activity, Cry, Consolability (FLACC)';
                                                                break;
                                                            case 3:
                                                                $skalaText =
                                                                    'Crying, Requires, Increased, Expression, Sleepless (CRIES)';
                                                                break;
                                                            default:
                                                                $skalaText = '-';
                                                        }
                                                    @endphp
                                                    {{ $skalaText }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nilai Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->nilai_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->kesimpulan_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Karakteristik Nyeri -->
                                    <div class="row mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lokasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ optional($asesmen->rmeAsesmenKepAnakStatusNyeri)->lokasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Durasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ optional($asesmen->rmeAsesmenKepAnakStatusNyeri)->durasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = optional($asesmen->rmeAsesmenKepAnakStatusNyeri);
                                                        $jenisNyeriId = $statusNyeri->jenis_nyeri ?? null;
                                                    @endphp

                                                    @if ($jenisNyeriId)
                                                        @foreach ($jenisnyeri as $jenis)
                                                            @if ($jenis->id == $jenisNyeriId)
                                                                {{ $jenis->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Frekuensi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = optional($asesmen->rmeAsesmenKepAnakStatusNyeri);
                                                        $frekuensiId = $statusNyeri->frekuensi ?? null;
                                                    @endphp

                                                    @if ($frekuensiId)
                                                        @foreach ($frekuensinyeri as $frekuensi)
                                                            @if ($frekuensi->id == $frekuensiId)
                                                                {{ $frekuensi->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Menjalar :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri;
                                                        $menjalarId = $statusNyeri ? $statusNyeri->menjalar : null;
                                                    @endphp

                                                    @if ($menjalarId)
                                                        @foreach ($menjalar as $men)
                                                            @if ($men->id == $menjalarId)
                                                                {{ $men->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kualitas :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri;
                                                        $kualitasId = $statusNyeri ? $statusNyeri->kualitas : null;
                                                    @endphp

                                                    @if ($kualitasId)
                                                        @foreach ($kualitasnyeri as $kualitas)
                                                            @if ($kualitas->id == $kualitasId)
                                                                {{ $kualitas->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Faktor Pemberat :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri;
                                                        $faktorPemberatId = $statusNyeri
                                                            ? $statusNyeri->faktor_pemberat
                                                            : null;
                                                    @endphp

                                                    @if ($faktorPemberatId)
                                                        @foreach ($faktorpemberat as $pemberat)
                                                            @if ($pemberat->id == $faktorPemberatId)
                                                                {{ $pemberat->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Faktor Peringan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri;
                                                        $faktorPeringanId = $statusNyeri
                                                            ? $statusNyeri->faktor_peringan
                                                            : null;
                                                    @endphp

                                                    @if ($faktorPeringanId)
                                                        @foreach ($faktorperingan as $peringan)
                                                            @if ($peringan->id == $faktorPeringanId)
                                                                {{ $peringan->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Efek Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri;
                                                        $efekNyeriId = $statusNyeri ? $statusNyeri->efek_nyeri : null;
                                                    @endphp

                                                    @if ($efekNyeriId)
                                                        @foreach ($efeknyeri as $efek)
                                                            @if ($efek->id == $efekNyeriId)
                                                                {{ $efek->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Riwayat Kesehatan -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>5. Riwayat Kesehatan</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Penyakit Yang Pernah Diderita :</label>
                                                @php
                                                    $penyakitDiderita = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                            ->penyakit_yang_diderita ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($penyakitDiderita))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Nama Penyakit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($penyakitDiderita as $index => $penyakit)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $penyakit }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Kecelakaan :</label>
                                                @php
                                                    $riwayatKecelakaan = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                            ->riwayat_kecelakaan_lalu ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($riwayatKecelakaan))
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @foreach ($riwayatKecelakaan as $kecelakaan)
                                                            <span class="badge bg-warning">{{ $kecelakaan }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Rawat Inap :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $riwayatKesehatan = optional(
                                                            $asesmen->rmeAsesmenKepAnakRiwayatKesehatan,
                                                        );
                                                        $riwayatRawatInap =
                                                            $riwayatKesehatan->riwayat_rawat_inap ?? null;
                                                        $tanggalRawatInap =
                                                            $riwayatKesehatan->tanggal_riwayat_rawat_inap ?? null;
                                                    @endphp

                                                    {{ $riwayatRawatInap ? 'Ya' : 'Tidak' }}

                                                    @if ($tanggalRawatInap)
                                                        <br>
                                                        <small class="text-muted">
                                                            Tanggal:
                                                            {{ \Carbon\Carbon::parse($tanggalRawatInap)->format('d/m/Y') }}
                                                        </small>
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tumbuh Kembang Dibanding
                                                    Saudara-Saudaranya :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Operasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_operasi ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis/Nama Operasi :</label>
                                                @php
                                                    $jenisOperasi = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->nama_operasi ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($jenisOperasi))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Jenis Operasi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($jenisOperasi as $index => $operasi)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $operasi }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Kesehatan Keluarga :</label>
                                                @php
                                                    $riwayatKeluarga = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                            ->riwayat_penyakit_keluarga ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($riwayatKeluarga))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Riwayat Kesehatan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($riwayatKeluarga as $index => $riwayat)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $riwayat }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Konsumsi Obat-Obatan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->konsumsi_obat ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Alergi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>6. Alergi</h5>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Alergi :</label>
                                                @php
                                                    // Ambil data alergi langsung dari database berdasarkan kd_pasien
                                                    $alergiPasienData = \App\Models\RmeAlergiPasien::where(
                                                        'kd_pasien',
                                                        $dataMedis->kd_pasien,
                                                    )->get();
                                                @endphp

                                                @if ($alergiPasienData->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Jenis</th>
                                                                    <th>Alergen</th>
                                                                    <th>Reaksi</th>
                                                                    <th>Tingkat Keparahan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($alergiPasienData as $alergi)
                                                                    <tr>
                                                                        <td>{{ $alergi->jenis_alergi ?? '-' }}</td>
                                                                        <td>{{ $alergi->nama_alergi ?? '-' }}</td>
                                                                        <td>{{ $alergi->reaksi ?? '-' }}</td>
                                                                        <td>{{ $alergi->tingkat_keparahan ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada riwayat alergi</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Risiko Jatuh -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>7. Risiko Jatuh</h5>
                                        <div class="col-md-12">
                                            @php
                                                $risikoJatuh = optional($asesmen->rmeAsesmenKepAnakRisikoJatuh);
                                                $jenisSkala = $risikoJatuh->resiko_jatuh_jenis ?? null;
                                                $skalaOptions = [
                                                    '1' => 'Skala Umum',
                                                    '2' => 'Skala Morse',
                                                    '3' => 'Skala Humpty-Dumpty / Pediatrik',
                                                    '4' => 'Skala Ontario Modified Stratify Sydney / Lansia',
                                                    '5' => 'Lainnya',
                                                ];
                                            @endphp

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Penilaian Risiko Jatuh :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $skalaOptions[$jenisSkala] ?? '-' }}
                                                </p>
                                            </div>

                                            @if ($jenisSkala == 1)
                                                <!-- Skala Umum -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Penilaian Risiko Jatuh Skala Umum</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah pasien berusia < dari 2
                                                                        tahun?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_usia ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien dalam kondisi sebagai geriatri, dizzines,
                                                                    vertigo, gangguan keseimbangan?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_kondisi_khusus ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien didiagnosis sebagai pasien dengan penyakit
                                                                    parkinson?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien sedang mendapatkan obat sedasi?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien saat ini sedang berada pada lokasi
                                                                    berisiko?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_lokasi_berisiko ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $risikoJatuh->kesimpulan_skala_umum ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisSkala == 2)
                                                <!-- Skala Morse -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Penilaian Risiko Jatuh Skala Morse</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Riwayat Jatuh</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 25 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Diagnosis Sekunder</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 15 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alat Bantu</th>
                                                                <td>
                                                                    @php
                                                                        $bantuanAmbulasi =
                                                                            $risikoJatuh->risiko_jatuh_morse_bantuan_ambulasi;
                                                                        $bantuanOptions = [
                                                                            30 => 'Meja/kursi',
                                                                            15 => 'Kruk/tongkat/alat bantu berjalan',
                                                                            0 => 'Tidak ada/bed rest/bantuan perawat',
                                                                        ];
                                                                    @endphp
                                                                    {{ $bantuanOptions[$bantuanAmbulasi] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Terpasang Infus</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_morse_terpasang_infus == 20 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Cara Berjalan</th>
                                                                <td>
                                                                    @php
                                                                        $caraBerjalan =
                                                                            $risikoJatuh->risiko_jatuh_morse_cara_berjalan;
                                                                        $caraBerjalanOptions = [
                                                                            0 => 'Normal/bed rest/kursi roda',
                                                                            20 => 'Terganggu',
                                                                            10 => 'Lemah',
                                                                        ];
                                                                    @endphp
                                                                    {{ $caraBerjalanOptions[$caraBerjalan] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status Mental</th>
                                                                <td>
                                                                    {{ $risikoJatuh->risiko_jatuh_morse_status_mental == 15
                                                                        ? 'Lupa akan keterbatasannya'
                                                                        : 'Berorientasi pada kemampuannya' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $risikoJatuh->kesimpulan_skala_morse ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisSkala == 3)
                                                <!-- Skala Humpty Dumpty -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik
                                                    </h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Usia Anak</th>
                                                                <td>
                                                                    @php
                                                                        $usia =
                                                                            $risikoJatuh->risiko_jatuh_pediatrik_usia_anak;
                                                                        $usiaOptions = [
                                                                            4 => 'Dibawah 3 tahun',
                                                                            3 => '3-7 tahun',
                                                                            2 => '7-13 tahun',
                                                                            1 => 'Diatas 13 tahun',
                                                                        ];
                                                                    @endphp
                                                                    {{ $usiaOptions[$usia] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 2 ? 'Laki-laki' : 'Perempuan' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Diagnosis</th>
                                                                <td>
                                                                    @php
                                                                        $diagnosis =
                                                                            $risikoJatuh->risiko_jatuh_pediatrik_diagnosis;
                                                                        $diagnosisOptions = [
                                                                            4 => 'Diagnosis Neurologis',
                                                                            3 => 'Perubahan oksigennasi (diagnosis respiratorik, dehidrasi, anemia, syncope, pusing, dsb)',
                                                                            2 => 'Gangguan perilaku /psikiatri',
                                                                            1 => 'Diagnosis lainnya',
                                                                        ];
                                                                    @endphp
                                                                    {{ $diagnosisOptions[$diagnosis] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gangguan Kognitif</th>
                                                                <td>
                                                                    @php
                                                                        $kognitif =
                                                                            $risikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif;
                                                                        $kognitifOptions = [
                                                                            3 => 'Tidak menyadari keterbatasan dirinya',
                                                                            2 => 'Lupa akan adanya keterbatasan',
                                                                            1 => 'Orientasi baik terhadap dari sendiri',
                                                                        ];
                                                                    @endphp
                                                                    {{ $kognitifOptions[$kognitif] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Faktor Lingkungan</th>
                                                                <td>
                                                                    @php
                                                                        $lingkungan =
                                                                            $risikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan;
                                                                        $lingkunganOptions = [
                                                                            4 => 'Riwayat jatuh /bayi diletakkan di tempat tidur dewasa',
                                                                            3 => 'Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi / perabot rumah',
                                                                            2 => 'Pasien diletakkan di tempat tidur',
                                                                            1 => 'Area di luar rumah sakit',
                                                                        ];
                                                                    @endphp
                                                                    {{ $lingkunganOptions[$lingkungan] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pembedahan/Sedasi/Anestesi</th>
                                                                <td>
                                                                    @php
                                                                        $pembedahan =
                                                                            $risikoJatuh->risiko_jatuh_pediatrik_pembedahan;
                                                                        $pembedahanOptions = [
                                                                            3 => 'Dalam 24 jam',
                                                                            2 => 'Dalam 48 jam',
                                                                            1 => '> 48 jam atau tidak menjalani pembedahan/sedasi/anestesi',
                                                                        ];
                                                                    @endphp
                                                                    {{ $pembedahanOptions[$pembedahan] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Penggunaan Medika mentosa</th>
                                                                <td>
                                                                    @php
                                                                        $medika =
                                                                            $risikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa;
                                                                        $medikaOptions = [
                                                                            3 => 'Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose',
                                                                            2 => 'Penggunaan salah satu obat diatas',
                                                                            1 => 'Penggunaan medikasi lainnya/tidak ada mediksi',
                                                                        ];
                                                                    @endphp
                                                                    {{ $medikaOptions[$medika] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $risikoJatuh->kesimpulan_skala_pediatrik ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisSkala == 4)
                                                <!-- Skala Ontario -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Penilaian Risiko Jatuh Skala Ontario Modified
                                                        Stratify Sydney/ Lansia</h6>

                                                    <h6 class="mt-4 mb-3">1. Riwayat Jatuh</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah pasien datang kerumah sakit
                                                                    karena jatuh?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 6 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien mengalami jatuh dalam 2 bulan terakhir?
                                                                </th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 6 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3">2. Status Mental</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah pasien bingung?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_status_bingung == 14 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien disorientasi?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_status_disorientasi == 14 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien mengalami agitasi?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_status_agitasi == 14 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3">3. Penglihatan</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah pasien memakai kacamata?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_kacamata == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien mengalami kelainan penglihatan?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien mempunyai glukoma/katarak/degenerasi
                                                                    makula?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_glukoma == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3">4. Kebiasaan Berkemih</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah terdapat perubahan perilaku
                                                                    berkemih?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 2 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3">5. Transfer</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Mandiri</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 0 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Memerlukan sedikit bantuan (1 orang)</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Memerlukan bantuan yang nyata (2 orang)</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 2 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tidak dapat duduk dengan seimbang</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 3 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3">6. Mobilitas Pasien</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Mandiri</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 0 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Berjalan dengan bantuan 1 orang</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Menggunakan kursi roda</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 2 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Imobilisasi</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 3 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $risikoJatuh->kesimpulan_skala_lansia ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisSkala == 5)
                                                <div class="alert alert-warning">
                                                    <strong>Catatan:</strong> Pasien tidak dapat dinilai status risiko jatuh
                                                    (Lainnya)
                                                </div>
                                            @endif

                                            <!-- Intervensi Risiko Jatuh -->
                                            <div class="mb-4">
                                                <h6 class="fw-bold">Intervensi Risiko Jatuh</h6>
                                                @php
                                                    $intervensi = json_decode(
                                                        $risikoJatuh->intervensi_risiko_jatuh ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($intervensi))
                                                    <ul class="list-group">
                                                        @foreach ($intervensi as $item)
                                                            <li class="list-group-item">{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted">Tidak ada intervensi yang ditambahkan</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Risiko Dekubitus -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>8. Risiko Dekubitus</h5>
                                        <div class="col-md-12">

                                            @if ($asesmen->rmeAsesmenKepAnakResikoDekubitus)
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Jenis Skala Dekubitus :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if ($asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 1)
                                                            Skala Norton
                                                        @elseif($asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 2)
                                                            Skala Braden
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>

                                                @if ($asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 1)
                                                    <!-- Skala Norton -->
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold">Penilaian Risiko DECUBITUS Skala Norton</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm">
                                                                <tr>
                                                                    <th width="200">Kondisi Fisik</th>
                                                                    <td>
                                                                        @php
                                                                            $fisik =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->norton_kondisi_fisik;
                                                                            switch ($fisik) {
                                                                                case 4:
                                                                                    echo 'Baik (4)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Sedang (3)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Buruk (2)';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Sangat Buruk (1)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kondisi Mental</th>
                                                                    <td>
                                                                        @php
                                                                            $mental =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->norton_kondisi_mental;
                                                                            switch ($mental) {
                                                                                case 4:
                                                                                    echo 'Sadar (4)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Apatis (3)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Bingung (2)';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Stupor (1)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Aktivitas</th>
                                                                    <td>
                                                                        @php
                                                                            $aktivitas =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->norton_aktivitas;
                                                                            switch ($aktivitas) {
                                                                                case 4:
                                                                                    echo 'Aktif (4)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Jalan dengan bantuan (3)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Terbatas di kursi (2)';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Terbatas di tempat tidur (1)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Mobilitas</th>
                                                                    <td>
                                                                        @php
                                                                            $mobilitas =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->norton_mobilitas;
                                                                            switch ($mobilitas) {
                                                                                case 4:
                                                                                    echo 'Bebas bergerak (4)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Agak terbatas (3)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Sangat terbatas (2)';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Tidak dapat bergerak (1)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Inkontinensia</th>
                                                                    <td>
                                                                        @php
                                                                            $inkontinensia =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->norton_inkontenesia;
                                                                            switch ($inkontinensia) {
                                                                                case 4:
                                                                                    echo 'Tidak ada (4)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Kadang-kadang (3)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Biasanya urin (2)';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Urin dan feses (1)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="alert alert-info mt-3">
                                                            <strong>Total Skor:</strong>
                                                            {{ ($asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia ?? 0) }}
                                                            <br>
                                                            <strong>Kesimpulan:</strong>
                                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '-' }}
                                                        </div>
                                                    </div>
                                                @elseif($asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 2)
                                                    <!-- Skala Braden -->
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold">Penilaian Risiko DECUBITUS Skala Braden</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm">
                                                                <tr>
                                                                    <th width="200">Persepsi Sensori</th>
                                                                    <td>
                                                                        @php
                                                                            $sensori =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->braden_persepsi;
                                                                            switch ($sensori) {
                                                                                case 1:
                                                                                    echo 'Keterbatasan Penuh (1)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Sangat Terbatas (2)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Keterbatasan Ringan (3)';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Tidak Ada Gangguan (4)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kelembapan</th>
                                                                    <td>
                                                                        @php
                                                                            $kelembapan =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->braden_kelembapan;
                                                                            switch ($kelembapan) {
                                                                                case 1:
                                                                                    echo 'Selalu Lembap (1)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Umumnya Lembap (2)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Kadang-Kadang Lembap (3)';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Jarang Lembap (4)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Aktivitas</th>
                                                                    <td>
                                                                        @php
                                                                            $aktivitas =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->braden_aktivitas;
                                                                            switch ($aktivitas) {
                                                                                case 1:
                                                                                    echo 'Total di Tempat Tidur (1)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Dapat Duduk (2)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Berjalan Kadang-kadang (3)';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Dapat Berjalan-jalan (4)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Mobilitas</th>
                                                                    <td>
                                                                        @php
                                                                            $mobilitas =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->braden_mobilitas;
                                                                            switch ($mobilitas) {
                                                                                case 1:
                                                                                    echo 'Tidak Mampu Bergerak Sama sekali (1)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Sangat Terbatas (2)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Tidak Ada Masalah (3)';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Tanpa Keterbatasan (4)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Nutrisi</th>
                                                                    <td>
                                                                        @php
                                                                            $nutrisi =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->braden_nutrisi;
                                                                            switch ($nutrisi) {
                                                                                case 1:
                                                                                    echo 'Sangat Buruk (1)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Kurang Mencukupi (2)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Mencukupi (3)';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Sangat Baik (4)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Pergesekan dan Pergeseran</th>
                                                                    <td>
                                                                        @php
                                                                            $pergesekan =
                                                                                $asesmen
                                                                                    ->rmeAsesmenKepAnakResikoDekubitus
                                                                                    ->braden_pergesekan;
                                                                            switch ($pergesekan) {
                                                                                case 1:
                                                                                    echo 'Bermasalah (1)';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Potensial Bermasalah (2)';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Keterbatasan Ringan (3)';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="alert alert-info mt-3">
                                                            <strong>Total Skor:</strong>
                                                            {{ ($asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi ?? 0) +
                                                                ($asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan ?? 0) }}
                                                            <br>
                                                            <strong>Kesimpulan:</strong>
                                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '-' }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Jenis Skala Dekubitus :</label>
                                                    <p class="form-control-plaintext border-bottom">-</p>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Status Psikologis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>9. Status Psikologis</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Kondisi Psikologis :</label>
                                                @php
                                                    $kondisiPsikologis = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakStatusPsikologis
                                                            ->kondisi_psikologis ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($kondisiPsikologis))
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @foreach ($kondisiPsikologis as $kondisi)
                                                            <span class="badge bg-info">{{ $kondisi }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada kondisi psikologis yang
                                                            dipilih</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Gangguan Perilaku :</label>
                                                @php
                                                    $gangguanPerilaku = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakStatusPsikologis
                                                            ->gangguan_perilaku ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($gangguanPerilaku))
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @foreach ($gangguanPerilaku as $perilaku)
                                                            <span class="badge bg-info">{{ $perilaku }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada gangguan perilaku yang
                                                            dipilih</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Potensi Menyakiti Diri Sendiri/Orang
                                                    Lain:</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenKepAnakStatusPsikologis)
                                                        @if ($asesmen->rmeAsesmenKepAnakStatusPsikologis->potensi_menyakiti === 0)
                                                            Ya
                                                        @elseif($asesmen->rmeAsesmenKepAnakStatusPsikologis->potensi_menyakiti === 1)
                                                            Tidak
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Anggota Keluarga Gangguan Jiwa:</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $gangguanJiwa =
                                                            $asesmen->rmeAsesmenKepAnakStatusPsikologis
                                                                ?->keluarga_gangguan_jiwa;
                                                    @endphp

                                                    @if ($gangguanJiwa === 0)
                                                        Ya
                                                    @elseif ($gangguanJiwa === 1)
                                                        Tidak
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Lainnya :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->lainnya ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 10. Status Spiritual -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>10. Status Spiritual</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Keyakinan Agama :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->agama ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Pandangan Pasien Terhadap Penyakit
                                                    :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 11. Status Sosial Ekonomi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>11. Status Sosial Ekonomi</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Pekerjaan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi->sosial_ekonomi_pekerjaan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Status Pernikahan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi->sosial_ekonomi_status_pernikahan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Tempat Tinggal :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi->sosial_ekonomi_tempat_tinggal ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Curiga Penganiayaan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi->sosial_ekonomi_curiga_penganiayaan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Status Tinggal dengan Keluarga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. Status Gizi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>12. Status Gizi</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Jenis Penilaian Gizi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisGizi =
                                                            $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis ?? null;
                                                        $jenisGiziOptions = [
                                                            1 => 'Malnutrition Screening Tool (MST)',
                                                            2 => 'The Mini Nutritional Assessment (MNA)',
                                                            3 => 'Strong Kids (1 bln - 18 Tahun)',
                                                            4 => 'NRS (Nutritional Risk Screening)',
                                                            5 => 'Tidak Dapat Dinilai',
                                                        ];
                                                    @endphp
                                                    {{ $jenisGiziOptions[$jenisGizi] ?? '-' }}
                                                </p>
                                            </div>

                                            @if ($jenisGizi == 1)
                                                <!-- MST Detail -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Detail Malnutrition Screening Tool (MST)</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Penurunan Berat Badan dalam 6 bulan
                                                                    terakhir</th>
                                                                <td>
                                                                    @php
                                                                        $penurunanBB =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mst_penurunan_bb ?? null;
                                                                        $penurunanBBOptions = [
                                                                            0 => 'Tidak ada penurunan Berat Badan (BB)',
                                                                            2 => 'Tidak yakin/ tidak tahu/ terasa baju lebih longgar',
                                                                            3 => 'Ya ada penurunan BB',
                                                                        ];
                                                                    @endphp
                                                                    {{ $penurunanBBOptions[$penurunanBB] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jumlah Penurunan Berat Badan</th>
                                                                <td>
                                                                    @php
                                                                        $jumlahPenurunanBB =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mst_jumlah_penurunan_bb ?? null;
                                                                        $jumlahPenurunanBBOptions = [
                                                                            0 => 'Tidak ada',
                                                                            1 => '1-5 kg',
                                                                            2 => '6-10 kg',
                                                                            3 => '11-15 kg',
                                                                            4 => '>15 kg',
                                                                        ];
                                                                    @endphp
                                                                    {{ $jumlahPenurunanBBOptions[$jumlahPenurunanBB] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nafsu Makan Berkurang</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_nafsu_makan_berkurang == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Diagnosis Khusus (DM, Cancer, Geriatri, GGK, dll)</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_diagnosis_khusus == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_kesimpulan ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisGizi == 2)
                                                <!-- MNA Detail -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Detail Mini Nutritional Assessment (MNA)</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Penurunan Asupan Makanan 3 bulan
                                                                    terakhir</th>
                                                                <td>
                                                                    @php
                                                                        $penurunanAsupan =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mna_penurunan_asupan_3_bulan ??
                                                                            null;
                                                                        $penurunanAsupanOptions = [
                                                                            0 => 'Mengalami penurunan asupan makanan yang parah',
                                                                            1 => 'Mengalami penurunan asupan makanan sedang',
                                                                            2 => 'Tidak mengalami penurunan asupan makanan',
                                                                        ];
                                                                    @endphp
                                                                    {{ $penurunanAsupanOptions[$penurunanAsupan] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kehilangan Berat Badan 3 bulan terakhir</th>
                                                                <td>
                                                                    @php
                                                                        $penurunanBB =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mna_kehilangan_bb_3_bulan ??
                                                                            null;
                                                                        $penurunanBBOptions = [
                                                                            0 => 'Kehilangan BB lebih dari 3 Kg',
                                                                            1 => 'Tidak tahu',
                                                                            2 => 'Kehilangan BB antara 1 s.d 3 Kg',
                                                                            3 => 'Tidak ada kehilangan BB',
                                                                        ];
                                                                    @endphp
                                                                    {{ $penurunanBBOptions[$penurunanBB] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mobilitas</th>
                                                                <td>
                                                                    @php
                                                                        $mobilitas =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mna_mobilisasi ?? null;
                                                                        $mobilitasOptions = [
                                                                            0 => 'Hanya di tempat tidur atau kursi roda',
                                                                            1 => 'Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan',
                                                                            2 => 'Dapat jalan-jalan',
                                                                        ];
                                                                    @endphp
                                                                    {{ $mobilitasOptions[$mobilitas] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Stres Psikologi/Penyakit Akut</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_stress_penyakit_akut == 1 ? 'Tidak' : 'Ya' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status Neuropsikologi</th>
                                                                <td>
                                                                    @php
                                                                        $neuropsikologi =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mna_status_neuropsikologi ??
                                                                            null;
                                                                        $neuropsikologiOptions = [
                                                                            0 => 'Demensia atau depresi berat',
                                                                            1 => 'Demensia ringan',
                                                                            2 => 'Tidak mengalami masalah neuropsikologi',
                                                                        ];
                                                                    @endphp
                                                                    {{ $neuropsikologiOptions[$neuropsikologi] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Berat Badan</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_berat_badan ?? '-' }}
                                                                    kg</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tinggi Badan</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_tinggi_badan ?? '-' }}
                                                                    cm</td>
                                                            </tr>
                                                            <tr>
                                                                <th>IMT</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_imt ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisGizi == 3)
                                                <!-- Strong Kids Detail -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Detail Strong Kids</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Anak tampak kurus (kehilangan lemak
                                                                    subkutan, massa otot, wajah cekung)</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_status_kurus == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Penurunan Berat Badan selama 1 bulan terakhir</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penurunan_bb == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gangguan Pencernaan (diare ≥5x/hari, muntah >3x/hari,
                                                                    penurunan asupan)</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_gangguan_pencernaan == 1 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Penyakit/keadaan yang berisiko malnutrisi</th>
                                                                <td>{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penyakit_berisiko == 2 ? 'Ya' : 'Tidak' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisGizi == 5)
                                                <div class="alert alert-warning">
                                                    <strong>Catatan:</strong> Pasien tidak dapat dinilai status gizinya
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13. Status Fungsional -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>13. Status Fungsional</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Jenis Skala Fungsional :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisSkala =
                                                            $asesmen->rmeAsesmenKepAnakStatusFungsional->jenis_skala ??
                                                            null;
                                                        $jenisSkalaOptions = [
                                                            1 => 'Pengkajian Aktivitas Harian',
                                                            2 => 'Lainnya',
                                                            0 => 'Tidak Dipilih',
                                                        ];
                                                    @endphp
                                                    {{ $jenisSkalaOptions[$jenisSkala] ?? '-' }}
                                                </p>
                                            </div>

                                            @if ($jenisSkala == 1)
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Pengkajian Aktivitas Harian (ADL)</h6>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Makan :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 14. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>14. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Gaya Bicara :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Bahasa Sehari-Hari :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->bahasa ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Perlu Penerjemah :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->perlu_penerjemahan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Hambatan Komunikasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Media Disukai :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->media_disukai ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Tingkat Pendidikan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 15. Discharge Planning -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>15. Discharge Planning</h5>
                                        <div class="col-md-6">
                                            {{-- <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Medis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->diagnosis_medis ?? '-' }}
                                                </p>
                                            </div> --}}

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Usia Lanjut</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut) &&
                                                            $asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut !== null)
                                                        {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hambatan Mobilisasi</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi) &&
                                                            $asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi !== null)
                                                        {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Membutuhkan Pelayanan Medis
                                                    Berkelanjutan</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->membutuhkan_pelayanan_medis ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Memerlukan Keterampilan Khusus</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_keterampilan_khusus ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Memerlukan Alat Bantu</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_alat_bantu ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Memiliki Nyeri Kronis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->memiliki_nyeri_kronis ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Ketergantungan Aktivitas</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->ketergantungan_aktivitas ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat) &&
                                                            $asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat !== null)
                                                        {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat }}
                                                        Hari
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang) &&
                                                            $asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang !== null)
                                                        {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang ? \Carbon\Carbon::parse($asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang)->format('d M Y') : '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan</label>
                                                <div
                                                    class="alert
                            @if ($asesmen->rmeAsesmenKepAnakRencanaPulang->kesimpulan == 'Mebutuhkan rencana pulang khusus') alert-warning
                            @elseif($asesmen->rmeAsesmenKepAnakRencanaPulang->kesimpulan == 'Tidak mebutuhkan rencana pulang khusus')
                                alert-success
                            @else
                                alert-info @endif
                        ">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->kesimpulan ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MASALAH/ DIAGNOSIS KEPERAWATAN  -->
                        <div class="section-separator" id="masalah_diagnosis">
                            <h5 class="section-title">13. MASALAH/ DIAGNOSIS KEPERAWATAN</h5>
                            <p class="text-muted mb-4">(Diisi berdasarkan hasil asesmen dan berurut sesuai masalah yang
                                dominan terlebih dahulu)</p>

                            <!-- Diagnosis Keperawatan Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="50%">DIAGNOSA KEPERAWATAN</th>
                                            <th width="50%">RENCANA KEPERAWATAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- 1. Bersihan Jalan Nafas Tidak Efektif -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox" name="diagnosis[]"
                                                        value="bersihan_jalan_nafas" id="diag_bersihan_jalan_nafas"
                                                        onchange="toggleRencana('bersihan_jalan_nafas')"
                                                        {{ in_array('bersihan_jalan_nafas', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_bersihan_jalan_nafas">
                                                        <strong>Bersihan jalan nafas tidak efektif</strong> berhubungan
                                                        dengan spasme jalan nafas...
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox" name="diagnosis[]" value="risiko_aspirasi"
                                                        id="diag_risiko_aspirasi"
                                                        onchange="toggleRencana('risiko_aspirasi')"
                                                        {{ in_array('risiko_aspirasi', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_risiko_aspirasi">
                                                        <strong>Risiko aspirasi</strong> berhubungan dengan tingkat
                                                        kesadaran...
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox" name="diagnosis[]"
                                                        value="pola_nafas_tidak_efektif"
                                                        id="diag_pola_nafas_tidak_efektif"
                                                        onchange="toggleRencana('pola_nafas_tidak_efektif')"
                                                        {{ in_array('pola_nafas_tidak_efektif', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_pola_nafas_tidak_efektif">
                                                        <strong>Pola nafas tidak efektif</strong> berhubungan dengan depresi
                                                        pusat pernafasan...
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_bersihan_jalan_nafas" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_pola_nafas"
                                                            {{ in_array('monitor_pola_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor pola nafas ( frekuensi ,
                                                            kedalaman, usaha nafas )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_bunyi_nafas"
                                                            {{ in_array('monitor_bunyi_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor bunyi nafas tambahan (
                                                            mengi, wheezing, rhonchi )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]" value="monitor_sputum"
                                                            {{ in_array('monitor_sputum', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor sputum ( jumlah, warna,
                                                            aroma )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_tingkat_kesadaran"
                                                            {{ in_array('monitor_tingkat_kesadaran', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tingkat kesadaran, batuk,
                                                            muntah dan kemampuan menelan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_kemampuan_batuk"
                                                            {{ in_array('monitor_kemampuan_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan batuk
                                                            efektif</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="pertahankan_kepatenan"
                                                            {{ in_array('pertahankan_kepatenan', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan kepatenan jalan nafas
                                                            dengan head-tilt dan chin -lift ( jaw – thrust jika curiga
                                                            trauma servikal ) </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="posisikan_semi_fowler"
                                                            {{ in_array('posisikan_semi_fowler', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan semi fowler atau
                                                            fowler</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="berikan_minum_hangat"
                                                            {{ in_array('berikan_minum_hangat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan minum hangat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="fisioterapi_dada"
                                                            {{ in_array('fisioterapi_dada', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan fisioterapi dada, jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="keluarkan_benda_padat"
                                                            {{ in_array('keluarkan_benda_padat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Keluarkan benda padat dengan
                                                            forcep</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="penghisapan_lendir"
                                                            {{ in_array('penghisapan_lendir', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan penghisapan lendir</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="berikan_oksigen"
                                                            {{ in_array('berikan_oksigen', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="anjuran_asupan_cairan"
                                                            {{ in_array('anjuran_asupan_cairan', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjuran asupan cairan 2000
                                                            ml/hari, jika tidak kontra indikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="ajarkan_teknik_batuk"
                                                            {{ in_array('ajarkan_teknik_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik batuk
                                                            efektif</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="kolaborasi_pemberian_obat"
                                                            {{ in_array('kolaborasi_pemberian_obat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian
                                                            bronkodilator, ekspektoran, mukolitik, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 2. Penurunan Curah Jantung -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="penurunan_curah_jantung"
                                                        id="diag_penurunan_curah_jantung"
                                                        onchange="toggleRencana('penurunan_curah_jantung')"
                                                        {{ in_array('penurunan_curah_jantung', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}
                                                        onchange="toggleRencana('diag_penurunan_curah_jantung')">
                                                    <label class="form-check-label" for="diag_penurunan_curah_jantung">
                                                        <strong>Penurunan curah jantung</strong> berhubungan dengan
                                                        perubahan irama jantung, perubahan frekuensi jantung.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_penurunan_curah_jantung" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="identifikasi_tanda_gejala"
                                                            {{ in_array('identifikasi_tanda_gejala', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda/gejala primer
                                                            penurunan curah jantung (meliputi dipsnea, kelelahan,
                                                            edema)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_tekanan_darah"
                                                            {{ in_array('monitor_tekanan_darah', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tekanan darah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_intake_output"
                                                            {{ in_array('monitor_intake_output', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output
                                                            cairan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_saturasi_oksigen"
                                                            {{ in_array('monitor_saturasi_oksigen', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor saturasi oksigen</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_keluhan_nyeri"
                                                            {{ in_array('monitor_keluhan_nyeri', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keluhan nyeri dada
                                                            (intensitas, lokasi, durasi, presivitasi yang mengurangi
                                                            nyeri)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_aritmia"
                                                            {{ in_array('monitor_aritmia', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor aritmia (kelainan irama
                                                            dan frekuensi)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="posisikan_pasien"
                                                            {{ in_array('posisikan_pasien', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan pasien semi fowler atau
                                                            fowler dengan kaki kebawah atau posisi nyaman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="berikan_terapi_relaksasi"
                                                            {{ in_array('berikan_terapi_relaksasi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan therapi relaksasi untuk
                                                            mengurangi stres, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="berikan_dukungan_emosional"
                                                            {{ in_array('berikan_dukungan_emosional', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan dukungan emosional dan
                                                            spirital</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="berikan_oksigen_saturasi"
                                                            {{ in_array('berikan_oksigen_saturasi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen untuk
                                                            mempertahankan saturasi oksigen >94%</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="anjurkan_beraktifitas"
                                                            {{ in_array('anjurkan_beraktifitas', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan beraktifitas fisik sesuai
                                                            toleransi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="anjurkan_berhenti_merokok"
                                                            {{ in_array('anjurkan_berhenti_merokok', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="ajarkan_mengukur_intake"
                                                            {{ in_array('ajarkan_mengukur_intake', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan pasien dan keluarga
                                                            mengukur intake dan output cairan harian</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="kolaborasi_pemberian_terapi"
                                                            {{ in_array('kolaborasi_pemberian_terapi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 3. Perfusi Perifer Tidak Efektif -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="perfusi_perifer"
                                                        id="diag_perfusi_perifer"
                                                        onchange="toggleRencana('perfusi_perifer')"
                                                        {{ in_array('perfusi_perifer', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_perfusi_perifer">
                                                        <strong>Perfusi perifer tidak efektif</strong> berhubungan dengan
                                                        hyperglikemia, penurunan konsentrasi hemoglobin, peningkatan tekanan
                                                        darah, kekurangan volume cairan, penurunan aliran arteri dan/atau
                                                        vena, kurang terpapar informasi tentang proses penyakit (misal:
                                                        diabetes melitus, hiperlipidmia).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_perfusi_perifer" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="periksa_sirkulasi"
                                                            {{ in_array('periksa_sirkulasi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa sirkulasi perifer (edema,
                                                            pengisian kapiler/CRT, suhu)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="identifikasi_faktor_risiko"
                                                            {{ in_array('identifikasi_faktor_risiko', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko
                                                            gangguan sirkulasi (diabetes, perokok, hipertensi, kadar
                                                            kolesterol tinggi)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="monitor_suhu_kemerahan"
                                                            {{ in_array('monitor_suhu_kemerahan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu, kemerahan, nyeri
                                                            atau bengkak pada ekstremitas.</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="hindari_pemasangan_infus"
                                                            {{ in_array('hindari_pemasangan_infus', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemasangan infus atau
                                                            pengambilan darah di area keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="hindari_pengukuran_tekanan"
                                                            {{ in_array('hindari_pengukuran_tekanan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pengukuran tekanan darah
                                                            pada ekstremitas dengan keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="hindari_penekanan"
                                                            {{ in_array('hindari_penekanan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari penekanan dan pemasangan
                                                            tourniqet pada area yang cedera</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="lakukan_pencegahan_infeksi"
                                                            {{ in_array('lakukan_pencegahan_infeksi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pencegahan infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="perawatan_kaki_kuku"
                                                            {{ in_array('perawatan_kaki_kuku', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan perawatan kaki dan
                                                            kuku</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="anjurkan_berhenti_merokok_perfusi"
                                                            {{ in_array('anjurkan_berhenti_merokok_perfusi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="anjurkan_berolahraga"
                                                            {{ in_array('anjurkan_berolahraga', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berolahraga rutin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="anjurkan_minum_obat"
                                                            {{ in_array('anjurkan_minum_obat', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan minum obat pengontrol
                                                            tekanan darah secara teratur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="kolaborasi_terapi_perfusi"
                                                            {{ in_array('kolaborasi_terapi_perfusi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 4. Hipovolemia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="hipovolemia" id="diag_hipovolemia"
                                                        onchange="toggleRencana('hipovolemia')"
                                                        {{ in_array('hipovolemia', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipovolemia">
                                                        <strong>Hipovolemia</strong> berhubungan dengan kehilangan cairan
                                                        aktif, peningkatan permeabilitas kapiler, kekurangan intake cairan,
                                                        evaporasi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipovolemia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]" value="periksa_tanda_gejala"
                                                            {{ in_array('periksa_tanda_gejala', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala
                                                            hipovolemia (frekuensi nadi meningkat, nadi teraba lemah,
                                                            tekanan darah penurun, turgor kulit menurun, membran mukosa
                                                            kering, volume urine menurun, haus, lemah)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="monitor_intake_output_hipovolemia"
                                                            {{ in_array('monitor_intake_output_hipovolemia', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output
                                                            cairan</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]" value="berikan_asupan_cairan"
                                                            {{ in_array('berikan_asupan_cairan', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]" value="posisi_trendelenburg"
                                                            {{ in_array('posisi_trendelenburg', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisi modified
                                                            trendelenburg</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="anjurkan_memperbanyak_cairan"
                                                            {{ in_array('anjurkan_memperbanyak_cairan', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memperbanyak asupan
                                                            cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="hindari_perubahan_posisi"
                                                            {{ in_array('hindari_perubahan_posisi', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari perubahan
                                                            posisi mendadak</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="kolaborasi_terapi_hipovolemia"
                                                            {{ in_array('kolaborasi_terapi_hipovolemia', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 5. Hipervolemia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="hipervolemia" id="diag_hipervolemia"
                                                        onchange="toggleRencana('hipervolemia')"
                                                        {{ in_array('hipervolemia', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipervolemia">
                                                        <strong>Hipervolemia</strong> berhubungan dengan kelebihan asupan
                                                        cairan, kelebihan asupan natrium, gangguan aliran balik vena.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipervolemia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="periksa_tanda_hipervolemia"
                                                            {{ in_array('periksa_tanda_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala
                                                            hipervolemia (dipsnea, edema, suara nafas tambahan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="identifikasi_penyebab_hipervolemia"
                                                            {{ in_array('identifikasi_penyebab_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab
                                                            hipervolemia</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="monitor_hemodinamik"
                                                            {{ in_array('monitor_hemodinamik', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor status hemodinamik
                                                            (frekuensi jantung, tekanan darah)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="monitor_intake_output_hipervolemia"
                                                            {{ in_array('monitor_intake_output_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output
                                                            cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="monitor_efek_diuretik"
                                                            {{ in_array('monitor_efek_diuretik', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping diuretik
                                                            (hipotensi ortostatik, hipovolemia, hipokalemia,
                                                            hiponatremia)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="timbang_berat_badan"
                                                            {{ in_array('timbang_berat_badan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Timbang berat badan setiap hari
                                                            pada waktu yang sama</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="batasi_asupan_cairan"
                                                            {{ in_array('batasi_asupan_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan dan
                                                            garam</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="tinggi_kepala_tempat_tidur"
                                                            {{ in_array('tinggi_kepala_tempat_tidur', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40
                                                            º</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="ajarkan_mengukur_cairan"
                                                            {{ in_array('ajarkan_mengukur_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengukur dan mencatat
                                                            asupan dan haluaran cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="ajarkan_membatasi_cairan"
                                                            {{ in_array('ajarkan_membatasi_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara membatasi
                                                            cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="kolaborasi_terapi_hipervolemia"
                                                            {{ in_array('kolaborasi_terapi_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 6. Diare -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="diare" id="diag_diare"
                                                        onchange="toggleRencana('diare')"
                                                        {{ in_array('diare', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_diare">
                                                        <strong>Diare</strong> berhubungan dengan inflamasi
                                                        gastrointestinal, iritasi gastrointestinal, proses infeksi,
                                                        malabsorpsi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_diare" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="identifikasi_penyebab_diare"
                                                            {{ in_array('identifikasi_penyebab_diare', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab diare
                                                            (inflamasi gastrointestinal, iritasi gastrointestinal, proses
                                                            infeksi, malabsorpsi, ansietas, stres, efek samping
                                                            obat)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="identifikasi_riwayat_makanan"
                                                            {{ in_array('identifikasi_riwayat_makanan', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat pemberian
                                                            makanan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]"
                                                            value="identifikasi_gejala_invaginasi"
                                                            {{ in_array('identifikasi_gejala_invaginasi', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat gejala
                                                            invaginasi (tangisan keras, kepucatan pada bayi)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_warna_volume_tinja"
                                                            {{ in_array('monitor_warna_volume_tinja', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor warna, volume, frekuensi
                                                            dan konsistensi tinja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_tanda_hipovolemia"
                                                            {{ in_array('monitor_tanda_hipovolemia', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala
                                                            hipovolemia (takikardi, nadi teraba lemah, tekanan darah turun,
                                                            turgor kulit turun, mukosa mulit kering, CRT melambat, BB
                                                            menurun)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_iritasi_kulit"
                                                            {{ in_array('monitor_iritasi_kulit', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor iritasi dan ulserasi kulit
                                                            di daerah perianal</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_jumlah_diare"
                                                            {{ in_array('monitor_jumlah_diare', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor jumlah pengeluaran
                                                            diare</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="berikan_asupan_cairan_oral"
                                                            {{ in_array('berikan_asupan_cairan_oral', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral
                                                            (larutan garam gula, oralit, pedialyte)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="pasang_jalur_intravena"
                                                            {{ in_array('pasang_jalur_intravena', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang jalur intravena</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="berikan_cairan_intravena"
                                                            {{ in_array('berikan_cairan_intravena', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan intravena</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="anjurkan_makanan_porsi_kecil"
                                                            {{ in_array('anjurkan_makanan_porsi_kecil', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan makanan porsi kecil dan
                                                            sering secara bertahap</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="hindari_makanan_gas"
                                                            {{ in_array('hindari_makanan_gas', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari makanan
                                                            pembentuk gas, pedas dan mengandung laktosa</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="lanjutkan_asi"
                                                            {{ in_array('lanjutkan_asi', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melanjutkan pemberian
                                                            ASI</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="kolaborasi_terapi_diare"
                                                            {{ in_array('kolaborasi_terapi_diare', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 7. Retensi Urine -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="retensi_urine"
                                                        id="diag_retensi_urine"
                                                        onchange="toggleRencana('retensi_urine')"
                                                        {{ in_array('retensi_urine', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_retensi_urine">
                                                        <strong>Retensi urine</strong> berhubungan dengan peningkatan
                                                        tekanan uretra, kerusakan arkus refleks, Blok spingter, disfungsi
                                                        neurologis (trauma, penyakit saraf), efek agen farmakologis
                                                        (atropine, belladona, psikotropik, antihistamin, opiate).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_retensi_urine" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="identifikasi_tanda_retensi"
                                                            {{ in_array('identifikasi_tanda_retensi', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda dan gejala
                                                            retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="identifikasi_faktor_penyebab"
                                                            {{ in_array('identifikasi_faktor_penyebab', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang
                                                            menyebabkan retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="monitor_eliminasi_urine"
                                                            {{ in_array('monitor_eliminasi_urine', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor eliminasi urine
                                                            (frekuensi, konsistensi, aroma, volume dan warna)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="catat_waktu_berkemih"
                                                            {{ in_array('catat_waktu_berkemih', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Catat waktu-waktu dan haluaran
                                                            berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="batasi_asupan_cairan"
                                                            {{ in_array('batasi_asupan_cairan', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan, jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="ambil_sampel_urine"
                                                            {{ in_array('ambil_sampel_urine', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ambil sampel urine tengah
                                                            (midstream) atau kultur</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="ajarkan_tanda_infeksi"
                                                            {{ in_array('ajarkan_tanda_infeksi', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan tanda dan gejala infeksi
                                                            saluran kemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="ajarkan_mengukur_asupan"
                                                            {{ in_array('ajarkan_mengukur_asupan', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengukur asupan cairan dan
                                                            haluaran urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="ajarkan_spesimen_midstream"
                                                            {{ in_array('ajarkan_spesimen_midstream', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengambil spesimen urine
                                                            midstream</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="ajarkan_tanda_berkemih"
                                                            {{ in_array('ajarkan_tanda_berkemih', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengenali tanda berkemih
                                                            dan waktu yang tepat untuk berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="ajarkan_minum_cukup"
                                                            {{ in_array('ajarkan_minum_cukup', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan minum yang cukup, jika
                                                            tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="kurangi_minum_tidur"
                                                            {{ in_array('kurangi_minum_tidur', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengurangi minum
                                                            menjelang tidur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="kolaborasi_supositoria"
                                                            {{ in_array('kolaborasi_supositoria', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian obat
                                                            supositoria uretra, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 8. Nyeri Akut -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="nyeri_akut" id="diag_nyeri_akut"
                                                        onchange="toggleRencana('nyeri_akut')"
                                                        {{ in_array('nyeri_akut', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_nyeri_akut">
                                                        <strong>Nyeri akut</strong> b.d agen pencedera fisiologis (inflamsi,
                                                        iskemia, neoplasma), agen pencedera kimiawi (terbakar, bahan kimia
                                                        iritan), agen pencedera fisik (abses, amputasi, terbakar, terpotong,
                                                        mengangkat berat, prosedur operasi, trauma, latihan fisik
                                                        berlebihan).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_nyeri_akut" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_lokasi_nyeri"
                                                            {{ in_array('identifikasi_lokasi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi,
                                                            karakteristik, durasi, frekuensi, kualitas, intensitas
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="identifikasi_skala_nyeri"
                                                            {{ in_array('identifikasi_skala_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_respons_nonverbal"
                                                            {{ in_array('identifikasi_respons_nonverbal', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non
                                                            verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_faktor_nyeri"
                                                            {{ in_array('identifikasi_faktor_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang
                                                            memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_pengetahuan_nyeri"
                                                            {{ in_array('identifikasi_pengetahuan_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan
                                                            keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_pengaruh_budaya"
                                                            {{ in_array('identifikasi_pengaruh_budaya', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya
                                                            terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_pengaruh_kualitas_hidup"
                                                            {{ in_array('identifikasi_pengaruh_kualitas_hidup', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada
                                                            kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="monitor_keberhasilan_terapi"
                                                            {{ in_array('monitor_keberhasilan_terapi', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi
                                                            komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="monitor_efek_samping_analgetik"
                                                            {{ in_array('monitor_efek_samping_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan
                                                            analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="berikan_teknik_nonfarmakologis"
                                                            {{ in_array('berikan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis
                                                            untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi
                                                            musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi
                                                            terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="kontrol_lingkungan_nyeri"
                                                            {{ in_array('kontrol_lingkungan_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang
                                                            memperberat rasa nyeri (suhu ruangan, pencahayaan,
                                                            kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="fasilitasi_istirahat"
                                                            {{ in_array('fasilitasi_istirahat', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan
                                                            tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="pertimbangkan_strategi_nyeri"
                                                            {{ in_array('pertimbangkan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber
                                                            nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="jelaskan_penyebab_nyeri"
                                                            {{ in_array('jelaskan_penyebab_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan
                                                            pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="jelaskan_strategi_nyeri"
                                                            {{ in_array('jelaskan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="anjurkan_monitor_nyeri"
                                                            {{ in_array('anjurkan_monitor_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara
                                                            mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="anjurkan_analgetik"
                                                            {{ in_array('anjurkan_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik
                                                            secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="ajarkan_teknik_nonfarmakologis"
                                                            {{ in_array('ajarkan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis
                                                            untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="kolaborasi_analgetik"
                                                            {{ in_array('kolaborasi_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian analgetik,
                                                            jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 9. Nyeri Kronis -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="nyeri_kronis" id="diag_nyeri_kronis"
                                                        onchange="toggleRencana('nyeri_kronis')"
                                                        {{ in_array('nyeri_kronis', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_nyeri_kronis">
                                                        <strong>Nyeri kronis</strong> b.d kondisi muskuloskeletal kronis,
                                                        kerusakan sistem saraf, penekanan saraf, infiltrasi tumor,
                                                        ketidakseimbangan neurotransmiter, neuromodulator, dan reseptor,
                                                        gangguan imunitas, (neuropati terkait HIV, virus varicella-zoster),
                                                        gangguan fungsi metabolik, riwayat posisi kerja statis, peningkatan
                                                        indeks masa tubuh, kondisi pasca trauma, tekanan emosional, riwayat
                                                        penganiayaan (fisik, psikologis, seksual), riwayat penyalahgunaan
                                                        obat/zat.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_nyeri_kronis" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_lokasi_nyeri_kronis"
                                                            {{ in_array('identifikasi_lokasi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi,
                                                            karakteristik, durasi, frekuensi, kualitas, intensitas
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_skala_nyeri_kronis"
                                                            {{ in_array('identifikasi_skala_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_respons_nonverbal_kronis"
                                                            {{ in_array('identifikasi_respons_nonverbal_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non
                                                            verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_faktor_nyeri_kronis"
                                                            {{ in_array('identifikasi_faktor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang
                                                            memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_pengetahuan_nyeri_kronis"
                                                            {{ in_array('identifikasi_pengetahuan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan
                                                            keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_pengaruh_budaya_kronis"
                                                            {{ in_array('identifikasi_pengaruh_budaya_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya
                                                            terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_pengaruh_kualitas_hidup_kronis"
                                                            {{ in_array('identifikasi_pengaruh_kualitas_hidup_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada
                                                            kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="monitor_keberhasilan_terapi_kronis"
                                                            {{ in_array('monitor_keberhasilan_terapi_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi
                                                            komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="monitor_efek_samping_analgetik_kronis"
                                                            {{ in_array('monitor_efek_samping_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan
                                                            analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="berikan_teknik_nonfarmakologis_kronis"
                                                            {{ in_array('berikan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis
                                                            untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi
                                                            musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi
                                                            terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="kontrol_lingkungan_nyeri_kronis"
                                                            {{ in_array('kontrol_lingkungan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang
                                                            memperberat rasa nyeri (suhu ruangan, pencahayaan,
                                                            kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="fasilitasi_istirahat_kronis"
                                                            {{ in_array('fasilitasi_istirahat_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan
                                                            tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="pertimbangkan_strategi_nyeri_kronis"
                                                            {{ in_array('pertimbangkan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber
                                                            nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="jelaskan_penyebab_nyeri_kronis"
                                                            {{ in_array('jelaskan_penyebab_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan
                                                            pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="jelaskan_strategi_nyeri_kronis"
                                                            {{ in_array('jelaskan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="anjurkan_monitor_nyeri_kronis"
                                                            {{ in_array('anjurkan_monitor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara
                                                            mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="anjurkan_analgetik_kronis"
                                                            {{ in_array('anjurkan_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik
                                                            secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="ajarkan_teknik_nonfarmakologis_kronis"
                                                            {{ in_array('ajarkan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis
                                                            untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="kolaborasi_analgetik_kronis"
                                                            {{ in_array('kolaborasi_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian analgetik,
                                                            jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 10. Hipertermia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="hipertermia" id="diag_hipertermia"
                                                        onchange="toggleRencana('hipertermia')"
                                                        {{ in_array('hipertermia', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipertermia">
                                                        <strong>Hipertermia</strong> b.d dehidrasi, terpapar lingkungan
                                                        panas, peroses penyakit (infeksi, kanker), ketidaksesuaian pakaian
                                                        dengan suhu lingkungan, peningkatan laju metabolisme, respon trauma,
                                                        aktivitas berlebihan, penggunaan inkubator.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipertermia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="identifikasi_penyebab_hipertermia"
                                                            {{ in_array('identifikasi_penyebab_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab hipertermia
                                                            (dehidrasi, terpapar lingkungan panas, penggunaan
                                                            inkubator)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="monitor_suhu_tubuh"
                                                            {{ in_array('monitor_suhu_tubuh', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="monitor_kadar_elektrolit"
                                                            {{ in_array('monitor_kadar_elektrolit', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kadar elektrolit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="monitor_haluaran_urine"
                                                            {{ in_array('monitor_haluaran_urine', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor haluaran urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="monitor_komplikasi_hipertermia"
                                                            {{ in_array('monitor_komplikasi_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor komplikasi akibat
                                                            hipertermia</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="sediakan_lingkungan_dingin"
                                                            {{ in_array('sediakan_lingkungan_dingin', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Sediakan lingkungan yang
                                                            dingin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="longgarkan_pakaian"
                                                            {{ in_array('longgarkan_pakaian', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Longgarkan atau lepaskan
                                                            pakaian</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="basahi_kipasi_tubuh"
                                                            {{ in_array('basahi_kipasi_tubuh', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Basahi dan kipasi permukaan
                                                            tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="berikan_cairan_oral_hipertermia"
                                                            {{ in_array('berikan_cairan_oral_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan oral</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="ganti_linen_hiperhidrosis"
                                                            {{ in_array('ganti_linen_hiperhidrosis', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ganti linen setiap hari atau lebih
                                                            sering jika mengalami hiperhidrosis (keringat berlebih)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="pendinginan_eksternal"
                                                            {{ in_array('pendinginan_eksternal', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pendinginan eksternal
                                                            (selimut hipotermia atau kompres dingin pada dahi, leher, dada,
                                                            abdomen, aksila)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="hindari_antipiretik"
                                                            {{ in_array('hindari_antipiretik', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemberian antipiretik atau
                                                            aspirin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="berikan_oksigen_hipertermia"
                                                            {{ in_array('berikan_oksigen_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen, jika
                                                            perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="anjurkan_tirah_baring"
                                                            {{ in_array('anjurkan_tirah_baring', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan tirah baring</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="kolaborasi_cairan_elektrolit"
                                                            {{ in_array('kolaborasi_cairan_elektrolit', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian cairan dan
                                                            elektrolit intravena, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 11. Gangguan Mobilitas Fisik -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="gangguan_mobilitas_fisik"
                                                        id="diag_gangguan_mobilitas_fisik"
                                                        onchange="toggleRencana('gangguan_mobilitas_fisik')"
                                                        {{ in_array('gangguan_mobilitas_fisik', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_gangguan_mobilitas_fisik">
                                                        <strong>Gangguan mobilitas fisik</strong> b.d kerusakan intergritas
                                                        struktur tulang, perubahan metabolisme, ketidakbugaran fisik,
                                                        penurunan kendali otot, penurunan massa otot, penurunan kekuatan
                                                        otot, keterlambatan perkembangan, kekakuan sendi, kontraktur,
                                                        malnutrisi, gangguan muskuloskeletal, gangguan neuromuskular, indeks
                                                        masa tubuh diatas persentil ke-75 seusai usia, efek agen
                                                        farmakologis, program pembatasan gerak, nyeri, kurang terpapar
                                                        informasi tentang aktivitas fisik, kecemasan, gangguan kognitif,
                                                        keengganan melakukan pergerakan, gangguan sensoripersepsi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_gangguan_mobilitas_fisik" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="identifikasi_nyeri_keluhan"
                                                            {{ in_array('identifikasi_nyeri_keluhan', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indentifikasi adanya nyeri atau
                                                            keluhan fisik lainnya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="identifikasi_toleransi_ambulasi"
                                                            {{ in_array('identifikasi_toleransi_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indetifikasi toleransi fisik
                                                            melakukan ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="monitor_frekuensi_jantung_ambulasi"
                                                            {{ in_array('monitor_frekuensi_jantung_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor frekuensi jantung dan
                                                            tekanan darah sebelum memulai ambulasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="monitor_kondisi_umum_ambulasi"
                                                            {{ in_array('monitor_kondisi_umum_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kondiri umum selama
                                                            melakukan ambulasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="fasilitasi_aktivitas_ambulasi"
                                                            {{ in_array('fasilitasi_aktivitas_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi aktivitas ambulasi
                                                            dengan alat bantu (tongkat, kruk)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="fasilitasi_mobilisasi_fisik"
                                                            {{ in_array('fasilitasi_mobilisasi_fisik', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi melakukan mobilisasi
                                                            fisik, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="libatkan_keluarga_ambulasi"
                                                            {{ in_array('libatkan_keluarga_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Libatkan keluarga untuk membantu
                                                            pasien dalam meningkatkan ambulasi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="jelaskan_tujuan_ambulasi"
                                                            {{ in_array('jelaskan_tujuan_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tujuan dan prosedur
                                                            ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="anjurkan_ambulasi_dini"
                                                            {{ in_array('anjurkan_ambulasi_dini', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melakukan ambulasi
                                                            dini</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="ajarkan_ambulasi_sederhana"
                                                            {{ in_array('ajarkan_ambulasi_sederhana', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan ambulasi sederhana yang
                                                            harus dilakukan (berjalan dari tempat tidur ke kursi roda,
                                                            berjalan dari tempat tidur ke kamar mandi, berjalan sesuai
                                                            toleransi)</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 12. Resiko Infeksi -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="resiko_infeksi"
                                                        id="diag_resiko_infeksi"
                                                        onchange="toggleRencana('resiko_infeksi')"
                                                        {{ in_array('resiko_infeksi', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_resiko_infeksi">
                                                        <strong>Resiko infeksi</strong> b.d efek prosedur invasif, penyakit
                                                        kronis (diabetes melitus), malnutrisi, peningkatan paparan organisme
                                                        patogen lingkungan, ketidakadekuatan pertahanan tubuh primer
                                                        (gangguan persitaltik, kerusakan integritas kulit, perubahan sekresi
                                                        PH, penurunan kerja siliaris, ketuban pecah lama, ketuban pecah
                                                        sebelum waktunya, merokok, statis cairan tubuh), ketidakadekuatan
                                                        pertahanan tubuh sekunder (penurunan hemoglobin, imununosupresi,
                                                        leukopenia, supresi respon inflamasi, vaksinasi tidak adekuat).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_resiko_infeksi" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="monitor_tanda_infeksi_sistemik"
                                                            {{ in_array('monitor_tanda_infeksi_sistemik', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala infeksi
                                                            lokal dan sistemik</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="batasi_pengunjung"
                                                            {{ in_array('batasi_pengunjung', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi jumlah pengunjung</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="perawatan_kulit_edema"
                                                            {{ in_array('perawatan_kulit_edema', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan perawatan kulit pada area
                                                            edema</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="cuci_tangan_kontak"
                                                            {{ in_array('cuci_tangan_kontak', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Cuci tangan sebelum dan sesudah
                                                            kontak dengan pasien dan lingkungan pasien</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="pertahankan_teknik_aseptik"
                                                            {{ in_array('pertahankan_teknik_aseptik', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik aseptik pada
                                                            pasien beresiko tinggi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="jelaskan_tanda_infeksi_edukasi"
                                                            {{ in_array('jelaskan_tanda_infeksi_edukasi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala
                                                            infeksi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="ajarkan_cuci_tangan"
                                                            {{ in_array('ajarkan_cuci_tangan', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mencuci tangan dengan
                                                            benar</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="ajarkan_etika_batuk"
                                                            {{ in_array('ajarkan_etika_batuk', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan etika batuk</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="ajarkan_periksa_luka"
                                                            {{ in_array('ajarkan_periksa_luka', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara memeriksa kondisi
                                                            luka atau luka operasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="anjurkan_asupan_nutrisi"
                                                            {{ in_array('anjurkan_asupan_nutrisi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan
                                                            nutrisi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="anjurkan_asupan_cairan_infeksi"
                                                            {{ in_array('anjurkan_asupan_cairan_infeksi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan
                                                            cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="kolaborasi_imunisasi"
                                                            {{ in_array('kolaborasi_imunisasi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian imunisasi,
                                                            jika perlu.</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 13. Konstipasi -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="konstipasi" id="diag_konstipasi"
                                                        onchange="toggleRencana('konstipasi')"
                                                        {{ in_array('konstipasi', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_konstipasi">
                                                        <strong>Konstipasi</strong> b.d penurunan motilitas
                                                        gastrointestinal, ketidaadekuatan pertumbuhan gigi, ketidakcukupan
                                                        diet, ketidakcukupan asupan serat, ketidakcukupan asupan serat,
                                                        ketidakcukupan asupan cairan, aganglionik (penyakit Hircsprung),
                                                        kelemahan otot abdomen.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_konstipasi" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="periksa_tanda_gejala_konstipasi"
                                                            {{ in_array('periksa_tanda_gejala_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="periksa_pergerakan_usus"
                                                            {{ in_array('periksa_pergerakan_usus', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa pergerakan usus,
                                                            karakteristik feses</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="identifikasi_faktor_risiko_konstipasi"
                                                            {{ in_array('identifikasi_faktor_risiko_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko
                                                            konstipasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="anjurkan_diet_tinggi_serat"
                                                            {{ in_array('anjurkan_diet_tinggi_serat', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan diet tinggi serat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="masase_abdomen"
                                                            {{ in_array('masase_abdomen', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan masase abdomen, jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="evakuasi_feses_manual"
                                                            {{ in_array('evakuasi_feses_manual', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan evakuasi feses secara
                                                            manual, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="berikan_enema"
                                                            {{ in_array('berikan_enema', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan enema atau intigasi, jika
                                                            perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="jelaskan_etiologi_konstipasi"
                                                            {{ in_array('jelaskan_etiologi_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan etiologi masalah dan
                                                            alasan tindakan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="anjurkan_peningkatan_cairan_konstipasi"
                                                            {{ in_array('anjurkan_peningkatan_cairan_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan peningkatan asupan
                                                            cairan, jika tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="ajarkan_mengatasi_konstipasi"
                                                            {{ in_array('ajarkan_mengatasi_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengatasi
                                                            konstipasi/impaksi</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="kolaborasi_obat_pencahar"
                                                            {{ in_array('kolaborasi_obat_pencahar', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi penggunaan obat
                                                            pencahar, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 14. Resiko Jatuh -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="resiko_jatuh" id="diag_resiko_jatuh"
                                                        onchange="toggleRencana('resiko_jatuh')"
                                                        {{ in_array('resiko_jatuh', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_resiko_jatuh">
                                                        <strong>Resiko jatuh</strong> b.d usia lebih dari sama dengan 65
                                                        tahun (pada dewasa) atau kurang dari sama dengan 2 tahun (pada anak)
                                                        Riwayat jatuh, anggota gerak bawah prostesis (buatan), penggunaan
                                                        alat bantu berjalan, penurunan tingkat kesadaran, perubahan fungsi
                                                        kognitif, lingkungan tidak aman (licin, gelap, lingkungan asing),
                                                        kondisi pasca operasi, hipotensi ortostatik, perubahan kadar glukosa
                                                        darah, anemia, kekuatan otot menurun, gangguan pendengaran, gangguan
                                                        keseimbangan, gangguan penglihatan (glaukoma, katarak, ablasio
                                                        retina, neuritis optikus), neuropati, efek agen farmakologis
                                                        (sedasi, alkohol, anastesi umum).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_resiko_jatuh" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="identifikasi_faktor_risiko_jatuh"
                                                            {{ in_array('identifikasi_faktor_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko jatuh
                                                            (usia >65 tahun, penurunan tingkat kesadaran, defisit kognitif,
                                                            hipotensi ortostatik, gangguan keseimbangan, gangguan
                                                            penglihatan, neuropati)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="identifikasi_risiko_setiap_shift"
                                                            {{ in_array('identifikasi_risiko_setiap_shift', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi risiko jatuh
                                                            setidaknya sekali setiap shift atau sesuai dengan kebijakan
                                                            institusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="identifikasi_faktor_lingkungan"
                                                            {{ in_array('identifikasi_faktor_lingkungan', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor lingkungan
                                                            yang meningkatkan risiko jatuh (lantai licin, penerangan
                                                            kurang)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="hitung_risiko_jatuh"
                                                            {{ in_array('hitung_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hitung risiko jatuh dengan
                                                            menggunakan skala (Fall Morse Scale, humpty dumpty scale), jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="monitor_kemampuan_berpindah"
                                                            {{ in_array('monitor_kemampuan_berpindah', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan berpindah dari
                                                            tempat tidur ke kursi roda dan sebaliknya</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="orientasikan_ruangan"
                                                            {{ in_array('orientasikan_ruangan', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Orientasikan ruangan pada pasien
                                                            dan keluarga</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="pastikan_roda_terkunci"
                                                            {{ in_array('pastikan_roda_terkunci', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pastikan roda tempat tidur dan
                                                            kursi roda selalu dalam kondisi terkunci</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="pasang_handrail"
                                                            {{ in_array('pasang_handrail', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang handrail tempat
                                                            tidur</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="atur_tempat_tidur"
                                                            {{ in_array('atur_tempat_tidur', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Atur tempat tidur mekanis pada
                                                            posisi terendah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="tempatkan_dekat_perawat"
                                                            {{ in_array('tempatkan_dekat_perawat', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tempatkan pasien berisiko tinggi
                                                            jatuh dekat dengan pantauan perawat dari nurse station</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="gunakan_alat_bantu"
                                                            {{ in_array('gunakan_alat_bantu', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Gunakan alat bantu berjalan (kursi
                                                            roda, walker)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="dekatkan_bel"
                                                            {{ in_array('dekatkan_bel', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Dekatkan bel pemanggil dalam
                                                            jangkauan pasien</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="anjurkan_memanggil_perawat"
                                                            {{ in_array('anjurkan_memanggil_perawat', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memanggil perawat jika
                                                            membutuhkan bantuan untuk berpindah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="anjurkan_alas_kaki"
                                                            {{ in_array('anjurkan_alas_kaki', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan alas kaki
                                                            yang tidak licin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="anjurkan_berkonsentrasi"
                                                            {{ in_array('anjurkan_berkonsentrasi', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berkonsentrasi untuk
                                                            menjaga keseimbangan tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="anjurkan_melebarkan_jarak"
                                                            {{ in_array('anjurkan_melebarkan_jarak', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melebarkan jarak kedua
                                                            kaki untuk meningkatkan keseimbangan saat berdiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="ajarkan_bel_pemanggil"
                                                            {{ in_array('ajarkan_bel_pemanggil', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara menggunakan bel
                                                            pemanggil untuk memanggil perawat</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 15. Gangguan Integritas Kulit/Jaringan -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="gangguan_integritas_kulit"
                                                        id="diag_gangguan_integritas_kulit"
                                                        onchange="toggleRencana('gangguan_integritas_kulit')"
                                                        {{ in_array('gangguan_integritas_kulit', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="diag_gangguan_integritas_kulit">
                                                        <strong>Gangguan integritas kulit/jaringan</strong> b.d perubahan
                                                        sirkulasi, perubahan status nutrisi (kelebihan atau kekurangan),
                                                        kekurangan/kelebihan volume cairan, penurunan mobilitas, bahan kimia
                                                        iritatif, suhu lingkungan yang ekstream, faktor mekanis (penekanan
                                                        pada tonjolan tulang, gesekan) atau faktor elektris
                                                        (elektrodiatermi, energi listrik bertegangan tinggi), efek samping
                                                        terapi radiasi, kelembapan, proses penuaan, neuropati perifer,
                                                        perubahan pigmentasi, perubahan hormonal, kurang terpapar informasi
                                                        tentang upaya mempertahankan/melindungi integritas jaringan.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_gangguan_integritas_kulit" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="monitor_karakteristik_luka"
                                                            {{ in_array('monitor_karakteristik_luka', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor karakteristik luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="monitor_tanda_infeksi"
                                                            {{ in_array('monitor_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda-tanda
                                                            infeksi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="lepaskan_balutan"
                                                            {{ in_array('lepaskan_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lepaskan balutan dan plester
                                                            secara perlahan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="bersihkan_nacl"
                                                            {{ in_array('bersihkan_nacl', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan dengan cairan NaCl atau
                                                            pembersih nontoksik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="bersihkan_jaringan_nekrotik"
                                                            {{ in_array('bersihkan_jaringan_nekrotik', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan jaringan
                                                            nekrotik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="berikan_salep"
                                                            {{ in_array('berikan_salep', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan salep yang sesuai ke
                                                            kulit/lesi, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="pasang_balutan"
                                                            {{ in_array('pasang_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang balutan sesuai jenis
                                                            luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="pertahankan_teknik_steril"
                                                            {{ in_array('pertahankan_teknik_steril', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik steril saat
                                                            melakukan perawatan luka</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="jelaskan_tanda_infeksi"
                                                            {{ in_array('jelaskan_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala
                                                            infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="anjurkan_makanan_tinggi_protein"
                                                            {{ in_array('anjurkan_makanan_tinggi_protein', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengkonsumsi makanan
                                                            tinggi kalori dan protein</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="kolaborasi_debridement"
                                                            {{ in_array('kolaborasi_debridement', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi prosedur
                                                            debridement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="kolaborasi_antibiotik"
                                                            {{ in_array('kolaborasi_antibiotik', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian
                                                            antibiotik</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css')
    <style>
        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
        }

        .border-bottom {
            border-color: #dee2e6 !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .fw-medium {
            font-weight: 500 !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }
    </style>
@endpush

@push('js')
    <script>
        // 13. MASALAH/ DIAGNOSIS KEPERAWATAN

        function toggleRencana(diagnosisType) {
            // Handle special case for respiratory group (3 diagnosis yang menggunakan 1 rencana)
            const respiratoryGroup = ['bersihan_jalan_nafas', 'risiko_aspirasi', 'pola_nafas_tidak_efektif'];

            if (respiratoryGroup.includes(diagnosisType)) {
                // Check if any of the 3 respiratory checkboxes is checked
                const anyRespChecked = respiratoryGroup.some(diagnosis => {
                    const checkbox = document.getElementById('diag_' + diagnosis);
                    return checkbox && checkbox.checked;
                });

                const rencanaDiv = document.getElementById('rencana_bersihan_jalan_nafas');
                if (rencanaDiv) {
                    if (anyRespChecked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when no respiratory diagnosis is checked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            } else {
                // Handle normal case (1 diagnosis = 1 rencana)
                const checkbox = document.getElementById('diag_' + diagnosisType);
                const rencanaDiv = document.getElementById('rencana_' + diagnosisType);

                if (checkbox && rencanaDiv) {
                    if (checkbox.checked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when diagnosis is unchecked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            }
        }

        // KODE BARU: Initialize untuk mode EDIT - tampilkan rencana yang sudah tercentang
        document.addEventListener('DOMContentLoaded', function() {
            // Daftar semua diagnosis
            const allDiagnosis = [
                'bersihan_jalan_nafas',
                'risiko_aspirasi',
                'pola_nafas_tidak_efektif',
                'penurunan_curah_jantung',
                'perfusi_perifer',
                'hipovolemia',
                'hipervolemia',
                'diare',
                'retensi_urine',
                'nyeri_akut',
                'nyeri_kronis',
                'hipertermia',
                'gangguan_mobilitas_fisik',
                'resiko_infeksi',
                'konstipasi',
                'resiko_jatuh',
                'gangguan_integritas_kulit'
            ];

            // Loop semua diagnosis dan trigger toggleRencana jika checkbox sudah tercentang
            allDiagnosis.forEach(diagnosis => {
                const checkbox = document.getElementById('diag_' + diagnosis);
                if (checkbox && checkbox.checked) {
                    toggleRencana(diagnosis);
                }
            });
        });
    </script>
@endpush
