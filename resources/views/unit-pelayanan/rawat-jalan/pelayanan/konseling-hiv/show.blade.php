@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .card-header {
                font-weight: bold;
            }

            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
                width: 30%;
            }

            .table td {
                width: 70%;
            }

            .badge {
                font-size: 0.875em;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Detail Konseling HIV</h5>
            </div>

            <hr>

            <div class="form-section">
                <!-- Informasi Umum -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Informasi Umum</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Tanggal Implementasi</th>
                                <td>{{ $konselingHiv->tgl_implementasi ? \Carbon\Carbon::parse($konselingHiv->tgl_implementasi)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jam Implementasi</th>
                                <td>{{ $konselingHiv->jam_implementasi ? \Carbon\Carbon::parse($konselingHiv->jam_implementasi)->format('H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Kunjungan</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $konselingHiv->status_kunjungan ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <th>Status Rujukan</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $konselingHiv->status_rujukan ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <th>Warga Binaan Pemasyarakatan</th>
                                <td>{{ $konselingHiv->warga_binaan ? ucfirst($konselingHiv->warga_binaan) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Petugas Input</th>
                                <td>{{ $konselingHiv->user->name ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Status Reproduksi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Status Reproduksi</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Status Kehamilan</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $konselingHiv->status_kehamilan ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <th>Umur Anak Terakhir</th>
                                <td>{{ $konselingHiv->umur_anak_terakhir ? $konselingHiv->umur_anak_terakhir . ' tahun' : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Anak Kandung</th>
                                <td>{{ $konselingHiv->jumlah_anak_kandung ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Informasi Pasangan Klien -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Informasi Pasangan Klien</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Jenis Kelamin Pasien</th>
                                <td>{{ $konselingHiv->jenis_kelamin ? ucfirst(str_replace('_', '-', $konselingHiv->jenis_kelamin)) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pasangan Tetap</th>
                                <td>{{ $konselingHiv->pasangan_tetap ? ucfirst($konselingHiv->pasangan_tetap) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kelompok Risiko</th>
                                <td>{{ $konselingHiv->kelompok_risiko ? ucfirst(str_replace('_', ' ', $konselingHiv->kelompok_risiko)) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis PS</th>
                                <td>{{ $konselingHiv->jenis_ps ? ucfirst(str_replace('_', ' ', $konselingHiv->jenis_ps)) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pasangan Perempuan</th>
                                <td>{{ $konselingHiv->pasangan_perempuan ? ucfirst($konselingHiv->pasangan_perempuan) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pasangan Hamil</th>
                                <td>{{ $konselingHiv->pasangan_hamil ? ucfirst(str_replace('_', ' ', $konselingHiv->pasangan_hamil)) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir Pasangan</th>
                                <td>{{ $konselingHiv->tgl_lahir_pasangan ? \Carbon\Carbon::parse($konselingHiv->tgl_lahir_pasangan)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status HIV Pasangan</th>
                                <td>{{ $konselingHiv->status_hiv_pasangan ? ucfirst($konselingHiv->status_hiv_pasangan) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Tes Terakhir Pasangan</th>
                                <td>{{ $konselingHiv->tgl_tes_terakhir_pasangan ? \Carbon\Carbon::parse($konselingHiv->tgl_tes_terakhir_pasangan)->format('d-m-Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Konseling Pra Tes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Konseling Pra Tes</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Tanggal Konseling Pra Tes</th>
                                <td>{{ $konselingHiv->tgl_konseling_pra_tes ? \Carbon\Carbon::parse($konselingHiv->tgl_konseling_pra_tes)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Klien</th>
                                <td>{{ $konselingHiv->status_klien ? ucfirst($konselingHiv->status_klien) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alasan Tes HIV</th>
                                <td>
                                    @if($konselingHiv->alasan_tes)
                                        @php
                                            $alasanTes = is_string($konselingHiv->alasan_tes) ? json_decode($konselingHiv->alasan_tes, true) : $konselingHiv->alasan_tes;
                                        @endphp
                                        @if($alasanTes && is_array($alasanTes))
                                            @foreach($alasanTes as $alasan)
                                                <span class="badge bg-secondary me-1">{{ ucfirst(str_replace('_', ' ', $alasan)) }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Alasan Tes Lainnya</th>
                                <td>{{ $konselingHiv->alasan_tes_lainnya ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mengetahui Tes Dari</th>
                                <td>{{ $konselingHiv->mengetahui_tes_dari ? ucfirst(str_replace('_', ' ', $konselingHiv->mengetahui_tes_dari)) : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Kajian Tingkat Risiko -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Kajian Tingkat Risiko</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Seks Vaginal Berisiko</th>
                                <td>
                                    {{ $konselingHiv->seks_vaginal_berisiko ? ucfirst($konselingHiv->seks_vaginal_berisiko) : '-' }}
                                    @if($konselingHiv->seks_vaginal_berisiko == 'ya' && $konselingHiv->seks_vaginal_kapan)
                                        ({{ $konselingHiv->seks_vaginal_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Anal Seks Berisiko</th>
                                <td>
                                    {{ $konselingHiv->anal_seks_berisiko ? ucfirst($konselingHiv->anal_seks_berisiko) : '-' }}
                                    @if($konselingHiv->anal_seks_berisiko == 'ya' && $konselingHiv->anal_seks_kapan)
                                        ({{ $konselingHiv->anal_seks_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Bergantian Suntik</th>
                                <td>
                                    {{ $konselingHiv->bergantian_suntik ? ucfirst($konselingHiv->bergantian_suntik) : '-' }}
                                    @if($konselingHiv->bergantian_suntik == 'ya' && $konselingHiv->bergantian_suntik_kapan)
                                        ({{ $konselingHiv->bergantian_suntik_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Transfusi Darah</th>
                                <td>
                                    {{ $konselingHiv->transfusi_darah ? ucfirst($konselingHiv->transfusi_darah) : '-' }}
                                    @if($konselingHiv->transfusi_darah == 'ya' && $konselingHiv->transfusi_darah_kapan)
                                        ({{ $konselingHiv->transfusi_darah_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Transmisi Ibu ke Anak</th>
                                <td>
                                    {{ $konselingHiv->transmisi_ibu_anak ? ucfirst($konselingHiv->transmisi_ibu_anak) : '-' }}
                                    @if($konselingHiv->transmisi_ibu_anak == 'ya' && $konselingHiv->transmisi_ibu_anak_kapan)
                                        ({{ $konselingHiv->transmisi_ibu_anak_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Lainnya</th>
                                <td>
                                    {{ $konselingHiv->lainnya_risiko ?? '-' }}
                                    @if($konselingHiv->lainnya_risiko && $konselingHiv->lainnya_risiko_kapan)
                                        ({{ $konselingHiv->lainnya_risiko_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Periode Jendela</th>
                                <td>
                                    {{ $konselingHiv->periode_jendela ? ucfirst($konselingHiv->periode_jendela) : '-' }}
                                    @if($konselingHiv->periode_jendela == 'ya' && $konselingHiv->periode_jendela_kapan)
                                        ({{ $konselingHiv->periode_jendela_kapan }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Kesediaan untuk Tes</th>
                                <td>{{ $konselingHiv->kesediaan_tes ? ucfirst($konselingHiv->kesediaan_tes) : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Riwayat Tes HIV -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Riwayat Tes HIV Sebelumnya</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Pernah Tes HIV</th>
                                <td>{{ $konselingHiv->pernah_tes_hiv ? ucfirst($konselingHiv->pernah_tes_hiv) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Dimana</th>
                                <td>{{ $konselingHiv->pernah_tes_dimana ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kapan</th>
                                <td>{{ $konselingHiv->pernah_tes_kapan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hasil Tes Sebelumnya</th>
                                <td>{{ $konselingHiv->hasil_tes_sebelumnya ? ucfirst(str_replace('_', ' ', $konselingHiv->hasil_tes_sebelumnya)) : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Status HIV Pasangan -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Status HIV Pasangan</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Bagaimana Status HIV Pasangan</th>
                                <td>{{ $konselingHiv->bagaimana_status_hiv_pasangan ? ucfirst(str_replace('_', ' ', $konselingHiv->bagaimana_status_hiv_pasangan)) : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Konseling Pasca Tes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Konseling Pasca Tes</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Tanggal Konseling Pasca Tes</th>
                                <td>{{ $konselingHiv->tgl_konseling_pasca_tes ? \Carbon\Carbon::parse($konselingHiv->tgl_konseling_pasca_tes)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Terima Hasil</th>
                                <td>{{ $konselingHiv->terima_hasil ? ucfirst($konselingHiv->terima_hasil) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kaji Gejala TB</th>
                                <td>{{ $konselingHiv->kaji_gejala_tb ? ucfirst($konselingHiv->kaji_gejala_tb) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Kondom Diberikan</th>
                                <td>{{ $konselingHiv->jumlah_kondom ? $konselingHiv->jumlah_kondom . ' buah' : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tindak Lanjut KTS</th>
                                <td>
                                    @if($konselingHiv->tindak_lanjut_kts)
                                        @php
                                            $tindakLanjutKts = is_string($konselingHiv->tindak_lanjut_kts) ? json_decode($konselingHiv->tindak_lanjut_kts, true) : $konselingHiv->tindak_lanjut_kts;
                                        @endphp
                                        @if($tindakLanjutKts && is_array($tindakLanjutKts))
                                            @foreach($tindakLanjutKts as $tindak)
                                                <span class="badge bg-info me-1">{{ ucfirst(str_replace('_', ' ', $tindak)) }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Konselor</th>
                                <td>{{ $konselingHiv->nama_konselor ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Layanan</th>
                                <td>{{ $konselingHiv->status_layanan ? ucfirst(str_replace('_', ' ', $konselingHiv->status_layanan)) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pelayanan</th>
                                <td>{{ $konselingHiv->jenis_pelayanan ? ucfirst(str_replace('_', ' ', $konselingHiv->jenis_pelayanan)) : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Informasi Lainnya</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Nomor Registrasi PDP</th>
                                <td>{{ $konselingHiv->nomor_registrasi_pdp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk PDP</th>
                                <td>{{ $konselingHiv->tgl_masuk_pdp ? \Carbon\Carbon::parse($konselingHiv->tgl_masuk_pdp)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tindak Lanjut</th>
                                <td>
                                    @if($konselingHiv->tindak_lanjut)
                                        @php
                                            $tindakLanjut = is_string($konselingHiv->tindak_lanjut) ? json_decode($konselingHiv->tindak_lanjut, true) : $konselingHiv->tindak_lanjut;
                                        @endphp
                                        @if($tindakLanjut && is_array($tindakLanjut))
                                            @foreach($tindakLanjut as $tindak)
                                                <span class="badge bg-warning me-1">{{ ucfirst(str_replace('_', ' ', $tindak)) }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('rawat-jalan.konseling-hiv.edit', [$konselingHiv->kd_unit, $konselingHiv->kd_pasien, $konselingHiv->tgl_masuk, $konselingHiv->urut_masuk, $konselingHiv->id]) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('rawat-jalan.konseling-hiv.index', [$konselingHiv->kd_unit, $konselingHiv->kd_pasien, $konselingHiv->tgl_masuk, $konselingHiv->urut_masuk]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection