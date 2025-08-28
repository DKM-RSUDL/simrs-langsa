@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}" class="btn btn-outline-secondary">
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
                                                <label class="form-label fw-bold">Agama Orang Tua :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenPerinatology->agama_orang_tua ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Data Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ date('d M Y H:i', strtotime($asesmen->rmeAsesmenPerinatology->data_masuk ?? $asesmen->waktu_asesmen)) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- 2. Identitas Bayi -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>2. Identitas Bayi</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Bayi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->nama_bayi ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tanggal Lahir Bayi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->tgl_lahir_bayi ? date('d M Y H:i', strtotime($asesmen->rmeAsesmenPerinatology->tgl_lahir_bayi)) : '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Jenis Kelamin :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if ($asesmen->rmeAsesmenPerinatology)
                                                            @if ($asesmen->rmeAsesmenPerinatology->jenis_kelamin == '0')
                                                                Laki-laki
                                                            @elseif($asesmen->rmeAsesmenPerinatology->jenis_kelamin == '1')
                                                                Perempuan
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Alamat :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->alamat ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Identitas Ibu -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>3. Identitas Ibu</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Ibu :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->nama_ibu ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">NIK Ibu :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->nik_ibu ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Sidik Kaki dan Jari -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>4. Sidik Kaki dan Jari</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Sidik Telapak Kaki Kiri :</label>
                                                    @if ($asesmen->rmeAsesmenPerinatology && $asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kiri)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kiri) }}"
                                                                target="_blank" class="btn btn-sm btn-info">
                                                                Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    @else
                                                        <p class="form-control-plaintext border-bottom">
                                                            <span class="text-muted">Tidak ada dokumen</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Sidik Telapak Kaki Kanan :</label>
                                                    @if ($asesmen->rmeAsesmenPerinatology && $asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kanan)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kanan) }}"
                                                                target="_blank" class="btn btn-sm btn-info">
                                                                Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    @else
                                                        <p class="form-control-plaintext border-bottom">
                                                            <span class="text-muted">Tidak ada dokumen</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Sidik Jari Ibu Kiri :</label>
                                                    @if ($asesmen->rmeAsesmenPerinatology && $asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kiri)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kiri) }}"
                                                                target="_blank" class="btn btn-sm btn-info">
                                                                Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    @else
                                                        <p class="form-control-plaintext border-bottom">
                                                            <span class="text-muted">Tidak ada dokumen</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Sidik Jari Ibu Kanan :</label>
                                                    @if ($asesmen->rmeAsesmenPerinatology && $asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kanan)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kanan) }}"
                                                                target="_blank" class="btn btn-sm btn-info">
                                                                Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    @else
                                                        <p class="form-control-plaintext border-bottom">
                                                            <span class="text-muted">Tidak ada dokumen</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Anamnesis -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>5. Anamnesis</h5>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->anamnesis ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 6. Pemeriksaan Fisik -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>6. Pemeriksaan Fisik</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Frekuensi Nadi (Per Menit) :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->frekuensi_nadi ?? '-' }}
                                                        x/menit
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Status Frekuensi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->status_frekuensi ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Frekuensi Nafas (Per Menit) :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->nafas ?? '-' }} x/menit
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Suhu (°C) :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->suhu ?? '-' }} °C
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">SpO² Tanpa Bantuan (%) :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->spo2_tanpa_bantuan ?? '-' }}%
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">SpO² Dengan Bantuan (%) :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->spo2_dengan_bantuan ?? '-' }}%
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Kesadaran :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->kesadaran ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">AVPU :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @php
                                                            $avpu = $asesmen->rmeAsesmenPerinatologyFisik->avpu ?? null;
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
                                        </div>

                                        <div class="row mt-4">
                                            <h5>Anthropometri</h5>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tinggi Badan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->tinggi_badan ?? '-' }} cm
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Berat Badan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->berat_badan ?? '-' }} kg
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Lingkar Kepala :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->lingkar_kepala ?? '-' }}
                                                        cm
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Lingkar Dada :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->lingkar_dada ?? '-' }} cm
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Lingkar Perut :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyFisik->lingkar_perut ?? '-' }}
                                                        cm
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pemeriksaan Fisik Komprehensif -->
                                        <div class="row mt-4">
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

                            <!-- 7. Pemeriksaan Lanjutan -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>7. Pemeriksaan Lanjutan</h5>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Warna Kulit :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_kulit ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Sianosis :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Kemerahan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->kemerahan ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Turgor Kulit :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->turgor_kulit ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tanda Lahir :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->tanda_lahir ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Fontanel Anterior :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->fontanel_anterior ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Sutura Sagitalis :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sutura_sagitalis ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Gambaran Wajah :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gambaran_wajah ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Cephalhemeton :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->cephalhemeton ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Caput Succedaneun :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->caput_succedaneun ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mulut :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mulut ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mucosa Mulut :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mucosa_mulut ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Dada Paru :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->dada_paru ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Suara Nafas :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->suara_nafas ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Respirasi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->respirasi ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Down Score :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->down_score ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Bunyi Jantung :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->bunyi_jantung ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Waktu Pengisian Kapiler :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->waktu_pengisian_kapiler ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Keadaan Perut :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->keadaan_perut ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Umbilikus :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->umbilikus ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Warna Umbilikus :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_umbilikus ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Genitalis :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->genitalis ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Gerakan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gerakan ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Ekstremitas Atas :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->ekstremitas_atas ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Ekstremitas Bawah :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->ekstremitas_bawah ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tulang Belakang :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->tulang_belakang ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <h5>Refleks</h5>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Refleks :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->refleks ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Genggaman :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->genggaman ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Menghisap :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menghisap ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Aktivitas :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->aktivitas ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Menangis :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menangis ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 8. Riwayat Ibu -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>8. Riwayat Ibu</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Pemeriksaan Kehamilan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->pemeriksaan_kehamilan ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tempat Pemeriksaan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->tempat_pemeriksaan ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Usia Kehamilan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->usia_kehamilan ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Cara Persalinan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->cara_persalinan ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Riwayat Penyakit & Pengobatan
                                                        :</label>
                                                    @php
                                                        $riwayatPenyakit = json_decode(
                                                            $asesmen->rmeAsesmenPerinatologyRiwayatIbu
                                                                ->riwayat_penyakit_pengobatan ?? '[]',
                                                            true,
                                                        );
                                                    @endphp
                                                    @if (!empty($riwayatPenyakit))
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Penyakit</th>
                                                                        <th>Pengobatan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($riwayatPenyakit as $index => $riwayat)
                                                                        <tr>
                                                                            <td>{{ $index + 1 }}</td>
                                                                            <td>{{ $riwayat['penyakit'] ?? '-' }}</td>
                                                                            <td>{{ $riwayat['pengobatan'] ?? '-' }}</td>
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 9. Alergi -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>9. Alergi</h5>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Riwayat Alergi :</label>
                                                    @php
                                                        $alergis = json_decode($asesmen->riwayat_alergi ?? '[]', true);
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
                                                                            <td>{{ $alergi['keparahan'] ?? '-' }}</td>
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

                            <!-- 10. Status Nyeri -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>10. Status Nyeri</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Jenis Skala Nyeri :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @php
                                                            $jenisSkala =
                                                                $asesmen->rmeAsesmenPerinatologyStatusNyeri
                                                                    ->jenis_skala_nyeri ?? '';
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
                                                        {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->nilai_nyeri ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Kesimpulan Nyeri :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->kesimpulan_nyeri ?? '-' }}
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
                                                        {{ optional($asesmen->rmeAsesmenPerinatologyStatusNyeri)->lokasi ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Durasi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ optional($asesmen->rmeAsesmenPerinatologyStatusNyeri)->durasi ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Jenis Nyeri :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @php
                                                            $statusNyeri = optional(
                                                                $asesmen->rmeAsesmenPerinatologyStatusNyeri,
                                                            );
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
                                                            $statusNyeri = optional(
                                                                $asesmen->rmeAsesmenPerinatologyStatusNyeri,
                                                            );
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
                                                            $statusNyeri = $asesmen->rmeAsesmenPerinatologyStatusNyeri;
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
                                                            $statusNyeri = $asesmen->rmeAsesmenPerinatologyStatusNyeri;
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
                                                            $statusNyeri = $asesmen->rmeAsesmenPerinatologyStatusNyeri;
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
                                                            $statusNyeri = $asesmen->rmeAsesmenPerinatologyStatusNyeri;
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
                                                            $statusNyeri = $asesmen->rmeAsesmenPerinatologyStatusNyeri;
                                                            $efekNyeriId = $statusNyeri
                                                                ? $statusNyeri->efek_nyeri
                                                                : null;
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

                            <!-- 11. Risiko Jatuh -->
                            <div class="tab-pane fade show">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>11. Risiko Jatuh</h5>
                                            <div class="col-md-12">
                                                @php
                                                    $risikoJatuh = optional(
                                                        $asesmen->rmeAsesmenPerinatologyRisikoJatuh,
                                                    );
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
                                                    <label class="form-label fw-bold">Jenis Penilaian Risiko Jatuh
                                                        :</label>
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
                                                                    <th>Apakah pasien dalam kondisi sebagai geriatri,
                                                                        dizzines,
                                                                        vertigo, gangguan keseimbangan?</th>
                                                                    <td>{{ $risikoJatuh->risiko_jatuh_umum_kondisi_khusus ? 'Ya' : 'Tidak' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Apakah pasien didiagnosis sebagai pasien dengan
                                                                        penyakit
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
                                                @elseif($jenisSkala == 2 || $jenisSkala == 3 || $jenisSkala == 4)
                                                    <!-- Skala lainnya -->
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Kesimpulan:</strong>
                                                        @if ($jenisSkala == 2)
                                                            {{ $risikoJatuh->kesimpulan_skala_morse ?? '-' }}
                                                        @elseif($jenisSkala == 3)
                                                            {{ $risikoJatuh->kesimpulan_skala_pediatrik ?? '-' }}
                                                        @elseif($jenisSkala == 4)
                                                            {{ $risikoJatuh->kesimpulan_skala_lansia ?? '-' }}
                                                        @endif
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
                                                                $asesmen->rmeAsesmenPerinatologyGizi->gizi_jenis ?? null;
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
                                                                                $asesmen->rmeAsesmenPerinatologyGizi
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
                                                                                $asesmen->rmeAsesmenPerinatologyGizi
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
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_nafsu_makan_berkurang == 1 ? 'Berkurang' : 'Tidak Berkurang' }}
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Diagnosis Khusus
                                                                        :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_diagnosis_khusus == 1 ? 'Ya' : 'Tidak' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <strong>Kesimpulan:</strong>
                                                            {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_kesimpulan ?? '-' }}
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
                                                                                $asesmen->rmeAsesmenPerinatologyGizi
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
                                                                                $asesmen->rmeAsesmenPerinatologyGizi
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
                                                                                $asesmen->rmeAsesmenPerinatologyGizi
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
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_stress_penyakit_akut == 1 ? 'Tidak' : 'Ya' }}
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Status Neuropsikologi
                                                                        :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        @php
                                                                            $neuropsikologi =
                                                                                $asesmen->rmeAsesmenPerinatologyGizi
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
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_berat_badan ?? '-' }}
                                                                        kg
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Tinggi Badan :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_tinggi_badan ?? '-' }}
                                                                        cm
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">IMT :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_imt ?? '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <strong>Kesimpulan:</strong>
                                                            {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kesimpulan ?? '-' }}
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
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_status_kurus == 1 ? 'Ya' : 'Tidak' }}
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Penurunan Berat Badan
                                                                        :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_penurunan_bb == 1 ? 'Ya' : 'Tidak' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Gangguan Pencernaan
                                                                        :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_gangguan_pencernaan == 1 ? 'Ya' : 'Tidak' }}
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Penyakit Berisiko
                                                                        :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_penyakit_berisiko == 2 ? 'Ya' : 'Tidak' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <strong>Kesimpulan:</strong>
                                                            {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_kesimpulan ?? '-' }}
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
                                                                $asesmen->rmeAsesmenPerinatologyFungsional->jenis_skala ??
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
                                                                        {{ $asesmen->rmeAsesmenPerinatologyFungsional->makan ?? '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Berjalan :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyFungsional->berjalan ?? '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Mandi :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyFungsional->mandi ?? '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Total Skala :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyFungsional->jumlah_skala ?? '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Kesimpulan :</label>
                                                                    <p class="form-control-plaintext border-bottom">
                                                                        {{ $asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan ?? '-' }}
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
                                                        {{ $asesmen->rmeAsesmenPerinatology->gaya_bicara ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Bahasa Sehari-Hari :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->bahasa ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Perlu Penerjemah :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->perlu_penerjemahan ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Hambatan Komunikasi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->hambatan_komunikasi ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Media Disukai :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->media_disukai ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Tingkat Pendidikan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan ?? '-' }}
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
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->diagnosis_medis ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Usia Lanjut</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if(
                                                            isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->usia_lanjut) 
                                                            && $asesmen->rmeAsesmenPerinatologyRencanaPulang->usia_lanjut !== null
                                                        )
                                                            {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Hambatan Mobilisasi</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->hambatan_mobilisasi) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->hambatan_mobilisasi !== null)
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Penggunaan Media Berkelanjutan</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->penggunaan_media_berkelanjutan) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->penggunaan_media_berkelanjutan !== null)
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->membutuhkan_pelayanan_medis ?? '-' }}
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
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->memerlukan_keterampilan_khusus) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->memerlukan_keterampilan_khusus !== null)
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->memerlukan_keterampilan_khusus ?? '-' }}
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Alat Bantu</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->memerlukan_alat_bantu) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->memerlukan_alat_bantu !== null)
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->memerlukan_alat_bantu ?? '-' }}
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nyeri Kronis</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->memiliki_nyeri_kronis) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->memiliki_nyeri_kronis !== null)
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->memiliki_nyeri_kronis ?? '-' }}
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->perkiraan_lama_dirawat) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->perkiraan_lama_dirawat !== null)
                                                            {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->perkiraan_lama_dirawat ?? '-' }}
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
                                                        @if (isset($asesmen->rmeAsesmenPerinatologyRencanaPulang->rencana_pulang) && $asesmen->rmeAsesmenPerinatologyRencanaPulang->rencana_pulang !== null)
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->rencana_pulang ? \Carbon\Carbon::parse($asesmen->rmeAsesmenPerinatologyRencanaPulang->rencana_pulang)->format('d M Y') : '-' }}
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Kesimpulan</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->kesimpulan ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 16. Masalah/Diagnosis Keperawatan -->
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>16. Masalah/Diagnosis Keperawatan</h5>
                                            <div class="col-md-12">
                                                <!-- Masalah/Diagnosis Keperawatan -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">1. Masalah/Diagnosis Keperawatan</label>
                                                    @php
                                                        $masalahDiagnosis = json_decode(
                                                            $asesmen->rmeAsesmenPerinatology->masalah_diagnosis ?? '[]',
                                                            true,
                                                        );
                                                    @endphp
                                                    @if (!empty($masalahDiagnosis))
                                                        <div class="bg-light p-3 rounded">
                                                            <ol class="mb-0">
                                                                @foreach ($masalahDiagnosis as $masalah)
                                                                    <li class="mb-2">{{ $masalah }}</li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    @else
                                                        <p class="form-control-plaintext border-bottom text-muted">
                                                            Tidak ada masalah diagnosis yang tercatat
                                                        </p>
                                                    @endif
                                                </div>

                                                <!-- Intervensi/Rencana Asuhan -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">2. Intervensi/Rencana Asuhan dan Target
                                                        Terukur</label>
                                                    @php
                                                        $intervensiRencana = json_decode(
                                                            $asesmen->rmeAsesmenPerinatology->intervensi_rencana ?? '[]',
                                                            true,
                                                        );
                                                    @endphp
                                                    @if (!empty($intervensiRencana))
                                                        <div class="bg-light p-3 rounded">
                                                            <ol class="mb-0">
                                                                @foreach ($intervensiRencana as $intervensi)
                                                                    <li class="mb-2">{{ $intervensi }}</li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    @else
                                                        <p class="form-control-plaintext border-bottom text-muted">
                                                            Tidak ada intervensi rencana yang tercatat
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
