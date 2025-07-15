@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengkajian Resiko Jatuh Skala Humpty Dumpty</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Informasi Dasar -->
                    <h6 class="mb-3">Informasi Dasar</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Implementasi</strong></td>
                            <td>{{ date('d/m/Y', strtotime($dataHumptyDumpty->tanggal_implementasi)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Implementasi</strong></td>
                            <td>{{ date('H:i', strtotime($dataHumptyDumpty->jam_implementasi)) }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Shift</strong></td>
                            <td><span class="badge bg-secondary">{{ ucfirst($dataHumptyDumpty->shift) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Total Skor</strong></td>
                            <td><h5 class="mb-0">{{ $dataHumptyDumpty->total_skor }}</h5></td>
                        </tr>
                        <tr>
                            <td><strong>Kategori Risiko</strong></td>
                            <td>
                                @if($dataHumptyDumpty->kategori_risiko == 'Risiko Rendah')
                                    <span class="badge bg-success">{{ $dataHumptyDumpty->kategori_risiko }}</span>
                                @elseif($dataHumptyDumpty->kategori_risiko == 'Risiko Tinggi')
                                    <span class="badge bg-danger">{{ $dataHumptyDumpty->kategori_risiko }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $dataHumptyDumpty->kategori_risiko }}</span>
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
                            <tr>
                                <td><strong>Usia</strong></td>
                                <td>
                                    @if($dataHumptyDumpty->usia == 4)
                                        &lt;3 tahun
                                    @elseif($dataHumptyDumpty->usia == 3)
                                        3 sampai 7 tahun
                                    @elseif($dataHumptyDumpty->usia == 2)
                                        7 sampai 13 tahun
                                    @else
                                        &gt;13 tahun
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->usia }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>{{ $dataHumptyDumpty->jenis_kelamin == 2 ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->jenis_kelamin }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Diagnosis</strong></td>
                                <td>
                                    @if($dataHumptyDumpty->diagnosis == 3)
                                        Perubahan oksigenasi (diagnosis respiratorik, dehidrasi, anemia, syncope, pusing)
                                    @elseif($dataHumptyDumpty->diagnosis == 2)
                                        Gangguan perilaku / psikiatri
                                    @else
                                        Diagnosis lainnya
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->diagnosis }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Gangguan Kognitif</strong></td>
                                <td>
                                    @if($dataHumptyDumpty->gangguan_kognitif == 3)
                                        Tidak menyadari keterbatasan dirinya
                                    @elseif($dataHumptyDumpty->gangguan_kognitif == 2)
                                        Lupa akan adanya keterbatasan
                                    @else
                                        Orientasi baik terhadap diri sendiri
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->gangguan_kognitif }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Faktor Lingkungan</strong></td>
                                <td>
                                    @if($dataHumptyDumpty->faktor_lingkungan == 4)
                                        Riwayat jatuh / bayi diletakkan di tempat tidur dewasa
                                    @elseif($dataHumptyDumpty->faktor_lingkungan == 3)
                                        Pasien menggunakan alat bantu / bayi diletakkan di tempat tidur bayi / perabot rumah
                                    @elseif($dataHumptyDumpty->faktor_lingkungan == 2)
                                        Pasien diletakkan di tempat tidur
                                    @else
                                        Area diluar rumah
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->faktor_lingkungan }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Pembedahan/Sedasi/Anestesi</strong></td>
                                <td>
                                    @if($dataHumptyDumpty->pembedahan_sedasi == 3)
                                        Dalam 24 jam
                                    @elseif($dataHumptyDumpty->pembedahan_sedasi == 2)
                                        Dalam 48 jam
                                    @else
                                        &gt;48 jam atau tidak menjalani pembedahan/sedasi/anestesi
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->pembedahan_sedasi }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Penggunaan Medikamentosa</strong></td>
                                <td>
                                    @if($dataHumptyDumpty->penggunaan_medikamentosa == 3)
                                        Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose
                                    @elseif($dataHumptyDumpty->penggunaan_medikamentosa == 2)
                                        Penggunaan salah satu obat di atas
                                    @else
                                        Penggunaan medikasi lainnya/tidak ada medikasi
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-primary">{{ $dataHumptyDumpty->penggunaan_medikamentosa }}</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Intervensi -->
                    <h6 class="mb-3">Intervensi Pencegahan Jatuh</h6>
                    @if($dataHumptyDumpty->kategori_risiko == 'Risiko Rendah')
                        <div class="alert alert-success">
                            <strong>Intervensi untuk Risiko Rendah</strong>
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
                                        @if($dataHumptyDumpty->observasi_ambulasi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tingkatkan observasi bantuan yang sesuai saat ambulasi</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->orientasi_kamar_mandi)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tunjukkan lokasi kamar mandi</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->orientasi_bertahap)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Jika pasien linglung, orientasi dilaksanakan bertahap</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->tempatkan_bel)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tempatkan bel ditempat yang mudah dicapai</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->instruksi_bantuan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->pagar_pengaman)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/ tangan tidak tersangkut</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->tempat_tidur_rendah)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tempat tidur dalam posisi rendah dan terkunci</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->edukasi_perilaku)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Edukasi perilaku yang lebih aman saat jatuh atau transfer</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->monitor_berkala)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->anjuran_kaus_kaki)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->lantai_antislip)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lantai kamar mandi dengan karpet antislip, tidak licin</td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($dataHumptyDumpty->kategori_risiko == 'Risiko Tinggi')
                        <div class="alert alert-danger">
                            <strong>Intervensi untuk Risiko Tinggi</strong>
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
                                        @if($dataHumptyDumpty->semua_intervensi_rendah)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Lakukan SEMUA intervensi jatuh resiko rendah / standar</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->gelang_kuning)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pakailah gelang risiko jatuh berwarna kuning</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->pasang_gambar)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->tanda_daftar_nama)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna kuning)</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->pertimbangkan_obat)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->alat_bantu_jalan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Gunakan alat bantu jalan (walker, handrail)</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->pintu_terbuka)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Biarkan pintu ruangan terbuka kecuali untuk tujuan isolasi</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->jangan_tinggalkan)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->dekat_nurse_station)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->bed_posisi_rendah)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Posisi Bed atur ke posisi paling rendah</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if($dataHumptyDumpty->edukasi_keluarga)
                                            <span class="badge bg-success">✓</span>
                                        @else
                                            <span class="badge bg-danger">✗</span>
                                        @endif
                                    </td>
                                    <td>Edukasi pasien/ keluarga yang harus diperhatikan sesuai protokol</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <!-- Informasi Petugas -->
                    <h6 class="mb-3">Informasi Petugas</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Nama Petugas</strong></td>
                            <td>{{ $dataHumptyDumpty->userCreated->name ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Username</strong></td>
                            <td>{{ $dataHumptyDumpty->userCreated->username ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Pada</strong></td>
                            <td>{{ date('d/m/Y H:i', strtotime($dataHumptyDumpty->created_at)) }} WIB</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                        
                        <div>
                            <a href="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataHumptyDumpty->id]) }}" 
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