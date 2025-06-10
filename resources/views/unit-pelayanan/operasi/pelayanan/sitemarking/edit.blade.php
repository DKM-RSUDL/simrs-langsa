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

        .drawing-toolbar {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            flex-wrap: wrap;
        }

        .drawing-toolbar button {
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }

        .drawing-toolbar button:hover {
            background-color: #f0f0f0;
        }

        .drawing-toolbar button.active {
            background-color: #4e73df;
            color: white;
            border-color: #4e73df;
        }

        .color-picker {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-option {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-option.active {
            border-color: #333;
        }

        .notes-container {
            margin-top: 20px;
        }

        .notes-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-height: 100px;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-cancel {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .btn-save {
            background-color: #4e73df;
            color: white;
        }

        .template-selector {
            margin-bottom: 15px;
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

        .body-image {
            display: none;
            max-width: 100%;
            margin: 0 auto;
        }

        #drawingCanvas {
            display: block;
            margin: 0 auto;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }

        .form-label.fw-bold {
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #375ad3;
            border-color: #375ad3;
        }

        .responsible-person-container {
            display: none;
        }

        .responsible-person-container.active {
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i>Edit Penandaan Daerah Operasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mengedit form ini akan mereset tanda site marking. Silakan beri tanda ulang pada gambar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <form id="siteMarkingForm"
                            action="{{ route('operasi.pelayanan.site-marking.update', ['kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => $dataMedis->tgl_masuk, 'urut_masuk' => $dataMedis->urut_masuk, 'id' => $siteMarking->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                            <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                            <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">
                            <input type="hidden" name="marking_data" id="markingData" value="{{ htmlspecialchars($siteMarking->marking_data) }}">
                            <input type="hidden" name="active_template" id="activeTemplate" value="{{ $siteMarking->active_template }}">

                            <input type="hidden" name="template_png_full_body" id="template_png_full_body">
                            <input type="hidden" name="template_png_head_front_back" id="template_png_head_front_back">
                            <input type="hidden" name="template_png_head_side" id="template_png_head_side">
                            <input type="hidden" name="template_png_hand_dorsal" id="template_png_hand_dorsal">
                            <input type="hidden" name="template_png_hand_palmar" id="template_png_hand_palmar">
                            <input type="hidden" name="template_png_foot" id="template_png_foot">

                            <div class="template-selector mb-3">
                                <label class="d-block mb-2">Pilih Template Anatomi:</label>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary {{ $siteMarking->active_template == 'full-body' ? 'active' : '' }}"
                                        data-template="full-body">Seluruh Tubuh</button>
                                    <button type="button" class="btn btn-outline-primary {{ $siteMarking->active_template == 'head-front-back' ? 'active' : '' }}"
                                        data-template="head-front-back">Muka Depan/Belakang</button>
                                    <button type="button" class="btn btn-outline-primary {{ $siteMarking->active_template == 'head-side' ? 'active' : '' }}"
                                        data-template="head-side">Muka Samping Kiri/Kanan</button>
                                    <button type="button" class="btn btn-outline-primary {{ $siteMarking->active_template == 'hand-dorsal' ? 'active' : '' }}"
                                        data-template="hand-dorsal">Tangan Dorsal Kiri/Kanan</button>
                                    <button type="button" class="btn btn-outline-primary {{ $siteMarking->active_template == 'hand-palmar' ? 'active' : '' }}"
                                        data-template="hand-palmar">Tangan Palmar Kiri/Kanan</button>
                                    <button type="button" class="btn btn-outline-primary {{ $siteMarking->active_template == 'foot' ? 'active' : '' }}"
                                        data-template="foot">Kaki</button>
                                </div>
                            </div>

                            <div class="body-diagram-container">
                                <div class="drawing-toolbar">
                                    <button type="button" id="circleBtn" class="tool-btn" data-tool="circle">
                                        <i class="fas fa-circle"></i> Lingkaran
                                    </button>
                                    <button type="button" id="squareBtn" class="tool-btn" data-tool="square">
                                        <i class="fas fa-square"></i> Kotak
                                    </button>
                                    <button type="button" id="freeDrawBtn" class="tool-btn active" data-tool="freeDraw">
                                        <i class="fas fa-pencil-alt"></i> Gambar Bebas
                                    </button>
                                    <button type="button" id="arrowBtn" class="tool-btn" data-tool="arrow">
                                        <i class="fas fa-long-arrow-alt-right"></i> Panah
                                    </button>
                                    <button type="button" id="textBtn" class="tool-btn" data-tool="text">
                                        <i class="fas fa-font"></i> Teks
                                    </button>
                                    <button type="button" id="eraseBtn" class="tool-btn" data-tool="erase">
                                        <i class="fas fa-eraser"></i> Hapus
                                    </button>
                                    <button type="button" id="clearBtn">
                                        <i class="fas fa-trash-alt"></i> Hapus Semua
                                    </button>

                                    <div class="color-picker">
                                        <span>Warna:</span>
                                        <div class="color-option active" data-color="#ff0000" style="background-color: #ff0000;"></div>
                                        <div class="color-option" data-color="#0000ff" style="background-color: #0000ff;"></div>
                                        <div class="color-option" data-color="#00cc00" style="background-color: #00cc00;"></div>
                                        <div class="color-option" data-color="#ffcc00" style="background-color: #ffcc00;"></div>
                                        <div class="color-option" data-color="#000000" style="background-color: #000000;"></div>
                                    </div>
                                </div>

                                <div class="drawing-container">
                                    <div class="image-templates">
                                        @if ($dataMedis->pasien->jenis_kelamin == 1)
                                            <img src="{{ asset('assets/images/sitemarking/7.png') }}" class="body-image" id="template-full-body" alt="Seluruh Tubuh">
                                            <img src="{{ asset('assets/images/sitemarking/9.png') }}" class="body-image" id="template-head-front-back" alt="Muka Depan/Belakang">
                                            <img src="{{ asset('assets/images/sitemarking/8.png') }}" class="body-image" id="template-head-side" alt="Muka Samping Kiri/Kanan">
                                            <img src="{{ asset('assets/images/sitemarking/11.png') }}" class="body-image" id="template-hand-dorsal" alt="Tangan Dorsal Kiri/Kanan">
                                            <img src="{{ asset('assets/images/sitemarking/10.png') }}" class="body-image" id="template-hand-palmar" alt="Tangan Palmar Kiri/Kanan">
                                            <img src="{{ asset('assets/images/sitemarking/12.png') }}" class="body-image" id="template-foot" alt="Kaki">
                                        @else
                                            <img src="{{ asset('assets/images/sitemarking/1.png') }}" class="body-image" id="template-full-body" alt="Seluruh Tubuh">
                                            <img src="{{ asset('assets/images/sitemarking/3.png') }}" class="body-image" id="template-head-front-back" alt="Muka Depan/Belakang">
                                            <img src="{{ asset('assets/images/sitemarking/2.png') }}" class="body-image" id="template-head-side" alt="Muka Samping Kiri/Kanan">
                                            <img src="{{ asset('assets/images/sitemarking/6.png') }}" class="body-image" id="template-hand-dorsal" alt="Tangan Dorsal Kiri/Kanan">
                                            <img src="{{ asset('assets/images/sitemarking/4.png') }}" class="body-image" id="template-hand-palmar" alt="Tangan Palmar Kiri/Kanan">
                                            <img src="{{ asset('assets/images/sitemarking/5.png') }}" class="body-image" id="template-foot" alt="Kaki">
                                        @endif
                                    </div>

                                    <div class="canvas-container">
                                        <canvas id="drawingCanvas"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Detail Prosedur Operasi</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold"><i class="fas fa-user-md me-2"></i>Dokter Bedah</label>
                                                        <select class="form-control select2" style="width: 100%;" name="ahli_bedah" required>
                                                            <option value="" disabled>Pilih Ahli Bedah</option>
                                                            @foreach ($dokter as $d)
                                                                <option value="{{ $d->kd_dokter }}" {{ $siteMarking->kd_dokter == $d->kd_dokter ? 'selected' : '' }}>
                                                                    {{ $d->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="waktu" class="form-label fw-bold"><i class="fas fa-clock me-2"></i>Tanggal Prosedur</label>
                                                        <input type="datetime-local" name="waktu" id="waktu" class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($siteMarking->waktu_prosedure)->format('Y-m-d\TH:i') }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="prosedur_operasi" class="form-label fw-bold"><i class="fas fa-procedures me-2"></i>Prosedur Operasi</label>
                                                <textarea name="prosedur_operasi" id="prosedur_operasi" class="form-control" rows="3"
                                                    placeholder="Jelaskan prosedur operasi yang akan dilakukan..." required>{{ $siteMarking->prosedure }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes" class="form-label fw-bold"><i class="fas fa-clipboard me-2"></i>Catatan Site Marking</label>
                                                <textarea name="notes" id="notes" class="form-control" rows="3"
                                                    placeholder="Tambahkan catatan tentang site marking...">{{ $siteMarking->notes }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="responsible_person" class="form-label fw-bold"><i class="fas fa-user me-2"></i>Yang Bertanggung Jawab</label>
                                                <select class="form-control" name="responsible_person" id="responsible_person" required>
                                                    <option value="" disabled>Pilih Yang Bertanggung Jawab</option>
                                                    <option value="pasien" {{ $siteMarking->responsible_person == 'pasien' ? 'selected' : '' }}>Pasien</option>
                                                    <option value="keluarga" {{ $siteMarking->responsible_person == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                                                </select>
                                            </div>

                                            <div class="responsible-person-container {{ $siteMarking->responsible_person == 'pasien' ? 'active' : '' }}" id="patient_container">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Pasien</label>
                                                    <input type="text" name="patient_name" id="patient_name" class="form-control"
                                                        value="{{ $siteMarking->patient_name ?? $dataMedis->pasien->nama }}" readonly>
                                                </div>
                                            </div>

                                            <div class="responsible-person-container {{ $siteMarking->responsible_person == 'keluarga' ? 'active' : '' }}" id="family_container">
                                                <div class="mb-3">
                                                    <label for="family_name" class="form-label fw-bold">Nama Keluarga</label>
                                                    <input type="text" name="family_name" id="family_name" class="form-control"
                                                        value="{{ $siteMarking->family_name }}" placeholder="Masukkan nama keluarga">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="family_relationship" class="form-label fw-bold">Status Hubungan dengan Pasien</label>
                                                    <input type="text" name="family_relationship" id="family_relationship" class="form-control"
                                                        value="{{ $siteMarking->family_relationship }}" placeholder="Masukkan hubungan (misal: Istri, Anak)">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="family_address" class="form-label fw-bold">Alamat Keluarga</label>
                                                    <textarea name="family_address" id="family_address" class="form-control" rows="3"
                                                        placeholder="Masukkan alamat keluarga">{{ $siteMarking->family_address }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group mt-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="confirmation" id="markingConfirmation"
                                                        {{ $siteMarking->confirmation ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="markingConfirmation">
                                                        Saya menyatakan bahwa lokasi operasi yang telah ditetapkan pada diagram di atas adalah benar dan telah dikonfirmasi oleh pasien.
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-4 gap-2">
                                                <a href="{{ route('operasi.pelayanan.site-marking.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-light border">
                                                    <i class="fas fa-times me-2"></i>Batal
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>Perbarui Site Marking
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            // Canvas Initialization and Drawing Tools
            let activeTemplate = "{{ $siteMarking->active_template }}";
            let canvas;
            let markingDataPerTemplate = {};

            // Load marking data from database
            try {
                let savedData = {};
                const markingDataValue = document.getElementById('markingData').value;

                if (markingDataValue && markingDataValue.trim() !== '') {
                    savedData = JSON.parse(markingDataValue);
                }

                if (savedData && savedData.templates) {
                    markingDataPerTemplate = savedData.templates;
                    activeTemplate = savedData.activeTemplate || activeTemplate;
                }
            } catch (e) {
                console.error('Error parsing marking data:', e);
                markingDataPerTemplate = {};
            }

            let currentTool = 'freeDraw';
            let currentColor = '#ff0000';
            let isDrawing = false;
            let lastPosX, lastPosY;

            function initializeCanvas() {
                const activeImage = document.getElementById('template-' + activeTemplate);
                const imageWidth = activeImage.naturalWidth;
                const imageHeight = activeImage.naturalHeight;

                if (!canvas) {
                    canvas = new fabric.Canvas('drawingCanvas', {
                        width: imageWidth,
                        height: imageHeight,
                        backgroundColor: 'transparent',
                        selection: true
                    });
                } else {
                    canvas.setWidth(imageWidth);
                    canvas.setHeight(imageHeight);
                }

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

                if (markingDataPerTemplate[activeTemplate]) {
                    canvas.loadFromJSON(markingDataPerTemplate[activeTemplate], canvas.renderAll.bind(canvas));
                } else {
                    canvas.clear();
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
                }

                canvas.isDrawingMode = currentTool === 'freeDraw';
                canvas.freeDrawingBrush.color = currentColor;
                canvas.freeDrawingBrush.width = 3;

                document.getElementById('activeTemplate').value = activeTemplate;
            }

            initializeCanvas();

            document.querySelectorAll('.template-selector .btn-group button').forEach(button => {
                button.addEventListener('click', function() {
                    markingDataPerTemplate[activeTemplate] = JSON.stringify(canvas.toJSON(['selectable', 'hasControls']));
                    document.querySelectorAll('.template-selector .btn-group button').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    activeTemplate = this.dataset.template;
                    initializeCanvas();
                });
            });

            document.querySelectorAll('.tool-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.tool-btn').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    currentTool = this.dataset.tool;

                    canvas.isDrawingMode = currentTool === 'freeDraw';
                    if (canvas.isDrawingMode) {
                        canvas.freeDrawingBrush.color = currentColor;
                        canvas.freeDrawingBrush.width = 3;
                    }
                });
            });

            document.querySelectorAll('.color-option').forEach(color => {
                color.addEventListener('click', function() {
                    document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentColor = this.dataset.color;

                    if (canvas.isDrawingMode) {
                        canvas.freeDrawingBrush.color = currentColor;
                    }
                });
            });

            document.getElementById('clearBtn').addEventListener('click', function() {
                canvas.clear();
                const activeImage = document.getElementById('template-' + activeTemplate);
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
                delete markingDataPerTemplate[activeTemplate];
                saveAllMarkingData();
            });

            canvas.on('mouse:down', function(o) {
                const pointer = canvas.getPointer(o.e);
                const target = canvas.findTarget(o.e);

                if (target && currentTool !== 'erase') {
                    canvas.setActiveObject(target);
                    isDrawing = false;
                    return;
                }

                isDrawing = true;
                lastPosX = pointer.x;
                lastPosY = pointer.y;

                if (currentTool === 'circle') {
                    const circle = new fabric.Circle({
                        left: pointer.x,
                        top: pointer.y,
                        radius: 10,
                        fill: 'transparent',
                        stroke: currentColor,
                        strokeWidth: 2,
                        originX: 'center',
                        originY: 'center',
                        selectable: true,
                        hasControls: true
                    });
                    canvas.add(circle);
                } else if (currentTool === 'square') {
                    const square = new fabric.Rect({
                        left: pointer.x,
                        top: pointer.y,
                        width: 20,
                        height: 20,
                        fill: 'transparent',
                        stroke: currentColor,
                        strokeWidth: 2,
                        originX: 'center',
                        originY: 'center',
                        selectable: true,
                        hasControls: true
                    });
                    canvas.add(square);
                } else if (currentTool === 'text') {
                    const text = new fabric.IText('Text', {
                        left: pointer.x,
                        top: pointer.y,
                        fontFamily: 'Arial',
                        fontSize: 16,
                        fill: currentColor,
                        selectable: true,
                        hasControls: true
                    });
                    canvas.add(text);
                    canvas.setActiveObject(text);
                } else if (currentTool === 'arrow') {
                    const line = new fabric.Line([pointer.x, pointer.y, pointer.x, pointer.y], {
                        stroke: currentColor,
                        strokeWidth: 2,
                        originX: 'center',
                        originY: 'center',
                        selectable: true,
                        hasControls: true
                    });
                    canvas.add(line);
                    canvas.setActiveObject(line);
                } else if (currentTool === 'erase') {
                    if (target) {
                        canvas.remove(target);
                    }
                }
            });

            canvas.on('mouse:move', function(o) {
                if (!isDrawing) return;
                const pointer = canvas.getPointer(o.e);

                if (currentTool === 'arrow') {
                    const activeObject = canvas.getActiveObject();
                    if (activeObject && activeObject.type === 'line') {
                        activeObject.set({
                            x2: pointer.x,
                            y2: pointer.y
                        });
                        canvas.renderAll();
                    }
                }
            });

            canvas.on('mouse:up', function() {
                isDrawing = false;
                markingDataPerTemplate[activeTemplate] = JSON.stringify(canvas.toJSON(['selectable', 'hasControls']));
                saveAllMarkingData();
            });

            canvas.on('object:modified', function() {
                markingDataPerTemplate[activeTemplate] = JSON.stringify(canvas.toJSON(['selectable', 'hasControls']));
                saveAllMarkingData();
            });

            function saveAllMarkingData() {
                const allMarkingData = {
                    activeTemplate: activeTemplate,
                    templates: markingDataPerTemplate
                };
                document.getElementById('markingData').value = JSON.stringify(allMarkingData);
            }

            function saveTemplatePngData() {
                const templateNames = [
                    'full-body',
                    'head-front-back',
                    'head-side',
                    'hand-dorsal',
                    'hand-palmar',
                    'foot'
                ];

                templateNames.forEach(template => {
                    const templateImage = document.getElementById('template-' + template);
                    if (!templateImage) return;

                    const tempCanvas = new fabric.Canvas(null, {
                        width: templateImage.naturalWidth,
                        height: templateImage.naturalHeight
                    });

                    fabric.Image.fromURL(templateImage.src, function(img) {
                        tempCanvas.setBackgroundImage(img, tempCanvas.renderAll.bind(tempCanvas), {
                            scaleX: tempCanvas.width / img.width,
                            scaleY: tempCanvas.height / img.height,
                            top: 0,
                            left: 0,
                            originX: 'left',
                            originY: 'top'
                        });

                        if (markingDataPerTemplate[template]) {
                            tempCanvas.loadFromJSON(markingDataPerTemplate[template], function() {
                                tempCanvas.renderAll();
                                const pngData = tempCanvas.toDataURL('image/png', 0.7);
                                const inputId = 'template_png_' + template.replace(/-/g, '_');
                                const inputElement = document.getElementById(inputId);
                                if (inputElement) {
                                    inputElement.value = pngData;
                                }
                                tempCanvas.dispose();
                            });
                        } else {
                            tempCanvas.renderAll();
                            const pngData = tempCanvas.toDataURL('image/png', 0.7);
                            const inputId = 'template_png_' + template.replace(/-/g, '_');
                            const inputElement = document.getElementById(inputId);
                            if (inputElement) {
                                inputElement.value = pngData;
                            }
                            tempCanvas.dispose();
                        }
                    });
                });
            }

            // Handle responsible person selection
            const responsiblePersonSelect = document.getElementById('responsible_person');
            const patientContainer = document.getElementById('patient_container');
            const familyContainer = document.getElementById('family_container');

            function updateResponsiblePersonFields() {
                const selectedValue = responsiblePersonSelect.value;

                patientContainer.classList.remove('active');
                familyContainer.classList.remove('active');

                document.getElementById('patient_name').removeAttribute('required');
                document.getElementById('family_name').removeAttribute('required');
                document.getElementById('family_relationship').removeAttribute('required');
                document.getElementById('family_address').removeAttribute('required');

                if (selectedValue === 'pasien') {
                    patientContainer.classList.add('active');
                    document.getElementById('patient_name').setAttribute('required', 'required');
                } else if (selectedValue === 'keluarga') {
                    familyContainer.classList.add('active');
                    document.getElementById('family_name').setAttribute('required', 'required');
                    document.getElementById('family_relationship').setAttribute('required', 'required');
                    document.getElementById('family_address').setAttribute('required', 'required');
                }
            }

            responsiblePersonSelect.addEventListener('change', updateResponsiblePersonFields);
            updateResponsiblePersonFields(); // Initialize on load

            // Handle form submission
            document.getElementById('siteMarkingForm').addEventListener('submit', function(e) {
                e.preventDefault();

                markingDataPerTemplate[activeTemplate] = JSON.stringify(canvas.toJSON(['selectable', 'hasControls']));
                saveAllMarkingData();
                saveTemplatePngData();

                setTimeout(() => {
                    this.submit();
                }, 1500);
            });
        });
    </script>
@endpush
