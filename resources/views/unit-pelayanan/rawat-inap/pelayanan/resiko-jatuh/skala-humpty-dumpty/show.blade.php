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
                    'title' => 'Rincian Pengkajian Resiko Jatuh - Humpty Dumpty',
                    'description' => 'Rincian data pengkajian resiko jatuh - Humpty Dumpty pasien rawat inap.',
                ])

                <!-- Informasi Dasar -->
                <div class="row">
                    <div class="col-md-4">
                        <dt class="form-label fw-bold">Tanggal</dt>
                        <div class="form-control-plaintext bg-light p-2 rounded">
                            {{ date('d/m/Y', strtotime($dataHumptyDumpty->tanggal_implementasi)) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <dt class="form-label fw-bold">Jam</dt>
                        <div class="form-control-plaintext bg-light p-2 rounded">
                            {{ date('H:i', strtotime($dataHumptyDumpty->jam_implementasi)) }} WIB
                        </div>
                    </div>
                    <div class="col-md-4">
                        <dt class="form-label fw-bold">Shift</dt>
                        <div class="form-control-plaintext bg-light p-2 rounded">
                            {{ ucfirst($dataHumptyDumpty->shift) }}
                        </div>
                    </div>
                </div>

                <!-- Detail Penilaian -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="ti-list-ol me-2"></i> Detail Penilaian</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Jawaban</th>
                                        <th class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>1. Usia</strong></td>
                                        <td>
                                            @if ($dataHumptyDumpty->usia == 4)
                                                &lt;3 tahun
                                            @elseif($dataHumptyDumpty->usia == 3)
                                                3 sampai 7 tahun
                                            @elseif($dataHumptyDumpty->usia == 2)
                                                7 sampai 13 tahun
                                            @else
                                                &gt;13 tahun
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dataHumptyDumpty->usia }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>2. Jenis Kelamin</strong></td>
                                        <td>{{ $dataHumptyDumpty->jenis_kelamin == 2 ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td class="text-center">{{ $dataHumptyDumpty->jenis_kelamin }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>3. Diagnosis</strong></td>
                                        <td>
                                            @if ($dataHumptyDumpty->diagnosis == 3)
                                                Perubahan oksigenasi (respiratori, dehidrasi, anemia, syncope, pusing)
                                            @elseif($dataHumptyDumpty->diagnosis == 2)
                                                Gangguan perilaku / psikiatri
                                            @else
                                                Diagnosis lainnya
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dataHumptyDumpty->diagnosis }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>4. Gangguan Kognitif</strong></td>
                                        <td>
                                            @if ($dataHumptyDumpty->gangguan_kognitif == 3)
                                                Tidak menyadari keterbatasan dirinya
                                            @elseif($dataHumptyDumpty->gangguan_kognitif == 2)
                                                Lupa akan adanya keterbatasan
                                            @else
                                                Orientasi baik terhadap diri sendiri
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dataHumptyDumpty->gangguan_kognitif }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>5. Faktor Lingkungan</strong></td>
                                        <td>
                                            @if ($dataHumptyDumpty->faktor_lingkungan == 4)
                                                Riwayat jatuh / bayi diletakkan di tempat tidur dewasa
                                            @elseif($dataHumptyDumpty->faktor_lingkungan == 3)
                                                Pasien menggunakan alat bantu / bayi diletakkan di tempat tidur bayi /
                                                perabot rumah
                                            @elseif($dataHumptyDumpty->faktor_lingkungan == 2)
                                                Pasien diletakkan di tempat tidur
                                            @else
                                                Area diluar rumah
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dataHumptyDumpty->faktor_lingkungan }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>6. Pembedahan / Sedasi / Anestesi</strong></td>
                                        <td>
                                            @if ($dataHumptyDumpty->pembedahan_sedasi == 3)
                                                Dalam 24 jam
                                            @elseif($dataHumptyDumpty->pembedahan_sedasi == 2)
                                                Dalam 48 jam
                                            @else
                                                &gt;48 jam atau tidak menjalani pembedahan/sedasi/anestesi
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dataHumptyDumpty->pembedahan_sedasi }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>7. Penggunaan Medikamentosa</strong></td>
                                        <td>
                                            @if ($dataHumptyDumpty->penggunaan_medikamentosa == 3)
                                                Penggunaan multiple (sedative, hipnosis, antidepresan, obat pencahar, dll)
                                            @elseif($dataHumptyDumpty->penggunaan_medikamentosa == 2)
                                                Penggunaan salah satu obat di atas
                                            @else
                                                Penggunaan medikasi lainnya / tidak ada medikasi
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dataHumptyDumpty->penggunaan_medikamentosa }}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-warning">
                                    <tr>
                                        <th colspan="2" class="text-center">TOTAL SKOR</th>
                                        <th class="text-center">{{ $dataHumptyDumpty->total_skor }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hasil & Kategori -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <label class="form-label fw-bold">Skor Total</label>
                                <div class="form-control-plaintext fs-2 fw-bold">{{ $dataHumptyDumpty->total_skor }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <label class="form-label fw-bold">Kategori Risiko</label>
                                <div class="form-control-plaintext fs-2 fw-bold">
                                    @if ($dataHumptyDumpty->kategori_risiko == 'Risiko Rendah')
                                        <span class="badge bg-success">RESIKO RENDAH</span>
                                    @elseif($dataHumptyDumpty->kategori_risiko == 'Risiko Tinggi')
                                        <span class="badge bg-danger">RESIKO TINGGI</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $dataHumptyDumpty->kategori_risiko }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Intervensi (kumulatif: Tinggi => Low+High, Rendah => Low only) -->
                @php
                    $kat = $dataHumptyDumpty->kategori_risiko;
                    $lowMap = [
                        'observasi_ambulasi' => 'Tingkatkan observasi bantuan yang sesuai saat ambulasi',
                        'orientasi_kamar_mandi' => 'Tunjukkan lokasi kamar mandi',
                        'orientasi_bertahap' => 'Jika pasien linglung, orientasi dilaksanakan bertahap',
                        'tempatkan_bel' => 'Tempatkan bel di tempat yang mudah dicapai',
                        'instruksi_bantuan' => 'Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur',
                        'pagar_pengaman' =>
                            'Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/tangan tidak tersangkut',
                        'tempat_tidur_rendah' => 'Tempat tidur dalam posisi rendah dan terkunci',
                        'edukasi_perilaku' => 'Edukasi perilaku yang lebih aman saat jatuh atau transfer',
                        'monitor_berkala' => 'Monitor kebutuhan pasien secara berkala (minimal tiap 2 jam)',
                        'anjuran_kaus_kaki' => 'Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin',
                        'lantai_antislip' => 'Lantai kamar mandi dengan karpet antislip, tidak licin',
                    ];

                    $highMap = [
                        'semua_intervensi_rendah' => 'Lakukan SEMUA intervensi jatuh resiko rendah / standar',
                        'gelang_kuning' => 'Pakailah gelang risiko jatuh berwarna kuning',
                        'pasang_gambar' =>
                            'Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien',
                        'tanda_daftar_nama' =>
                            'Tempatkan tanda risiko pasien jatuh pada daftar nama pasien (warna kuning)',
                        'pertimbangkan_obat' =>
                            'Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan',
                        'alat_bantu_jalan' => 'Gunakan alat bantu jalan (walker, handrail)',
                        'pintu_terbuka' => 'Biarkan pintu ruangan terbuka kecuali untuk tujuan isolasi',
                        'jangan_tinggalkan' => 'Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan',
                        'dekat_nurse_station' =>
                            'Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)',
                        'bed_posisi_rendah' => 'Posisi Bed atur ke posisi paling rendah',
                        'edukasi_keluarga' => 'Edukasi pasien/keluarga yang harus diperhatikan sesuai protokol',
                    ];
                @endphp

                {{-- Low interventions (show for both rendah & tinggi) --}}
                @if (in_array($kat, ['Risiko Rendah', 'Risiko Tinggi']))
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="text-success mb-3"><i class="ti-shield me-2"></i> Intervensi — Risiko Rendah</h6>
                            @php $hasLow = false; @endphp
                            <ul class="list-group">
                                @foreach ($lowMap as $field => $label)
                                    @if (!empty($dataHumptyDumpty->$field))
                                        @php $hasLow = true; @endphp
                                        <li class="list-group-item">
                                            <i class="ti-check text-success me-2"></i> {!! $label !!}
                                        </li>
                                    @endif
                                @endforeach
                                @unless ($hasLow)
                                    <li class="list-group-item text-muted">Tidak ada intervensi rendah yang dipilih</li>
                                @endunless
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- High interventions (show only for Tinggi) --}}
                @if ($kat === 'Risiko Tinggi')
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="text-danger mb-3"><i class="ti-alert me-2"></i> Intervensi — Risiko Tinggi</h6>
                            @php $hasHigh = false; @endphp
                            <ul class="list-group">
                                @foreach ($highMap as $field => $label)
                                    @if (!empty($dataHumptyDumpty->$field))
                                        @php $hasHigh = true; @endphp
                                        <li class="list-group-item">
                                            <i class="ti-check text-danger me-2"></i> {!! $label !!}
                                        </li>
                                    @endif
                                @endforeach
                                @unless ($hasHigh)
                                    <li class="list-group-item text-muted">Tidak ada intervensi tinggi yang dipilih</li>
                                @endunless
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Informasi Petugas -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Informasi Petugas</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Nama Petugas:</strong>
                                    {{ $dataHumptyDumpty->userCreated->name ?? 'Unknown' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div><strong>Dibuat Pada:</strong>
                                    {{ date('d/m/Y H:i', strtotime($dataHumptyDumpty->created_at)) }} WIB</div>
                            </div>
                        </div>
                    </div>
                </div>

            </x-content-card>
        </div>
    </div>
@endsection
