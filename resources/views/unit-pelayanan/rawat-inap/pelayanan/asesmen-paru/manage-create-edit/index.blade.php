<script>

    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle input fields based on radio button selection


        // Client-side validation on form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            let errors = [];

            // Check Merokok
            const merokok = document.querySelector('input[name="merokok"]:checked')?.value;
            if (merokok === 'ya') {
                const jumlah = document.getElementById('merokok_jumlah').value;
                const lama = document.getElementById('merokok_lama').value;
                if (!jumlah || jumlah < 0) {
                    errors.push('Jumlah batang/hari harus diisi dan tidak boleh negatif.');
                    document.getElementById('merokok_jumlah').classList.add('is-invalid');
                }
                if (!lama || lama < 0) {
                    errors.push('Lama merokok harus diisi dan tidak boleh negatif.');
                    document.getElementById('merokok_lama').classList.add('is-invalid');
                }
            }

            // Check Alkohol
            const alkohol = document.querySelector('input[name="alkohol"]:checked')?.value;
            if (alkohol === 'ya' && !document.getElementById('alkohol_jumlah').value.trim()) {
                errors.push('Jumlah konsumsi alkohol harus diisi.');
                document.getElementById('alkohol_jumlah').classList.add('is-invalid');
            }

            // Check Obat-obatan
            const obat = document.querySelector('input[name="obat_obatan"]:checked')?.value;
            if (obat === 'ya' && !document.getElementById('obat_jenis').value.trim()) {
                errors.push('Jenis obat-obatan harus diisi.');
                document.getElementById('obat_jenis').classList.add('is-invalid');
            }

            // If there are errors, prevent form submission and show alert
            if (errors.length > 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    html: errors.join('<br>'),
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        // Toggle 'lainnya' input based on checkbox
        const lainnyaCheck = document.getElementById('lainnya_check');
        const lainnyaInput = document.getElementById('lainnya');

        // Initialize state
        lainnyaInput.disabled = !lainnyaCheck.checked;
        if (!lainnyaCheck.checked) {
            lainnyaInput.value = '';
        }

        // Add event listener to checkbox
        lainnyaCheck.addEventListener('change', function () {
            lainnyaInput.disabled = !this.checked;
            if (!this.checked) {
                lainnyaInput.value = '';
                lainnyaInput.classList.remove('is-invalid');
            }
        });

        // Client-side validation on form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            let errors = [];

            // Validate 'lainnya' field
            if (lainnyaCheck.checked && !lainnyaInput.value.trim()) {
                errors.push('Rencana lainnya wajib diisi jika dicentang.');
                lainnyaInput.classList.add('is-invalid');
            } else {
                lainnyaInput.classList.remove('is-invalid');
            }

            // If there are errors, prevent submission and show alert
            if (errors.length > 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    html: errors.join('<br>'),
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });

    // pemeriksaan fisik baru
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle keterangan input based on radio selection
        function toggleKeteranganInput(radioName, keteranganId) {
            const radios = document.getElementsByName(radioName);
            const keteranganInput = document.getElementById(keteranganId);

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === '0') { // Tidak Normal
                        keteranganInput.disabled = false;
                        keteranganInput.focus();
                    } else { // Normal
                        keteranganInput.disabled = true;
                        keteranganInput.value = '';
                    }
                });
            });

            // Initialize state
            const selectedRadio = Array.from(radios).find(radio => radio.checked);
            if (selectedRadio) {
                keteranganInput.disabled = selectedRadio.value !== '0';
            }
        }

        // Apply toggle functionality to all pemeriksaan fisik items
        toggleKeteranganInput('paru_kepala', 'paru_kepala_keterangan');
        toggleKeteranganInput('paru_mata', 'paru_mata_keterangan');
        toggleKeteranganInput('paru_tht', 'paru_tht_keterangan');
        toggleKeteranganInput('paru_leher', 'paru_leher_keterangan');
        toggleKeteranganInput('paru_jantung', 'paru_jantung_keterangan');

        // Function to update JSON hidden input based on checkbox selections
        function updateCheckboxJSON(checkboxClass, hiddenInputId) {
            const checkboxes = document.querySelectorAll('.' + checkboxClass);
            const hiddenInput = document.getElementById(hiddenInputId);

            function updateJSON() {
                const selectedValues = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedValues.push(checkbox.value);
                    }
                });

                // Update hidden input dengan format JSON yang diinginkan: ["vesikuler","wheezing"]
                hiddenInput.value = selectedValues.length > 0 ? JSON.stringify(selectedValues) : '';

                // Debug log untuk melihat hasil
                console.log(`${hiddenInputId}:`, hiddenInput.value);
            }

            // Add event listeners to all checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateJSON);
            });

            // Initialize on page load
            updateJSON();
        }

        // Apply checkbox JSON functionality
        updateCheckboxJSON('paru-suara-pernafasan', 'paru_suara_pernafasan_json');
        updateCheckboxJSON('paru-suara-tambahan', 'paru_suara_tambahan_json');

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function (e) {
            // Update JSON values one more time before submit
            const paruSuaraPernafasanCheckboxes = document.querySelectorAll(
                '.paru-suara-pernafasan:checked');
            const paruSuaraTambahanCheckboxes = document.querySelectorAll(
                '.paru-suara-tambahan:checked');

            const suaraPernafasanValues = Array.from(paruSuaraPernafasanCheckboxes).map(cb => cb.value);
            const suaraTambahanValues = Array.from(paruSuaraTambahanCheckboxes).map(cb => cb.value);

            document.getElementById('paru_suara_pernafasan_json').value = suaraPernafasanValues.length >
                0 ? JSON.stringify(suaraPernafasanValues) : '';
            document.getElementById('paru_suara_tambahan_json').value = suaraTambahanValues.length > 0 ?
                JSON.stringify(suaraTambahanValues) : '';

            console.log('Final Suara Pernafasan:', document.getElementById('paru_suara_pernafasan_json')
                .value);
            console.log('Final Suara Tambahan:', document.getElementById('paru_suara_tambahan_json')
                .value);
        });
    });

    // Inisialisasi Site Marking Paru - letakkan di bagian akhir JavaScript
    document.addEventListener('DOMContentLoaded', function () {
        initParuSiteMarking();
    });

    function initParuSiteMarking() {
        const image = document.getElementById('paruAnatomyImage');
        const canvas = document.getElementById('paruMarkingCanvas');

        // Check if elements exist
        if (!image || !canvas) {
            console.error('Paru site marking elements not found');
            return;
        }

        const ctx = canvas.getContext('2d');
        const markingsList = document.getElementById('paruMarkingsList');
        const siteMarkingData = document.getElementById('siteMarkingParuData');
        const markingNote = document.getElementById('paruMarkingNote');
        const clearAllBtn = document.getElementById('paruClearAll');
        const undoBtn = document.getElementById('paruUndoLast');
        const saveBtn = document.getElementById('paruSaveMarking');
        const markingCount = document.getElementById('paruMarkingCount');
        const emptyState = document.getElementById('paruEmptyState');
        const brushSizeSlider = document.getElementById('paruBrushSize');
        const brushSizeValue = document.getElementById('paruBrushSizeValue');

        let savedMarkings = []; // Array untuk menyimpan penandaan yang sudah disimpan
        let currentStroke = []; // Array untuk stroke yang sedang digambar
        let allStrokes = []; // Array untuk semua stroke (termasuk yang belum disimpan)
        let markingCounter = 1;
        let currentColor = '#dc3545';
        let currentBrushSize = 2;
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        // Initialize
        initParuColorSelection();
        setupParuCanvas();
        loadParuExistingData();

        function setupParuCanvas() {
            function updateCanvasSize() {
                const rect = image.getBoundingClientRect();
                canvas.width = image.offsetWidth;
                canvas.height = image.offsetHeight;
                canvas.style.width = image.offsetWidth + 'px';
                canvas.style.height = image.offsetHeight + 'px';

                // Redraw all strokes
                redrawParuCanvas();
            }

            // Update canvas size when image loads
            image.onload = updateCanvasSize;

            // Update canvas size when window resizes
            window.addEventListener('resize', updateCanvasSize);

            // Initial setup
            if (image.complete) {
                updateCanvasSize();
            }
        }

        function initParuColorSelection() {
            document.querySelectorAll('.paru-color-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    currentColor = this.getAttribute('data-color');
                    updateParuColorSelection();
                });
            });
        }

        function updateParuColorSelection() {
            document.querySelectorAll('.paru-color-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            const selectedBtn = document.querySelector(`.paru-color-btn[data-color="${currentColor}"]`);
            if (selectedBtn) {
                selectedBtn.classList.add('active');
            }
        }

        // Brush size slider
        brushSizeSlider.addEventListener('input', function () {
            currentBrushSize = parseFloat(this.value);
            brushSizeValue.textContent = currentBrushSize;
        });

        // Mouse events for drawing
        canvas.addEventListener('mousedown', function (e) {
            isDrawing = true;
            const rect = canvas.getBoundingClientRect();
            lastX = e.clientX - rect.left;
            lastY = e.clientY - rect.top;

            // Start new stroke
            currentStroke = [{
                x: (lastX / canvas.width) * 100,
                y: (lastY / canvas.height) * 100,
                color: currentColor,
                size: currentBrushSize
            }];
        });

        canvas.addEventListener('mousemove', function (e) {
            if (!isDrawing) return;

            const rect = canvas.getBoundingClientRect();
            const currentX = e.clientX - rect.left;
            const currentY = e.clientY - rect.top;

            // Add point to current stroke dengan interpolasi untuk smooth line
            const distance = Math.sqrt(Math.pow(currentX - lastX, 2) + Math.pow(currentY - lastY, 2));

            // Hanya tambah point jika jarak cukup untuk menghindari point yang terlalu rapat
            if (distance > 1) {
                currentStroke.push({
                    x: (currentX / canvas.width) * 100,
                    y: (currentY / canvas.height) * 100,
                    color: currentColor,
                    size: currentBrushSize
                });

                // Draw smooth line dengan quadratic curve
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = currentBrushSize;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.globalAlpha = 0.8; // Sedikit transparansi untuk efek natural

                // Menggunakan quadratic curve untuk smooth line
                const midX = (lastX + currentX) / 2;
                const midY = (lastY + currentY) / 2;

                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.quadraticCurveTo(lastX, lastY, midX, midY);
                ctx.stroke();

                lastX = currentX;
                lastY = currentY;
            }
        });

        canvas.addEventListener('mouseup', function (e) {
            if (!isDrawing) return;
            isDrawing = false;

            // Add current stroke to all strokes if it has points
            if (currentStroke.length > 1) {
                allStrokes.push([...currentStroke]);
            }
        });

        // Save current drawing as a marking
        saveBtn.addEventListener('click', function () {
            if (allStrokes.length === 0) {
                alert('Tidak ada penandaan untuk disimpan. Silakan gambar terlebih dahulu.');
                return;
            }

            const note = markingNote.value.trim() || `Penandaan Paru ${markingCounter}`;

            const marking = {
                id: `paru_mark_${Date.now()}`,
                strokes: JSON.parse(JSON.stringify(allStrokes)), // Deep copy
                note: note,
                timestamp: new Date().toISOString()
            };

            savedMarkings.push(marking);

            // Add to list
            addToParuMarkingsList(marking);

            // Update hidden input and counter
            updateParuHiddenInput();
            updateParuMarkingCount();

            // Clear note input and current drawing
            markingNote.value = '';
            allStrokes = [];
            currentStroke = [];
            markingCounter++;

            // Clear canvas and redraw only saved markings
            redrawParuCanvas();

            alert('Penandaan berhasil disimpan!');
        });

        // Undo last stroke
        undoBtn.addEventListener('click', function () {
            if (allStrokes.length === 0) {
                alert('Tidak ada stroke untuk di-undo.');
                return;
            }

            allStrokes.pop();
            redrawParuCanvas();
        });

        // Clear all markings
        clearAllBtn.addEventListener('click', function () {
            if (savedMarkings.length === 0 && allStrokes.length === 0) {
                alert('Tidak ada penandaan untuk dihapus.');
                return;
            }

            if (confirm('Hapus semua penandaan? Tindakan ini tidak dapat dibatalkan.')) {
                savedMarkings = [];
                allStrokes = [];
                currentStroke = [];
                markingsList.innerHTML =
                    '<div class="text-muted text-center py-3" id="paruEmptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
                updateParuHiddenInput();
                updateParuMarkingCount();
                redrawParuCanvas();
                markingCounter = 1;
            }
        });

        function redrawParuCanvas() {
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw all saved markings
            savedMarkings.forEach(marking => {
                drawStrokesOnCanvas(marking.strokes);
            });

            // Draw current unsaved strokes
            drawStrokesOnCanvas(allStrokes);
        }

        function drawStrokesOnCanvas(strokesArray) {
            strokesArray.forEach(stroke => {
                if (stroke.length < 2) return;

                ctx.strokeStyle = stroke[0].color;
                ctx.lineWidth = stroke[0].size;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.globalAlpha = 0.8; // Transparansi untuk efek natural

                ctx.beginPath();
                const firstPoint = stroke[0];
                ctx.moveTo(
                    (firstPoint.x / 100) * canvas.width,
                    (firstPoint.y / 100) * canvas.height
                );

                // Menggunakan smooth curve untuk redraw
                for (let i = 1; i < stroke.length - 1; i++) {
                    const currentPoint = stroke[i];
                    const nextPoint = stroke[i + 1];

                    const currentX = (currentPoint.x / 100) * canvas.width;
                    const currentY = (currentPoint.y / 100) * canvas.height;
                    const nextX = (nextPoint.x / 100) * canvas.width;
                    const nextY = (nextPoint.y / 100) * canvas.height;

                    const midX = (currentX + nextX) / 2;
                    const midY = (currentY + nextY) / 2;

                    ctx.quadraticCurveTo(currentX, currentY, midX, midY);
                }

                // Terakhir, gambar ke point terakhir
                if (stroke.length > 1) {
                    const lastPoint = stroke[stroke.length - 1];
                    ctx.lineTo(
                        (lastPoint.x / 100) * canvas.width,
                        (lastPoint.y / 100) * canvas.height
                    );
                }

                ctx.stroke();
                ctx.globalAlpha = 1; // Reset alpha
            });
        }

        function addToParuMarkingsList(marking) {
            // Hide empty state
            const emptyStateEl = document.getElementById('paruEmptyState');
            if (emptyStateEl) {
                emptyStateEl.style.display = 'none';
            }

            const listItem = document.createElement('div');
            listItem.className = 'paru-marking-list-item';
            listItem.setAttribute('data-marking-id', marking.id);

            listItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold">${marking.note}</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-secondary" style="font-size: 10px;">CORET</span>
                            <small class="text-muted">${new Date(marking.timestamp).toLocaleTimeString('id-ID')}</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteParuMarking('${marking.id}')">
                        <i class="ti-trash"></i>
                    </button>
                </div>
            `;

            markingsList.appendChild(listItem);
        }

        function updateParuMarkingCount() {
            markingCount.textContent = savedMarkings.length;

            // Show/hide empty state
            const emptyStateEl = document.getElementById('paruEmptyState');
            if (emptyStateEl) {
                if (savedMarkings.length === 0) {
                    emptyStateEl.style.display = 'block';
                } else {
                    emptyStateEl.style.display = 'none';
                }
            }
        }

        function updateParuHiddenInput() {
            siteMarkingData.value = JSON.stringify(savedMarkings);
        }

        function loadParuExistingData() {
            try {
                const existingData = JSON.parse(siteMarkingData.value || '[]');
                if (existingData.length > 0) {
                    savedMarkings = existingData;
                    markingCounter = savedMarkings.length + 1;

                    // Rebuild list
                    markingsList.innerHTML =
                        '<div class="text-muted text-center py-3" id="paruEmptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
                    savedMarkings.forEach(marking => {
                        addToParuMarkingsList(marking);
                    });

                    updateParuMarkingCount();

                    // Redraw canvas after a short delay
                    setTimeout(() => {
                        redrawParuCanvas();
                    }, 100);
                }
            } catch (e) {
                console.error('Error loading existing paru marking data:', e);
            }
        }

        // Global function for delete
        window.deleteParuMarking = function (markingId) {
            if (confirm('Hapus penandaan ini?')) {
                // Remove from array
                savedMarkings = savedMarkings.filter(m => m.id !== markingId);

                // Remove from list
                const listElement = markingsList.querySelector(`[data-marking-id="${markingId}"]`);
                if (listElement) {
                    markingsList.removeChild(listElement);
                }

                updateParuHiddenInput();
                updateParuMarkingCount();
                redrawParuCanvas();
            }
        };
    }

    

</script>