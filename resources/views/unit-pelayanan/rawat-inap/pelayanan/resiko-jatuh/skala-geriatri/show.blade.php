@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.resiko-jatuh.geriatri.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengkajian Resiko Jatuh Skala Geriatri</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Informasi Dasar -->
                    <h6 class="mb-3">Informasi Dasar</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Implementasi</strong></td>
                            <td>{{ date('d/m/Y', strtotime($dataGeriatri->tanggal_implementasi)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Implementasi</strong></td>
                            <td>{{ date('H:i', strtotime($dataGeriatri->jam_implementasi)) }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Shift</strong></td>
                            <td><span class="badge bg-secondary">{{ ucfirst($dataGeriatri->shift) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Total Skor</strong></td>
                            <td><h5 class="mb-0">{{ $dataGeriatri->total_skor }}</h5></td>
                        </tr>
                        <tr>
                            <td><strong>Kategori Risiko</strong></td>
                            <td>
                                @if($dataGeriatri->kategori_risiko == 'Risiko Rendah')
                                    <span class="badge bg-success">{{ $dataGeriatri->kategori_risiko }}</span>
                                @elseif($dataGeriatri->kategori_risiko == 'Risiko Sedang')
                                    <span class="badge bg-warning">{{ $dataGeriatri->kategori_risiko }}</span>
                                @elseif($dataGeriatri->kategori_risiko == 'Risiko Tinggi')
                                    <span class="badge bg-danger">{{ $dataGeriatri->kategori_risiko }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $dataGeriatri->kategori_risiko }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <!-- Hasil Penilaian -->
                    <h6 class="mb-3">Hasil Penilaian</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th>Pilihan</th>
                                <th width="10%">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Riwayat Jatuh -->
                            <tr>
                                <td rowspan="2"><strong>1. Riwayat Jatuh</strong></td>
                                <td>a. Tidak ada riwayat jatuh dalam 3 bulan terakhir</td>
                                <td class="text-center">
                                    @if($dataGeriatri->riwayat_jatuh_1a == 6)
                                        <span class="badge bg-primary">{{ $dataGeriatri->riwayat_jatuh_1a }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>b. Ada riwayat jatuh dalam 3 bulan terakhir</td>
                                <td class="text-center">
                                    @if($dataGeriatri->riwayat_jatuh_1b == 6)
                                        <span class="badge bg-primary">{{ $dataGeriatri->riwayat_jatuh_1b }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Total Skor Riwayat Jatuh</strong></td>
                                <td class="text-center"><span class="badge bg-info">{{ $dataGeriatri->skor_riwayat_jatuh }}</span></td>
                            </tr>

                            <!-- Status Mental -->
                            <tr>
                                <td rowspan="3"><strong>2. Status Mental</strong></td>
                                <td>a. Orientasi baik / dapat mengikuti perintah</td>
                                <td class="text-center">
                                    @if($dataGeriatri->status_mental_2a == 14)
                                        <span class="badge bg-primary">{{ $dataGeriatri->status_mental_2a }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>b. Orientasi terganggu kadang-kadang</td>
                                <td class="text-center">
                                    @if($dataGeriatri->status_mental_2b == 14)
                                        <span class="badge bg-primary">{{ $dataGeriatri->status_mental_2b }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>c. Orientasi terganggu setiap saat</td>
                                <td class="text-center">
                                    @if($dataGeriatri->status_mental_2c == 14)
                                        <span class="badge bg-primary">{{ $dataGeriatri->status_mental_2c }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Total Skor Status Mental</strong></td>
                                <td class="text-center"><span class="badge bg-info">{{ $dataGeriatri->skor_status_mental }}</span></td>
                            </tr>

                            <!-- Penglihatan -->
                            <tr>
                                <td rowspan="3"><strong>3. Penglihatan</strong></td>
                                <td>a. Tidak ada gangguan penglihatan</td>
                                <td class="text-center">
                                    @if($dataGeriatri->penglihatan_3a == 1)
                                        <span class="badge bg-primary">{{ $dataGeriatri->penglihatan_3a }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>b. Gangguan penglihatan ringan</td>
                                <td class="text-center">
                                    @if($dataGeriatri->penglihatan_3b == 1)
                                        <span class="badge bg-primary">{{ $dataGeriatri->penglihatan_3b }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>c. Gangguan penglihatan berat</td>
                                <td class="text-center">
                                    @if($dataGeriatri->penglihatan_3c == 1)
                                        <span class="badge bg-primary">{{ $dataGeriatri->penglihatan_3c }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Total Skor Penglihatan</strong></td>
                                <td class="text-center"><span class="badge bg-info">{{ $dataGeriatri->skor_penglihatan }}</span></td>
                            </tr>

                            <!-- Kebiasaan Berkemih -->
                            <tr>
                                <td><strong>4. Kebiasaan Berkemih</strong></td>
                                <td>
                                    @if($dataGeriatri->kebiasaan_berkemih_4a == 2)
                                        Inkontinensia / menggunakan kateter / sering ke toilet
                                    @else
                                        Normal / bantuan dalam berkemih
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataGeriatri->kebiasaan_berkemih_4a }}</span></td>
                            </tr>

                            <!-- Transfer & Mobilitas -->
                            <tr>
                                <td><strong>5. Transfer</strong></td>
                                <td>
                                    @if($dataGeriatri->transfer == 0)
                                        Mandiri / dengan bantuan alat
                                    @elseif($dataGeriatri->transfer == 1)
                                        Perlu bantuan minimal 1 orang / bantuan alat
                                    @elseif($dataGeriatri->transfer == 2)
                                        Perlu bantuan 2 orang / bantuan alat
                                    @else
                                        Tidak dapat melakukan transfer
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataGeriatri->transfer }}</span></td>
                            </tr>

                            <tr>
                                <td><strong>6. Mobilitas</strong></td>
                                <td>
                                    @if($dataGeriatri->mobilitas == 0)
                                        Mandiri / dengan bantuan alat
                                    @elseif($dataGeriatri->mobilitas == 1)
                                        Perlu bantuan minimal 1 orang / bantuan alat
                                    @elseif($dataGeriatri->mobilitas == 2)
                                        Perlu bantuan 2 orang / bantuan alat
                                    @else
                                        Tidak dapat melakukan mobilitas
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataGeriatri->mobilitas }}</span></td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Total Skor Transfer & Mobilitas</strong></td>
                                <td class="text-center"><span class="badge bg-info">{{ $dataGeriatri->skor_transfer_mobilitas }}</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Intervensi -->
                    <h6 class="mb-3">Intervensi Pencegahan Jatuh</h6>
                    @if($dataGeriatri->kategori_risiko == 'Risiko Rendah')
                        <div class="alert alert-success">
                            <strong>Intervensi untuk Risiko Rendah (Skor 0-5)</strong>
                        </div>
                        <table class="table table-bordered table-sm mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Status</th>
                                    <th>Intervensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_observasi_ambulasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tingkatkan observasi bantuan yang sesuai saat ambulasi</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_orientasi_kamar_mandi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tunjukkan lokasi kamar mandi</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_orientasi_bertahap)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Jika pasien linglung, orientasi dilaksanakan bertahap</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_tempatkan_bel)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tempatkan bel ditempat yang mudah dicapai</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_instruksi_bantuan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_pagar_pengaman)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/tangan tidak tersangkut</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_tempat_tidur_rendah)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tempat tidur dalam posisi rendah dan terkunci</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_edukasi_perilaku)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Edukasi perilaku yang lebih aman saat jatuh atau transfer</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_monitor_berkala)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_anjuran_kaus_kaki)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rr_lantai_antislip)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lantai kamar mandi dengan karpet antislip, tidak licin</td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($dataGeriatri->kategori_risiko == 'Risiko Sedang')
                        <div class="alert alert-warning">
                            <strong>Intervensi untuk Risiko Sedang (Skor 6-16)</strong>
                        </div>
                        <table class="table table-bordered table-sm mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Status</th>
                                    <th>Intervensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rs_semua_intervensi_rendah)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lakukan SEMUA intervensi jatuh risiko rendah / standar</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rs_gelang_kuning)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pakailah gelang risiko jatuh berwarna kuning</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rs_pasang_gambar)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rs_tanda_daftar_nama)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tempatkan tanda risiko pasien jatuh pada daftar nama pasien (warna kuning)</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rs_pertimbangkan_obat)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rs_alat_bantu_jalan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Gunakan alat bantu jalan (walker, handrail)</td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($dataGeriatri->kategori_risiko == 'Risiko Tinggi')
                        <div class="alert alert-danger">
                            <strong>Intervensi untuk Risiko Tinggi (Skor 17-30)</strong>
                        </div>
                        <table class="table table-bordered table-sm mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Status</th>
                                    <th>Intervensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rt_semua_intervensi_rendah_sedang)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lakukan SEMUA intervensi jatuh risiko rendah dan sedang</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rt_jangan_tinggalkan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Jangan tinggalkan pasien saat di ruangan diagnostik atau tindakan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataGeriatri->rt_dekat_nurse_station)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Penempatan pasien dekat nurse station untuk memudahkan observasi</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <!-- Informasi Petugas -->
                    <h6 class="mb-3">Informasi Petugas</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Nama Petugas</strong></td>
                            <td>{{ $dataGeriatri->userCreated->name ?? 'Unknown' }}</td>
                        </tr>
                        @if($dataGeriatri->userUpdated)
                        <tr>
                            <td><strong>Terakhir Diupdate Oleh</strong></td>
                            <td>{{ $dataGeriatri->userUpdated->name ?? '-' }}</td>
                        </tr>
                        @endif
                    </table>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-inap.resiko-jatuh.geriatri.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                        
                        <div>
                            <a href="{{ route('rawat-inap.resiko-jatuh.geriatri.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataGeriatri->id]) }}" 
                               class="btn btn-warning me-2">
                                <i class="ti-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection