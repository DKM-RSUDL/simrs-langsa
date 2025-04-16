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
                    <h5 class="mb-0">Data Asesmen Keperawatan Umum</h5>
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
                                                    {{ $asesmen->asesmenKepUmumDetail->cara_masuk ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosa Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->diagnosa_masuk ?? '-' }}
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
                                                    {{ $asesmen->anamnesis ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Tanda Vital -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>3. Tanda Vital</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tekanan Darah :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->sistole ?? '-' }}/{{ $asesmen->asesmenKepUmumDetail->diastole ?? '-' }} mmHg
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nadi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->nadi ?? '-' }} x/menit
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Respirasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->nafas ?? '-' }} x/menit
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Suhu :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->suhu ?? '-' }} °C
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">SpO2 (tanpa O2) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->spo_tanpa_o2 ?? '-' }} %
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">SpO2 (dengan O2) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->spo_dengan_o2 ?? '-' }} %
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Antropometri -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>4. Antropometri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->tinggi_badan ?? '-' }} cm
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berat Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->berat_badan ?? '-' }} kg
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Pemeriksaan Fisik -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>5. Pemeriksaan Fisik</h5>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Pemeriksaan</th>
                                                            <th>Status</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($asesmen->pemeriksaanFisik as $fisik)
                                                            <tr>
                                                                <td>{{ $fisik->itemFisik->nama ?? '' }}</td>
                                                                <td>{{ $fisik->is_normal ? 'Normal' : 'Tidak Normal' }}</td>
                                                                <td>{{ $fisik->keterangan ?? '-' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center">Tidak ada data pemeriksaan fisik</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Status Nyeri -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>6. Status Nyeri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisSkala = '';
                                                        if ($asesmen->asesmenKepUmumStatusNyeri->jenis_skala_nyeri ?? null) {
                                                            $skalaMap = [1 => 'NRS', 2 => 'FLACC', 3 => 'CRIES'];
                                                            $jenisSkala = $skalaMap[$asesmen->asesmenKepUmumStatusNyeri->jenis_skala_nyeri] ?? '-';
                                                        }
                                                    @endphp
                                                    {{ $jenisSkala }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nilai Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusNyeri->nilai_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lokasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusNyeri->lokasi ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Durasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusNyeri->durasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusNyeri->kesimpulan_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Riwayat Kesehatan -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>7. Riwayat Kesehatan</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Penyakit yang Diderita :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRiwayatKesehatan->penyakit_yang_diderita ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Kecelakaan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRiwayatKesehatan->riwayat_kecelakaan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Rawat Inap :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRiwayatKesehatan->riwayat_rawat_inap ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Operasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRiwayatKesehatan->riwayat_operasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Konsumsi Obat :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRiwayatKesehatan->konsumsi_obat ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Penyakit Keluarga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRiwayatKesehatan->riwayat_penyakit_keluarga ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Rencana Pulang -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>8. Rencana Pulang</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Medis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRencanaPulang->diagnosis_medis ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Perkiraan Lama Dirawat :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRencanaPulang->perkiraan_lama_dirawat ?? '-' }} hari
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Pulang :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRencanaPulang->rencana_pulang ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRencanaPulang->kesimpulan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Risiko Jatuh -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>9. Risiko Jatuh</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Pengkajian Risiko Jatuh :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisRisikoJatuh = '';
                                                        if ($asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? null) {
                                                            $jenisMap = [
                                                                1 => 'Umum', 
                                                                2 => 'Morse', 
                                                                3 => 'Pediatrik',
                                                                4 => 'Lansia',
                                                                5 => 'Lainnya'
                                                            ];
                                                            $jenisRisikoJatuh = $jenisMap[$asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis] ?? '-';
                                                        }
                                                    @endphp
                                                    {{ $jenisRisikoJatuh }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $kesimpulanJatuh = '';
                                                        if ($asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? null) {
                                                            switch($asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis) {
                                                                case 1:
                                                                    $kesimpulanJatuh = $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan ?? '-';
                                                                    break;
                                                                case 2:
                                                                    $kesimpulanJatuh = $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan ?? '-';
                                                                    break;
                                                                case 3:
                                                                    $kesimpulanJatuh = $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? '-';
                                                                    break;
                                                                case 4:
                                                                    $kesimpulanJatuh = $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan ?? '-';
                                                                    break;
                                                                default:
                                                                    $kesimpulanJatuh = '-';
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $kesimpulanJatuh }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 10. Risiko Dekubitus -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>10. Risiko Dekubitus</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Skala :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisDekubitus = '';
                                                        if ($asesmen->asesmenKepUmumRisikoDekubitus->jenis_skala ?? null) {
                                                            $jenisDekubitus = ($asesmen->asesmenKepUmumRisikoDekubitus->jenis_skala == 1) ? 'Norton' : 'Braden';
                                                        }
                                                    @endphp
                                                    {{ $jenisDekubitus }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 11. Status Psikologis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>11. Status Psikologis</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kondisi Psikologis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $kondisiPsikologis = [];
                                                        if ($asesmen->asesmenKepUmumStatusPsikologis->kondisi_psikologis ?? null) {
                                                            $kondisiPsikologis = json_decode($asesmen->asesmenKepUmumStatusPsikologis->kondisi_psikologis, true) ?? [];
                                                        }
                                                    @endphp
                                                    {{ !empty($kondisiPsikologis) ? implode(', ', $kondisiPsikologis) : '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Gangguan Perilaku :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $gangguanPerilaku = [];
                                                        if ($asesmen->asesmenKepUmumStatusPsikologis->gangguan_perilaku ?? null) {
                                                            $gangguanPerilaku = json_decode($asesmen->asesmenKepUmumStatusPsikologis->gangguan_perilaku, true) ?? [];
                                                        }
                                                    @endphp
                                                    {{ !empty($gangguanPerilaku) ? implode(', ', $gangguanPerilaku) : '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Potensi Menyakiti :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusPsikologis->potensi_menyakiti ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Gangguan Jiwa Keluarga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusPsikologis->keluarga_gangguan_jiwa ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. Sosial Ekonomi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>12. Sosial Ekonomi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pekerjaan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_pekerjaan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status Pernikahan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_status_pernikahan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tempat Tinggal :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_tempat_tinggal ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggal dengan Keluarga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13. Status Gizi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>13. Status Gizi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Pengkajian Gizi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisGizi = '';
                                                        if ($asesmen->asesmenKepUmumGizi->gizi_jenis ?? null) {
                                                            $giziMap = [
                                                                1 => 'MST', 
                                                                2 => 'MNA', 
                                                                3 => 'Strong Kids',
                                                                4 => 'NRS',
                                                                5 => 'Tidak Ada'
                                                            ];
                                                            $jenisGizi = $giziMap[$asesmen->asesmenKepUmumGizi->gizi_jenis] ?? '-';
                                                        }
                                                    @endphp
                                                    {{ $jenisGizi }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $kesimpulanGizi = '';
                                                        if ($asesmen->asesmenKepUmumGizi->gizi_jenis ?? null) {
                                                            switch($asesmen->asesmenKepUmumGizi->gizi_jenis) {
                                                                case 1:
                                                                    $kesimpulanGizi = $asesmen->asesmenKepUmumGizi->gizi_mst_kesimpulan ?? '-';
                                                                    break;
                                                                case 2:
                                                                    $kesimpulanGizi = $asesmen->asesmenKepUmumGizi->gizi_mna_kesimpulan ?? '-';
                                                                    break;
                                                                case 3:
                                                                    $kesimpulanGizi = $asesmen->asesmenKepUmumGizi->gizi_strong_kesimpulan ?? '-';
                                                                    break;
                                                                case 4:
                                                                    $kesimpulanGizi = $asesmen->asesmenKepUmumGizi->gizi_nrs_kesimpulan ?? '-';
                                                                    break;
                                                                default:
                                                                    $kesimpulanGizi = '-';
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $kesimpulanGizi }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 14. Status Fungsional -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>14. Status Fungsional</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Skala :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisFungsional = '';
                                                        if ($asesmen->asesmenKepUmumStatusFungsional->jenis_skala ?? null) {
                                                            $jenisFungsional = ($asesmen->asesmenKepUmumStatusFungsional->jenis_skala == 1) ? 
                                                                'Pengkajian Aktivitas' : 'Lainnya';
                                                        }
                                                    @endphp
                                                    {{ $jenisFungsional }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nilai Skala ADL :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusFungsional->nilai_skala_adl ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 15. Spiritual dan Kebutuhan Edukasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>15. Spiritual dan Kebutuhan Edukasi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Agama/Keyakinan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmum->spiritual_agama ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Gaya Bicara :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmum->kebutuhan_edukasi_gaya_bicara ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Bahasa Sehari-hari :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Perlu Penerjemah :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hambatan Komunikasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Media Belajar :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 16. Diagnosis dan Implementasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>16. Diagnosis dan Implementasi</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Banding :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $diagnosisBanding = [];
                                                        if ($asesmen->asesmenKepUmumDetail->diagnosis_banding ?? null) {
                                                            $diagnosisBanding = json_decode($asesmen->asesmenKepUmumDetail->diagnosis_banding, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($diagnosisBanding))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($diagnosisBanding as $diagnosis)
                                                                <li>{{ $diagnosis }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Kerja :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $diagnosisKerja = [];
                                                        if ($asesmen->asesmenKepUmumDetail->diagnosis_kerja ?? null) {
                                                            $diagnosisKerja = json_decode($asesmen->asesmenKepUmumDetail->diagnosis_kerja, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($diagnosisKerja))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($diagnosisKerja as $diagnosis)
                                                                <li>{{ $diagnosis }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Prognosis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $prognosis = [];
                                                        if ($asesmen->asesmenKepUmumDetail->prognosis ?? null) {
                                                            $prognosis = json_decode($asesmen->asesmenKepUmumDetail->prognosis, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($prognosis))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($prognosis as $prog)
                                                                <li>{{ $prog }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Observasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $observasi = [];
                                                        if ($asesmen->asesmenKepUmumDetail->observasi ?? null) {
                                                            $observasi = json_decode($asesmen->asesmenKepUmumDetail->observasi, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($observasi))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($observasi as $obs)
                                                                <li>{{ $obs }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Terapeutik :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $terapeutik = [];
                                                        if ($asesmen->asesmenKepUmumDetail->terapeutik ?? null) {
                                                            $terapeutik = json_decode($asesmen->asesmenKepUmumDetail->terapeutik, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($terapeutik))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($terapeutik as $terapi)
                                                                <li>{{ $terapi }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Edukasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $edukasi = [];
                                                        if ($asesmen->asesmenKepUmumDetail->edukasi ?? null) {
                                                            $edukasi = json_decode($asesmen->asesmenKepUmumDetail->edukasi, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($edukasi))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($edukasi as $edu)
                                                                <li>{{ $edu }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kolaborasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $kolaborasi = [];
                                                        if ($asesmen->asesmenKepUmumDetail->kolaborasi ?? null) {
                                                            $kolaborasi = json_decode($asesmen->asesmenKepUmumDetail->kolaborasi, true) ?? [];
                                                        }
                                                    @endphp
                                                    @if(!empty($kolaborasi))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach($kolaborasi as $kolab)
                                                                <li>{{ $kolab }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Evaluasi Keperawatan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->asesmenKepUmumDetail->evaluasi ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 17. Riwayat Alergi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>17. Riwayat Alergi</h5>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Jenis</th>
                                                            <th>Alergen</th>
                                                            <th>Reaksi</th>
                                                            <th>Tingkat Keparahan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $alergis = [];
                                                            if ($asesmen->riwayat_alergi ?? null) {
                                                                $alergis = json_decode($asesmen->riwayat_alergi, true) ?? [];
                                                            }
                                                        @endphp
                                                        @forelse($alergis as $alergi)
                                                            <tr>
                                                                <td>{{ $alergi['jenis'] ?? '-' }}</td>
                                                                <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                                                <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                                                <td>{{ $alergi['keparahan'] ?? '-' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">Tidak ada data alergi</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
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