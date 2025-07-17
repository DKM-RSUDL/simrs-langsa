@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.resiko-decubitus.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengkajian Resiko Decubitus (Skala Norton)</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Informasi Dasar -->
                    <h6 class="mb-3">Informasi Dasar</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Implementasi</strong></td>
                            <td>{{ date('d/m/Y', strtotime($dataDecubitus->tanggal_implementasi)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Implementasi</strong></td>
                            <td>{{ date('H:i', strtotime($dataDecubitus->jam_implementasi)) }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Hari Ke</strong></td>
                            <td><span class="badge bg-info">Hari {{ $dataDecubitus->hari_ke }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Shift</strong></td>
                            <td>
                                <span class="badge bg-secondary">
                                    @if($dataDecubitus->shift == '1')
                                        Pagi
                                    @elseif($dataDecubitus->shift == '2')
                                        Siang
                                    @elseif($dataDecubitus->shift == '3')
                                        Malam
                                    @else
                                        {{ $dataDecubitus->shift }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total Skor Norton</strong></td>
                            <td><h5 class="mb-0">{{ $dataDecubitus->norton_total_score }}</h5></td>
                        </tr>
                        <tr>
                            <td><strong>Kategori Risiko</strong></td>
                            <td>
                                @if($dataDecubitus->kategori_risiko == 'Risiko Rendah')
                                    <span class="badge bg-success">{{ $dataDecubitus->kategori_risiko }}</span>
                                @elseif($dataDecubitus->kategori_risiko == 'Risiko Sedang')
                                    <span class="badge bg-warning">{{ $dataDecubitus->kategori_risiko }}</span>
                                @elseif($dataDecubitus->kategori_risiko == 'Risiko Tinggi')
                                    <span class="badge bg-danger">{{ $dataDecubitus->kategori_risiko }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $dataDecubitus->kategori_risiko }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <!-- Hasil Penilaian Skala Norton -->
                    <h6 class="mb-3">Hasil Penilaian Skala Norton</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th>Penilaian</th>
                                <th width="10%">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>1. Kondisi Fisik</strong></td>
                                <td>
                                    @if($dataDecubitus->kondisi_fisik == 4)
                                        Baik
                                    @elseif($dataDecubitus->kondisi_fisik == 3)
                                        Sedang
                                    @elseif($dataDecubitus->kondisi_fisik == 2)
                                        Buruk
                                    @else
                                        Sangat Buruk
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataDecubitus->kondisi_fisik }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>2. Status Mental</strong></td>
                                <td>
                                    @if($dataDecubitus->status_mental == 4)
                                        Sadar
                                    @elseif($dataDecubitus->status_mental == 3)
                                        Apatis
                                    @elseif($dataDecubitus->status_mental == 2)
                                        Bingung
                                    @else
                                        Stupor
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataDecubitus->status_mental }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>3. Aktivitas</strong></td>
                                <td>
                                    @if($dataDecubitus->aktivitas == 4)
                                        Jalan Sendiri
                                    @elseif($dataDecubitus->aktivitas == 3)
                                        Jalan dengan Bantuan
                                    @elseif($dataDecubitus->aktivitas == 2)
                                        Kursi Roda
                                    @else
                                        Di tempat tidur
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataDecubitus->aktivitas }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>4. Mobilitas</strong></td>
                                <td>
                                    @if($dataDecubitus->mobilitas == 4)
                                        Bisa bergerak
                                    @elseif($dataDecubitus->mobilitas == 3)
                                        Agak terbatas
                                    @elseif($dataDecubitus->mobilitas == 2)
                                        Sangat terbatas
                                    @else
                                        Tidak bergerak
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataDecubitus->mobilitas }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>5. Inkontinensia</strong></td>
                                <td>
                                    @if($dataDecubitus->inkontinensia == 4)
                                        Kontinen
                                    @elseif($dataDecubitus->inkontinensia == 3)
                                        Kadang-kadang inkontinensia urine
                                    @elseif($dataDecubitus->inkontinensia == 2)
                                        Selalu inkontinensia urine
                                    @else
                                        Inkontinensia urine dan alvi
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataDecubitus->inkontinensia }}</span></td>
                            </tr>
                            <tr class="table-info">
                                <td colspan="2"><strong>TOTAL SKOR NORTON</strong></td>
                                <td class="text-center"><span class="badge bg-success fs-5">{{ $dataDecubitus->norton_total_score }}</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Protokol Intervensi -->
                    <h6 class="mb-3">Protokol Intervensi Pencegahan Decubitus</h6>
                    @if($dataDecubitus->kategori_risiko == 'Risiko Rendah')
                        <div class="alert alert-success">
                            <strong>Intervensi untuk Risiko Rendah (Skor 16-20)</strong>
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
                                        @if($dataDecubitus->rr_kaji_ulang)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lakukan pengkajian ulang setiap hari atau jika ada perubahan kondisi pasien</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rr_cek_control)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Cek kondisi kulit pada area yang tertekan atau lembab setiap hari</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rr_kebersihan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pertahankan kebersihan dan kerapihan linen</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rr_beritahu_pasien)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Beritahu pasien untuk melaporkan bila ada nyeri pada area yang tertekan atau kulit yang lembab</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rr_monitor_nutrisi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Monitor pemasukan nutrisi dan cairan pasien</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rr_edukasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Edukasi pasien dan keluarga pasien mengenai pencegahan dekubitus</td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($dataDecubitus->kategori_risiko == 'Risiko Sedang')
                        <div class="alert alert-warning">
                            <strong>Intervensi untuk Risiko Sedang (Skor 12-15)</strong>
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
                                        @if($dataDecubitus->rs_kaji_ulang)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lakukan pengkajian ulang (dengan skala norton) setiap shift</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_ubah_posisi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Ubah posisi pasien secara teratur, setidaknya 4 jam sekali</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_motivasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Beri motivasi pasien untuk mobilisasi seaktif mungkin</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_lotion)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Berikan lotion/ skin barrier cream untuk kulit yang kering</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_lindungi_area)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lindungi area tonjolan tulang yang berisiko untuk terjadi luka tekan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_alat_penyangga)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Gunakan alat penyangga untuk melindungi area tubuh dari tekanan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_cegah_gesekan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Cegah gesekan dengan mengangkat atau mobilisasi pasif dengan benar</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_nutrisi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Berikan nutrisi secara adekuat sesuai dengan kebutuhan pasien/ program dietnya</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_keringkan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Keringkan area yang lembab dengan segera</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_edukasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Edukasi pasien dan keluarga/ care giver pasien mengenai pencegahan dekubitus</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rs_libatkan_keluarga)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Libatkan keluarga/ care giver dalam program pencegahan dekubitus</td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($dataDecubitus->kategori_risiko == 'Risiko Tinggi')
                        <div class="alert alert-danger">
                            <strong>Intervensi untuk Risiko Tinggi (Skor < 12)</strong>
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
                                        @if($dataDecubitus->rt_kaji_ulang)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lakukan pengkajian ulang (dengan skala norton) setiap shift</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_ubah_posisi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Ubah posisi pasien secara teratur, setidaknya 1 - 2 jam sekali</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_motivasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Beri motivasi pasien untuk mobilisasi seaktif mungkin</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_lotion)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Berikan lotion/ skin barrier cream untuk kulit yang kering</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_lindungi_area)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lindungi area tonjolan tulang yang berisiko untuk terjadi luka tekan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_alat_penyangga)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Gunakan alat penyangga untuk melindungi area tubuh dari tekanan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_cegah_gesekan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Cegah gesekan dengan mengangkat atau mobilisasi pasif dengan benar</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_nutrisi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Berikan nutrisi secara adekuat sesuai dengan kebutuhan pasien/ program dietnya</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_keringkan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Keringkan area yang lembab dengan segera</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_posisi_miring)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pengaturan posisi miring 30° dengan menggunakan bantuan bantal busa</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_matras_khusus)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Gunakan matras khusus untuk terjadi luka tekan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_edukasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Edukasi pasien dan keluarga care giver mengenai pencegahan dekubitus</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataDecubitus->rt_libatkan_keluarga)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Libatkan keluarga/ care giver dalam program pencegahan dekubitus</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <!-- Informasi Petugas -->
                    <h6 class="mb-3">Informasi Petugas</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Nama Petugas</strong></td>
                            <td>{{ $dataDecubitus->userCreated->name ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            <td>{{ date('d/m/Y H:i', strtotime($dataDecubitus->created_at)) }}</td>
                        </tr>
                        @if($dataDecubitus->userUpdated)
                        <tr>
                            <td><strong>Terakhir Diupdate Oleh</strong></td>
                            <td>{{ $dataDecubitus->userUpdated->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Update</strong></td>
                            <td>{{ date('d/m/Y H:i', strtotime($dataDecubitus->updated_at)) }}</td>
                        </tr>
                        @endif
                    </table>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-inap.resiko-decubitus.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                        
                        <div>
                            <a href="{{ route('rawat-inap.resiko-decubitus.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataDecubitus->id]) }}" 
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