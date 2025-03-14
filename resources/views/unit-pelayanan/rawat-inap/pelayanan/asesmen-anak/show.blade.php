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
                    <p>Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
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
                                                <label class="form-label fw-bold">AVPU :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $avpu = $asesmen->rmeAsesmenKepAnakFisik->avpu ?? null;
                                                        $avpuOptions = [
                                                            '0' => 'Sadar Baik/Alert',
                                                            '1' => 'Berespon dengan kata-kata/Voice',
                                                            '2' => 'Hanya berespon jika dirangsang nyeri/pain',
                                                            '3' => 'Pasien tidak sadar/unresponsive',
                                                            '4' => 'Gelisah atau bingung',
                                                            '5' => 'Acute Confusional States',
                                                        ];
                                                    @endphp
                                                    {{ $avpuOptions[$avpu] ?? '-' }}
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
                                                            $asesmen->rmeAsesmenKepAnakFisik->refleks_menelan ?? null;
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
                                                            $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal ?? null;
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
                                                <label class="form-label fw-bold">Jenis Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri;
                                                        $jenisNyeriId = $statusNyeri ? $statusNyeri->jenis_nyeri : null;
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
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_kecelakaan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Rawat Inap :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $riwayatKesehatan = optional($asesmen->rmeAsesmenKepAnakRiwayatKesehatan);
                                                        $riwayatRawatInap = $riwayatKesehatan->riwayat_rawat_inap ?? null;
                                                        $tanggalRawatInap = $riwayatKesehatan->tanggal_riwayat_rawat_inap ?? null;
                                                    @endphp

                                                    {{ $riwayatRawatInap ? 'Ya' : 'Tidak' }}
                                                    
                                                    @if($tanggalRawatInap)
                                                        <br>
                                                        <small class="text-muted">
                                                            Tanggal:
                                                            {{ \Carbon\Carbon::parse($tanggalRawatInap)->format('d/m/Y') }}
                                                        </small>
                                                    @endif
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
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Konsumsi Obat-Obatan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->konsumsi_obat ?? '-' }}
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
                                                    $alergis = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->alergi ?? '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($alergis))
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
                                                                @foreach ($alergis as $alergi)
                                                                    <tr>
                                                                        <td>{{ $alergi['jenis'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['severe'] ?? '-' }}</td>
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

                                            @if($jenisSkala == 1)
                                                <!-- Skala Umum -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Penilaian Risiko Jatuh Skala Umum</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah pasien berusia < dari 2 tahun?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_usia ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien dalam kondisi sebagai geriatri, dizzines, vertigo, gangguan keseimbangan?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_kondisi_khusus ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien didiagnosis sebagai pasien dengan penyakit parkinson?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien sedang mendapatkan obat sedasi?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien saat ini sedang berada pada lokasi berisiko?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_umum_lokasi_berisiko ? 'Ya' : 'Tidak' }}</td>
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
                                                                <td>{{ $risikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 25 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Diagnosis Sekunder</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 15 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alat Bantu</th>
                                                                <td>
                                                                    @php
                                                                        $bantuanAmbulasi = $risikoJatuh->risiko_jatuh_morse_bantuan_ambulasi;
                                                                        $bantuanOptions = [
                                                                            30 => 'Meja/kursi',
                                                                            15 => 'Kruk/tongkat/alat bantu berjalan',
                                                                            0 => 'Tidak ada/bed rest/bantuan perawat'
                                                                        ];
                                                                    @endphp
                                                                    {{ $bantuanOptions[$bantuanAmbulasi] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Terpasang Infus</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_morse_terpasang_infus == 20 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Cara Berjalan</th>
                                                                <td>
                                                                    @php
                                                                        $caraBerjalan = $risikoJatuh->risiko_jatuh_morse_cara_berjalan;
                                                                        $caraBerjalanOptions = [
                                                                            0 => 'Normal/bed rest/kursi roda',
                                                                            20 => 'Terganggu',
                                                                            10 => 'Lemah'
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
                                                    <h6 class="fw-bold">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Usia Anak</th>
                                                                <td>
                                                                    @php
                                                                        $usia = $risikoJatuh->risiko_jatuh_pediatrik_usia_anak;
                                                                        $usiaOptions = [
                                                                            4 => 'Dibawah 3 tahun',
                                                                            3 => '3-7 tahun',
                                                                            2 => '7-13 tahun',
                                                                            1 => 'Diatas 13 tahun'
                                                                        ];
                                                                    @endphp
                                                                    {{ $usiaOptions[$usia] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 2 ? 'Laki-laki' : 'Perempuan' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Diagnosis</th>
                                                                <td>
                                                                    @php
                                                                        $diagnosis = $risikoJatuh->risiko_jatuh_pediatrik_diagnosis;
                                                                        $diagnosisOptions = [
                                                                            4 => 'Diagnosis Neurologis',
                                                                            3 => 'Perubahan oksigennasi (diagnosis respiratorik, dehidrasi, anemia, syncope, pusing, dsb)',
                                                                            2 => 'Gangguan perilaku /psikiatri',
                                                                            1 => 'Diagnosis lainnya'
                                                                        ];
                                                                    @endphp
                                                                    {{ $diagnosisOptions[$diagnosis] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gangguan Kognitif</th>
                                                                <td>
                                                                    @php
                                                                        $kognitif = $risikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif;
                                                                        $kognitifOptions = [
                                                                            3 => 'Tidak menyadari keterbatasan dirinya',
                                                                            2 => 'Lupa akan adanya keterbatasan',
                                                                            1 => 'Orientasi baik terhadap dari sendiri'
                                                                        ];
                                                                    @endphp
                                                                    {{ $kognitifOptions[$kognitif] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Faktor Lingkungan</th>
                                                                <td>
                                                                    @php
                                                                        $lingkungan = $risikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan;
                                                                        $lingkunganOptions = [
                                                                            4 => 'Riwayat jatuh /bayi diletakkan di tempat tidur dewasa',
                                                                            3 => 'Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi / perabot rumah',
                                                                            2 => 'Pasien diletakkan di tempat tidur',
                                                                            1 => 'Area di luar rumah sakit'
                                                                        ];
                                                                    @endphp
                                                                    {{ $lingkunganOptions[$lingkungan] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pembedahan/Sedasi/Anestesi</th>
                                                                <td>
                                                                    @php
                                                                        $pembedahan = $risikoJatuh->risiko_jatuh_pediatrik_pembedahan;
                                                                        $pembedahanOptions = [
                                                                            3 => 'Dalam 24 jam',
                                                                            2 => 'Dalam 48 jam',
                                                                            1 => '> 48 jam atau tidak menjalani pembedahan/sedasi/anestesi'
                                                                        ];
                                                                    @endphp
                                                                    {{ $pembedahanOptions[$pembedahan] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Penggunaan Medika mentosa</th>
                                                                <td>
                                                                    @php
                                                                        $medika = $risikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa;
                                                                        $medikaOptions = [
                                                                            3 => 'Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose',
                                                                            2 => 'Penggunaan salah satu obat diatas',
                                                                            1 => 'Penggunaan medikasi lainnya/tidak ada mediksi'
                                                                        ];
                                                                    @endphp
                                                                    {{ $medikaOptions[$medika] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $risikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? '-' }}
                                                    </div>
                                                </div>
                                            @elseif($jenisSkala == 4)
                                                <!-- Skala Ontario -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Penilaian Risiko Jatuh Skala Ontario Modified Stratify Sydney/ Lansia</h6>

                                                    <h6 class="mt-4 mb-3">1. Riwayat Jatuh</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="60%">Apakah pasien datang kerumah sakit karena jatuh?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 6 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Apakah pasien mengalami jatuh dalam 2 bulan terakhir?</th>
                                                                <td>{{ $risikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 6 ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <!-- Tambahkan bagian-bagian lain dari Skala Ontario dengan pola yang sama -->
                                                    <!-- Status Mental, Penglihatan, dll. -->

                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $risikoJatuh->risiko_jatuh_lansia_kesimpulan ?? '-' }}
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Intervensi Risiko Jatuh -->
                                            <div class="mb-4">
                                                <h6 class="fw-bold">Intervensi Risiko Jatuh</h6>
                                                @php
                                                    $intervensi = json_decode($risikoJatuh->intervensi_risiko_jatuh ?? '[]', true);
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

                                            {{-- Cek dulu apakah relasi ada / tidak null --}}
                                            @if($asesmen->rmeAsesmenKepAnakResikoDekubitus)
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
                                                                            $fisik = $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik;
                                                                            switch ($fisik) {
                                                                                case 4:
                                                                                    echo 'Baik';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Sedang';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Buruk';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Sangat Buruk';
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
                                                                            $mental = $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental;
                                                                            switch ($mental) {
                                                                                case 4:
                                                                                    echo 'Sadar';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Apatis';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Bingung';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Stupor';
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
                                                                            $aktivitas = $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas;
                                                                            switch ($aktivitas) {
                                                                                case 4:
                                                                                    echo 'Aktif';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Jalan dengan bantuan';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Terbatas di kursi';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Terbatas di tempat tidur';
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
                                                                            $mobilitas = $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas;
                                                                            switch ($mobilitas) {
                                                                                case 4:
                                                                                    echo 'Bebas bergerak';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Agak terbatas';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Sangat terbatas';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Tidak dapat bergerak';
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
                                                                            $inkontinensia = $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia;
                                                                            switch ($inkontinensia) {
                                                                                case 4:
                                                                                    echo 'Tidak ada';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Kadang-kadang';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Biasanya urin';
                                                                                    break;
                                                                                case 1:
                                                                                    echo 'Urin dan feses';
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
                                                                            $sensori = $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi;
                                                                            switch ($sensori) {
                                                                                case 1:
                                                                                    echo 'Keterbatasan Penuh';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Sangat Terbatas';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Keterbatasan Ringan';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Tidak Ada Gangguan';
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
                                                                            $kelembapan = $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan;
                                                                            switch ($kelembapan) {
                                                                                case 1:
                                                                                    echo 'Selalu Lembap';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Umumnya Lembap';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Kadang-Kadang Lembap';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Jarang Lembap';
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
                                                                            $aktivitas = $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas;
                                                                            switch ($aktivitas) {
                                                                                case 1:
                                                                                    echo 'Total di Tempat Tidur';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Dapat Duduk';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Berjalan Kadang-kadang';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Dapat Berjalan-jalan';
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
                                                                            $mobilitas = $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas;
                                                                            switch ($mobilitas) {
                                                                                case 1:
                                                                                    echo 'Tidak Mampu Bergerak Sama sekali';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Sangat Terbatas';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Tidak Ada Masalah';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Tanpa Keterbatasan';
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
                                                                            $nutrisi = $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi;
                                                                            switch ($nutrisi) {
                                                                                case 1:
                                                                                    echo 'Sangat Buruk';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Kurang Mencukupi';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Mencukupi';
                                                                                    break;
                                                                                case 4:
                                                                                    echo 'Sangat Baik';
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
                                                                            $pergesekan = $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan;
                                                                            switch ($pergesekan) {
                                                                                case 1:
                                                                                    echo 'Bermasalah';
                                                                                    break;
                                                                                case 2:
                                                                                    echo 'Potensial Bermasalah';
                                                                                    break;
                                                                                case 3:
                                                                                    echo 'Keterbatasan Ringan';
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
                                                            <strong>Kesimpulan:</strong>
                                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '-' }}
                                                        </div>
                                                    </div>
                                                @endif

                                            @else
                                                {{-- Jika tidak ada data rmeAsesmenKepAnakResikoDekubitus --}}
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
                                                <label class="form-label fw-bold">
                                                    Potensi Menyakiti Diri Sendiri/Orang Lain:
                                                </label>
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
                                                <label class="form-label fw-bold">
                                                    Anggota Keluarga Gangguan Jiwa:
                                                </label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $gangguanJiwa = $asesmen->rmeAsesmenKepAnakStatusPsikologis?->keluarga_gangguan_jiwa;
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
                                                    {{ $asesmen->rmeAsesmenKepAnak->pekerjaan_pasien ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Status Pernikahan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->status_pernikahan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Tempat Tinggal :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->tempat_tinggal ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Curiga Penganiayaan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->curiga_penganiayaan ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Status Tinggal dengan Keluarga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->status_tinggal ?? '-' }}
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
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Penurunan Berat Badan
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
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
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Jumlah Penurunan Berat
                                                                    Badan :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    @php
                                                                        $jumlahPenurunanBB =
                                                                            $asesmen->rmeAsesmenKepAnakGizi
                                                                                ->gizi_mst_jumlah_penurunan_bb ?? null;
                                                                        $jumlahPenurunanBBOptions = [
                                                                            0 => 'Pilih',
                                                                            1 => '1-5 kg',
                                                                            2 => '6-10 kg',
                                                                            3 => '11-15 kg',
                                                                            4 => '>15 kg',
                                                                        ];
                                                                    @endphp
                                                                    {{ $jumlahPenurunanBBOptions[$jumlahPenurunanBB] ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Nafsu Makan :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_nafsu_makan_berkurang == 1 ? 'Berkurang' : 'Tidak Berkurang' }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Diagnosis Khusus
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_diagnosis_khusus == 1 ? 'Ya' : 'Tidak' }}
                                                                </p>
                                                            </div>
                                                        </div>
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
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Penurunan Asupan Makanan
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
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
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Penurunan Berat Badan
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
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
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Mobilitas :</label>
                                                                <p class="form-control-plaintext border-bottom">
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
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Stres Psikologi/Penyakit
                                                                    Akut :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_stress_penyakit_akut == 1 ? 'Tidak' : 'Ya' }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Status Neuropsikologi
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
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
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Berat Badan :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_berat_badan ?? '-' }}
                                                                    kg
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Tinggi Badan :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_tinggi_badan ?? '-' }}
                                                                    cm
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">IMT :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_imt ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
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
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Status Kurus :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_status_kurus == 1 ? 'Ya' : 'Tidak' }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Penurunan Berat Badan
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penurunan_bb == 1 ? 'Ya' : 'Tidak' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Gangguan Pencernaan
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_gangguan_pencernaan == 1 ? 'Ya' : 'Tidak' }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Penyakit Berisiko
                                                                    :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penyakit_berisiko == 2 ? 'Ya' : 'Tidak' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <strong>Kesimpulan:</strong>
                                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '-' }}
                                                    </div>
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
                                                                    {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->makan ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Berjalan :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->berjalan ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Mandi :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->mandi ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Total Skala :</label>
                                                                <p class="form-control-plaintext border-bottom">
                                                                    {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->jumlah_skala ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Kesimpulan :</label>
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
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Medis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->diagnosis_medis ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Usia Lanjut</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if(
                                                        isset($asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut) 
                                                        && $asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut !== null
                                                    )
                                                        {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>


                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hambatan Mobilisasi</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi) && $asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi !== null)
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Penggunaan Media Berkelanjutan</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->penggunaan_media_berkelanjutan) && $asesmen->rmeAsesmenKepAnakRencanaPulang->penggunaan_media_berkelanjutan !== null)
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->membutuhkan_pelayanan_medis ?? '-' }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Keterampilan Khusus</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_keterampilan_khusus) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_keterampilan_khusus !== null)
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_keterampilan_khusus ?? '-' }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Alat Bantu</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_alat_bantu) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_alat_bantu !== null)
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_alat_bantu ?? '-' }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nyeri Kronis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->memiliki_nyeri_kronis) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memiliki_nyeri_kronis !== null)
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->memiliki_nyeri_kronis ?? '-' }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat) && $asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat !== null)
                                                        {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat ?? '-' }}
                                                    Hari
                                                    @else
                                                    -
                                                    @endif                                           
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang !== null)
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang ? \Carbon\Carbon::parse($asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang)->format('d M Y') : '-' }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnakRencanaPulang->kesimpulan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 16. Diagnosis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>16. Diagnosis</h5>
                                        <div class="col-md-12">
                                            <!-- Diagnosis Banding -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Diagnosis Banding</label>
                                                @php
                                                    $diagnosisBanding = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->diagnosis_banding ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($diagnosisBanding))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($diagnosisBanding as $diagnosis)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-info">{{ $diagnosis }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada diagnosis banding
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Diagnosis Kerja -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Diagnosis Kerja</label>
                                                @php
                                                    $diagnosisKerja = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->diagnosis_kerja ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($diagnosisKerja))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($diagnosisKerja as $diagnosis)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-success">{{ $diagnosis }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada diagnosis kerja
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Prognosis -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Prognosis</label>
                                                @php
                                                    $prognosis = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->prognosis ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($prognosis))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($prognosis as $item)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-warning">{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada prognosis
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 17. Implementasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>17. Implementasi</h5>
                                        <div class="col-md-12">
                                            <!-- Observasi -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Observasi</label>
                                                @php
                                                    $observasi = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->observasi ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($observasi))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($observasi as $item)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-primary">{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada observasi
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Terapeutik -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Terapeutik</label>
                                                @php
                                                    $terapeutik = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->terapeutik ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($terapeutik))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($terapeutik as $item)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-success">{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada terapeutik
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Edukasi -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Edukasi</label>
                                                @php
                                                    $edukasi = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->edukasi ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($edukasi))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($edukasi as $item)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-warning">{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada edukasi
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Kolaborasi -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Kolaborasi</label>
                                                @php
                                                    $kolaborasi = json_decode(
                                                        $asesmen->rmeAsesmenKepAnak->kolaborasi ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($kolaborasi))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($kolaborasi as $item)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-info">{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada kolaborasi
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 18. Evaluasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>18. Evaluasi</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Evaluasi Keperawatan</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepAnak->evaluasi ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Continue with other sections following the same pattern... -->

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
