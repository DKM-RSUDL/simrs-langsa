@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        // 5. Pemantauan Selama Anestesi dan Sedasi
        document.addEventListener('DOMContentLoaded', function () {
            // Pastikan SweetAlert2 sudah dimuat
            if (typeof Swal === 'undefined') {
                console.warn('SweetAlert2 tidak ditemukan. Menggunakan konfirmasi standar sebagai fallback.');
            }

            // Fungsi untuk mengisolasi kode dari pengaruh luar
            initPemantauanAnestesiSedasi();

            function initPemantauanAnestesiSedasi() {
                // Set current time to time input field
                setCurrentTimePAS();

                // Initialize the chart
                let vitalSignsChartPAS;
                const vitalSignsCtxPAS = document.getElementById('vitalSignsChartPAS').getContext('2d');

                // Initial data
                const timeLabelsPAS = [];
                const tekananDarahDataPAS = [];
                const nadiDataPAS = [];
                const nafasDataPAS = [];
                const spo2DataPAS = [];

                // Load or initialize all monitoring data array
                let allMonitoringDataPAS = [];
                try {
                    const savedDataPAS = document.getElementById('all_monitoring_data_pas').value;
                    if (savedDataPAS && savedDataPAS !== '[]') {
                        allMonitoringDataPAS = JSON.parse(savedDataPAS);

                        // Populate arrays from saved data
                        allMonitoringDataPAS.forEach(item => {
                            timeLabelsPAS.push(item.time);
                            tekananDarahDataPAS.push(item.tekananDarah);
                            nadiDataPAS.push(item.nadi);
                            nafasDataPAS.push(item.nafas);
                            spo2DataPAS.push(item.spo2);
                        });
                    }
                } catch (error) {
                    console.error('Error loading saved data PAS:', error);
                    allMonitoringDataPAS = [];
                }

                // Create the chart
                function initChartPAS() {
                    vitalSignsChartPAS = new Chart(vitalSignsCtxPAS, {
                        type: 'line',
                        data: {
                            labels: timeLabelsPAS,
                            datasets: [
                                {
                                    label: 'Sistole',
                                    data: sistoleDataPAS,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Diastole',
                                    data: diastoleDataPAS,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Nadi',
                                    data: nadiDataPAS,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Nafas',
                                    data: nafasDataPAS,
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'SPO₂',
                                    data: spo2DataPAS,
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderColor: 'rgba(255, 159, 64, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    min: 0,
                                    max: 250,
                                    ticks: {
                                        stepSize: 50
                                    }
                                }
                            },
                            elements: {
                                point: {
                                    radius: 4
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                tooltip: {
                                    enabled: true,
                                    mode: 'index',
                                    intersect: false
                                }
                            }
                        }
                    });
                }

                // Function to set current time
                function setCurrentTimePAS() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const currentTime = `${hours}:${minutes}`;

                    const waktuEl = document.getElementById('waktu_pemantauan_pas');
                    if (waktuEl) waktuEl.value = currentTime;
                }

                // Function to display monitoring data in a table
                function displayMonitoringTable() {
                    // Create or update table element
                    let tableContainer = document.getElementById('monitoring-table-container');
                    if (!tableContainer) {
                        tableContainer = document.createElement('div');
                        tableContainer.id = 'monitoring-table-container';
                        tableContainer.className = 'table-responsive mt-4';

                        // Insert after chart
                        const chartElement = document.getElementById('vitalSignsChartPAS');
                        if (chartElement && chartElement.parentNode) {
                            chartElement.parentNode.insertBefore(tableContainer, chartElement.nextSibling);
                        }
                    }

                    if (allMonitoringDataPAS.length === 0) {
                        tableContainer.innerHTML = '<div class="alert alert-info">Belum ada data pemantauan yang tersimpan.</div>';
                        return;
                    }

                    // Create table HTML
                    let tableHTML = `
                    <h6 class="mt-3 mb-2">Data Pemantauan</h6>
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Sistole (mmHg)</th>
                                <th>Diastole (mmHg)</th>
                                <th>Nadi (Per Menit)</th>
                                <th>Nafas (Per Menit)</th>
                                <th>SpO₂ (%)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                    // Add rows for each data point
                    allMonitoringDataPAS.forEach((item, index) => {
                        tableHTML += `
                        <tr>
                            <td>${item.time}</td>
                            <td>${item.tekananDarah}</td>
                            <td>${item.nadi}</td>
                            <td>${item.nafas}</td>
                            <td>${item.spo2}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning edit-data-btn me-1" data-index="${index}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-data-btn" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    tableHTML += `
                        </tbody>
                    </table>
                `;

                    tableContainer.innerHTML = tableHTML;

                    // Add event listeners to edit buttons
                    const editButtons = document.querySelectorAll('.edit-data-btn');
                    editButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const index = parseInt(this.getAttribute('data-index'));
                            editDataPoint(index);
                        });
                    });

                    // Add event listeners to delete buttons
                    const deleteButtons = document.querySelectorAll('.delete-data-btn');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const index = parseInt(this.getAttribute('data-index'));
                            deleteDataPoint(index);
                        });
                    });
                }

                // Function to edit data point
                function editDataPoint(index) {
                    if (index >= 0 && index < allMonitoringDataPAS.length) {
                        const dataPoint = allMonitoringDataPAS[index];

                        // Fill form with data for editing
                        document.getElementById('waktu_pemantauan_pas').value = dataPoint.time;
                        document.getElementById('tekanan_darah_pantau_pas').value = dataPoint.tekananDarah;
                        document.getElementById('nadi_pantau_pas').value = dataPoint.nadi;
                        document.getElementById('nafas_pantau_pas').value = dataPoint.nafas;
                        document.getElementById('saturasi_oksigen_pantau_pas').value = dataPoint.spo2;

                        // Change button to update mode
                        const saveButton = document.getElementById('saveButtonPAS');
                        saveButton.innerHTML = '<i class="fas fa-check"></i> Perbarui';
                        saveButton.setAttribute('data-editing-index', index);

                        // Scroll to form
                        document.getElementById('monitoringFormPAS').scrollIntoView({ behavior: 'smooth' });
                    }
                }

                // Function to delete a data point with SweetAlert
                function deleteDataPoint(index) {
                    if (index >= 0 && index < allMonitoringDataPAS.length) {
                        // Use SweetAlert if available, otherwise use standard confirm
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Hapus Data?',
                                text: "Data pemantauan yang dihapus tidak dapat dikembalikan!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Perform deletion
                                    performDelete(index);

                                    // Show success message
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: 'Data pemantauan berhasil dihapus.',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            });
                        } else {
                            // Fallback to standard confirm
                            if (confirm('Apakah Anda yakin ingin menghapus data pemantauan ini?')) {
                                // Perform deletion
                                performDelete(index);

                                // Show success message
                                showAlertPAS('Data berhasil dihapus!', 'success');
                            }
                        }
                    }
                }

                // Helper function to perform actual deletion
                function performDelete(index) {
                    // Remove data point from arrays
                    allMonitoringDataPAS.splice(index, 1);
                    timeLabelsPAS.splice(index, 1);
                    sistoleDataPAS.splice(index, 1);
                    diastoleDataPAS.splice(index, 1);
                    nadiDataPAS.splice(index, 1);
                    nafasDataPAS.splice(index, 1);
                    spo2DataPAS.splice(index, 1);

                    // Update hidden input
                    document.getElementById('all_monitoring_data_pas').value = JSON.stringify(allMonitoringDataPAS);

                    // Update chart
                    vitalSignsChartPAS.update();

                    // Update table
                    displayMonitoringTable();

                    // If we're in edit mode and deleting the currently edited item, reset form
                    const saveButton = document.getElementById('saveButtonPAS');
                    const editIndex = saveButton.getAttribute('data-editing-index');
                    if (editIndex !== null && parseInt(editIndex) === index) {
                        saveButton.removeAttribute('data-editing-index');
                        saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan';
                        resetFormPAS();
                    }
                }

                // Load sample data
                function loadSampleDataPAS() {
                    // Use SweetAlert if available
                    const proceedWithLoading = () => {
                        // Clear existing data
                        timeLabelsPAS.length = 0;
                        sistoleDataPAS.length = 0;
                        diastoleDataPAS.length = 0;
                        nadiDataPAS.length = 0;
                        nafasDataPAS.length = 0;
                        spo2DataPAS.length = 0;
                        allMonitoringDataPAS = [];

                        // Sample data
                        const sampleDataPAS = [
                            { time: "08:00", sistolik: 140, diastolik: 90, nadi: 90, nafas: 45, spo2: 95 },
                            { time: "08:05", sistolik: 120, diastolik: 80, nadi: 70, nafas: 25, spo2: 90 },
                            { time: "08:10", sistolik: 135, diastolik: 85, nadi: 85, nafas: 40, spo2: 92 },
                            { time: "08:15", sistolik: 215, diastolik: 100, nadi: 100, nafas: 60, spo2: 98 }
                        ];

                        // Add each data point
                        sampleDataPAS.forEach(item => {
                            timeLabelsPAS.push(item.time);
                            sistoleDataPAS.push(item.sistolik);
                            diastoleDataPAS.push(item.diastolik);
                            nadiDataPAS.push(item.nadi);
                            nafasDataPAS.push(item.nafas);
                            spo2DataPAS.push(item.spo2);
                            allMonitoringDataPAS.push(item);
                        });

                        // Update hidden input
                        document.getElementById('all_monitoring_data_pas').value = JSON.stringify(allMonitoringDataPAS);

                        // Update chart
                        vitalSignsChartPAS.update();

                        // Update table
                        displayMonitoringTable();

                        // Show success message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data contoh berhasil dimuat',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            showAlertPAS('Data contoh berhasil dimuat!', 'success');
                        }
                    };

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Muat Data Contoh?',
                            text: "Data yang sudah ada akan diganti dengan data contoh!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, muat!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                proceedWithLoading();
                            }
                        });
                    } else {
                        // Fallback to standard confirm
                        if (confirm('Data yang sudah ada akan diganti dengan data contoh. Lanjutkan?')) {
                            proceedWithLoading();
                        }
                    }
                }

                // Reset all data with confirmation
                function resetAllDataPAS() {
                    const performReset = () => {
                        // Clear all data arrays
                        timeLabelsPAS.length = 0;
                        sistoleDataPAS.length = 0;
                        diastoleDataPAS.length = 0;
                        nadiDataPAS.length = 0;
                        nafasDataPAS.length = 0;
                        spo2DataPAS.length = 0;
                        allMonitoringDataPAS = [];

                        // Update hidden input
                        document.getElementById('all_monitoring_data_pas').value = JSON.stringify(allMonitoringDataPAS);

                        // Update chart
                        vitalSignsChartPAS.update();

                        // Update table
                        displayMonitoringTable();

                        // Reset form
                        resetFormPAS();

                        // Reset edit mode if active
                        const saveButton = document.getElementById('saveButtonPAS');
                        if (saveButton.hasAttribute('data-editing-index')) {
                            saveButton.removeAttribute('data-editing-index');
                            saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan';
                        }

                        // Show success message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Semua data pemantauan telah dihapus',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            showAlertPAS('Semua data telah dihapus!', 'warning');
                        }
                    };

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Hapus Semua Data?',
                            text: "Semua data pemantauan akan dihapus dan tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus semua!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                performReset();
                            }
                        });
                    } else {
                        if (confirm('Apakah Anda yakin ingin menghapus SEMUA data pemantauan?')) {
                            performReset();
                        }
                    }
                }

                // Initialize the chart
                initChartPAS();

                // Display initial monitoring data table
                displayMonitoringTable();

                // Add event listener to load sample data button
                const loadDataButtonPAS = document.getElementById('loadDataButtonPAS');
                if (loadDataButtonPAS) {
                    loadDataButtonPAS.addEventListener('click', loadSampleDataPAS);
                }

                // Add event listener to reset data button
                const resetDataButtonPAS = document.getElementById('resetDataButtonPAS');
                if (resetDataButtonPAS) {
                    resetDataButtonPAS.addEventListener('click', resetAllDataPAS);
                }

                // Add event listener to the save button
                const saveButtonPAS = document.getElementById('saveButtonPAS');
                if (saveButtonPAS) {
                    saveButtonPAS.addEventListener('click', function () {
                        // Check if we're in edit mode
                        const editingIndex = this.getAttribute('data-editing-index');
                        const isEditMode = editingIndex !== null && editingIndex !== undefined;

                        // Validate form fields
                        if (!validateFormPAS()) {
                            return;
                        }

                        // Get form values
                        const time = document.getElementById('waktu_pemantauan_pas').value;
                        const sistole = parseFloat(document.getElementById('sistole_pantau_pas').value);
                        const diastole = parseFloat(document.getElementById('diastole_pantau_pas').value);
                        const nadi = parseFloat(document.getElementById('nadi_pantau_pas').value);
                        const nafas = parseFloat(document.getElementById('nafas_pantau_pas').value);
                        const spo2 = parseFloat(document.getElementById('saturasi_oksigen_pantau_pas').value);

                        // Create data object
                        const dataPoint = {
                            time: time,
                            sistole: sistole,
                            diastole: diastole,
                            nadi: nadi,
                            nafas: nafas,
                            spo2: spo2
                        };

                        if (isEditMode) {
                            // Edit existing data point
                            const index = parseInt(editingIndex);

                            // Update data arrays
                            allMonitoringDataPAS[index] = dataPoint;
                            timeLabelsPAS[index] = time;
                            sistoleDataPAS[index] = sistole;
                            diastoleDataPAS[index] = diastole;
                            nadiDataPAS[index] = nadi;
                            nafasDataPAS[index] = nafas;
                            spo2DataPAS[index] = spo2;

                            // Reset edit mode
                            this.removeAttribute('data-editing-index');
                            this.innerHTML = '<i class="fas fa-save"></i> Simpan';

                            // Success message
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data pemantauan berhasil diperbarui',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                showAlertPAS('Data pemantauan berhasil diperbarui!', 'success');
                            }
                        } else {
                            // Add new data point
                            allMonitoringDataPAS.push(dataPoint);

                            // Add to chart arrays
                            timeLabelsPAS.push(time);
                            sistoleDataPAS.push(sistole);
                            diastoleDataPAS.push(diastole);
                            nadiDataPAS.push(nadi);
                            nafasDataPAS.push(nafas);
                            spo2DataPAS.push(spo2);

                            // Success message
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data pemantauan berhasil ditambahkan',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                showAlertPAS('Data pemantauan berhasil ditambahkan ke grafik.', 'success');
                            }
                        }

                        // Update hidden input with JSON string
                        document.getElementById('all_monitoring_data_pas').value = JSON.stringify(allMonitoringDataPAS);

                        // Update the chart
                        vitalSignsChartPAS.update();

                        // Update table
                        displayMonitoringTable();

                        // Reset form
                        resetFormPAS();
                    });
                }

                // Validate form input fields
                function validateFormPAS() {
                    let isValid = true;
                    const requiredFields = [
                        'waktu_pemantauan_pas',
                        'sistole_pantau_pas',
                        'diastole_pantau_pas',
                        'nadi_pantau_pas',
                        'nafas_pantau_pas',
                        'saturasi_oksigen_pantau_pas'
                    ];

                    requiredFields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field && !field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else if (field) {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Harap isi semua kolom yang diperlukan!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            showAlertPAS('Harap isi semua kolom yang diperlukan!', 'danger');
                        }
                    }

                    return isValid;
                }

                // Show alert message
                function showAlertPAS(message, type = 'success') {
                    // Create alert element
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `alert alert-${type} alert-dismissible fade show pas-alert`;
                    alertDiv.setAttribute('role', 'alert');
                    alertDiv.innerHTML = `
                    <strong>${type === 'success' ? 'Berhasil!' : 'Perhatian!'}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;

                    // Insert alert before the form
                    const form = document.getElementById('monitoringFormPAS');
                    if (form) {
                        form.parentNode.insertBefore(alertDiv, form);

                        // Automatically remove the alert after 3 seconds
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.parentNode.removeChild(alertDiv);
                            }
                        }, 3000);
                    }
                }

                // Reset form fields after submission
                function resetFormPAS() {
                    // Set current time
                    setCurrentTimePAS();

                    // Reset other fields
                    const fields = [
                        { id: 'sistole_pantau_pas', value: '' },
                        { id: 'diastole_pantau_pas', value: '' },
                        { id: 'nadi_pantau_pas', value: '' },
                        { id: 'nafas_pantau_pas', value: '' },
                        { id: 'saturasi_oksigen_pantau_pas', value: '' }
                    ];

                    fields.forEach(field => {
                        const element = document.getElementById(field.id);
                        if (element) {
                            element.value = field.value;
                            element.classList.remove('is-invalid');
                        }
                    });
                }
            }
        });

        // 6. Catatan Kamar Pemulihan
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk mengisolasi kode dari pengaruh luar
            initCatatanKamarPemulihan();

            function initCatatanKamarPemulihan() {
                // Get all necessary elements
                const observasiContainer = document.getElementById('observasiFormCKP');
                const hiddenInput = document.getElementById('all_observasi_data_ckp');
                const waktuObservasiInput = document.getElementById('waktu_observasi_ckp');
                const sistoleInput = document.getElementById('sistole_pemulihan_ckp');
                const diastoleInput = document.getElementById('diastole_pemulihan_ckp');
                const nadiInput = document.getElementById('nadi_pemulihan_ckp');
                const nafasInput = document.getElementById('nafas_pemulihan_ckp');
                const spo2Input = document.getElementById('saturasi_oksigen_pemulihan_ckp');
                const tvsInput = document.getElementById('tanda_vital_stabil_ckp');
                const saveButton = document.getElementById('saveObservasiButtonCKP');
                const loadSampleButton = document.getElementById('loadSampleButtonCKP');
                const resetButton = document.getElementById('resetDataButtonCKP');
                const chartCanvas = document.getElementById('recoveryVitalChartCKP');
                const tableContainer = document.getElementById('observasi-table-container');

                // Find the main form that will be submitted to the server
                const mainForm = observasiContainer.closest('form');

                // Check if essential elements exist
                if (!observasiContainer || !hiddenInput || !chartCanvas) {
                    console.error('Essential elements missing from the DOM');
                    return;
                }

                // Set current time to time input fields
                setCurrentTimeCKP();

                // Initialize chart context
                const chartCtx = chartCanvas.getContext('2d');
                let vitalChart;

                // Data arrays for chart
                const timeLabels = [];
                const sistoleData = [];
                const diastoleData = [];
                const nadiData = [];
                const nafasData = [];
                const spo2Data = [];
                const tvsData = [];

                // Load or initialize all observasi data array
                let allObservasiData = [];

                try {
                    // Make sure to get the current value from the hidden input
                    const savedData = hiddenInput.value;
                    if (savedData && savedData !== '[]') {
                        allObservasiData = JSON.parse(savedData);

                        // Populate chart arrays from saved data
                        allObservasiData.forEach(item => {
                            timeLabels.push(item.time);
                            sistoleData.push(item.sistole);
                            diastoleData.push(item.diastole);
                            nadiData.push(item.nadi);
                            nafasData.push(item.nafas);
                            spo2Data.push(item.spo2);
                            tvsData.push(item.tvs);
                        });
                    }
                } catch (error) {
                    console.error('Error loading saved data:', error);
                    // Initialize as empty array if there's an error
                    allObservasiData = [];
                    // Clear the hidden input to prevent future parsing errors
                    hiddenInput.value = JSON.stringify(allObservasiData);
                }

                // Initialize the chart
                initChart();

                // Display data table
                updateDataTable();

                // Add event listeners to buttons
                if (saveButton) {
                    saveButton.addEventListener('click', saveObservationData);
                }

                if (loadSampleButton) {
                    loadSampleButton.addEventListener('click', loadSampleData);
                }

                if (resetButton) {
                    resetButton.addEventListener('click', resetAllData);
                }

                // Add event listener to the main form if it exists
                if (mainForm) {
                    mainForm.addEventListener('submit', function (e) {
                        // Make sure the hidden input has the most recent data before submission
                        hiddenInput.value = JSON.stringify(allObservasiData);
                        console.log('Form submission - observation data:', hiddenInput.value);
                    });
                }

                // Function to create chart
                function initChart() {
                    // Destroy existing chart if it exists
                    if (vitalChart) {
                        vitalChart.destroy();
                    }

                    vitalChart = new Chart(chartCtx, {
                        type: 'line',
                        data: {
                            labels: timeLabels,
                            datasets: [
                                {
                                    label: 'Sistole',
                                    data: sistoleData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Diastole',
                                    data: diastoleData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Nadi',
                                    data: nadiData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Nafas',
                                    data: nafasData,
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'SPO₂',
                                    data: spo2Data,
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderColor: 'rgba(255, 159, 64, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'TVS',
                                    data: tvsData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    min: 0,
                                    max: 200,
                                    ticks: {
                                        stepSize: 50
                                    }
                                }
                            },
                            elements: {
                                point: {
                                    radius: 4
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: true,
                                    mode: 'index',
                                    intersect: false
                                }
                            }
                        }
                    });
                }

                // Function to update data table
                function updateDataTable() {
                    if (!tableContainer) return;

                    if (allObservasiData.length === 0) {
                        tableContainer.innerHTML = '<div class="alert alert-info">Belum ada data observasi yang tersimpan.</div>';
                        return;
                    }

                    // Create table HTML
                    let tableHTML = `
                            <h6 class="mb-2">Data Observasi</h6>
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Sistole</th>
                                        <th>Diastole</th>
                                        <th>Nadi</th>
                                        <th>Nafas</th>
                                        <th>SpO₂</th>
                                        <th>TVS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                    // Add rows for each data point
                    allObservasiData.forEach((item, index) => {
                        tableHTML += `
                                <tr>
                                    <td>${item.time}</td>
                                    <td>${item.sistole}</td>
                                    <td>${item.diastole}</td>
                                    <td>${item.nadi}</td>
                                    <td>${item.nafas}</td>
                                    <td>${item.spo2}</td>
                                    <td>${item.tvs}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning edit-data-btn me-1" data-index="${index}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-data-btn" data-index="${index}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                    });

                    tableHTML += `
                                </tbody>
                            </table>
                        `;

                    tableContainer.innerHTML = tableHTML;

                    // Add event listeners to edit buttons
                    const editButtons = document.querySelectorAll('.edit-data-btn');
                    editButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const index = parseInt(this.getAttribute('data-index'));
                            editObservationData(index);
                        });
                    });

                    // Add event listeners to delete buttons
                    const deleteButtons = document.querySelectorAll('.delete-data-btn');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const index = parseInt(this.getAttribute('data-index'));
                            deleteObservationData(index);
                        });
                    });
                }

                // Function to save observation data
                function saveObservationData() {
                    // Validate form inputs
                    if (!validateFormData()) {
                        return;
                    }

                    // Get values from form
                    const time = waktuObservasiInput.value;
                    const sistole = parseFloat(sistoleInput.value);
                    const diastole = parseFloat(diastoleInput.value);
                    const nadi = parseFloat(nadiInput.value);
                    const nafas = parseFloat(nafasInput.value);
                    const spo2 = parseFloat(spo2Input.value);
                    const tvs = parseFloat(tvsInput.value);

                    // Create data object
                    const dataPoint = {
                        time: time,
                        sistole: sistole,
                        diastole: diastole,
                        nadi: nadi,
                        nafas: nafas,
                        spo2: spo2,
                        tvs: tvs
                    };

                    // Check if we're in edit mode (using a data attribute on the save button)
                    const editIndex = saveButton.getAttribute('data-editing-index');

                    if (editIndex !== null && editIndex !== undefined) {
                        // Update existing data point
                        const index = parseInt(editIndex);
                        allObservasiData[index] = dataPoint;

                        // Update chart data arrays
                        timeLabels[index] = time;
                        sistoleData[index] = sistole;
                        diastoleData[index] = diastole;
                        nadiData[index] = nadi;
                        nafasData[index] = nafas;
                        spo2Data[index] = spo2;
                        tvsData[index] = tvs;

                        // Clear edit mode
                        saveButton.removeAttribute('data-editing-index');
                        saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan';

                        // Show success message
                        showAlert('Data observasi berhasil diperbarui!', 'success');
                    } else {
                        // Add new data point
                        allObservasiData.push(dataPoint);

                        // Add to chart arrays
                        timeLabels.push(time);
                        sistoleData.push(sistole);
                        diastoleData.push(diastole);
                        nadiData.push(nadi);
                        nafasData.push(nafas);
                        spo2Data.push(spo2);
                        tvsData.push(tvs);

                        // Show success message
                        showAlert('Data observasi berhasil ditambahkan!', 'success');
                    }

                    // Update hidden input with JSON string - THIS IS CRITICAL
                    hiddenInput.value = JSON.stringify(allObservasiData);

                    // Debug log to verify the value was actually set
                    console.log('Data JSON diperbarui:', hiddenInput.value);

                    // Update the chart
                    vitalChart.update();

                    // Update the data table
                    updateDataTable();

                    // Reset form fields
                    resetForm();
                }

                // Function to edit observation data
                function editObservationData(index) {
                    if (index >= 0 && index < allObservasiData.length) {
                        // Get data point
                        const dataPoint = allObservasiData[index];

                        // Fill form with data
                        waktuObservasiInput.value = dataPoint.time;
                        sistoleInput.value = dataPoint.sistole;
                        diastoleInput.value = dataPoint.diastole;
                        nadiInput.value = dataPoint.nadi;
                        nafasInput.value = dataPoint.nafas;
                        spo2Input.value = dataPoint.spo2;
                        tvsInput.value = dataPoint.tvs;

                        // Set save button to edit mode
                        saveButton.setAttribute('data-editing-index', index);
                        saveButton.innerHTML = '<i class="fas fa-check"></i> Perbarui';

                        // Scroll to form
                        observasiContainer.scrollIntoView({ behavior: 'smooth' });
                    }
                }

                // Function to delete observation data
                function deleteObservationData(index) {
                    if (index >= 0 && index < allObservasiData.length) {
                        // Gunakan SweetAlert2 untuk konfirmasi
                        Swal.fire({
                            title: 'Hapus Data?',
                            text: "Data observasi yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Remove data point from arrays
                                allObservasiData.splice(index, 1);
                                timeLabels.splice(index, 1);
                                sistoleData.splice(index, 1);
                                diastoleData.splice(index, 1);
                                nadiData.splice(index, 1);
                                nafasData.splice(index, 1);
                                spo2Data.splice(index, 1);
                                tvsData.splice(index, 1);

                                // Update hidden input
                                hiddenInput.value = JSON.stringify(allObservasiData);

                                // Update chart
                                vitalChart.update();

                                // Update table
                                updateDataTable();

                                // Show success message with SweetAlert2
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data observasi berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // If we're in edit mode and deleting the currently edited item, reset form
                                const editIndex = saveButton.getAttribute('data-editing-index');
                                if (editIndex !== null && parseInt(editIndex) === index) {
                                    saveButton.removeAttribute('data-editing-index');
                                    saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan';
                                    resetForm();
                                }
                            }
                        });
                    }
                }

                // Function to load sample data
                function loadSampleData() {
                    if (confirm('Perhatian: Data contoh akan menimpa data yang sudah ada. Lanjutkan?')) {
                        // Clear existing data
                        timeLabels.length = 0;
                        sistoleData.length = 0;
                        diastoleData.length = 0;
                        nadiData.length = 0;
                        nafasData.length = 0;
                        spo2Data.length = 0;
                        tvsData.length = 0;
                        allObservasiData = [];

                        // Sample data with proper formatting (using clock time format)
                        const sampleData = [
                            { time: "08:00", sistole: 140, diastole: 90, nadi: 80, nafas: 30, spo2: 96, tvs: 2 },
                            { time: "08:05", sistole: 135, diastole: 85, nadi: 78, nafas: 28, spo2: 95, tvs: 1 },
                            { time: "08:10", sistole: 130, diastole: 80, nadi: 75, nafas: 25, spo2: 97, tvs: 1 },
                            { time: "08:15", sistole: 125, diastole: 75, nadi: 72, nafas: 22, spo2: 98, tvs: 2 },
                            { time: "08:20", sistole: 120, diastole: 70, nadi: 70, nafas: 20, spo2: 99, tvs: 2 }
                        ];

                        // Add each data point
                        sampleData.forEach(item => {
                            timeLabels.push(item.time);
                            sistoleData.push(item.sistole);
                            diastoleData.push(item.diastole);
                            nadiData.push(item.nadi);
                            nafasData.push(item.nafas);
                            spo2Data.push(item.spo2);
                            tvsData.push(item.tvs);
                            allObservasiData.push(item);
                        });

                        // Update hidden input with proper JSON string
                        hiddenInput.value = JSON.stringify(allObservasiData);

                        // Debug log to verify the data is stored
                        console.log('Data contoh telah dimuat:', hiddenInput.value);

                        // Update chart
                        vitalChart.update();

                        // Update table
                        updateDataTable();

                        // Show success message
                        showAlert('Data contoh berhasil dimuat!', 'success');
                    }
                }

                // Function to reset all data
                function resetAllData() {
                    if (confirm('Apakah Anda yakin ingin menghapus SEMUA data observasi?')) {
                        // Clear all data arrays
                        timeLabels.length = 0;
                        sistoleData.length = 0;
                        diastoleData.length = 0;
                        nadiData.length = 0;
                        nafasData.length = 0;
                        spo2Data.length = 0;
                        tvsData.length = 0;
                        allObservasiData = [];

                        // Update hidden input with empty array
                        hiddenInput.value = JSON.stringify(allObservasiData);

                        // Debug log to verify reset
                        console.log('Data telah direset:', hiddenInput.value);

                        // Update chart
                        vitalChart.update();

                        // Update table
                        updateDataTable();

                        // Reset form and make sure we're not in edit mode
                        saveButton.removeAttribute('data-editing-index');
                        saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan';
                        resetForm();

                        // Show message
                        showAlert('Semua data observasi telah dihapus!', 'warning');
                    }
                }
                // Function to set current time
                function setCurrentTimeCKP() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const currentTime = `${hours}:${minutes}`;

                    // Set time for observasi
                    if (waktuObservasiInput) {
                        waktuObservasiInput.value = currentTime;
                    }

                    // Set time for other fields if they exist
                    const jamMasukEl = document.getElementById('jam_masuk_pemulihan_ckp');
                    if (jamMasukEl && jamMasukEl.value === '') {
                        jamMasukEl.value = currentTime;
                    }
                }

                // Validate form input fields
                function validateFormData() {
                    let isValid = true;
                    const requiredFields = [
                        { element: waktuObservasiInput, name: 'Waktu Observasi' },
                        { element: sistoleInput, name: 'Sistole' },
                        { element: diastoleInput, name: 'Diastole' },
                        { element: nadiInput, name: 'Nadi' },
                        { element: nafasInput, name: 'Nafas' },
                        { element: spo2Input, name: 'Saturasi Oksigen' },
                        { element: tvsInput, name: 'Tanda Vital Stabil' }
                    ];

                    // Check each required field
                    requiredFields.forEach(field => {
                        if (!field.element || !field.element.value.trim()) {
                            if (field.element) {
                                field.element.classList.add('is-invalid');
                            }
                            isValid = false;
                            console.error(`Field "${field.name}" is required but empty or not found`);
                        } else {
                            field.element.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        showAlert('Harap isi semua kolom yang diperlukan!', 'danger');
                    }

                    return isValid;
                }

                // Show alert message
                function showAlert(message, type = 'success') {
                    // Remove any existing alerts with class ckp-alert
                    const existingAlerts = document.querySelectorAll('.ckp-alert');
                    existingAlerts.forEach(alert => {
                        alert.remove();
                    });

                    // Create alert element
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `alert alert-${type} alert-dismissible fade show ckp-alert`;
                    alertDiv.setAttribute('role', 'alert');
                    alertDiv.innerHTML = `
                            <strong>${type === 'success' ? 'Berhasil!' : 'Perhatian!'}</strong> ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;

                    // Insert alert before the form
                    if (observasiContainer) {
                        observasiContainer.parentNode.insertBefore(alertDiv, observasiContainer);

                        // Automatically remove the alert after 3 seconds
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.parentNode.removeChild(alertDiv);
                            }
                        }, 3000);
                    }
                }

                // Reset form fields after submission
                function resetForm() {
                    // Set current time
                    setCurrentTimeCKP();

                    // Reset other fields
                    if (sistoleInput) sistoleInput.value = '';
                    if (diastoleInput) diastoleInput.value = '';
                    if (nadiInput) nadiInput.value = '';
                    if (nafasInput) nafasInput.value = '';
                    if (spo2Input) spo2Input.value = '';
                    if (tvsInput) tvsInput.value = '';

                    // Remove any validation classes
                    const formInputs = observasiContainer.querySelectorAll('.ckp-input');
                    formInputs.forEach(input => {
                        input.classList.remove('is-invalid');
                    });
                }

                // Initialize form dependency between Jalan Nafas and Nafas Spontan
                const jalanNafasSelect = document.getElementById('jalan_nafas_ckp');
                const nafasSpontanSelect = document.getElementById('nafas_spontan_ckp');

                if (jalanNafasSelect && nafasSpontanSelect) {
                    // Set initial state
                    updateNafasSpontanVisibility();

                    // Add event listener
                    jalanNafasSelect.addEventListener('change', updateNafasSpontanVisibility);

                    function updateNafasSpontanVisibility() {
                        const parentDiv = nafasSpontanSelect.closest('.form-group');

                        if (jalanNafasSelect.value === 'Spontan') {
                            parentDiv.style.display = 'block';
                        } else {
                            parentDiv.style.display = 'none';
                            nafasSpontanSelect.value = '';  // Reset value when hidden
                        }
                    }
                }

                // Link Pain Scale Score to display in VAS field
                const painScaleScoreInput = document.getElementById('nilai_skala_vas');
                const painScaleSelect = document.querySelector('select[name="pain_scale"]');

                if (painScaleScoreInput && painScaleSelect) {
                    painScaleSelect.addEventListener('change', function () {
                        // If there's a selected pain scale value, use it for VAS
                        if (this.value) {
                            painScaleScoreInput.value = this.value;
                        }
                    });
                }
            }
        });

        /*
            Skala Pada Pasien
            6. Catatan Kamar Pemulihan
        */
        document.addEventListener('DOMContentLoaded', function () {
    // Get all required elements
    const skalaPasien = document.getElementById('skalaPasien');
    const bromageScoreForm = document.getElementById('bromageScoreForm');
    const stewardScoreForm = document.getElementById('stewardScoreForm');
    const aldreteScoreForm = document.getElementById('aldreteScoreForm');
    const paddsScoreForm = document.getElementById('paddsScoreForm');
    const patientScoreDataJSON = document.getElementById('patientScoreDataJSON');

    // Initialize data object
    let scoreData = {
        selected_score: "",
        bromage_data: {},
        steward_data: {},
        aldrete_data: {},
        padds_data: {}
    };

    // Function to load data from JSON
    function loadFromJSON() {
        try {
            const jsonValue = patientScoreDataJSON.value;
            if (jsonValue && jsonValue !== '{}') {
                scoreData = JSON.parse(jsonValue);
                console.log("Data loaded:", scoreData);

                // Set the selected scale if it was saved before
                if (scoreData.selected_score && skalaPasien) {
                    skalaPasien.value = scoreData.selected_score;
                    showSelectedForm(scoreData.selected_score);
                }

                // Pre-populate form values based on saved data
                populateFormData();
            }
        } catch (error) {
            console.error("Error loading JSON data:", error);
        }
    }

    // Hide all forms initially
    const hideForms = () => {
        if (bromageScoreForm) bromageScoreForm.style.display = 'none';
        if (stewardScoreForm) stewardScoreForm.style.display = 'none';
        if (aldreteScoreForm) aldreteScoreForm.style.display = 'none';
        if (paddsScoreForm) paddsScoreForm.style.display = 'none';
    };

    // Show form based on selection
    function showSelectedForm(selectedValue) {
        hideForms();

        switch (selectedValue) {
            case 'bromage':
                if (bromageScoreForm) bromageScoreForm.style.display = 'block';
                break;
            case 'steward':
                if (stewardScoreForm) stewardScoreForm.style.display = 'block';
                break;
            case 'aldrete':
                if (aldreteScoreForm) aldreteScoreForm.style.display = 'block';
                break;
            case 'padds':
                if (paddsScoreForm) paddsScoreForm.style.display = 'block';
                break;
        }
    }

    // Show form based on selection
    if (skalaPasien) {
        skalaPasien.addEventListener('change', function () {
            // Update the selected score in the data object
            scoreData.selected_score = this.value;

            // Show the selected form
            showSelectedForm(this.value);

            // Update the hidden input with the current JSON data
            updateJSONData();
        });
    }

    // Function to update the hidden JSON input
    function updateJSONData() {
        if (patientScoreDataJSON) {
            patientScoreDataJSON.value = JSON.stringify(scoreData);
            console.log("Data saved:", scoreData);
        }
    }

    // Function to populate form fields with saved data
    function populateFormData() {
        if (scoreData.selected_score === 'bromage' && bromageScoreForm) {
            const bromageData = scoreData.bromage_data;
            if (bromageData) {
                // Set time radio button
                if (bromageData.time) {
                    const timeRadio = document.querySelector(`input[name="bromage_time"][value="${bromageData.time}"]`);
                    if (timeRadio) timeRadio.checked = true;
                }

                // Set gerakan penuh data
                if (bromageData.gerakan_penuh) {
                    const gerakanPenuh = bromageData.gerakan_penuh;
                    const jamInput = document.querySelector('input[name="bromage_gerakan_penuh"]');
                    if (jamInput && gerakanPenuh.jam) jamInput.value = gerakanPenuh.jam;

                    // Set checkboxes
                    setCheckboxState('bromage_gerakan_penuh_15', gerakanPenuh.checked_15);
                    setCheckboxState('bromage_gerakan_penuh_30', gerakanPenuh.checked_30);
                    setCheckboxState('bromage_gerakan_penuh_45', gerakanPenuh.checked_45);
                    setCheckboxState('bromage_gerakan_penuh_1', gerakanPenuh.checked_1);
                    setCheckboxState('bromage_gerakan_penuh_2', gerakanPenuh.checked_2);
                }

                // Set tak ekstensi data
                if (bromageData.tak_ekstensi) {
                    const takEkstensi = bromageData.tak_ekstensi;
                    const jamInput = document.querySelector('input[name="bromage_tak_ekstensi"]');
                    if (jamInput && takEkstensi.jam) jamInput.value = takEkstensi.jam;

                    // Set checkboxes
                    setCheckboxState('bromage_tak_ekstensi_15', takEkstensi.checked_15);
                    setCheckboxState('bromage_tak_ekstensi_30', takEkstensi.checked_30);
                    setCheckboxState('bromage_tak_ekstensi_45', takEkstensi.checked_45);
                    setCheckboxState('bromage_tak_ekstensi_1', takEkstensi.checked_1);
                    setCheckboxState('bromage_tak_ekstensi_2', takEkstensi.checked_2);
                }

                // Set tak fleksi data
                if (bromageData.tak_fleksi) {
                    const takFleksi = bromageData.tak_fleksi;
                    const jamInput = document.querySelector('input[name="bromage_tak_fleksi"]');
                    if (jamInput && takFleksi.jam) jamInput.value = takFleksi.jam;

                    // Set checkboxes
                    setCheckboxState('bromage_tak_fleksi_15', takFleksi.checked_15);
                    setCheckboxState('bromage_tak_fleksi_30', takFleksi.checked_30);
                    setCheckboxState('bromage_tak_fleksi_45', takFleksi.checked_45);
                    setCheckboxState('bromage_tak_fleksi_1', takFleksi.checked_1);
                    setCheckboxState('bromage_tak_fleksi_2', takFleksi.checked_2);
                }

                // Set tak pergerakan data
                if (bromageData.tak_pergerakan) {
                    const takPergerakan = bromageData.tak_pergerakan;
                    const jamInput = document.querySelector('input[name="bromage_tak_pergerakan"]');
                    if (jamInput && takPergerakan.jam) jamInput.value = takPergerakan.jam;

                    // Set checkboxes
                    setCheckboxState('bromage_tak_pergerakan_15', takPergerakan.checked_15);
                    setCheckboxState('bromage_tak_pergerakan_30', takPergerakan.checked_30);
                    setCheckboxState('bromage_tak_pergerakan_45', takPergerakan.checked_45);
                    setCheckboxState('bromage_tak_pergerakan_1', takPergerakan.checked_1);
                    setCheckboxState('bromage_tak_pergerakan_2', takPergerakan.checked_2);
                }

                // Set jam pindah data
                if (bromageData.jam_pindah) {
                    const jamPindah = bromageData.jam_pindah;
                    const jamInput = document.querySelector('input[name="bromage_jam_pindah"]');
                    if (jamInput && jamPindah.jam) jamInput.value = jamPindah.jam;

                    // Set checkboxes
                    setCheckboxState('bromage_jam_pindah_15', jamPindah.checked_15);
                    setCheckboxState('bromage_jam_pindah_30', jamPindah.checked_30);
                    setCheckboxState('bromage_jam_pindah_45', jamPindah.checked_45);
                    setCheckboxState('bromage_jam_pindah_1', jamPindah.checked_1);
                    setCheckboxState('bromage_jam_pindah_2', jamPindah.checked_2);
                }
            }
        } else if (scoreData.selected_score === 'steward' && stewardScoreForm) {
            const stewardData = scoreData.steward_data;
            if (stewardData) {
                // Set time radio button
                if (stewardData.time) {
                    const timeRadio = document.querySelector(`input[name="steward_time"][value="${stewardData.time}"]`);
                    if (timeRadio) timeRadio.checked = true;
                }

                // Set kesadaran data
                if (stewardData.kesadaran) {
                    const kesadaran = stewardData.kesadaran;
                    const selectElem = document.querySelector('select[name="steward_kesadaran"]');
                    if (selectElem && kesadaran.value) selectElem.value = kesadaran.value;

                    const jamInput = document.querySelector('input[name="steward_kesadaran_jam"]');
                    if (jamInput && kesadaran.jam) jamInput.value = kesadaran.jam;

                    // Set checkboxes
                    setCheckboxState('steward_kesadaran_15', kesadaran.checked_15);
                    setCheckboxState('steward_kesadaran_30', kesadaran.checked_30);
                    setCheckboxState('steward_kesadaran_45', kesadaran.checked_45);
                    setCheckboxState('steward_kesadaran_1', kesadaran.checked_1);
                    setCheckboxState('steward_kesadaran_2', kesadaran.checked_2);
                }

                // Set respirasi data
                if (stewardData.respirasi) {
                    const respirasi = stewardData.respirasi;
                    const selectElem = document.querySelector('select[name="steward_respirasi"]');
                    if (selectElem && respirasi.value) selectElem.value = respirasi.value;

                    const jamInput = document.querySelector('input[name="steward_respirasi_jam"]');
                    if (jamInput && respirasi.jam) jamInput.value = respirasi.jam;

                    // Set checkboxes
                    setCheckboxState('steward_respirasi_15', respirasi.checked_15);
                    setCheckboxState('steward_respirasi_30', respirasi.checked_30);
                    setCheckboxState('steward_respirasi_45', respirasi.checked_45);
                    setCheckboxState('steward_respirasi_1', respirasi.checked_1);
                    setCheckboxState('steward_respirasi_2', respirasi.checked_2);
                }

                // Set motorik data
                if (stewardData.motorik) {
                    const motorik = stewardData.motorik;
                    const selectElem = document.querySelector('select[name="steward_motorik"]');
                    if (selectElem && motorik.value) selectElem.value = motorik.value;

                    const jamInput = document.querySelector('input[name="steward_motorik_jam"]');
                    if (jamInput && motorik.jam) jamInput.value = motorik.jam;

                    // Set checkboxes
                    setCheckboxState('steward_motorik_15', motorik.checked_15);
                    setCheckboxState('steward_motorik_30', motorik.checked_30);
                    setCheckboxState('steward_motorik_45', motorik.checked_45);
                    setCheckboxState('steward_motorik_1', motorik.checked_1);
                    setCheckboxState('steward_motorik_2', motorik.checked_2);
                }

                // Set jam pindah
                if (stewardData.jam_pindah) {
                    const jamInput = document.querySelector('input[name="steward_jam_pindah"]');
                    if (jamInput) jamInput.value = stewardData.jam_pindah;
                }
            }
        } else if (scoreData.selected_score === 'aldrete' && aldreteScoreForm) {
            const aldreteData = scoreData.aldrete_data;
            if (aldreteData) {
                // Set select values
                setSelectValue('aktivitas_motorik', aldreteData.aktivitas_motorik);
                setSelectValue('respirasi', aldreteData.respirasi);
                setSelectValue('aldrete_sirkulasi', aldreteData.sirkulasi);
                setSelectValue('aldrete_kesadaran', aldreteData.kesadaran);
                setSelectValue('aldrete_warna_kulit', aldreteData.warna_kulit);

                // Set tanggal pasca anestesi
                const tanggalInput = document.querySelector('input[name="aldrete_tanggal"]');
                if (tanggalInput && aldreteData.tanggal_pasca_anestesi) {
                    tanggalInput.value = aldreteData.tanggal_pasca_anestesi;
                }

                // Set interval data
                if (aldreteData.intervals && aldreteData.intervals.length > 0) {
                    for (let i = 0; i < aldreteData.intervals.length && i < 3; i++) {
                        const interval = aldreteData.intervals[i];
                        const jamInput = document.querySelector(`input[name="interval_jam_${i+1}"]`);
                        const skorInput = document.querySelector(`input[name="skor_${i+1}"]`);
                        const keteranganInput = document.querySelector(`input[name="keterangan_${i+1}"]`);

                        if (jamInput && interval.jam) jamInput.value = interval.jam;
                        if (skorInput && interval.skor) skorInput.value = interval.skor;
                        if (keteranganInput && interval.keterangan) keteranganInput.value = interval.keterangan;
                    }
                }

                // Update conclusion display
                if (aldreteData.conclusion) {
                    const conclusionElements = aldreteScoreForm.querySelectorAll('.bg-success');
                    conclusionElements.forEach(element => {
                        element.innerHTML = `<strong>Kesimpulan : </strong> ${aldreteData.conclusion}`;
                    });
                }
            }
        } else if (scoreData.selected_score === 'padds' && paddsScoreForm) {
            const paddsData = scoreData.padds_data;
            if (paddsData) {
                // Set select values
                setSelectValue('padds_tanda_vital', paddsData.tanda_vital);
                setSelectValue('padds_aktivitas', paddsData.aktivitas);
                setSelectValue('padds_mual_muntah', paddsData.mual_muntah);
                setSelectValue('padds_perdarahan', paddsData.perdarahan);
                setSelectValue('padds_nyeri', paddsData.nyeri);

                // Set tanggal jam
                const tanggalJamInput = document.querySelector('input[name="padds_tanggal_jam"]');
                if (tanggalJamInput && paddsData.tanggal_jam) {
                    tanggalJamInput.value = paddsData.tanggal_jam;
                }

                // Update conclusion display
                if (paddsData.conclusion) {
                    const kesimpulanElement = document.getElementById('paddsKesimpulan');
                    const kesimpulanInput = document.getElementById('paddsKesimpulanInput');
                    if (kesimpulanElement) kesimpulanElement.textContent = paddsData.conclusion;
                    if (kesimpulanInput) kesimpulanInput.value = paddsData.conclusion;

                    const finalKesimpulanElement = document.getElementById('paddsFinalKesimpulan');
                    const finalKesimpulanInput = document.getElementById('paddsFinalKesimpulanInput');
                    if (finalKesimpulanElement) finalKesimpulanElement.textContent = paddsData.conclusion;
                    if (finalKesimpulanInput) finalKesimpulanInput.value = paddsData.conclusion;
                }

                // Populate time table
                if (paddsData.observations && paddsData.observations.length > 0) {
                    const paddsTimeTable = document.getElementById('paddsTimeTable');
                    if (paddsTimeTable) {
                        paddsTimeTable.innerHTML = '';

                        paddsData.observations.forEach(obs => {
                            const newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                <td>${obs.datetime}</td>
                                <td>${obs.score}</td>
                                <td>${obs.conclusion}</td>
                            `;
                            paddsTimeTable.appendChild(newRow);
                        });
                    }
                }
            }
        }
    }

    // Helper function to set checkbox state
    function setCheckboxState(name, isChecked) {
        const checkbox = document.querySelector(`input[name="${name}"]`);
        if (checkbox && isChecked !== undefined) {
            checkbox.checked = isChecked;
        }
    }

    // Helper function to set select value
    function setSelectValue(name, value) {
        const select = document.querySelector(`select[name="${name}"]`);
        if (select && value !== undefined) {
            select.value = value;
        }
    }

    // Bromage Score Form Data Collection
    if (bromageScoreForm) {
        const bromageInputs = bromageScoreForm.querySelectorAll('input');
        bromageInputs.forEach(input => {
            input.addEventListener('change', function () {
                collectBromageData();
            });
        });
    }

    // Steward Score Form Data Collection
    if (stewardScoreForm) {
        const stewardInputs = stewardScoreForm.querySelectorAll('input, select');
        stewardInputs.forEach(input => {
            input.addEventListener('change', function () {
                collectStewardData();
            });
        });
    }

    // Aldrete Score Form Data Collection
    if (aldreteScoreForm) {
        const aldreteInputs = aldreteScoreForm.querySelectorAll('input, select');
        aldreteInputs.forEach(input => {
            input.addEventListener('change', function () {
                collectAldreteData();
            });
        });
    }

    // PADDS Score Form Data Collection
    if (paddsScoreForm) {
        const paddsInputs = paddsScoreForm.querySelectorAll('input, select');
        paddsInputs.forEach(input => {
            input.addEventListener('change', function () {
                collectPADDSData();
            });
        });
    }

    // Collect Bromage Score Data
    function collectBromageData() {
        const timeRadios = document.querySelectorAll('input[name="bromage_time"]');
        let selectedTime = "";
        timeRadios.forEach(radio => {
            if (radio.checked) {
                selectedTime = radio.value;
            }
        });

        scoreData.bromage_data = {
            time: selectedTime,
            gerakan_penuh: {
                jam: document.querySelector('input[name="bromage_gerakan_penuh"]').value,
                checked_15: document.querySelector('input[name="bromage_gerakan_penuh_15"]').checked,
                checked_30: document.querySelector('input[name="bromage_gerakan_penuh_30"]').checked,
                checked_45: document.querySelector('input[name="bromage_gerakan_penuh_45"]').checked,
                checked_1: document.querySelector('input[name="bromage_gerakan_penuh_1"]').checked,
                checked_2: document.querySelector('input[name="bromage_gerakan_penuh_2"]').checked
            },
            tak_ekstensi: {
                jam: document.querySelector('input[name="bromage_tak_ekstensi"]').value,
                checked_15: document.querySelector('input[name="bromage_tak_ekstensi_15"]').checked,
                checked_30: document.querySelector('input[name="bromage_tak_ekstensi_30"]').checked,
                checked_45: document.querySelector('input[name="bromage_tak_ekstensi_45"]').checked,
                checked_1: document.querySelector('input[name="bromage_tak_ekstensi_1"]').checked,
                checked_2: document.querySelector('input[name="bromage_tak_ekstensi_2"]').checked
            },
            tak_fleksi: {
                jam: document.querySelector('input[name="bromage_tak_fleksi"]').value,
                checked_15: document.querySelector('input[name="bromage_tak_fleksi_15"]').checked,
                checked_30: document.querySelector('input[name="bromage_tak_fleksi_30"]').checked,
                checked_45: document.querySelector('input[name="bromage_tak_fleksi_45"]').checked,
                checked_1: document.querySelector('input[name="bromage_tak_fleksi_1"]').checked,
                checked_2: document.querySelector('input[name="bromage_tak_fleksi_2"]').checked
            },
            tak_pergerakan: {
                jam: document.querySelector('input[name="bromage_tak_pergerakan"]').value,
                checked_15: document.querySelector('input[name="bromage_tak_pergerakan_15"]').checked,
                checked_30: document.querySelector('input[name="bromage_tak_pergerakan_30"]').checked,
                checked_45: document.querySelector('input[name="bromage_tak_pergerakan_45"]').checked,
                checked_1: document.querySelector('input[name="bromage_tak_pergerakan_1"]').checked,
                checked_2: document.querySelector('input[name="bromage_tak_pergerakan_2"]').checked
            },
            jam_pindah: {
                jam: document.querySelector('input[name="bromage_jam_pindah"]').value,
                checked_15: document.querySelector('input[name="bromage_jam_pindah_15"]').checked,
                checked_30: document.querySelector('input[name="bromage_jam_pindah_30"]').checked,
                checked_45: document.querySelector('input[name="bromage_jam_pindah_45"]').checked,
                checked_1: document.querySelector('input[name="bromage_jam_pindah_1"]').checked,
                checked_2: document.querySelector('input[name="bromage_jam_pindah_2"]').checked
            }
        };

        updateJSONData();
    }

    // Collect Steward Score Data
    function collectStewardData() {
        const timeRadios = document.querySelectorAll('input[name="steward_time"]');
        let selectedTime = "";
        timeRadios.forEach(radio => {
            if (radio.checked) {
                selectedTime = radio.value;
            }
        });

        scoreData.steward_data = {
            time: selectedTime,
            kesadaran: {
                value: document.querySelector('select[name="steward_kesadaran"]').value,
                jam: document.querySelector('input[name="steward_kesadaran_jam"]').value,
                checked_15: document.querySelector('input[name="steward_kesadaran_15"]').checked,
                checked_30: document.querySelector('input[name="steward_kesadaran_30"]').checked,
                checked_45: document.querySelector('input[name="steward_kesadaran_45"]').checked,
                checked_1: document.querySelector('input[name="steward_kesadaran_1"]').checked,
                checked_2: document.querySelector('input[name="steward_kesadaran_2"]').checked
            },
            respirasi: {
                value: document.querySelector('select[name="steward_respirasi"]').value,
                jam: document.querySelector('input[name="steward_respirasi_jam"]').value,
                checked_15: document.querySelector('input[name="steward_respirasi_15"]').checked,
                checked_30: document.querySelector('input[name="steward_respirasi_30"]').checked,
                checked_45: document.querySelector('input[name="steward_respirasi_45"]').checked,
                checked_1: document.querySelector('input[name="steward_respirasi_1"]').checked,
                checked_2: document.querySelector('input[name="steward_respirasi_2"]').checked
            },
            motorik: {
                value: document.querySelector('select[name="steward_motorik"]').value,
                jam: document.querySelector('input[name="steward_motorik_jam"]').value,
                checked_15: document.querySelector('input[name="steward_motorik_15"]').checked,
                checked_30: document.querySelector('input[name="steward_motorik_30"]').checked,
                checked_45: document.querySelector('input[name="steward_motorik_45"]').checked,
                checked_1: document.querySelector('input[name="steward_motorik_1"]').checked,
                checked_2: document.querySelector('input[name="steward_motorik_2"]').checked
            },
            jam_pindah: document.querySelector('input[name="steward_jam_pindah"]').value
        };

        updateJSONData();
    }

    // Collect Aldrete Score Data
    function collectAldreteData() {
        scoreData.aldrete_data = {
            aktivitas_motorik: document.querySelector('select[name="aktivitas_motorik"]').value,
            respirasi: document.querySelector('select[name="respirasi"]').value,
            sirkulasi: document.querySelector('select[name="aldrete_sirkulasi"]').value,
            kesadaran: document.querySelector('select[name="aldrete_kesadaran"]').value,
            warna_kulit: document.querySelector('select[name="aldrete_warna_kulit"]').value,
            tanggal_pasca_anestesi: document.querySelector('input[name="aldrete_tanggal"]').value,
            intervals: [
                {
                    jam: document.querySelector('input[name="interval_jam_1"]').value,
                    skor: document.querySelector('input[name="skor_1"]').value,
                    keterangan: document.querySelector('input[name="keterangan_1"]').value
                },
                {
                    jam: document.querySelector('input[name="interval_jam_2"]').value,
                    skor: document.querySelector('input[name="skor_2"]').value,
                    keterangan: document.querySelector('input[name="keterangan_2"]').value
                },
                {
                    jam: document.querySelector('input[name="interval_jam_3"]').value,
                    skor: document.querySelector('input[name="skor_3"]').value,
                    keterangan: document.querySelector('input[name="keterangan_3"]').value
                }
            ]
        };

        // Calculate total score
        let totalScore = 0;
        if (scoreData.aldrete_data.aktivitas_motorik) totalScore += parseInt(scoreData.aldrete_data.aktivitas_motorik);
        if (scoreData.aldrete_data.respirasi) totalScore += parseInt(scoreData.aldrete_data.respirasi);
        if (scoreData.aldrete_data.sirkulasi) totalScore += parseInt(scoreData.aldrete_data.sirkulasi);
        if (scoreData.aldrete_data.kesadaran) totalScore += parseInt(scoreData.aldrete_data.kesadaran);
        if (scoreData.aldrete_data.warna_kulit) totalScore += parseInt(scoreData.aldrete_data.warna_kulit);

        scoreData.aldrete_data.total_score = totalScore;
        scoreData.aldrete_data.conclusion = totalScore >= 8 ? "Boleh pindah ruang" : "Tidak Boleh pindah ruang";

        // Update the conclusion in the UI
        const conclusionElements = aldreteScoreForm.querySelectorAll('.bg-success');
        conclusionElements.forEach(element => {
            element.innerHTML = `<strong>Kesimpulan : </strong> ${scoreData.aldrete_data.conclusion}`;
        });

        updateJSONData();
    }

    // Collect PADDS Score Data
    function collectPADDSData() {
        const tandaVital = document.querySelector('select[name="padds_tanda_vital"]').value;
        const aktivitas = document.querySelector('select[name="padds_aktivitas"]').value;
        const mualMuntah = document.querySelector('select[name="padds_mual_muntah"]').value;
        const perdarahan = document.querySelector('select[name="padds_perdarahan"]').value;
        const nyeri = document.querySelector('select[name="padds_nyeri"]').value;

        let totalScore = 0;
        if (tandaVital) totalScore += parseInt(tandaVital);
        if (aktivitas) totalScore += parseInt(aktivitas);
        if (mualMuntah) totalScore += parseInt(mualMuntah);
        if (perdarahan) totalScore += parseInt(perdarahan);
        if (nyeri) totalScore += parseInt(nyeri);

        const conclusion = totalScore >= 9 ? "Boleh pindah ruang" : "Tidak Boleh pindah ruang";

        // Check if we already have PADDS data
        if (!scoreData.padds_data) {
            scoreData.padds_data = {
                observations: []
            };
        }

        scoreData.padds_data = {
            ...scoreData.padds_data,
            tanda_vital: tandaVital,
            aktivitas: aktivitas,
            mual_muntah: mualMuntah,
            perdarahan: perdarahan,
            nyeri: nyeri,
            total_score: totalScore,
            conclusion: conclusion,
            tanggal_jam: document.querySelector('input[name="padds_tanggal_jam"]').value
        };

        // Update the conclusion in the UI
        const kesimpulanElement = document.getElementById('paddsKesimpulan');
        const kesimpulanInput = document.getElementById('paddsKesimpulanInput');
        if (kesimpulanElement) {
            kesimpulanElement.textContent = conclusion;
        }
        if (kesimpulanInput) {
            kesimpulanInput.value = conclusion;
        }

        // Also update the final conclusion
        const finalKesimpulanElement = document.getElementById('paddsFinalKesimpulan');
        const finalKesimpulanInput = document.getElementById('paddsFinalKesimpulanInput');
        if (finalKesimpulanElement) {
            finalKesimpulanElement.textContent = conclusion;
        }
        if (finalKesimpulanInput) {
            finalKesimpulanInput.value = conclusion;
        }

        updateJSONData();
    }

    // Additional function to add time entries to PADDS table
    if (paddsScoreForm) {
        // Add functionality to dynamically add entries to the PADDS time table
        const paddsTanggalJam = document.getElementById('paddsTanggalJam');
        const paddsTimeTable = document.getElementById('paddsTimeTable');

        if (paddsTanggalJam && paddsTimeTable) {
            paddsTanggalJam.addEventListener('change', function () {
                const currentScore = getCalculatedPADDSScore();
                const conclusion = currentScore >= 9 ? "Boleh pindah ruang" : "Tidak Boleh pindah ruang";

                // Check if observations array exists
                if (!scoreData.padds_data.observations) {
                    scoreData.padds_data.observations = [];
                }

                // Create new observation entry
                const newObservation = {
                    datetime: this.value,
                    score: currentScore,
                    conclusion: conclusion
                };

                // Add to observations in the data
                scoreData.padds_data.observations.push(newObservation);

                // Refresh the table display
                refreshPADDSTable();

                updateJSONData();
            });
        }
    }

    // Helper function to refresh the PADDS table
    function refreshPADDSTable() {
        const paddsTimeTable = document.getElementById('paddsTimeTable');
        if (paddsTimeTable && scoreData.padds_data && scoreData.padds_data.observations) {
            // Clear table first
            paddsTimeTable.innerHTML = '';

            // Add rows for each observation
            scoreData.padds_data.observations.forEach(obs => {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${obs.datetime}</td>
                    <td>${obs.score}</td>
                    <td>${obs.conclusion}</td>
                `;
                paddsTimeTable.appendChild(newRow);
            });

            // If no observations, add a placeholder row
            if (scoreData.padds_data.observations.length === 0) {
                paddsTimeTable.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data</td>
                    </tr>
                `;
            }
        }
    }

    // Helper function to calculate current PADDS score
    function getCalculatedPADDSScore() {
        const tandaVital = document.querySelector('select[name="padds_tanda_vital"]').value || "0";
        const aktivitas = document.querySelector('select[name="padds_aktivitas"]').value || "0";
        const mualMuntah = document.querySelector('select[name="padds_mual_muntah"]').value || "0";
        const perdarahan = document.querySelector('select[name="padds_perdarahan"]').value || "0";
        const nyeri = document.querySelector('select[name="padds_nyeri"]').value || "0";

        return parseInt(tandaVital) + parseInt(aktivitas) + parseInt(mualMuntah) + parseInt(perdarahan) + parseInt(nyeri);
    }

    // Initialize JSON data and load saved data on page load
    loadFromJSON();
    updateJSONData();

    // Show the selected form if a score is already selected
    if (scoreData.selected_score) {
        showSelectedForm(scoreData.selected_score);
    } else {
        hideForms(); // Hide all forms initially
    }

    // Fix for setting the value attribute for time inputs
    document.querySelectorAll('input[type="time"][value="Jam"]').forEach(input => {
        if (input.value === "Jam") {
            input.value = "";
            input.placeholder = "Jam";
        }
    });

    // Fix for duplicate selection in Steward form
    document.querySelectorAll('select[name="steward_kesadaran"] option:not(:first-child), select[name="steward_respirasi"] option:not(:first-child), select[name="steward_motorik"] option:not(:first-child)').forEach(option => {
        if (option.hasAttribute('selected') && option.parentElement.selectedIndex !== option.index) {
            option.removeAttribute('selected');
        }
    });
});

        /*
        4. Evaluasi Pra Anestesi dan Sedasi
        menghitung IMT dan Luas Permukaan Tubuh (LPT)
        */
        document.addEventListener('DOMContentLoaded', function () {
            const tinggiInput = document.querySelector('input[name="antropometri_tinggi_badan"]');
            const beratInput = document.querySelector('input[name="antropometri_berat_badan"]');
            const imtInput = document.querySelector('input[name="antropometri_imt"]');
            const lptInput = document.querySelector('input[name="antropometri_lpt"]');

            // Fungsi untuk mengonversi input ke number dan memastikan valid
            function parseNumericInput(input) {
                const value = parseFloat(input.value.replace(',', '.'));
                return isNaN(value) ? null : value;
            }

            // Fungsi untuk menghitung IMT
            function hitungIMT(berat, tinggi) {
                // Konversi tinggi ke meter jika dalam cm
                const tinggiMeter = tinggi > 3 ? tinggi / 100 : tinggi;

                if (berat && tinggiMeter) {
                    const imt = berat / (tinggiMeter * tinggiMeter);
                    return imt.toFixed(1);
                }
                return '';
            }

            // Fungsi untuk mengkategorikan IMT
            function kategorikanIMT(imt) {
                if (imt < 18.5) return 'Kekurangan Berat Badan';
                if (imt >= 18.5 && imt < 25) return 'Normal';
                if (imt >= 25 && imt < 30) return 'Kelebihan Berat Badan';
                if (imt >= 30) return 'Obesitas';
                return '';
            }

            // Fungsi untuk mengkalkulasi metrik
            function calculateMetrics() {
                const berat = parseNumericInput(beratInput);
                const tinggi = parseNumericInput(tinggiInput);

                if (berat && tinggi) {
                    // Konversi tinggi ke meter jika dalam cm
                    const tinggiMeter = tinggi > 3 ? tinggi / 100 : tinggi;

                    // Hitung IMT
                    const imt = hitungIMT(berat, tinggi);
                    imtInput.value = `${imt} (${kategorikanIMT(parseFloat(imt))})`;

                    // Hitung LPT menggunakan rumus Mosteller
                    const lpt = Math.sqrt(berat * tinggiMeter) / 60;
                    lptInput.value = lpt.toFixed(2);
                } else {
                    // Jika nilai awal sudah ada, jangan diubah
                    if (!imtInput.value) imtInput.value = '';
                    if (!lptInput.value) lptInput.value = '';
                }
            }

            // Tambahkan event listener untuk input berat dan tinggi
            beratInput.addEventListener('input', calculateMetrics);
            tinggiInput.addEventListener('input', calculateMetrics);

            // Hitung metrik pada saat halaman dimuat jika data sudah ada
            calculateMetrics();
        });
    </script>
@endpush
