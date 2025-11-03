@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')
    @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.include-script')

    <div class="row g-4">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Asesmen Catatan Keperawatan Periopetif (Intra dan Pasca Operasi)',
                    'description' => 'Rincian data Asesmen Catatan Perioperatif dalam formulir di bawah ini.',
                ])

                <!-- 1. Data Masuk -->
                <div class="mb-5">
                    <h5 class="mb-3 border-bottom pb-2">1. Data Masuk</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Tanggal dan Jam Masuk</label>
                            <p class="fw-medium">
                                {{ \Carbon\Carbon::parse($laporanAnastesi->waktu_laporan)->format('d-m-Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2. Jenis dan Tipe Operasi -->
                <div class="mb-5">
                    <h5 class="mb-3 border-bottom pb-2">2. Jenis dan Tipe Operasi</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Jenis Operasi</label>
                            <p class="fw-medium">{{ $laporanAnastesi->product?->deskripsi }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Tipe Operasi</label>
                            <p class="fw-medium">{{ $laporanAnastesi->tipe_operasi }}</p>
                        </div>
                    </div>
                </div>

                <!-- 3. Persiapan Pasien dan Peralatan -->
                <div class="mb-5">
                    <h5 class="mb-3 border-bottom pb-2">3. Persiapan Pasien dan Peralatan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Time Out</label>
                            <p class="fw-medium">
                                {{ $laporanAnastesi->time_out == 1 ? 'Ya' : 'Tidak' }}
                                @if ($laporanAnastesi->jam_time_out)
                                    ({{ date('H:i', strtotime($laporanAnastesi->jam_time_out)) }})
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Tingkat Kesadaran</label>
                            <p class="fw-medium">{{ $laporanAnastesi->tingkat_kesadaran }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Posisi Pasien</label>
                            <p class="fw-medium">{{ $laporanAnastesi->posisi_pasien }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Posisi Lengan</label>
                            <p class="fw-medium">{{ $laporanAnastesi->posisi_lengan }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Posisi Kanula Intra Vena</label>
                            <p class="fw-medium">{{ $laporanAnastesi->posisi_kanula }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Pemasangan Kater Urin</label>
                            <p class="fw-medium">
                                {{ $laporanAnastesi->pemasangan_kater_urin == 1 ? 'Ya' : 'Tidak' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Bila Dilakukan Kater Urin</label>
                            <p class="fw-medium">{{ $laporanAnastesi->dilakukan_kater }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Persiapan Kulit</label>
                            <p class="fw-medium">{{ $laporanAnastesi->persiapan_kulit }}</p>
                        </div>
                    </div>
                </div>

                <!-- 4. Penggunaan Alat dan Teknologi Medis -->
                <div>
                    <h5 class="mb-3 border-bottom pb-2">4. Penggunaan Alat dan Teknologi Medis</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Cek Instrumen</label>
                            <p class="fw-medium">
                                {{ $laporanAnastesiDtl->instrument == 1 ? 'Ya' : 'Tidak' }}
                                @if ($laporanAnastesiDtl->instrument_time)
                                    ({{ date('H:i', strtotime($laporanAnastesiDtl->instrument_time)) }})
                                @endif
                            </p>

                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Prothese/Implant</label>
                            <p class="fw-medium">
                                {{ $laporanAnastesiDtl->prothese == 1 ? 'Ya' : 'Tidak' }}
                                @if ($laporanAnastesiDtl->prothese_time)
                                    ({{ date('H:i', strtotime($laporanAnastesiDtl->prothese_time)) }})
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Pemasangan Diathermy</label>
                            <p class="fw-medium">
                                {{ $laporanAnastesiDtl->pemakaian_diathermy == 1 ? 'Ya' : 'Tidak' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Lokasi Diathermy</label>
                            <p class="fw-medium">{{ $laporanAnastesiDtl->lokasi_diathermy }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Kode Unit Elektrosurgical</label>
                            <p class="fw-medium">{{ $laporanAnastesiDtl->kode_elektrosurgical }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Unit Pemasangan/Pendingin</label>
                            <p class="fw-medium">
                                {{ $laporanAnastesiDtl->unit_pemasangan == 1 ? 'Ya' : 'Tidak' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Temperatur Mulai</label>
                            <p class="fw-medium">{{ $laporanAnastesiDtl->temperatur_mulai }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Kode Unit</label>
                            <p class="fw-medium">{{ $laporanAnastesiDtl->kode_unit }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Temperatur Selesai</label>
                            <p class="fw-medium">{{ $laporanAnastesiDtl->temperatur_selesai }}</p>

                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Pemakaian Tourniquet</label>
                            <p class="fw-medium">
                                {{ isset($laporanAnastesiDtl->pemakaian_tomiquet) ? ($laporanAnastesiDtl->pemakaian_tomiquet == 1 ? 'Ya' : 'Tidak') : 'Tidak ada data' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Pengawas Tourniquet</label>
                            <p class="fw-medium">{{ $laporanAnastesiDtl->pengawas_tomiquet ?? 'Tidak ada data' }}</p>
                        </div>
                        <!-- Tabel Tomiquet -->
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Lokasi</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Tekanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Lengan Kanan</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->lengan_kanan_mulai)) }}</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->lengan_kanan_selesai)) }}
                                        </td>
                                        <td>{{ $laporanAnastesiDtl->lengan_kanan_tekanan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kaki Kanan</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->kaki_kanan_mulai)) }}</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->kaki_kanan_selesai)) }}</td>
                                        <td>{{ $laporanAnastesiDtl->kaki_kanan_tekanan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lengan Kiri</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->lengan_kiri_mulai)) }}</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->lengan_kiri_selesai)) }}</td>
                                        <td>{{ $laporanAnastesiDtl->lengan_kiri_tekanan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kaki Kiri</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->kaki_kiri_mulai)) }}</td>
                                        <td>{{ date('H:i', strtotime($laporanAnastesiDtl->kaki_kiri_selesai)) }}</td>
                                        <td>{{ $laporanAnastesiDtl->kaki_kiri_tekanan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Pemakaian Laser</label>
                                <p class="fw-medium">
                                    {{ $laporanAnastesiDtl->pemakaian_laser == 1 ? 'Ya' : 'Tidak' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Kode Model</label>
                                <p class="fw-medium">{{ $laporanAnastesiDtl->kode_model }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Pengawas Laser</label>
                                <p class="fw-medium">{{ $laporanAnastesiDtl->pengawas_laser }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Pemakaian Implant</label>
                                <p class="fw-medium">
                                    {{ $laporanAnastesiDtl->pemakaian_implant == 1 ? 'Ya' : 'Tidak' }}
                                </p>
                            </div>
                            @if ($laporanAnastesiDtl->pemakaian_implant == 1)
                                <div class="col-12">
                                    <label class="fw-bold text-muted">Detail Implant</label>
                                    <div class="p-3 bg-light rounded">
                                        <p><strong>Pabrik:</strong> {{ $laporanAnastesiDtl->pabrik }}</p>
                                        <p><strong>Size:</strong> {{ $laporanAnastesiDtl->size }}</p>
                                        <p><strong>Type:</strong> {{ $laporanAnastesiDtl->type }}</p>
                                        <p><strong>No Seri:</strong> {{ $laporanAnastesiDtl->no_seri }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 5. Penghitungan Alat dan Bahan Operasi -->
                    <div class="mb-5">
                        <h5 class="mb-3 border-bottom pb-2">5. Penghitungan Alat dan Bahan Operasi</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Hitung</th>
                                        <th>Kasa</th>
                                        <th>Jarum</th>
                                        <th>Instrumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hitung 1</td>
                                        <td>{{ $laporanAnastesiDtl2->kassa_satu }}</td>
                                        <td>{{ $laporanAnastesiDtl2->jarum_satu }}</td>
                                        <td>{{ $laporanAnastesiDtl2->instrumen_satu }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hitung 2</td>
                                        <td>{{ $laporanAnastesiDtl2->kassa_dua }}</td>
                                        <td>{{ $laporanAnastesiDtl2->jarum_dua }}</td>
                                        <td>{{ $laporanAnastesiDtl2->instrumen_dua }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hitung 3</td>
                                        <td>{{ $laporanAnastesiDtl2->kassa_tiga }}</td>
                                        <td>{{ $laporanAnastesiDtl2->jarum_tiga }}</td>
                                        <td>{{ $laporanAnastesiDtl2->instrumen_tiga }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Dilakukan X-Ray</label>
                                <p class="fw-medium">
                                    {{ $laporanAnastesiDtl2->dilakukan_xray == 1 ? 'Ya' : 'Tidak' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Penggunaan Tampon</label>
                                <p class="fw-medium">
                                    {{ $laporanAnastesiDtl2->penggunaan_tampon == 1 ? 'Ya' : 'Tidak' }}
                                </p>
                            </div>
                            @if ($laporanAnastesiDtl2->penggunaan_tampon == 1)
                                <div class="col-md-6">
                                    <label class="fw-bold text-muted">Jenis Tampon</label>
                                    <p class="fw-medium">{{ $laporanAnastesiDtl2->jenis_tampon }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 6. Penggunaan Cairan dan Drain -->
                    <div class="mb-5">
                        <h5 class="mb-3 border-bottom pb-2">6. Penggunaan Cairan dan Drain</h5>
                        @if ($drainData && count($drainData) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tipe Drain</th>
                                            <th>Jenis Drain</th>
                                            <th>Ukuran</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($drainData as $drain)
                                            @if (
                                                !empty($drain['tipe_drain']) ||
                                                    !empty($drain['jenis_drain']) ||
                                                    !empty($drain['ukuran']) ||
                                                    !empty($drain['keterangan']))
                                                <tr>
                                                    <td>{{ $drain['tipe_drain'] }}</td>
                                                    <td>{{ $drain['jenis_drain'] }}</td>
                                                    <td>{{ $drain['ukuran'] }}</td>
                                                    <td>{{ $drain['keterangan'] }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Irigasi Luka</label>
                                <p class="fw-medium">{{ $laporanAnastesiDtl2->irigasi_luka }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Pemakaian Cairan</label>
                                <div class="w-100">
                                    @php
                                        $pemakaianCairan =
                                            json_decode($laporanAnastesiDtl2->pemakaian_cairan, true) ?: [];
                                    @endphp

                                    @if (count($pemakaianCairan) > 0)
                                        <div class="border rounded p-2 bg-light">
                                            @foreach ($pemakaianCairan as $index => $item)
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="me-2">{{ $index + 1 }}.</span>
                                                    <span><strong>{{ $item['jenis'] }}</strong>: {{ $item['jumlah'] }}
                                                        Liter</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="fw-medium text-muted">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Alat-alat terbungkus</label>
                        <p class="fw-medium">
                            {{-- Jika datanya null/kosong (karena user pilih "Tidak"), tampilkan "Tidak".
             Jika ada isinya, tampilkan isinya (Kasa/Jubah/Lainnya) --}}
                            {{ $laporanAnastesiDtl2->alat_terbungkus ?? 'Tidak' }}
                        </p>
                    </div>

                    <!-- 7. Waktu dan Tim Medis -->
                    <div class="mb-5">
                        <h5 class="mb-3 border-bottom pb-2">7. Waktu dan Tim Medis</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Waktu Mulai Operasi</label>
                                <p class="fw-medium">
                                    {{ \Carbon\Carbon::parse($laporanAnastesi->waktu_mulai_operasi)->format('d-m-Y H:i') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Waktu Selesai Operasi</label>
                                <p class="fw-medium">
                                    {{ \Carbon\Carbon::parse($laporanAnastesi->waktu_selesai_operasi)->format('d-m-Y H:i') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Dokter Bedah</label>
                                <p class="fw-medium">
                                    @php
                                        $dokterBedah = $dokter
                                            ->where('kd_dokter', $laporanAnastesi->dokter_bedah)
                                            ->first();
                                    @endphp
                                    {{ $dokterBedah ? $dokterBedah->nama_lengkap : $laporanAnastesi->dokter_bedah }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Dokter Anastesi</label>
                                <p class="fw-medium">
                                    @php
                                        $dokterAnastesiObj = $dokterAnastesi
                                            ->where('kd_dokter', $laporanAnastesi->dokter_anastesi)
                                            ->first();
                                    @endphp
                                    {{ $dokterAnastesiObj && $dokterAnastesiObj->dokter ? $dokterAnastesiObj->dokter->nama_lengkap : $laporanAnastesi->dokter_anastesi }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Penatara Anastesi</label>
                                <p class="fw-medium">
                                    @php
                                        $penataraAnastesi = $perawat
                                            ->where('kd_perawat', $laporanAnastesi->penatara_anastesi)
                                            ->first();
                                    @endphp
                                    {{ $penataraAnastesi ? $penataraAnastesi->nama : $laporanAnastesi->penatara_anastesi }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 8. Evaluasi Pasca Operasi -->
                    <div class="mb-5">
                        <h5 class="mb-3 border-bottom pb-2">8. Evaluasi Pasca Operasi</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Kondisi Kulit Pra Operasi</label>
                                <p class="fw-medium">{{ $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Kondisi Kulit Pasca Operasi</label>
                                <p class="fw-medium">
                                    {{ $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pasca_operasi }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Balutan Luka</label>
                                <p class="fw-medium">{{ $laporanAnastesiDtl2->balutan_luka }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">Spesimen</label>
                                @php
                                    $spesimen = json_decode($laporanAnastesiDtl2->spesimen, true) ?: [];
                                @endphp

                                @if (count($spesimen) > 0)
                                    <div class="w-100">
                                        @foreach ($spesimen as $index => $item)
                                            @php
                                                $checkIcon = '';
                                                if (isset($item['checked'])) {
                                                    $checkIcon = $item['checked'] ? ' ✓' : ' ✗';
                                                }
                                            @endphp
                                            <p class="fw-medium mb-1">
                                                {{ $index + 1 }}.
                                                <strong>{{ $item['kategori'] }}</strong>{{ $checkIcon }}:
                                                {{ $item['jenis'] }}
                                            </p>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="fw-medium text-muted">-</p>
                                @endif
                            </div>
                            @if ($laporanAnastesiDtl2->spesimen)
                                <div class="col-md-6">
                                    <label class="fw-bold text-muted">Jenis Spesimen</label>
                                    <p class="fw-medium">{{ $laporanAnastesiDtl2->jenis_spesimen }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold text-muted">Jumlah Total Jaringan/Cairan</label>
                                    <p class="fw-medium">{{ $laporanAnastesiDtl2->total_jaringan_cairan_pemeriksaan }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold text-muted">Jenis Jaringan</label>
                                    <p class="fw-medium">{{ $laporanAnastesiDtl2->jenis_jaringan }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold text-muted">Jumlah Jaringan</label>
                                    <p class="fw-medium">{{ $laporanAnastesiDtl2->jumlah_jaringan }}</p>
                                </div>
                            @endif
                            <div class="col-12">
                                <label class="fw-bold text-muted">Keterangan</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $laporanAnastesiDtl2->keterangan ?: 'Tidak ada keterangan' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Dokumentasi dan Verifikasi -->
                    <div>
                        <h5 class="mb-3 border-bottom pb-2">9. Dokumentasi dan Verifikasi</h5>
                        <div class="card shadow-sm border-0" style="background: #f8f9fa; border-radius: 10px;">
                            <div class="card-body p-4">
                                <div class="row g-4 align-items-center">
                                    <div class="col-md-4">
                                        <label class="fw-bold text-muted">
                                            <i class="ti-user me-2 text-primary"></i>
                                            E-Signature Perawat Instrumen
                                        </label>
                                    </div>
                                    <div class="col-md-8 text-center">
                                        @php
                                            $perawatInstrumen = $perawat
                                                ->where('kd_perawat', $laporanAnastesi->perawat_instrumen)
                                                ->first();
                                        @endphp
                                        <p class="mb-2">
                                            <span
                                                class="d-block fw-medium">{{ $perawatInstrumen ? $perawatInstrumen->nama : 'Tidak ada data' }}</span>
                                            <span class="badge bg-primary-subtle text-primary px-3 py-1">
                                                Ns. {{ $laporanAnastesi->perawat_instrumen }}
                                            </span>
                                        </p>
                                        @if ($laporanAnastesi->perawat_instrumen)
                                            <div id="qrcode_perawat_instrumen" class="d-inline-block"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row g-4 align-items-center mt-4">
                                    <div class="col-md-4">
                                        <label class="fw-bold text-muted">
                                            <i class="ti-user me-2 text-primary"></i>
                                            E-Signature Perawat Sirkuler
                                        </label>
                                    </div>
                                    <div class="col-md-8 text-center">
                                        @php
                                            $perawatSirkuler = $perawat
                                                ->where('kd_perawat', $laporanAnastesi->perawat_sirkuler)
                                                ->first();
                                        @endphp
                                        <p class="mb-2">
                                            <span
                                                class="d-block fw-medium">{{ $perawatSirkuler ? $perawatSirkuler->nama : 'Tidak ada data' }}</span>
                                            <span class="badge bg-primary-subtle text-primary px-3 py-1">
                                                Ns. {{ $laporanAnastesi->perawat_sirkuler }}
                                            </span>
                                        </p>
                                        @if ($laporanAnastesi->perawat_sirkuler)
                                            <div id="qrcode_perawat_sirkuler" class="d-inline-block"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row g-4 align-items-center mt-4">
                                    <div class="col-md-4">
                                        <label class="fw-bold text-muted">
                                            <i class="ti-calendar me-2 text-primary"></i>
                                            Tanggal dan Jam Pencatatan
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="fw-medium">
                                            @if ($laporanAnastesi->tanggal_jam_pencatatan)
                                                {{ \Carbon\Carbon::parse($laporanAnastesi->tanggal_jam_pencatatan)->format('d-m-Y H:i') }}
                                            @else
                                                Tidak ada data
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .table th {
            background-color: #ecf0f1;
            color: #34495e;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script>
        $(document).ready(function() { // <-- Buka document.ready DI SINI

            // --- (Blok 1: Logika QR Code Anda) ---
            $('#perawat_instrumen').on('select2:select', function(e) {
                var kodePerawat = $(this).val();
                var namaPerawat = $(this).find('option:selected').data(
                    'nama'); // Ambil nama perawat dari data-nama
                console.log("Kode perawat instrumen yang dipilih:", kodePerawat);
                console.log("Nama perawat instrumen yang dipilih:", namaPerawat);

                // Update nama perawat dan kode perawat
                $('#nama_perawat_instrumen').text(namaPerawat || '');
                $('#kode_perawat_instrumen').text(kodePerawat || '.........................');
                generateQRCode('qrcode_perawat_instrumen', kodePerawat);
            });

            $('#perawat_sirkuler').on('select2:select', function(e) {
                var kodePerawat = $(this).val();
                var namaPerawat = $(this).find('option:selected').data(
                    'nama'); // Ambil nama perawat dari data-nama
                console.log("Kode perawat sirkuler yang dipilih:", kodePerawat);
                console.log("Nama perawat sirkuler yang dipilih:", namaPerawat);

                // Update nama perawat dan kode perawat
                $('#nama_perawat_sirkuler').text(namaPerawat || '');
                $('#kode_perawat_sirkuler').text(kodePerawat || '.........................');
                generateQRCode('qrcode_perawat_sirkuler', kodePerawat);
            });

            function generateQRCode(elementId, text) {
                // Hapus QR code sebelumnya jika ada
                $('#' + elementId).empty();

                if (!text) return; // Hindari error jika text kosong

                try {
                    // Buat QR code baru
                    var qr = qrcode(0, 'M');
                    qr.addData(text);
                    qr.make();

                    // Tampilkan QR code
                    $('#' + elementId).html(qr.createImgTag(5));
                } catch (err) {
                    console.error("Error generating QR code:", err);
                }
            }
            // --- (Akhir Blok 1) ---


            // --- (Blok 2: Logika Show/Hide Anda) ---
            /**
             * Fungsi untuk menampilkan/menyembunyikan elemen
             * berdasarkan pilihan radio button 'ya'/'tidak'.
             */

        }); // <-- Tutup document.ready (HANYA SATU KALI DI AKHIR)
    </script>
@endpush
