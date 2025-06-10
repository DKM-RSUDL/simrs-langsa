@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .body-diagram-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .drawing-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            min-height: 400px;
            overflow: hidden;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .canvas-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto;
            background-color: white;
        }

        .body-image {
            display: none;
            max-width: 100%;
            margin: 0 auto;
        }

        .template-selector .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .template-selector .btn {
            flex: 1;
            min-width: 120px;
            margin-bottom: 5px;
        }
        
        .template-selector .btn-group .btn.active {
            background-color: #4e73df;
            color: white !important;
            border-color: #4e73df;
        }

        .template-selector .btn-group .btn:hover {
            background-color: #ffffff;
            color: rgb(0, 0, 0) !important;
            border-color: #ddd;
        }

        .template-selector .btn-group .btn {
            color: #4e73df;
        }

        .template-selector .btn-group .btn.active:hover {
            background-color: #3b5bdb;
            color: white !important;
        }

        .detail-section {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .detail-section h5 {
            color: #4e73df;
            border-bottom: 2px solid #e3e6f0;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: 600;
            color: #5a5c69;
        }

        .btn-back {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            color: #5a5c69;
        }

        .btn-print {
            background-color: #36b9cc;
            color: white;
        }

        .btn-edit {
            background-color: #f6c23e;
            color: white;
        }

        .responsible-section {
            background-color: #e8f4fd;
            border-left: 4px solid #4e73df;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .responsible-section h6 {
            color: #4e73df;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .responsible-info {
            background-color: white;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #e3e6f0;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-operasi')
            <div class="card-body">
                <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i>Detail Penandaan Daerah Operasi</h5>
                                <div>
                                    <a href="{{ route('operasi.pelayanan.site-marking.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-sm btn-back">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <a target="_blank" href="{{ route('operasi.pelayanan.site-marking.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $siteMarking->id]) }}" class="btn btn-sm btn-print">
                                        <i class="fas fa-print me-1"></i> Cetak
                                    </a>
                                    <a href="{{ route('operasi.pelayanan.site-marking.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $siteMarking->id]) }}" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="template-selector mb-3">
                                            <label class="d-block mb-2">Template Anatomi:</label>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-primary template-btn" data-template="full-body">Seluruh Tubuh</button>
                                                <button type="button" class="btn btn-outline-primary template-btn" data-template="head-front-back">Muka Depan/Belakang</button>
                                                <button type="button" class="btn btn-outline-primary template-btn" data-template="head-side">Muka Samping Kiri/Kanan</button>
                                                <button type="button" class="btn btn-outline-primary template-btn" data-template="hand-dorsal">Tangan Dorsal Kiri/Kanan</button>
                                                <button type="button" class="btn btn-outline-primary template-btn" data-template="hand-palmar">Tangan Palmar Kiri/Kanan</button>
                                                <button type="button" class="btn btn-outline-primary template-btn" data-template="foot">Kaki</button>
                                            </div>
                                        </div>

                                        <div class="body-diagram-container">
                                            <div class="drawing-container">
                                                <!-- Gambar-gambar anatomi (hidden, used as canvas background) -->
                                                <div class="image-templates">
                                                    @if ($dataMedis->pasien->jenis_kelamin == 1)
                                                        <!-- Gambar untuk laki-laki -->
                                                        <img src="{{ asset('assets/images/sitemarking/7.png') }}" class="body-image"
                                                            id="template-full-body" alt="Seluruh Tubuh">
                                                        <img src="{{ asset('assets/images/sitemarking/9.png') }}" class="body-image"
                                                            id="template-head-front-back" alt="Muka Depan/Belakang">
                                                        <img src="{{ asset('assets/images/sitemarking/8.png') }}" class="body-image"
                                                            id="template-head-side" alt="Muka Samping Kiri/Kanan">
                                                        <img src="{{ asset('assets/images/sitemarking/11.png') }}" class="body-image"
                                                            id="template-hand-dorsal" alt="Tangan Dorsal Kiri/Kanan">
                                                        <img src="{{ asset('assets/images/sitemarking/10.png') }}" class="body-image"
                                                            id="template-hand-palmar" alt="Tangan Palmar Kiri/Kanan">
                                                        <img src="{{ asset('assets/images/sitemarking/12.png') }}" class="body-image"
                                                            id="template-foot" alt="Kaki">
                                                    @else
                                                        <!-- Gambar untuk perempuan -->
                                                        <img src="{{ asset('assets/images/sitemarking/1.png') }}" class="body-image"
                                                        id="template-full-body" alt="Seluruh Tubuh">
                                                        <img src="{{ asset('assets/images/sitemarking/3.png') }}" class="body-image"
                                                            id="template-head-front-back" alt="Muka Depan/Belakang">
                                                        <img src="{{ asset('assets/images/sitemarking/2.png') }}" class="body-image"
                                                            id="template-head-side" alt="Muka Samping Kiri/Kanan">
                                                        <img src="{{ asset('assets/images/sitemarking/6.png') }}" class="body-image"
                                                            id="template-hand-dorsal" alt="Tangan Dorsal Kiri/Kanan">
                                                        <img src="{{ asset('assets/images/sitemarking/4.png') }}" class="body-image"
                                                            id="template-hand-palmar" alt="Tangan Palmar Kiri/Kanan">
                                                        <img src="{{ asset('assets/images/sitemarking/5.png') }}" class="body-image"
                                                            id="template-foot" alt="Kaki">
                                                    @endif
                                                </div>

                                                <!-- Canvas untuk drawing -->
                                                <div class="canvas-container">
                                                    <canvas id="drawingCanvas"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="detail-section">
                                            <h5><i class="fas fa-clipboard-list me-2"></i>Detail Prosedur Operasi</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="detail-item">
                                                        <div class="detail-label">Ahli Bedah</div>
                                                        <div>{{ $siteMarking->dokter ? $siteMarking->dokter->nama_lengkap : 'Tidak tersedia' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">Tanggal Prosedur</div>
                                                        <div>{{ \Carbon\Carbon::parse($siteMarking->waktu_prosedure)->format('d/m/Y H:i') }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item">
                                                        <div class="detail-label">Prosedur Operasi</div>
                                                        <div>{{ $siteMarking->prosedure }}</div>
                                                    </div>
                                                    
                                                    <div class="detail-item">
                                                        <div class="detail-label">Catatan Site Marking</div>
                                                        <div>{{ $siteMarking->notes ?: 'Tidak ada catatan' }}</div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="responsible-section">
                                            <h6><i class="fas fa-user-check me-2"></i>Yang Bertanggung Jawab</h6>
                                            <div class="responsible-info">
                                                @if($siteMarking->responsible_person === 'pasien')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <div class="detail-label">Jenis Penanggung Jawab</div>
                                                                <div><span class="badge bg-primary">Pasien</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <div class="detail-label">Nama</div>
                                                                <div>{{ $siteMarking->patient_name ?: $dataMedis->pasien->nama }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($siteMarking->responsible_person === 'keluarga')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <div class="detail-label">Jenis Penanggung Jawab</div>
                                                                <div><span class="badge bg-success">Keluarga</span></div>
                                                            </div>
                                                            <div class="detail-item">
                                                                <div class="detail-label">Nama Keluarga</div>
                                                                <div>{{ $siteMarking->family_name ?: 'Tidak tersedia' }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <div class="detail-label">Hubungan dengan Pasien</div>
                                                                <div>{{ $siteMarking->family_relationship ?: 'Tidak tersedia' }}</div>
                                                            </div>
                                                            <div class="detail-item">
                                                                <div class="detail-label">Alamat Keluarga</div>
                                                                <div>{{ $siteMarking->family_address ?: 'Tidak tersedia' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-muted">Data penanggung jawab tidak tersedia</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($siteMarking->confirmation)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <strong>Konfirmasi:</strong> Lokasi operasi yang telah ditetapkan pada diagram di atas telah dikonfirmasi sebagai benar.
                                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data marking dari database
            const markingData = @json($markingData);

            // Set template awal
            let activeTemplate = '{{ $siteMarking->active_template }}';

            // Variabel untuk canvas
            let canvas;

            // Inisialisasi canvas
            function initializeCanvas() {
                // Dapatkan ukuran gambar template yang aktif
                const activeImage = document.getElementById('template-' + activeTemplate);
                if (!activeImage) {
                    console.error('Template image not found for: ' + activeTemplate);
                    return;
                }
                const imageWidth = activeImage.naturalWidth;
                const imageHeight = activeImage.naturalHeight;

                // Inisialisasi canvas jika belum ada
                if (!canvas) {
                    canvas = new fabric.Canvas('drawingCanvas', {
                        width: imageWidth,
                        height: imageHeight,
                        backgroundColor: 'transparent',
                        selection: false,
                        hoverCursor: 'default',
                        isDrawingMode: false,
                        interactive: false
                    });
                } else {
                    canvas.setWidth(imageWidth);
                    canvas.setHeight(imageHeight);
                }

                // Set background image
                fabric.Image.fromURL(activeImage.src, function(img) {
                    canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                        scaleX: canvas.width / img.width,
                        scaleY: canvas.height / img.height,
                        top: 0,
                        left: 0,
                        originX: 'left',
                        originY: 'top'
                    });
                });

                // Load marking data jika ada
                if (markingData && markingData.templates && markingData.templates[activeTemplate]) {
                    canvas.loadFromJSON(markingData.templates[activeTemplate], function() {
                        canvas.forEachObject(function(obj) {
                            obj.set({
                                selectable: false,
                                evented: false,
                                hasControls: false,
                                hasBorders: false,
                                lockMovementX: true,
                                lockMovementY: true,
                                lockRotation: true,
                                lockScalingX: true,
                                lockScalingY: true
                            });
                        });
                        canvas.renderAll();
                    });
                } else {
                    canvas.clear();
                    console.warn('No marking data found for template: ' + activeTemplate);
                }

                // Nonaktifkan semua event mouse
                canvas.off('mouse:down');
                canvas.off('mouse:move');
                canvas.off('mouse:up');
                canvas.off('mouse:over');
                canvas.off('mouse:out');
            }

            // Inisialisasi canvas pertama kali
            initializeCanvas();

            // Set template button yang aktif
            const activeButton = document.querySelector(`.template-btn[data-template="${activeTemplate}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }

            // Event handler untuk template selector
            document.querySelectorAll('.template-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.template-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');

                    activeTemplate = this.dataset.template;

                    // Reinisialisasi canvas dengan template baru
                    initializeCanvas();
                });
            });
        });
    </script>
@endpush