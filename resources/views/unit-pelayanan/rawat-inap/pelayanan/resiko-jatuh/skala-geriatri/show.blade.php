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
                    'title' => 'Rincian Pengkajian Resiko Jatuh - Khusus Lansia (Geriatri)',
                    'description' =>
                        'Rincian data pengkajian resiko jatuh - khusus lansia (Geriatri) pasien rawat inap.',
                ])

                <!-- Informasi Dasar -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Implementasi</label>
                        <div class="form-control-plaintext bg-light p-2 rounded">
                            {{ date('d/m/Y', strtotime($dataGeriatri->tanggal_implementasi)) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jam Implementasi</label>
                        <div class="form-control-plaintext bg-light p-2 rounded">
                            {{ date('H:i', strtotime($dataGeriatri->jam_implementasi)) }} WIB
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Shift</label>
                        <div class="form-control-plaintext bg-light p-2 rounded">
                            <span class="badge bg-secondary">{{ ucfirst($dataGeriatri->shift) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Penilaian -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3"><i class="ti-list-ol me-2"></i> Detail Penilaian</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Pilihan</th>
                                        <th class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Riwayat Jatuh --}}
                                    <tr>
                                        <td rowspan="2"><strong>1. Riwayat Jatuh</strong></td>
                                        <td>a. Tidak ada riwayat jatuh dalam 3 bulan terakhir</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->riwayat_jatuh_1a == 6)
                                                <span class="badge bg-primary">{{ $dataGeriatri->riwayat_jatuh_1a }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>b. Ada riwayat jatuh dalam 3 bulan terakhir</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->riwayat_jatuh_1b == 6)
                                                <span class="badge bg-primary">{{ $dataGeriatri->riwayat_jatuh_1b }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Total Skor Riwayat Jatuh</strong></td>
                                        <td class="text-center"><span
                                                class="badge bg-info">{{ $dataGeriatri->skor_riwayat_jatuh }}</span></td>
                                    </tr>

                                    {{-- Status Mental --}}
                                    <tr>
                                        <td rowspan="3"><strong>2. Status Mental</strong></td>
                                        <td>a. Orientasi baik / dapat mengikuti perintah</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->status_mental_2a == 14)
                                                <span class="badge bg-primary">{{ $dataGeriatri->status_mental_2a }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>b. Orientasi terganggu kadang-kadang</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->status_mental_2b == 14)
                                                <span class="badge bg-primary">{{ $dataGeriatri->status_mental_2b }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>c. Orientasi terganggu setiap saat</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->status_mental_2c == 14)
                                                <span class="badge bg-primary">{{ $dataGeriatri->status_mental_2c }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Total Skor Status Mental</strong></td>
                                        <td class="text-center"><span
                                                class="badge bg-info">{{ $dataGeriatri->skor_status_mental }}</span></td>
                                    </tr>

                                    {{-- Penglihatan --}}
                                    <tr>
                                        <td rowspan="3"><strong>3. Penglihatan</strong></td>
                                        <td>a. Tidak ada gangguan penglihatan</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->penglihatan_3a == 1)
                                                <span class="badge bg-primary">{{ $dataGeriatri->penglihatan_3a }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>b. Gangguan penglihatan ringan</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->penglihatan_3b == 1)
                                                <span class="badge bg-primary">{{ $dataGeriatri->penglihatan_3b }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>c. Gangguan penglihatan berat</td>
                                        <td class="text-center">
                                            @if ($dataGeriatri->penglihatan_3c == 1)
                                                <span class="badge bg-primary">{{ $dataGeriatri->penglihatan_3c }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Total Skor Penglihatan</strong></td>
                                        <td class="text-center"><span
                                                class="badge bg-info">{{ $dataGeriatri->skor_penglihatan }}</span></td>
                                    </tr>

                                    {{-- Kebiasaan Berkemih --}}
                                    <tr>
                                        <td><strong>4. Kebiasaan Berkemih</strong></td>
                                        <td>
                                            @if ($dataGeriatri->kebiasaan_berkemih_4a == 2)
                                                Inkontinensia / menggunakan kateter / sering ke toilet
                                            @else
                                                Normal / bantuan dalam berkemih
                                            @endif
                                        </td>
                                        <td class="text-center"><span
                                                class="badge bg-primary">{{ $dataGeriatri->kebiasaan_berkemih_4a }}</span>
                                        </td>
                                    </tr>

                                    {{-- Transfer & Mobilitas --}}
                                    <tr>
                                        <td><strong>5. Transfer</strong></td>
                                        <td>
                                            @if ($dataGeriatri->transfer == 0)
                                                Mandiri / dengan bantuan alat
                                            @elseif($dataGeriatri->transfer == 1)
                                                Perlu bantuan minimal 1 orang / bantuan alat
                                            @elseif($dataGeriatri->transfer == 2)
                                                Perlu bantuan 2 orang / bantuan alat
                                            @else
                                                Tidak dapat melakukan transfer
                                            @endif
                                        </td>
                                        <td class="text-center"><span
                                                class="badge bg-primary">{{ $dataGeriatri->transfer }}</span></td>
                                    </tr>

                                    <tr>
                                        <td><strong>6. Mobilitas</strong></td>
                                        <td>
                                            @if ($dataGeriatri->mobilitas == 0)
                                                Mandiri / dengan bantuan alat
                                            @elseif($dataGeriatri->mobilitas == 1)
                                                Perlu bantuan minimal 1 orang / bantuan alat
                                            @elseif($dataGeriatri->mobilitas == 2)
                                                Perlu bantuan 2 orang / bantuan alat
                                            @else
                                                Tidak dapat melakukan mobilitas
                                            @endif
                                        </td>
                                        <td class="text-center"><span
                                                class="badge bg-primary">{{ $dataGeriatri->mobilitas }}</span></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><strong>Total Skor Transfer & Mobilitas</strong></td>
                                        <td class="text-center"><span
                                                class="badge bg-info">{{ $dataGeriatri->skor_transfer_mobilitas }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hasil Skor & Kategori (pisah card seperti Morse) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <label class="form-label fw-bold">Skor Total</label>
                                <div class="form-control-plaintext fs-2 fw-bold">{{ $dataGeriatri->total_skor }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <label class="form-label fw-bold">Kategori Risiko</label>
                                <div class="form-control-plaintext fs-5 fw-bold">
                                    @if ($dataGeriatri->kategori_risiko == 'Risiko Rendah')
                                        <span class="badge bg-success">RESIKO RENDAH</span>
                                    @elseif($dataGeriatri->kategori_risiko == 'Risiko Sedang')
                                        <span class="badge bg-warning text-dark">RESIKO SEDANG</span>
                                    @elseif($dataGeriatri->kategori_risiko == 'Risiko Tinggi')
                                        <span class="badge bg-danger">RESIKO TINGGI</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $dataGeriatri->kategori_risiko }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Intervensi (kumulatif: Tinggi => Low+Mid+High, Sedang => Mid+Low, Rendah => Low) -->
                <div class="mb-4">
                    <h5 class="mb-3"><i class="ti-shield me-2"></i> Intervensi Pencegahan Jatuh</h5>

                    @php $kat = $dataGeriatri->kategori_risiko; @endphp

                    {{-- Rendah --}}
                    @if (in_array($kat, ['Risiko Rendah', 'Risiko Sedang', 'Risiko Tinggi']))
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="text-success mb-3">Intervensi — Risiko Rendah</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_observasi_ambulasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Tingkatkan observasi bantuan yang sesuai saat ambulasi</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_orientasi_kamar_mandi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Tunjukkan lokasi kamar mandi</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_orientasi_bertahap)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Jika pasien linglung, orientasi dilaksanakan bertahap</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_tempatkan_bel)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Tempatkan bel ditempat yang mudah dicapai</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_instruksi_bantuan)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Instruksikan meminta bantuan perawat sebelum turun dari
                                            tempat tidur</div>
                                    </li>

                                    {{-- other low items --}}
                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_pagar_pengaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/tangan
                                            tidak tersangkut</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_tempat_tidur_rendah)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Tempat tidur dalam posisi rendah dan terkunci</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_edukasi_perilaku)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Edukasi perilaku yang lebih aman saat jatuh atau transfer
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_monitor_berkala)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Monitor kebutuhan pasien secara berkala (minimal tiap 2 jam)
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_anjuran_kaus_kaki)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang
                                            licin</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rr_lantai_antislip)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Lantai kamar mandi dengan karpet antislip, tidak licin</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Sedang --}}
                    @if (in_array($kat, ['Risiko Sedang', 'Risiko Tinggi']))
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="text-warning mb-3">Intervensi — Risiko Sedang</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rs_semua_intervensi_rendah)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Lakukan SEMUA intervensi jatuh risiko rendah / standar</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rs_gelang_kuning)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Pakailah gelang risiko jatuh berwarna kuning</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rs_pasang_gambar)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Pasang gambar risiko jatuh diatas tempat tidur pasien dan
                                            pada pintu kamar pasien</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rs_tanda_daftar_nama)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Tempatkan tanda risiko pasien jatuh pada daftar nama pasien
                                            (warna kuning)</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rs_pertimbangkan_obat)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Pertimbangkan riwayat obat-obatan dan suplemen untuk
                                            mengevaluasi pengobatan</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rs_alat_bantu_jalan)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Gunakan alat bantu jalan (walker, handrail)</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Tinggi --}}
                    @if ($kat == 'Risiko Tinggi')
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="text-danger mb-3">Intervensi — Risiko Tinggi</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rt_semua_intervensi_rendah_sedang)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Lakukan SEMUA intervensi jatuh risiko rendah dan sedang
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rt_jangan_tinggalkan)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Jangan tinggalkan pasien saat di ruangan diagnostik atau
                                            tindakan</div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-start">
                                        <div class="me-3 align-self-start">
                                            @if ($dataGeriatri->rt_dekat_nurse_station)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-secondary">✗</span>
                                            @endif
                                        </div>
                                        <div class="flex-fill">Penempatan pasien dekat nurse station untuk memudahkan
                                            observasi</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informasi Petugas -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Informasi Petugas</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Nama Petugas</strong></div>
                                <div>{{ $dataGeriatri->userCreated->name ?? 'Unknown' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Dibuat Pada</strong></div>
                                <div>{{ date('d/m/Y H:i', strtotime($dataGeriatri->created_at)) }} WIB</div>
                            </div>
                        </div>
                        @if ($dataGeriatri->userUpdated)
                            <div class="mt-3"><strong>Terakhir Diupdate Oleh:</strong>
                                {{ $dataGeriatri->userUpdated->name }}</div>
                        @endif
                    </div>
                </div>

            </x-content-card>
        </div>
    </div>
@endsection
