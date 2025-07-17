@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.status-fungsional.include')

@push('css')
    <style>
        .detail-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .detail-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 200px;
        }

        .info-value {
            font-weight: 500;
            color: #212529;
            text-align: right;
        }

        .score-display {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }

        .category-badge {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
        }

        .criteria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .criteria-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #667eea;
        }

        .criteria-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .criteria-value {
            font-size: 16px;
            font-weight: 600;
            color: #667eea;
        }

        .criteria-score {
            float: right;
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-action {
            margin: 0 5px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <!-- Tombol Kembali -->
            <div class="mb-3">
                <a href="{{ route('rawat-inap.status-fungsional.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary">
                    <i class="ti-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <!-- Header Detail -->
            <div class="detail-header">
                <h4 class="mb-2">
                    <i class="ti-clipboard mr-2"></i>
                    DETAIL PENILAIAN STATUS FUNGSIONAL
                </h4>
                <small>(BERDASARKAN PENILAIAN BARTHEL INDEX)</small>
            </div>

            <!-- Informasi Umum -->
            <div class="detail-card">
                <h5 class="mb-3">
                    <i class="ti-info mr-2 bg-info-subtle rounded-5"></i>
                    Informasi Penilaian
                </h5>
                <div class="info-item">
                    <span class="info-label">Tanggal Penilaian:</span>
                    <span class="info-value">{{ $statusFungsional->tanggal_formatted }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jam Penilaian:</span>
                    <span class="info-value">{{ $statusFungsional->jam_formatted }}</span>
                </div>                
                <div class="info-item">
                    <span class="info-label">Nilai Skor:</span>
                    <span class="info-value">{{ $statusFungsional->nilai_skor_text }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Petugas:</span>
                    <span class="info-value">{{ str()->title($statusFungsional->userCreate->name ?? 'Tidak Diketahui') }}</span>
                </div>
            </div>

            <!-- Hasil Penilaian -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="detail-card text-center">
                        <h5 class="mb-3">
                            Type
                        </h5>
                        <div class="score-display">{{ $statusFungsional->skor_total }}</div>
                        <small class="text-muted">dari 20 poin maksimal</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-card text-center">
                        <h5 class="mb-3">
                            Kategori
                        </h5>
                        <div class="mt-3">
                            @if($statusFungsional->kategori == 'Mandiri')
                                <span class="category-badge bg-success text-white">{{ $statusFungsional->kategori }}</span>
                            @elseif($statusFungsional->kategori == 'Ketergantungan Ringan')
                                <span class="category-badge bg-info text-white">{{ $statusFungsional->kategori }}</span>
                            @elseif($statusFungsional->kategori == 'Ketergantungan Sedang')
                                <span class="category-badge bg-warning text-dark">{{ $statusFungsional->kategori }}</span>
                            @elseif(in_array($statusFungsional->kategori, ['Ketergantungan Berat', 'Ketergantungan Total']))
                                <span class="category-badge bg-danger text-white">{{ $statusFungsional->kategori }}</span>
                            @else
                                <span class="category-badge bg-secondary text-white">{{ $statusFungsional->kategori }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Penilaian Kriteria -->
            <div class="detail-card">
                <h5 class="mb-4">
                    <i class="ti-list mr-2 bg-info-subtle rounded-5"></i>
                    Detail Penilaian Kriteria
                </h5>

                <div class="criteria-grid">
                    <!-- 1. BAB -->
                    <div class="criteria-item">
                        <div class="criteria-title">1. Mengendalikan rangsang defekasi (BAB)</div>
                        <div class="criteria-value">
                            @if($statusFungsional->bab == 0)
                                Tak terkendali/tak teratur (perlu pencahar)
                            @elseif($statusFungsional->bab == 1)
                                Kadang-kadang tak terkendali
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->bab }}</span>
                        </div>
                    </div>

                    <!-- 2. BAK -->
                    <div class="criteria-item">
                        <div class="criteria-title">2. Mengendalikan rangsang berkemih (BAK)</div>
                        <div class="criteria-value">
                            @if($statusFungsional->bak == 0)
                                Tak terkendali pakai kateter
                            @elseif($statusFungsional->bak == 1)
                                Kadang-kadang tak terkendali (1x 24 jam)
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->bak }}</span>
                        </div>
                    </div>

                    <!-- 3. Membersihkan Diri -->
                    <div class="criteria-item">
                        <div class="criteria-title">3. Membersihkan diri (cuci muka, sisir rambut, sikat gigi)</div>
                        <div class="criteria-value">
                            @if($statusFungsional->membersihkan_diri == 0)
                                Butuh pertolongan orang lain
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->membersihkan_diri }}</span>
                        </div>
                    </div>

                    <!-- 4. Penggunaan Jamban -->
                    <div class="criteria-item">
                        <div class="criteria-title">4. Penggunaan jamban, masuk dan keluar</div>
                        <div class="criteria-value">
                            @if($statusFungsional->penggunaan_jamban == 0)
                                Tergantung pertolongan orang lain
                            @elseif($statusFungsional->penggunaan_jamban == 1)
                                Perlu pertolongan pada beberapa kegiatan
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->penggunaan_jamban }}</span>
                        </div>
                    </div>

                    <!-- 5. Makan -->
                    <div class="criteria-item">
                        <div class="criteria-title">5. Makan</div>
                        <div class="criteria-value">
                            @if($statusFungsional->makan == 0)
                                Tidak mampu
                            @elseif($statusFungsional->makan == 1)
                                Perlu ditolong memotong makanan
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->makan }}</span>
                        </div>
                    </div>

                    <!-- 6. Berubah Sikap -->
                    <div class="criteria-item">
                        <div class="criteria-title">6. Berubah sikap dari berbaring ke duduk</div>
                        <div class="criteria-value">
                            @if($statusFungsional->berubah_sikap == 0)
                                Tidak mampu
                            @elseif($statusFungsional->berubah_sikap == 1)
                                Perlu banyak bantuan untuk bisa duduk (2 orang)
                            @elseif($statusFungsional->berubah_sikap == 2)
                                Bantuan (2 orang)
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->berubah_sikap }}</span>
                        </div>
                    </div>

                    <!-- 7. Berpindah -->
                    <div class="criteria-item">
                        <div class="criteria-title">7. Berpindah/berjalan</div>
                        <div class="criteria-value">
                            @if($statusFungsional->berpindah == 0)
                                Tidak mampu
                            @elseif($statusFungsional->berpindah == 1)
                                Bisa (pindah) dengan kursi roda
                            @elseif($statusFungsional->berpindah == 2)
                                Berjalan dengan bantuan 1 orang
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->berpindah }}</span>
                        </div>
                    </div>

                    <!-- 8. Berpakaian -->
                    <div class="criteria-item">
                        <div class="criteria-title">8. Memakai baju</div>
                        <div class="criteria-value">
                            @if($statusFungsional->berpakaian == 0)
                                Tergantung orang lain
                            @elseif($statusFungsional->berpakaian == 1)
                                Sebagian dibantu (misal mengancing baju)
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->berpakaian }}</span>
                        </div>
                    </div>

                    <!-- 9. Naik Turun Tangga -->
                    <div class="criteria-item">
                        <div class="criteria-title">9. Naik turun tangga</div>
                        <div class="criteria-value">
                            @if($statusFungsional->naik_turun_tangga == 0)
                                Tidak mampu
                            @elseif($statusFungsional->naik_turun_tangga == 1)
                                Butuh pertolongan
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->naik_turun_tangga }}</span>
                        </div>
                    </div>

                    <!-- 10. Mandi -->
                    <div class="criteria-item">
                        <div class="criteria-title">10. Mandi</div>
                        <div class="criteria-value">
                            @if($statusFungsional->mandi == 0)
                                Tergantung orang lain
                            @else
                                Mandiri
                            @endif
                            <span class="criteria-score">{{ $statusFungsional->mandi }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="detail-card">
                <h5 class="mb-3">
                    <i class="ti-info-alt mr-2 bg-info-subtle rounded-5"></i>
                    Keterangan Kategori Skor
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="badge bg-success me-2">Mandiri</span>
                                <strong>20</strong>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-info me-2">Ketergantungan Ringan</span>
                                <strong>12-19</strong>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-warning text-dark me-2">Ketergantungan Sedang</span>
                                <strong>9-11</strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="badge bg-danger me-2">Ketergantungan Berat</span>
                                <strong>5-8</strong>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-danger me-2">Ketergantungan Total</span>
                                <strong>0-4</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a href="{{ route('rawat-inap.status-fungsional.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary btn-action">
                    <i class="ti-list"></i> Daftar Data
                </a>
                <a href="{{ route('rawat-inap.status-fungsional.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $statusFungsional->id]) }}"
                    class="btn btn-warning btn-action">
                    <i class="ti-pencil"></i> Edit Data
                </a>
                <form action="{{ route('rawat-inap.status-fungsional.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $statusFungsional->id]) }}"
                    method="POST" class="d-inline-block" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-action">
                        <i class="ti-trash"></i> Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Confirm delete with SweetAlert if available
            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.')) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endpush
