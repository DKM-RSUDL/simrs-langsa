@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* =================== BASE STYLES =================== */
        .header-asesmen {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* =================== FORM STYLES =================== */
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .form-label.required::after {
            content: " *";
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control, .form-select {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        /* =================== SECTION STYLES =================== */
        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 24px;
            background-color: #097dd6;
            margin-right: 0.75rem;
            border-radius: 2px;
        }

        /* =================== TABLE STYLES =================== */
        .table {
            margin-bottom: 0;
        }

        .table-light {
            background-color: #f8f9fa;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table-responsive {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        /* =================== CHECKBOX STYLES =================== */
        .form-check {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
        }

        .form-check-input {
            margin-top: 0.125rem;
        }

        .form-check-label {
            margin-bottom: 0;
            cursor: pointer;
        }

        /* =================== INPUT GROUP STYLES =================== */
        .input-group {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .btn {
            border-left: 1px solid #ced4da;
            white-space: nowrap;
        }

        .input-group .form-control:focus {
            border-color: #097dd6;
            box-shadow: none;
        }

        .input-group .form-control:focus + .btn {
            border-color: #097dd6;
        }

        /* GCS Input specific styling */
        .input-group .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .input-group .form-control.is-valid {
            border-color: #28a745;
            background-color: #f8fff9;
        }

        /* =================== VITAL SIGN STYLES =================== */
        .vital-sign-group {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
        }

        .vital-sign-group .form-group:last-child {
            margin-bottom: 0;
        }

        /* =================== PAIN SCALE STYLES =================== */
        .pain-scale-input {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
        }

        .pain-scale-buttons .btn-group {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .pain-scale-images {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            background-color: #fff;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pain-scale-image {
            padding: 1rem;
            text-align: center;
        }

        .pain-scale-image img {
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem;
        }

        #skalaNyeriBtn {
            min-width: 150px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        /* =================== PEMERIKSAAN FISIK STYLES =================== */
        .pemeriksaan-fisik-info {
            background-color: #e7f3ff;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #097dd6;
        }

        .pemeriksaan-item {
            transition: all 0.2s ease;
        }

        .pemeriksaan-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .pemeriksaan-item .border {
            border-color: #e9ecef !important;
            transition: border-color 0.2s ease;
        }

        .pemeriksaan-item:hover .border {
            border-color: #097dd6 !important;
        }

        .keterangan input {
            border-color: #ffc107;
            background-color: #fff8e1;
        }

        .keterangan input:focus {
            border-color: #ff9800;
            box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
        }

        /* =================== DIAGNOSIS STYLES =================== */
        .diagnosis-item {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
            cursor: move;
        }

        .diagnosis-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-color: #097dd6;
        }

        .diagnosis-item.dragging {
            opacity: 0.5;
            transform: rotate(5deg);
        }

        .diagnosis-content {
            background-color: white;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border-left: 4px solid #097dd6;
        }

        .diagnosis-number {
            background-color: #097dd6;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.875rem;
        }

        .drag-handle {
            cursor: move;
            color: #6c757d;
            font-size: 1.2rem;
        }

        .drag-handle:hover {
            color: #097dd6;
        }

        .diagnosis-list {
            min-height: 50px;
        }

        .diagnosis-item .btn-group {
            gap: 0.25rem;
        }

        .sortable-ghost {
            opacity: 0.4;
        }

        .sortable-chosen {
            transform: scale(1.02);
        }

        /* =================== ALAT TERPASANG STYLES =================== */
        .alat-item {
            transition: all 0.2s ease;
        }

        .alat-item:hover {
            background-color: #f8f9fa;
        }

        #alatTerpasangTable .btn-group {
            gap: 0.25rem;
        }

        /* =================== TINDAK LANJUT SPECIFIC STYLES =================== */
        .tindak-lanjut-options {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1.5rem;
        }

        .conditional-form {
            margin-top: 1.5rem;
            animation: fadeIn 0.3s ease;
        }

        .conditional-form .card {
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .conditional-form .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
        }

        .conditional-form .card-header h6 {
            color: #097dd6;
            font-weight: 600;
            margin-bottom: 0;
        }

        .conditional-form .card-body {
            padding: 1.5rem;
        }

        /* Alert styling */
        .alert-info {
            background-color: #e7f3ff;
            border-color: #b8daff;
            color: #0c5460;
        }


        /* =================== BUTTON STYLES =================== */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #097dd6;
            border-color: #097dd6;
        }

        .btn-primary:hover {
            background-color: #0866b3;
            border-color: #0866b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(9, 125, 214, 0.3);
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            border-color: #097dd6;
            color: white;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
        }

        /* =================== RESPONSIVE DESIGN =================== */
        @media (max-width: 768px) {
            .header-asesmen {
                font-size: 1.25rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .vital-sign-group {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .pain-scale-buttons .btn-group {
                flex-direction: column;
            }

            .pain-scale-buttons .btn {
                margin-bottom: 0.5rem;
            }

            .pain-scale-input {
                margin-bottom: 1rem;
            }

            .pemeriksaan-item {
                margin-bottom: 1rem;
            }

            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem !important;
            }

            #skalaNyeriBtn {
                min-width: 100%;
            }

            .tindak-lanjut-options {
                padding: 1rem;
            }
            
            .radio-option {
                padding: 0.75rem;
                margin-bottom: 0.5rem;
            }
            
            .conditional-form .card-body {
                padding: 1rem;
            }

        }

        /* =================== UTILITY CLASSES =================== */
        .text-small {
            font-size: 0.875rem;
        }

        .border-rounded {
            border-radius: 0.5rem;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .gap-3 {
            gap: 1rem !important;
        }

        /* =================== DROPDOWN STYLES =================== */
        .dropdown-menu {
            display: none;
            position: absolute;
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
        }

        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        /* =================== COLOR BUTTON STYLES =================== */
        .color-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .color-btn:hover {
            transform: scale(1.1);
            border-color: #6c757d;
        }

        .color-btn.active {
            border-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        /* =================== ANIMATION STYLES =================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .keterangan {
            animation: fadeIn 0.3s ease;
        }

        /* =================== FOCUS STYLES =================== */
        .form-control:focus,
        .form-select:focus,
        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        /* =================== PRINT STYLES =================== */
        @media print {
            .btn, .pain-scale-buttons {
                display: none !important;
            }
            
            .section-separator {
                break-inside: avoid;
            }
            
            .pemeriksaan-item {
                break-inside: avoid;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // =================== PEMERIKSAAN FISIK ===================
            initPemeriksaanFisik();
            
            // =================== RIWAYAT ===================
            initRiwayat();
            
            // =================== SKALA NYERI ===================
            initSkalaNyeri();
            
            // =================== PAIN SCALE IMAGES ===================
            initPainScaleImages();

            // =================== DIAGNOSIS ===================
            initDiagnosis();

            // =================== ALAT TERPASANG ===================
            initAlatTerpasang();

            // =================== TINDAK LANJUT ===================
            initTindakLanjut();

        });

        // =================== PEMERIKSAAN FISIK FUNCTIONS ===================
        function initPemeriksaanFisik() {
            // Event listener untuk tombol tambah keterangan
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector('.form-check-input');
                    
                    if (keteranganDiv && normalCheckbox) {
                        toggleKeterangan(keteranganDiv, normalCheckbox);
                    }
                });
            });

            // Event listener untuk checkbox normal
            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                    if (keteranganDiv && this.checked) {
                        hideKeterangan(keteranganDiv);
                    }
                });
            });

            // Set default state
            setDefaultPemeriksaanState();
        }

        function toggleKeterangan(keteranganDiv, normalCheckbox) {
            if (keteranganDiv.style.display === 'none') {
                keteranganDiv.style.display = 'block';
                normalCheckbox.checked = false;
                keteranganDiv.querySelector('input')?.focus();
            } else {
                keteranganDiv.style.display = 'block';
            }
        }

        function hideKeterangan(keteranganDiv) {
            keteranganDiv.style.display = 'none';
            const input = keteranganDiv.querySelector('input');
            if (input) input.value = '';
        }

        function setDefaultPemeriksaanState() {
            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.checked = true;
                const keteranganDiv = checkbox.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                if (keteranganDiv) {
                    hideKeterangan(keteranganDiv);
                }
            });
        }

        // =================== RIWAYAT FUNCTIONS ===================
        function initRiwayat() {
            let riwayatArray = [];

            // Event listeners
            const btnTambahRiwayat = document.getElementById('btnTambahRiwayat');
            const btnTambahRiwayatModal = document.getElementById('btnTambahRiwayatModal');
            const riwayatModal = document.getElementById('riwayatModal');

            if (btnTambahRiwayat) {
                btnTambahRiwayat.addEventListener('click', resetRiwayatModal);
            }

            if (btnTambahRiwayatModal) {
                btnTambahRiwayatModal.addEventListener('click', function() {
                    handleTambahRiwayat(riwayatArray);
                });
            }

            if (riwayatModal) {
                riwayatModal.addEventListener('hidden.bs.modal', resetRiwayatModal);
            }
        }

        function resetRiwayatModal() {
            const namaPenyakit = document.getElementById('namaPenyakit');
            const namaObat = document.getElementById('namaObat');
            
            if (namaPenyakit) namaPenyakit.value = '';
            if (namaObat) namaObat.value = '';
        }

        function handleTambahRiwayat(riwayatArray) {
            const namaPenyakit = document.getElementById('namaPenyakit')?.value.trim();
            const namaObat = document.getElementById('namaObat')?.value.trim();
            const tbody = document.querySelector('#riwayatTable tbody');

            if (!namaPenyakit && !namaObat) {
                showAlert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                return;
            }

            const riwayatEntry = {
                penyakit: namaPenyakit || '-',
                obat: namaObat || '-'
            };

            riwayatArray.push(riwayatEntry);
            addRiwayatToTable(tbody, riwayatEntry, riwayatArray);
            updateRiwayatJson(riwayatArray);
            closeModal('riwayatModal');
        }

        function addRiwayatToTable(tbody, entry, riwayatArray) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${entry.penyakit}</td>
                <td>${entry.obat}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm hapus-riwayat">
                        <i class="ti-trash"></i> Hapus
                    </button>
                </td>
            `;

            tbody.appendChild(row);

            // Event listener untuk hapus
            row.querySelector('.hapus-riwayat')?.addEventListener('click', function() {
                removeRiwayat(row, entry, riwayatArray);
            });
        }

        function removeRiwayat(row, entry, riwayatArray) {
            const index = riwayatArray.findIndex(item =>
                item.penyakit === entry.penyakit && item.obat === entry.obat
            );
            
            if (index !== -1) {
                riwayatArray.splice(index, 1);
            }
            
            row.remove();
            updateRiwayatJson(riwayatArray);
        }

        function updateRiwayatJson(riwayatArray) {
            const riwayatJsonInput = document.getElementById('riwayatJson');
            if (riwayatJsonInput) {
                riwayatJsonInput.value = JSON.stringify(riwayatArray);
            }
        }

        // =================== SKALA NYERI FUNCTIONS ===================
        function initSkalaNyeri() {
            const inputSkalaNyeri = document.querySelector('input[name="skala_nyeri"]');
            const button = document.getElementById('skalaNyeriBtn');
            
            if (!inputSkalaNyeri || !button) return;

            // Set initial state
            updateNyeriButton(parseInt(inputSkalaNyeri.value) || 0, button);
            
            // Event listeners
            inputSkalaNyeri.addEventListener('input', function() {
                handleNyeriInput(this, button);
            });
            
            inputSkalaNyeri.addEventListener('change', function() {
                handleNyeriInput(this, button);
            });
        }

        function handleNyeriInput(input, button) {
            let nilai = parseInt(input.value) || 0;
            nilai = Math.min(Math.max(nilai, 0), 10);
            input.value = nilai;
            updateNyeriButton(nilai, button);
        }

        function updateNyeriButton(nilai, button) {
            const config = getNyeriConfig(nilai);
            
            button.className = `btn ${config.class}`;
            button.textContent = config.text;
            
            const nilaiInput = document.querySelector('input[name="skala_nyeri_nilai"]');
            if (nilaiInput) {
                nilaiInput.value = nilai;
            }
        }

        function getNyeriConfig(nilai) {
            switch (true) {
                case nilai === 0:
                    return { class: 'btn-success', text: 'Tidak Nyeri' };
                case nilai >= 1 && nilai <= 3:
                    return { class: 'btn-success', text: 'Nyeri Ringan' };
                case nilai >= 4 && nilai <= 5:
                    return { class: 'btn-warning', text: 'Nyeri Sedang' };
                case nilai >= 6 && nilai <= 7:
                    return { class: 'btn-warning', text: 'Nyeri Berat' };
                case nilai >= 8 && nilai <= 9:
                    return { class: 'btn-danger', text: 'Nyeri Sangat Berat' };
                case nilai >= 10:
                    return { class: 'btn-danger', text: 'Nyeri Tak Tertahankan' };
                default:
                    return { class: 'btn-success', text: 'Tidak Nyeri' };
            }
        }

        // =================== DIAGNOSIS FUNCTIONS ===================
        function initDiagnosis() {
            let diagnosisArray = [];
            let editIndex = -1;

            // Initialize sortable
            const diagnosisList = document.getElementById('diagnosisList');
            if (diagnosisList && typeof Sortable !== 'undefined') {
                new Sortable(diagnosisList, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    handle: '.drag-handle',
                    onEnd: function(evt) {
                        updateDiagnosisOrder(diagnosisArray);
                    }
                });
            }

            // Event listeners
            const btnTambahDiagnosis = document.getElementById('btnTambahDiagnosis');
            const btnSimpanDiagnosis = document.getElementById('btnSimpanDiagnosis');
            const diagnosisModal = document.getElementById('diagnosisModal');

            if (btnTambahDiagnosis) {
                btnTambahDiagnosis.addEventListener('click', function() {
                    openDiagnosisModal('add', diagnosisArray);
                });
            }

            if (btnSimpanDiagnosis) {
                btnSimpanDiagnosis.addEventListener('click', function() {
                    saveDiagnosis(diagnosisArray, editIndex);
                });
            }

            if (diagnosisModal) {
                diagnosisModal.addEventListener('hidden.bs.modal', function() {
                    resetDiagnosisModal();
                    editIndex = -1;
                });
            }

            // Functions
            function openDiagnosisModal(mode, diagnosisArray, index = -1) {
                const modal = new bootstrap.Modal(document.getElementById('diagnosisModal'));
                const modalTitle = document.getElementById('diagnosisModalTitle');
                const namaDiagnosis = document.getElementById('namaDiagnosis');

                if (mode === 'add') {
                    modalTitle.textContent = 'Tambah Diagnosis';
                    namaDiagnosis.value = '';
                    editIndex = -1;
                } else if (mode === 'edit' && index !== -1) {
                    modalTitle.textContent = 'Edit Diagnosis';
                    namaDiagnosis.value = diagnosisArray[index].nama;
                    editIndex = index;
                }

                modal.show();
                setTimeout(() => namaDiagnosis.focus(), 300);
            }

            function saveDiagnosis(diagnosisArray, editIndex) {
                const namaDiagnosis = document.getElementById('namaDiagnosis').value.trim();

                if (!namaDiagnosis) {
                    showAlert('Nama diagnosis harus diisi');
                    return;
                }

                const diagnosisData = {
                    nama: namaDiagnosis
                };

                if (editIndex === -1) {
                    // Add new
                    diagnosisArray.push(diagnosisData);
                } else {
                    // Edit existing
                    diagnosisArray[editIndex] = diagnosisData;
                }

                renderDiagnosisList(diagnosisArray);
                updateDiagnosisJson(diagnosisArray);
                closeModal('diagnosisModal');
                editIndex = -1;
            }

            function renderDiagnosisList(diagnosisArray) {
                const diagnosisList = document.getElementById('diagnosisList');
                const noDiagnosisMessage = document.getElementById('noDiagnosisMessage');

                if (diagnosisArray.length === 0) {
                    diagnosisList.innerHTML = '';
                    noDiagnosisMessage.style.display = 'block';
                    return;
                }

                noDiagnosisMessage.style.display = 'none';
                
                diagnosisList.innerHTML = diagnosisArray.map((diagnosis, index) => `
                    <div class="diagnosis-item" data-index="${index}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="drag-handle">
                                <i class="ti-menu"></i>
                            </div>
                            <div class="diagnosis-number">
                                ${index + 1}
                            </div>
                            <div class="diagnosis-content flex-grow-1">
                                <div class="fw-medium text-dark">${diagnosis.nama}</div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-diagnosis" 
                                        data-index="${index}" title="Edit">
                                    <i class="ti-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-diagnosis" 
                                        data-index="${index}" title="Hapus">
                                    <i class="ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Add event listeners for edit and delete buttons
                diagnosisList.querySelectorAll('.edit-diagnosis').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        openDiagnosisModal('edit', diagnosisArray, index);
                    });
                });

                diagnosisList.querySelectorAll('.delete-diagnosis').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        deleteDiagnosis(diagnosisArray, index);
                    });
                });
            }

            function deleteDiagnosis(diagnosisArray, index) {
                if (confirm('Apakah Anda yakin ingin menghapus diagnosis ini?')) {
                    diagnosisArray.splice(index, 1);
                    renderDiagnosisList(diagnosisArray);
                    updateDiagnosisJson(diagnosisArray);
                }
            }

            function updateDiagnosisOrder(diagnosisArray) {
                const items = document.querySelectorAll('.diagnosis-item');
                const newOrder = [];
                
                items.forEach(item => {
                    const index = parseInt(item.dataset.index);
                    newOrder.push(diagnosisArray[index]);
                });
                
                // Update the original array
                diagnosisArray.splice(0, diagnosisArray.length, ...newOrder);
                renderDiagnosisList(diagnosisArray);
                updateDiagnosisJson(diagnosisArray);
            }

            function updateDiagnosisJson(diagnosisArray) {
                const diagnosisDataInput = document.getElementById('diagnosisData');
                if (diagnosisDataInput) {
                    diagnosisDataInput.value = JSON.stringify(diagnosisArray);
                }
            }

            function resetDiagnosisModal() {
                const namaDiagnosis = document.getElementById('namaDiagnosis');
                if (namaDiagnosis) namaDiagnosis.value = '';
            }
        }


        // =================== ALAT TERPASANG FUNCTIONS ===================
        function initAlatTerpasang() {
            let alatArray = [];
            let editAlatIndex = -1;

            // Event listeners
            const btnTambahAlat = document.getElementById('btnTambahAlat');
            const btnSimpanAlat = document.getElementById('btnSimpanAlat');
            const alatModal = document.getElementById('alatModal');
            const namaAlat = document.getElementById('namaAlat');
            const alatLainnyaGroup = document.getElementById('alatLainnyaGroup');

            if (btnTambahAlat) {
                btnTambahAlat.addEventListener('click', function() {
                    openAlatModal('add');
                });
            }

            if (btnSimpanAlat) {
                btnSimpanAlat.addEventListener('click', function() {
                    saveAlat();
                });
            }

            if (alatModal) {
                alatModal.addEventListener('hidden.bs.modal', function() {
                    resetAlatModal();
                    editAlatIndex = -1;
                });
            }

            if (namaAlat) {
                namaAlat.addEventListener('change', function() {
                    toggleAlatLainnya();
                });
            }

            // Functions
            function openAlatModal(mode, index = -1) {
                const modalLabel = document.getElementById('alatModalLabel');
                const namaAlatSelect = document.getElementById('namaAlat');
                const alatLainnyaInput = document.getElementById('alatLainnya');
                const lokasiAlatInput = document.getElementById('lokasiAlat');
                const keteranganAlatInput = document.getElementById('keteranganAlat');

                if (mode === 'add') {
                    modalLabel.textContent = 'Tambah Alat yang Terpasang';
                    resetAlatModal();
                    editAlatIndex = -1;
                } else if (mode === 'edit' && index !== -1) {
                    modalLabel.textContent = 'Edit Alat yang Terpasang';
                    const alat = alatArray[index];
                    
                    namaAlatSelect.value = alat.nama;
                    if (alat.nama === 'Lainnya') {
                        alatLainnyaGroup.style.display = 'block';
                        alatLainnyaInput.value = alat.nama_lainnya || '';
                    }
                    lokasiAlatInput.value = alat.lokasi || '';
                    keteranganAlatInput.value = alat.keterangan || '';
                    editAlatIndex = index;
                }

                setTimeout(() => namaAlatSelect.focus(), 300);
            }

            function saveAlat() {
                const namaAlatSelect = document.getElementById('namaAlat');
                const alatLainnyaInput = document.getElementById('alatLainnya');
                const lokasiAlatInput = document.getElementById('lokasiAlat');
                const keteranganAlatInput = document.getElementById('keteranganAlat');

                const namaAlatValue = namaAlatSelect.value.trim();
                const lokasiValue = lokasiAlatInput.value.trim();
                const keteranganValue = keteranganAlatInput.value.trim();

                if (!namaAlatValue) {
                    showAlert('Nama alat harus dipilih');
                    return;
                }

                let namaAlatFinal = namaAlatValue;
                let namaLainnya = '';

                if (namaAlatValue === 'Lainnya') {
                    const alatLainnyaValue = alatLainnyaInput.value.trim();
                    if (!alatLainnyaValue) {
                        showAlert('Nama alat lainnya harus diisi');
                        return;
                    }
                    namaAlatFinal = alatLainnyaValue;
                    namaLainnya = alatLainnyaValue;
                }

                const alatData = {
                    nama: namaAlatValue === 'Lainnya' ? 'Lainnya' : namaAlatValue,
                    nama_lainnya: namaLainnya,
                    nama_display: namaAlatFinal,
                    lokasi: lokasiValue,
                    keterangan: keteranganValue
                };

                if (editAlatIndex === -1) {
                    // Add new
                    alatArray.push(alatData);
                } else {
                    // Edit existing
                    alatArray[editAlatIndex] = alatData;
                }

                renderAlatTable();
                updateAlatJson();
                closeModal('alatModal');
                editAlatIndex = -1;
            }

            function renderAlatTable() {
                const tbody = document.querySelector('#alatTerpasangTable tbody');
                const noAlatRow = document.getElementById('no-alat-row');

                if (alatArray.length === 0) {
                    noAlatRow.style.display = 'table-row';
                    // Remove all rows except the no-data row
                    const rows = tbody.querySelectorAll('tr:not(#no-alat-row)');
                    rows.forEach(row => row.remove());
                    return;
                }

                noAlatRow.style.display = 'none';

                // Clear existing rows except no-data row
                const existingRows = tbody.querySelectorAll('tr:not(#no-alat-row)');
                existingRows.forEach(row => row.remove());

                // Add new rows
                alatArray.forEach((alat, index) => {
                    const row = document.createElement('tr');
                    row.className = 'alat-item';
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${alat.nama_display}</td>
                        <td>${alat.lokasi || '-'}</td>
                        <td>${alat.keterangan || '-'}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-alat" 
                                        data-index="${index}" title="Edit">
                                    <i class="ti-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-alat" 
                                        data-index="${index}" title="Hapus">
                                    <i class="ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;

                    tbody.appendChild(row);
                });

                // Add event listeners for new buttons
                tbody.querySelectorAll('.edit-alat').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        openAlatModal('edit', index);
                    });
                });

                tbody.querySelectorAll('.delete-alat').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        deleteAlat(index);
                    });
                });
            }

            function deleteAlat(index) {
                if (confirm('Apakah Anda yakin ingin menghapus alat ini?')) {
                    alatArray.splice(index, 1);
                    renderAlatTable();
                    updateAlatJson();
                }
            }

            function updateAlatJson() {
                const alatDataInput = document.getElementById('alatTerpasangData');
                if (alatDataInput) {
                    alatDataInput.value = JSON.stringify(alatArray);
                }
            }

            function resetAlatModal() {
                const namaAlat = document.getElementById('namaAlat');
                const alatLainnya = document.getElementById('alatLainnya');
                const lokasiAlat = document.getElementById('lokasiAlat');
                const keteranganAlat = document.getElementById('keteranganAlat');
                
                if (namaAlat) namaAlat.value = '';
                if (alatLainnya) alatLainnya.value = '';
                if (lokasiAlat) lokasiAlat.value = '';
                if (keteranganAlat) keteranganAlat.value = '';
                
                alatLainnyaGroup.style.display = 'none';
            }

            function toggleAlatLainnya() {
                const namaAlatValue = document.getElementById('namaAlat').value;
                const alatLainnyaGroup = document.getElementById('alatLainnyaGroup');
                
                if (namaAlatValue === 'Lainnya') {
                    alatLainnyaGroup.style.display = 'block';
                    document.getElementById('alatLainnya').focus();
                } else {
                    alatLainnyaGroup.style.display = 'none';
                    document.getElementById('alatLainnya').value = '';
                }
            }

            // Expose functions globally if needed by other scripts
            window.openAlatModal = openAlatModal;
            window.saveAlat = saveAlat;
            window.deleteAlat = deleteAlat;
        }


        // =================== IMT FUNCTIONS =================== 
        function hitungIMT() {
            const tbInput = document.getElementById('tbInput');
            const bbInput = document.getElementById('bbInput');
            const imtInput = document.getElementById('imtInput');
            const imtKategori = document.getElementById('imtKategori');
            
            const tb = parseFloat(tbInput.value);
            const bb = parseFloat(bbInput.value);
            
            if (tb && bb && tb > 0) {
                // Konversi TB dari cm ke meter
                const tbMeter = tb / 100;
                
                // Hitung IMT
                const imt = bb / (tbMeter * tbMeter);
                
                // Set nilai IMT dengan 2 decimal places
                imtInput.value = imt.toFixed(2);
                
                // Tentukan kategori IMT
                let kategori = '';
                let kategoriClass = '';
                
                if (imt < 18.5) {
                    kategori = 'Underweight';
                    kategoriClass = 'bg-info text-white';
                } else if (imt >= 18.5 && imt < 25) {
                    kategori = 'Normal';
                    kategoriClass = 'bg-success text-white';
                } else if (imt >= 25 && imt < 30) {
                    kategori = 'Overweight';
                    kategoriClass = 'bg-warning text-dark';
                } else {
                    kategori = 'Obesitas';
                    kategoriClass = 'bg-danger text-white';
                }
                
                // Update kategori IMT
                imtKategori.textContent = kategori;
                imtKategori.className = `input-group-text ${kategoriClass}`;
            } else {
                // Reset jika input tidak valid
                imtInput.value = '';
                imtKategori.textContent = 'Normal';
                imtKategori.className = 'input-group-text';
            }
        }

        // =================== TINDAK LANJUT FUNCTIONS ===================
        function initTindakLanjut() {
            const radioOptions = document.querySelectorAll('.radio-option');
            const radioInputs = document.querySelectorAll('input[name="tindakLanjut"]');
            
            // Event listener untuk radio options
            radioOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const radioInput = this.querySelector('input[type="radio"]');
                    const targetForm = this.dataset.target;
                    
                    if (radioInput) {
                        radioInput.checked = true;
                        handleTindakLanjutChange(radioInput.value, targetForm);
                    }
                });
            });

            // Event listener untuk radio inputs
            radioInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    const targetForm = this.closest('.radio-option')?.dataset.target;
                    handleTindakLanjutChange(this.value, targetForm);
                });
            });

            function handleTindakLanjutChange(value, targetForm) {
                // Update visual state
                updateRadioOptionStates();
                
                // Hide semua conditional forms
                hideAllConditionalForms();
                
                // Show form yang dipilih
                if (targetForm) {
                    showConditionalForm(targetForm);
                }

                // Set default values
                setDefaultValues(value);

                updateTindakLanjutData();
            }

            function updateRadioOptionStates() {
                radioOptions.forEach(option => {
                    const radioInput = option.querySelector('input[type="radio"]');
                    
                    if (radioInput && radioInput.checked) {
                        option.classList.add('selected');
                    } else {
                        option.classList.remove('selected');
                    }
                });
            }

            function hideAllConditionalForms() {
                document.querySelectorAll('.conditional-form').forEach(form => {
                    form.style.display = 'none';
                });
            }

            function showConditionalForm(formId) {
                const form = document.getElementById(formId);
                if (form) {
                    form.style.display = 'block';
                }
            }

            function setDefaultValues(tindakLanjut) {
                const currentDate = new Date().toISOString().split('T')[0];
                const currentTime = new Date().toTimeString().slice(0, 5);

                switch(tindakLanjut) {
                    case 'berobatJalan':
                        // Set tanggal besok untuk berobat jalan
                        const tomorrow = new Date();
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        const tomorrowDate = tomorrow.toISOString().split('T')[0];
                        const tanggalRajalInput = document.querySelector('input[name="tanggal_rajal"]');
                        if (tanggalRajalInput) {
                            tanggalRajalInput.value = tomorrowDate;
                        }
                        break;
                }
            }

            document.addEventListener('input', function(e) {
                if (e.target.closest('.conditional-form')) {
                    updateTindakLanjutData();
                }
            });

            document.addEventListener('change', function(e) {
                if (e.target.closest('.conditional-form')) {
                    updateTindakLanjutData();
                }
            });

        }

        function updateTindakLanjutData() {
            const checkedRadio = document.querySelector('input[name="tindakLanjut"]:checked');
            
            if (!checkedRadio) {
                document.getElementById('tindakLanjutData').value = '';
                return;
            }

            const selectedOption = checkedRadio.value;
            const tindakLanjutData = { option: selectedOption };

            // Kumpulkan data berdasarkan option yang dipilih
            switch(selectedOption) {
                case 'rawatInap':
                    tindakLanjutData.tanggalRawatInap = document.querySelector('input[name="tanggalRawatInap"]')?.value || '';
                    tindakLanjutData.jamRawatInap = document.querySelector('input[name="jamRawatInap"]')?.value || '';
                    tindakLanjutData.keluhanUtama_ranap = document.querySelector('textarea[name="keluhanUtama_ranap"]')?.value || '';
                    tindakLanjutData.hasilPemeriksaan_ranap = document.querySelector('textarea[name="hasilPemeriksaan_ranap"]')?.value || '';
                    tindakLanjutData.jalannyaPenyakit_ranap = document.querySelector('textarea[name="jalannyaPenyakit_ranap"]')?.value || '';
                    tindakLanjutData.diagnosis_ranap = document.querySelector('textarea[name="diagnosis_ranap"]')?.value || '';
                    tindakLanjutData.tindakan_ranap = document.querySelector('textarea[name="tindakan_ranap"]')?.value || '';
                    tindakLanjutData.anjuran_ranap = document.querySelector('textarea[name="anjuran_ranap"]')?.value || '';
                    break;
                case 'rujukKeluar':
                    tindakLanjutData.tujuan_rujuk = document.querySelector('input[name="tujuan_rujuk"]')?.value || '';
                    tindakLanjutData.alasan_rujuk = document.querySelector('select[name="alasan_rujuk"]')?.value || '';
                    tindakLanjutData.transportasi_rujuk = document.querySelector('select[name="transportasi_rujuk"]')?.value || '';
                    tindakLanjutData.keterangan_rujuk = document.querySelector('textarea[name="keterangan_rujuk"]')?.value || '';
                    break;
                case 'pulangSembuh':
                    tindakLanjutData.tanggalPulang = document.querySelector('input[name="tanggalPulang"]')?.value || '';
                    tindakLanjutData.jamPulang = document.querySelector('input[name="jamPulang"]')?.value || '';
                    tindakLanjutData.alasan_pulang = document.querySelector('select[name="alasan_pulang"]')?.value || '';
                    tindakLanjutData.kondisi_pulang = document.querySelector('select[name="kondisi_pulang"]')?.value || '';
                    break;
                case 'berobatJalan':
                    tindakLanjutData.tanggal_rajal = document.querySelector('input[name="tanggal_rajal"]')?.value || '';
                    tindakLanjutData.poli_unit_tujuan = document.querySelector('select[name="poli_unit_tujuan"]')?.value || '';
                    tindakLanjutData.catatan_rajal = document.querySelector('textarea[name="catatan_rajal"]')?.value || '';
                    break;
                case 'menolakRawatInap':
                    tindakLanjutData.alasanMenolak = document.querySelector('textarea[name="alasanMenolak"]')?.value || '';
                    break;
                case 'meninggalDunia':
                    tindakLanjutData.tanggalMeninggal = document.querySelector('input[name="tanggalMeninggal"]')?.value || '';
                    tindakLanjutData.jamMeninggal = document.querySelector('input[name="jamMeninggal"]')?.value || '';
                    tindakLanjutData.penyebab_kematian = document.querySelector('textarea[name="penyebab_kematian"]')?.value || '';
                    break;
                case 'deathoffarrival':
                    tindakLanjutData.tanggalDoa = document.querySelector('input[name="tanggalDoa"]')?.value || '';
                    tindakLanjutData.jamDoa = document.querySelector('input[name="jamDoa"]')?.value || '';
                    tindakLanjutData.keterangan_doa = document.querySelector('textarea[name="keterangan_doa"]')?.value || '';
                    break;
            }

            // Update hidden input
            document.getElementById('tindakLanjutData').value = JSON.stringify(tindakLanjutData);
        }


        // =================== PAIN SCALE IMAGE FUNCTIONS ===================
        function initPainScaleImages() {
            const buttons = document.querySelectorAll('[data-scale]');
            const numericScale = document.getElementById('numericScale');
            const wongBakerScale = document.getElementById('wongBakerScale');

            if (buttons.length === 0) return;

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    handleScaleButtonClick(this, buttons, numericScale, wongBakerScale);
                });
            });

            // Show first scale by default
            if (buttons[0]) {
                buttons[0].click();
            }
        }

        function handleScaleButtonClick(clickedButton, allButtons, numericScale, wongBakerScale) {
            // Update button states
            allButtons.forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            clickedButton.classList.remove('btn-outline-primary');
            clickedButton.classList.add('btn-primary');

            // Show appropriate scale
            showSelectedScale(clickedButton.dataset.scale, numericScale, wongBakerScale);
        }

        function showSelectedScale(scale, numericScale, wongBakerScale) {
            if (!numericScale || !wongBakerScale) return;

            numericScale.style.display = 'none';
            wongBakerScale.style.display = 'none';

            if (scale === 'numeric') {
                numericScale.style.display = 'block';
            } else if (scale === 'wong-baker') {
                wongBakerScale.style.display = 'block';
            }
        }

        // =================== UTILITY FUNCTIONS ===================
        function showAlert(message, type = 'warning') {
            alert(message); // Simple alert for now, can be replaced with custom modal
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal && window.bootstrap) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
        }

        // =================== FORM VALIDATION ===================
        function validateForm() {
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        // Add form validation on submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        showAlert('Mohon lengkapi semua field yang wajib diisi');
                    }
                });
            }
        
        });
    </script>
@endpush