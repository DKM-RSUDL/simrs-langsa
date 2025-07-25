@extends('layouts.administrator.master')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.persetujuan-transfusi-darah.include')

@push('css')
    <style>
        .detail-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .detail-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 18px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .detail-title i {
            margin-right: 10px;
            width: 25px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
            width: 200px;
            flex-shrink: 0;
            margin-right: 15px;
        }

        .detail-value {
            color: #555;
            flex: 1;
            word-wrap: break-word;
        }

        .detail-value.empty {
            color: #999;
            font-style: italic;
        }

        .badge {
            font-size: 0.85rem;
            padding: 5px 12px;
        }

        .signature-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .signature-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .signature-name {
            font-weight: 600;
            color: #0066cc;
            margin-top: 10px;
            min-height: 20px;
        }

        .header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            text-align: center;
        }

        .hospital-info {
            font-size: 14px;
            margin-top: 15px;
            opacity: 0.9;
        }

        .consent-card {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 2px solid #ffc107;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
        }

        .consent-title {
            color: #856404;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .info-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 2px solid #2196f3;
            border-radius: 15px;
            padding: 25px;
        }

        .info-title {
            color: #0d47a1;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-list {
            margin: 0;
            padding-left: 20px;
        }

        .info-list li {
            margin-bottom: 8px;
            color: #1976d2;
        }

        .section-divider {
            border-top: 3px solid #667eea;
            margin: 30px 0;
            opacity: 0.3;
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .data-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .data-item-label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .data-item-value {
            color: #555;
            font-size: 15px;
        }

        .timestamp-info {
            background: #e8f5e8;
            border: 1px solid #4caf50;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .timestamp-label {
            font-weight: 600;
            color: #2e7d32;
            font-size: 14px;
        }

        .timestamp-value {
            color: #388e3c;
            font-size: 13px;
        }

        .btn-action {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .print-button {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            border: none;
            color: white;
        }

        @media print {

            .btn-action,
            .d-flex,
            .mb-3 {
                display: none !important;
            }

            .detail-card {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
        }

        @media (max-width: 768px) {
            .detail-label {
                width: 150px;
                font-size: 14px;
            }

            .detail-value {
                font-size: 14px;
            }

            .data-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .signature-box {
                padding: 15px;
                margin-bottom: 15px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <!-- Action Buttons -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('persetujuan-transfusi-darah.index', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary btn-action">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('persetujuan-transfusi-darah.edit', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $persetujuan->id]) }}"
                        class="btn btn-warning btn-action">
                        <i class="ti-pencil"></i> Edit
                    </a>
                    <a href="{{ route('persetujuan-transfusi-darah.print-pdf', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $persetujuan->id]) }}"
                        class="btn print-button btn-action" target="_blank">
                        <i class="ti-printer"></i> Print
                    </a>
                    <a href="{{ asset('assets/file/F.3_persetujuan_transfusi_darah.pdf') }}" class="btn btn-info btn-action"
                        target="_blank" rel="noopener noreferrer">
                        <i class="ti-file-text"></i> Form Edukasi
                    </a>
                </div>
            </div>

            <!-- Header -->
            <div class="header-card">
                <h5 class="mb-3">
                    <i class="ti-clipboard"></i> PERSETUJUAN TRANSFUSI DARAH/PRODUK DARAH
                </h5>
            </div>

            <!-- Data Dasar -->
            <div class="detail-card">
                <div class="detail-title">
                    <i class="ti-calendar"></i> Data Dasar
                </div>
                <div class="data-grid">
                    <div class="data-item">
                        <div class="data-item-label">Tanggal</div>
                        <div class="data-item-value">
                            {{ $persetujuan->tanggal ? $persetujuan->tanggal->format('d/m/Y') : '-' }}</div>
                    </div>
                    <div class="data-item">
                        <div class="data-item-label">Jam</div>
                        <div class="data-item-value">
                            {{ $persetujuan->jam ? date('H:i', strtotime($persetujuan->jam)) : '-' }}</div>
                    </div>
                    <div class="data-item">
                        <div class="data-item-label">Persetujuan Untuk</div>
                        <div class="data-item-value">
                            @if($persetujuan->persetujuan_untuk === 'diri_sendiri')
                                <span class="badge bg-info">Diri Sendiri</span>
                            @else
                                <span class="badge bg-warning">Keluarga/Wali</span>
                            @endif
                        </div>
                    </div>
                    <div class="data-item">
                        <div class="data-item-label">Diagnosa</div>
                        <div class="data-item-value">{{ $persetujuan->diagnosa ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Keluarga jika ada -->
            @if($persetujuan->persetujuan_untuk === 'keluarga')
                <div class="detail-card">
                    <div class="detail-title">
                        <i class="fas fa-user-check"></i> Data Keluarga/Wali
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Nama Lengkap:</div>
                                <div class="detail-value">{{ $persetujuan->nama_keluarga ?: '-' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Tanggal Lahir:</div>
                                <div class="detail-value">
                                    {{ $persetujuan->tgl_lahir_keluarga ? $persetujuan->tgl_lahir_keluarga->format('d/m/Y') : '-' }}
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Jenis Kelamin:</div>
                                <div class="detail-value">
                                    @if($persetujuan->jk_keluarga !== null)
                                        {{ $persetujuan->jk_keluarga == 1 ? 'Laki-laki' : 'Perempuan' }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">No. Telepon:</div>
                                <div class="detail-value">{{ $persetujuan->no_telp_keluarga ?: '-' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">No. KTP/SIM:</div>
                                <div class="detail-value">{{ $persetujuan->no_ktp_keluarga ?: '-' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Hubungan:</div>
                                <div class="detail-value">{{ $persetujuan->hubungan_keluarga ?: '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Alamat:</div>
                        <div class="detail-value">{{ $persetujuan->alamat_keluarga ?: '-' }}</div>
                    </div>
                </div>
            @endif

            <!-- Informasi Edukasi -->
            <div class="info-card">
                <div class="info-title">
                    <i class="ti-info-alt"></i> Informasi Edukasi
                </div>
                <p class="mb-3">Telah membaca atau dibacakan keterangan pada <strong>form edukasi transfusi darah</strong>
                    (di halaman belakang) dan telah
                    dijelaskan hal-hal terkait mengenai prosedur transfusi darah yang akan dilakukan terhadap diri saya
                    sendiri /
                    pihak yang saya wakili *), sehingga saya :
                </p>
                <ul class="info-list">
                    <li>Memahami alasan saya / pihak yang saya wakili memerlukan darah dan produk darah</li>
                    <li>Memahami risiko yang mungkin terjadi saat atau sesudah pelaksanaan pemberian darah dan produk darah</li>
                    <li>Memahami alternatif pemberian darah dan produk darah</li>
                </ul>
            </div>

            <!-- Data Dokter -->
            <div class="detail-card">
                <div class="detail-title">
                    <i class="ti-user"></i> Data Dokter
                </div>
                <div class="data-grid">
                    <div class="data-item">
                        <div class="data-item-label">Nama Dokter</div>
                        <div class="data-item-value">
                            {{ $persetujuan->dokter ? $dokter->where('kd_dokter', $persetujuan->dokter)->first()->nama_lengkap ?? 'Tidak ada dokter dipilih' : 'Tidak ada dokter dipilih' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Saksi -->
            <div class="detail-card">
                <div class="detail-title">
                    <i class="ti-users"></i> Data Saksi
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3"><i class="ti-user-check"></i> Saksi 1</h6>
                        <div class="detail-row">
                            <div class="detail-label">Nama:</div>
                            <div class="detail-value">{{ $persetujuan->nama_saksi1 ?: '-' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Lahir:</div>
                            <div class="detail-value">
                                {{ $persetujuan->tgl_lahir_saksi1 ? $persetujuan->tgl_lahir_saksi1->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Jenis Kelamin:</div>
                            <div class="detail-value">
                                @if($persetujuan->jk_saksi1 !== null)
                                    {{ $persetujuan->jk_saksi1 == 1 ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No. Telepon:</div>
                            <div class="detail-value">{{ $persetujuan->no_telp_saksi1 ?: '-' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No. KTP/SIM:</div>
                            <div class="detail-value">{{ $persetujuan->no_ktp_saksi1 ?: '-' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alamat:</div>
                            <div class="detail-value">{{ $persetujuan->alamat_saksi1 ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3"><i class="ti-user-check"></i> Saksi 2</h6>
                        <div class="detail-row">
                            <div class="detail-label">Nama:</div>
                            <div class="detail-value">{{ $persetujuan->nama_saksi2 ?: '-' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Lahir:</div>
                            <div class="detail-value">
                                {{ $persetujuan->tgl_lahir_saksi2 ? $persetujuan->tgl_lahir_saksi2->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Jenis Kelamin:</div>
                            <div class="detail-value">
                                @if($persetujuan->jk_saksi2 !== null)
                                    {{ $persetujuan->jk_saksi2 == 1 ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No. Telepon:</div>
                            <div class="detail-value">{{ $persetujuan->no_telp_saksi2 ?: '-' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No. KTP/SIM:</div>
                            <div class="detail-value">{{ $persetujuan->no_ktp_saksi2 ?: '-' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alamat:</div>
                            <div class="detail-value">{{ $persetujuan->alamat_saksi2 ?: '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Persetujuan -->
            <div class="consent-card">
                <div class="consent-title">
                    <i class="ti-help"></i> Persetujuan Transfusi Darah
                </div>
                <h5 class="mb-3">Apakah Anda menyetujui pemberian darah dan produk darah?</h5>
                <div class="mt-3">
                    @if($persetujuan->persetujuan === 'setuju')
                        <span class="badge bg-success fs-6 px-4 py-2">
                            <i class="ti-check"></i> YA, SETUJU
                        </span>
                    @else
                        <span class="badge bg-danger fs-6 px-4 py-2">
                            <i class="ti-close"></i> TIDAK SETUJU
                        </span>
                    @endif
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="detail-card">
                <div class="detail-title">
                    <i class="ti-pencil"></i> Tanda Tangan
                </div>
                <p><strong>Atas pemberian darah dan produk darah terhadap diri saya sendiri / pihak yang saya
                        wakili.</strong></p>
                <p class="mb-4">Yang bertanda tangan di bawah ini:</p>

                <div class="row">
                    <div class="col-md-3">
                        <div class="signature-box">
                            <strong><i class="ti-user"></i> Yang Menyatakan</strong>
                            <div class="signature-name">{{ $persetujuan->yang_menyatakan ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="signature-box">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="ti-user"></i> Dokter
                                </h5>
                                <div class="signature-name">
                                    {{ $persetujuan->dokter ? $dokter->where('kd_dokter', $persetujuan->dokter)->first()->nama_lengkap ?? 'Tidak ada dokter dipilih' : 'Tidak ada dokter dipilih' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="signature-box">
                            <strong><i class="ti-user-check"></i> Saksi 1</strong>
                            <div class="signature-name">{{ $persetujuan->nama_saksi1 ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="signature-box">
                            <strong><i class="ti-user-check"></i> Saksi 2</strong>
                            <div class="signature-name">{{ $persetujuan->nama_saksi2 ?: '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Petugas -->
            <div class="detail-card">
                <div class="detail-title">
                    <i class="ti-info"></i> Informasi Petugas
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="timestamp-info">
                            <div class="timestamp-label">
                                <i class="ti-user-plus"></i> Dibuat Oleh
                            </div>
                            <div class="timestamp-value">
                                <strong>{{ $persetujuan->userCreate->name ?? 'Tidak Diketahui' }}</strong><br>
                                @if($persetujuan->created_at)
                                    {{ $persetujuan->created_at->format('d/m/Y H:i:s') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($persetujuan->userEdit)
                            <div class="timestamp-info" style="background: #fff3cd; border-color: #ffc107;">
                                <div class="timestamp-label" style="color: #856404;">
                                    <i class="ti-edit"></i> Terakhir Diubah
                                </div>
                                <div class="timestamp-value" style="color: #856404;">
                                    <strong>{{ $persetujuan->userEdit->name ?? 'Tidak Diketahui' }}</strong><br>
                                    @if($persetujuan->updated_at)
                                        {{ $persetujuan->updated_at->format('d/m/Y H:i:s') }}
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="timestamp-info" style="background: #f0f0f0; border-color: #ccc;">
                                <div class="timestamp-label" style="color: #666;">
                                    <i class="ti-info"></i> Status
                                </div>
                                <div class="timestamp-value" style="color: #666;">
                                    Belum pernah diubah
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@push('js')
    <script>
        // Print functionality
        function printDocument() {
            window.print();
        }

        // Auto-hide alerts after 5 seconds (if any)
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);

        document.addEventListener('DOMContentLoaded', function () {
            // Add smooth scrolling for better UX
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Enhance signature boxes with hover effects
            const signatureBoxes = document.querySelectorAll('.signature-box');
            signatureBoxes.forEach(box => {
                box.addEventListener('mouseenter', function () {
                    this.style.borderColor = '#667eea';
                    this.style.borderWidth = '3px';
                });

                box.addEventListener('mouseleave', function () {
                    this.style.borderColor = '#667eea';
                    this.style.borderWidth = '2px';
                });
            });
        });
    </script>
@endpush
