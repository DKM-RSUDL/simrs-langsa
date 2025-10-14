@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        // 5. Pemantauan Selama Anestesi dan Sedasi
        document.addEventListener('DOMContentLoaded', function() {
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
                const sistoleDataPAS = [];
                const diastoleDataPAS = [];
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
                            sistoleDataPAS.push(item.sistolik);
                            diastoleDataPAS.push(item.diastolik);
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
                            datasets: [{
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

                // Load sample data
                function loadSampleDataPAS() {
                    // Clear existing data
                    timeLabelsPAS.length = 0;
                    sistoleDataPAS.length = 0;
                    diastoleDataPAS.length = 0;
                    nadiDataPAS.length = 0;
                    nafasDataPAS.length = 0;
                    spo2DataPAS.length = 0;
                    allMonitoringDataPAS = [];

                    // Sample data
                    const sampleDataPAS = [{
                            time: "1 Jam",
                            sistole: 140,
                            diastole: 90,
                            nadi: 90,
                            nafas: 45,
                            spo2: 95
                        },
                        {
                            time: "2 Jam",
                            sistole: 120,
                            diastole: 80,
                            nadi: 70,
                            nafas: 25,
                            spo2: 90
                        },
                        {
                            time: "3 Jam",
                            sistole: 135,
                            diastole: 85,
                            nadi: 85,
                            nafas: 40,
                            spo2: 92
                        },
                        {
                            time: "4 Jam",
                            sistole: 215,
                            diastole: 110,
                            nadi: 100,
                            nafas: 60,
                            spo2: 98
                        }
                    ];

                    // Add each data point
                    sampleDataPAS.forEach(item => {
                        timeLabelsPAS.push(item.time);
                        sistoleDataPAS.push(item.sistole);
                        diastoleDataPAS.push(item.diastole);
                        nadiDataPAS.push(item.nadi);
                        nafasDataPAS.push(item.nafas);
                        spo2DataPAS.push(item.spo2);
                        allMonitoringDataPAS.push(item);
                    });

                    // Update hidden input
                    document.getElementById('all_monitoring_data_pas').value = JSON.stringify(allMonitoringDataPAS);

                    // Update chart
                    vitalSignsChartPAS.update();

                    // Show success message
                    showAlertPAS('Data contoh berhasil dimuat!', 'success');
                }

                // Initialize the chart
                initChartPAS();

                // Add event listener to load sample data button
                const loadDataButtonPAS = document.getElementById('loadDataButtonPAS');
                if (loadDataButtonPAS) {
                    loadDataButtonPAS.addEventListener('click', loadSampleDataPAS);
                }

                // Add event listener to reset data button
                const resetDataButtonPAS = document.getElementById('resetDataButtonPAS');
                if (resetDataButtonPAS) {
                    resetDataButtonPAS.addEventListener('click', function() {
                        // Clear all data arrays
                        timeLabelsPAS.length = 0;
                        sistoleDataPAS.length = 0;
                        diastoleDataPAS.length = 0;
                        nadiDataPAS.length = 0;
                        nafasDataPAS.length = 0;
                        spo2DataPAS.length = 0;
                        allMonitoringDataPAS = [];

                        // Update hidden input
                        document.getElementById('all_monitoring_data_pas').value = JSON.stringify(
                            allMonitoringDataPAS);

                        // Update chart
                        vitalSignsChartPAS.update();

                        // Reset form
                        resetFormPAS();

                        // Show success message
                        showAlertPAS('Semua data telah dihapus!', 'warning');
                    });
                }

                // Add event listener to the save button
                const saveButtonPAS = document.getElementById('saveButtonPAS');
                if (saveButtonPAS) {
                    saveButtonPAS.addEventListener('click', function() {
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
                        const spo2 = parseFloat(document.getElementById('saturasi_oksigen_pantau_pas')
                            .value);

                        // Create data object
                        const dataPoint = {
                            time: time,
                            sistole: sistole,
                            diastole: diastole,
                            nadi: nadi,
                            nafas: nafas,
                            spo2: spo2
                        };

                        // Add to master data array
                        allMonitoringDataPAS.push(dataPoint);

                        // Update hidden input with JSON string
                        document.getElementById('all_monitoring_data_pas').value = JSON.stringify(
                            allMonitoringDataPAS);

                        // Add data to chart arrays
                        timeLabelsPAS.push(time);
                        sistoleDataPAS.push(sistole);
                        diastoleDataPAS.push(diastole);
                        nadiDataPAS.push(nadi);
                        nafasDataPAS.push(nafas);
                        spo2DataPAS.push(spo2);

                        // Update the chart
                        vitalSignsChartPAS.update();

                        // Show success message
                        showAlertPAS('Data pemantauan berhasil ditambahkan ke grafik.', 'success');

                        // Reset form
                        resetFormPAS();
                    });
                }

                // Validate form input fields
                function validateFormPAS() {
                    let isValid = true;
                    const requiredFields = [
                        'waktu_pemantauan_pas',
                        'diastole_pantau_pas',
                        'sistole_pantau_pas',
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
                        showAlertPAS('Harap isi semua kolom yang diperlukan!', 'danger');
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
                    const fields = [{
                            id: 'diastole_pantau_pas',
                            value: ''
                        },
                        {
                            id: 'sistole_pantau_pas',
                            value: ''
                        },
                        {
                            id: 'nadi_pantau_pas',
                            value: ''
                        },
                        {
                            id: 'nafas_pantau_pas',
                            value: ''
                        },
                        {
                            id: 'saturasi_oksigen_pantau_pas',
                            value: ''
                        }
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
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengisolasi kode dari pengaruh luar
            initCatatanKamarPemulihan();

            function initCatatanKamarPemulihan() {
                // Get all necessary elements
                const observasiContainer = document.getElementById('observasiFormCKP');
                const hiddenInput = document.getElementById('all_observasi_data_ckp');
                const waktuObservasiInput = document.getElementById('waktu_observasi_ckp');
                const sistoleInput = document.getElementById('sistole_ckp');
                const diastoleInput = document.getElementById('diastole_ckp');
                const nadiInput = document.getElementById('nadi_pemulihan_ckp');
                const nafasInput = document.getElementById('nafas_pemulihan_ckp');
                const spo2Input = document.getElementById('saturasi_oksigen_pemulihan_ckp');
                const tvsInput = document.getElementById('tanda_vital_stabil_ckp');
                const saveButton = document.getElementById('saveObservasiButtonCKP');
                const loadSampleButton = document.getElementById('loadSampleButtonCKP');
                const resetButton = document.getElementById('resetDataButtonCKP');
                const chartCanvas = document.getElementById('recoveryVitalChartCKP');

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
                    mainForm.addEventListener('submit', function(e) {
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
                            datasets: [{
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

                    // Add to master data array
                    allObservasiData.push(dataPoint);

                    // Update hidden input with JSON string - THIS IS CRITICAL
                    hiddenInput.value = JSON.stringify(allObservasiData);

                    // Debug log to verify the value was actually set
                    console.log('Data JSON diperbarui:', hiddenInput.value);

                    // Add data to chart arrays
                    timeLabels.push(time);
                    sistoleData.push(sistole);
                    diastoleData.push(diastole);
                    nadiData.push(nadi);
                    nafasData.push(nafas);
                    spo2Data.push(spo2);
                    tvsData.push(tvs);

                    // Update the chart
                    vitalChart.update();

                    // Show success message
                    showAlert('Data observasi berhasil ditambahkan ke grafik.', 'success');

                    // Reset form fields
                    resetForm();
                }

                // Function to load sample data
                function loadSampleData() {
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
                    const sampleData = [{
                            time: "08:00",
                            sistole: 140,
                            diastole: 90,
                            nadi: 80,
                            nafas: 30,
                            spo2: 96,
                            tvs: 20
                        },
                        {
                            time: "08:05",
                            sistole: 135,
                            diastole: 85,
                            nadi: 78,
                            nafas: 28,
                            spo2: 95,
                            tvs: 18
                        },
                        {
                            time: "08:10",
                            sistole: 130,
                            diastole: 80,
                            nadi: 75,
                            nafas: 25,
                            spo2: 97,
                            tvs: 16
                        },
                        {
                            time: "08:15",
                            sistole: 125,
                            diastole: 75,
                            nadi: 72,
                            nafas: 22,
                            spo2: 98,
                            tvs: 14
                        },
                        {
                            time: "08:20",
                            sistole: 120,
                            diastole: 70,
                            nadi: 70,
                            nafas: 20,
                            spo2: 99,
                            tvs: 12
                        }
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

                    // Show success message
                    showAlert('Data contoh berhasil dimuat!', 'success');
                }

                // Function to reset all data
                function resetAllData() {
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

                    // Reset form
                    resetForm();

                    // Show message
                    showAlert('Semua data telah dihapus!', 'warning');
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
                    if (jamMasukEl) {
                        jamMasukEl.value = currentTime;
                    }
                }

                // Validate form input fields
                function validateFormData() {
                    let isValid = true;
                    const requiredFields = [{
                            element: waktuObservasiInput,
                            name: 'Waktu Observasi'
                        },
                        {
                            element: sistoleInput,
                            name: 'Sistolik'
                        },
                        {
                            element: diastoleInput,
                            name: 'Diastolik'
                        },
                        {
                            element: nadiInput,
                            name: 'Nadi'
                        },
                        {
                            element: nafasInput,
                            name: 'Nafas'
                        },
                        {
                            element: spo2Input,
                            name: 'Saturasi Oksigen'
                        },
                        {
                            element: tvsInput,
                            name: 'Tanda Vital Stabil'
                        }
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
            }
        });

        /*
            Skala Pada Pasien
            6. Catatan Kamar Pemulihan
        */
        document.addEventListener('DOMContentLoaded', function() {
            const skalaPasien = document.getElementById('skalaPasien');
            const bromageScoreForm = document.getElementById('bromageScoreForm');
            const stewardScoreForm = document.getElementById('stewardScoreForm');
            const aldreteScoreForm = document.getElementById('aldreteScoreForm');
            const paddsScoreForm = document.getElementById('paddsScoreForm');
            const patientScoreDataJSON = document.getElementById('patientScoreDataJSON');

            let scoreData = {
                selected_score: "",
                bromage_data: {},
                steward_data: {},
                aldrete_data: {},
                padds_data: {}
            };

            // Load existing data from hidden input if available
            if (patientScoreDataJSON && patientScoreDataJSON.value && patientScoreDataJSON.value !== '{}') {
                try {
                    const existingData = JSON.parse(patientScoreDataJSON.value);
                    scoreData = { ...scoreData, ...existingData };
                } catch (e) {
                    console.error('Error parsing existing score data:', e);
                }
            }

            const hideForms = () => {
                if (bromageScoreForm) bromageScoreForm.style.display = 'none';
                if (stewardScoreForm) stewardScoreForm.style.display = 'none';
                if (aldreteScoreForm) aldreteScoreForm.style.display = 'none';
                if (paddsScoreForm) paddsScoreForm.style.display = 'none';
            };

            if (skalaPasien) {
                skalaPasien.addEventListener('change', function() {
                    hideForms();
                    scoreData.selected_score = this.value;
                    updateJSONData();

                    switch (this.value) {
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
                });
            }

            // Bromage Score - Radio Buttons
            if (bromageScoreForm) {
                const bromageRadios = bromageScoreForm.querySelectorAll('.bromage-radio');
                
                bromageRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        calculateBromageTotal();
                        collectBromageData();
                    });
                });

                function calculateBromageTotal() {
                    let timeScores = {};
                    const timeColumns = ['15', '30', '45', '60', '120'];
                    
                    // Hitung score untuk setiap waktu
                    timeColumns.forEach(time => {
                        const selectedRadio = bromageScoreForm.querySelector(`input[name="bromage_time_${time}"]:checked`);
                        if (selectedRadio) {
                            timeScores[time] = parseInt(selectedRadio.getAttribute('data-score'));
                        } else {
                            timeScores[time] = 0;
                        }
                    });

                    // Ambil score tertinggi dari semua waktu observasi
                    const allScores = Object.values(timeScores).filter(score => score > 0);
                    const total = allScores.length > 0 ? Math.max(...allScores) : 0;
                    
                    document.getElementById('bromage_total_score').textContent = total;
                    document.getElementById('bromage_total_score_value').value = total;

                    const statusBadge = document.getElementById('bromage_status');
                    if (total >= 2) {
                        statusBadge.textContent = '✓ Pasien BOLEH dipindah ke ruang perawatan';
                        statusBadge.className = 'badge bg-success';
                    } else {
                        statusBadge.textContent = '✗ Pasien BELUM BOLEH dipindah (score harus ≥ 2)';
                        statusBadge.className = 'badge bg-danger';
                    }
                    return { total, timeScores };
                }

                function collectBromageData() {
                    const timeColumns = ['15', '30', '45', '60', '120'];
                    
                    // Collect all time inputs
                    const timeInputs = {
                        gerakan_penuh: document.querySelector('input[name="bromage_gerakan_penuh"]')?.value || "",
                        tak_ekstensi: document.querySelector('input[name="bromage_tak_ekstensi"]')?.value || "",
                        tak_fleksi_lutut: document.querySelector('input[name="bromage_tak_fleksi_lutut"]')?.value || "",
                        tak_fleksi_pergelangan: document.querySelector('input[name="bromage_tak_fleksi_pergelangan"]')?.value || ""
                    };

                    // Collect observations per time period
                    const timeObservations = {};
                    timeColumns.forEach(time => {
                        const selectedRadio = bromageScoreForm.querySelector(`input[name="bromage_time_${time}"]:checked`);
                        if (selectedRadio) {
                            const group = selectedRadio.getAttribute('data-group');
                            const score = parseInt(selectedRadio.getAttribute('data-score'));
                            timeObservations[`time_${time}`] = {
                                selected_option: group,
                                score: score,
                                description: getOptionDescription(group, score)
                            };
                        }
                    });

                    const calculationResult = calculateBromageTotal();
                    
                    scoreData.bromage_data = {
                        total_score: calculationResult.total,
                        time_scores: calculationResult.timeScores,
                        time_observations: timeObservations,
                        time_inputs: timeInputs,
                        jam_pindah: document.querySelector('input[name="bromage_jam_pindah"]')?.value || "",
                        status: calculationResult.total >= 2 ? "Boleh pindah ruang" : "Belum boleh pindah ruang"
                    };

                    updateJSONData();
                }

                function getOptionDescription(group, score) {
                    const descriptions = {
                        'gerakan_penuh': 'Gerakan penuh dari tungkai',
                        'tak_ekstensi': 'Tak mampu ekstensi tungkai', 
                        'tak_fleksi_lutut': 'Tak mampu fleksi lutut',
                        'tak_fleksi_pergelangan': 'Tak mampu fleksi pergelangan kaki'
                    };
                    return descriptions[group] || '';
                }

                const allBromageInputs = bromageScoreForm.querySelectorAll('input[type="time"], input[type="radio"]');
                allBromageInputs.forEach(input => {
                    input.addEventListener('change', collectBromageData);
                });
            }

            // Steward Score - Radio Buttons
            if (stewardScoreForm) {
                const stewardRadios = stewardScoreForm.querySelectorAll('.steward-radio');
                
                stewardRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        calculateStewardTotal();
                        collectStewardData();
                    });
                });

                function calculateStewardTotal() {
                    let timeScores = {};
                    const timeColumns = ['15', '30', '45', '60', '120'];
                    
                    // Hitung total score per waktu (kesadaran + respirasi + motorik)
                    timeColumns.forEach(time => {
                        let scoreForTime = 0;
                        const categories = ['kesadaran', 'respirasi', 'motorik'];
                        categories.forEach(category => {
                            const selectedRadio = stewardScoreForm.querySelector(`input[name="steward_${category}_${time}"]:checked`);
                            if (selectedRadio) {
                                scoreForTime += parseInt(selectedRadio.getAttribute('data-score'));
                            }
                        });
                        timeScores[time] = scoreForTime;
                    });

                    // Ambil score tertinggi dari semua waktu observasi
                    const allScores = Object.values(timeScores).filter(score => score > 0);
                    const total = allScores.length > 0 ? Math.max(...allScores) : 0;
                    
                    document.getElementById('steward_total_score').textContent = total;
                    document.getElementById('steward_total_score_value').value = total;

                    const statusBadge = document.getElementById('steward_status');
                    if (total >= 5) {
                        statusBadge.textContent = '✓ Pasien BOLEH dipindah ke ruang perawatan';
                        statusBadge.className = 'badge bg-success';
                    } else {
                        statusBadge.textContent = '✗ Pasien BELUM BOLEH dipindah (score harus ≥ 5)';
                        statusBadge.className = 'badge bg-danger';
                    }
                    return { total, timeScores };
                }

                function collectStewardData() {
                    const timeColumns = ['15', '30', '45', '60', '120'];
                    const timeData = {};

                    timeColumns.forEach(time => {
                        timeData[time] = {
                            kesadaran: { score: null, description: null },
                            respirasi: { score: null, description: null },
                            motorik: { score: null, description: null },
                            total: 0
                        };

                        const categories = ['kesadaran', 'respirasi', 'motorik'];
                        categories.forEach(category => {
                            const selectedRadio = stewardScoreForm.querySelector(`input[name="steward_${category}_${time}"]:checked`);
                            if (selectedRadio) {
                                const score = parseInt(selectedRadio.getAttribute('data-score'));
                                const value = selectedRadio.value;
                                const description = getStewardDescription(category, value);
                                
                                timeData[time][category] = {
                                    score: score,
                                    value: value,
                                    description: description
                                };
                                timeData[time].total += score;
                            }
                        });
                    });

                    const calculationResult = calculateStewardTotal();
                    
                    scoreData.steward_data = {
                        total_score: calculationResult.total,
                        time_scores: calculationResult.timeScores,
                        time_observations: timeData,
                        jam_pindah: document.querySelector('input[name="steward_jam_pindah"]')?.value || "",
                        status: calculationResult.total >= 5 ? "Boleh pindah ruang" : "Belum boleh pindah ruang"
                    };

                    updateJSONData();
                }

                function getStewardDescription(category, value) {
                    const descriptions = {
                        kesadaran: {
                            'sadar_2': 'Sadar penuh, responsif',
                            'bangun_1': 'Bangun saat dipanggil/nama disebut',
                            'tidak_responsif_0': 'Tidak responsif'
                        },
                        respirasi: {
                            'normal_2': 'Bernapas normal/menangis',
                            'dangkal_1': 'Napas dangkal/terbatas',
                            'apnea_0': 'Apnea/perlu bantuan napas'
                        },
                        motorik: {
                            'aktif_2': 'Gerakan aktif/beraturan',
                            'lemah_1': 'Gerakan lemah/terbatas',
                            'tidak_bergerak_0': 'Tidak bergerak'
                        }
                    };
                    return descriptions[category]?.[value] || '';
                }

                const allStewardInputs = stewardScoreForm.querySelectorAll('input[type="time"], input[type="radio"]');
                allStewardInputs.forEach(input => {
                    input.addEventListener('change', collectStewardData);
                });
            }

            // Aldrete Score - Unchanged
            if (aldreteScoreForm) {
                const aldreteInputs = aldreteScoreForm.querySelectorAll('input, select');
                aldreteInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        collectAldreteData();
                    });
                });
            }

            function collectAldreteData() {
                scoreData.aldrete_data = {
                    aktivitas_motorik: document.querySelector('select[name="aktivitas_motorik"]')?.value || "",
                    respirasi: document.querySelector('select[name="respirasi"]')?.value || "",
                    sirkulasi: document.querySelector('select[name="aldrete_sirkulasi"]')?.value || "",
                    kesadaran: document.querySelector('select[name="aldrete_kesadaran"]')?.value || "",
                    warna_kulit: document.querySelector('select[name="aldrete_warna_kulit"]')?.value || "",
                    tanggal_pasca_anestesi: document.querySelector('input[name="aldrete_tanggal"]')?.value || "",
                    intervals: [
                        {
                            jam: document.querySelector('input[name="interval_jam_1"]')?.value || "",
                            skor: document.querySelector('input[name="skor_1"]')?.value || "",
                            keterangan: document.querySelector('input[name="keterangan_1"]')?.value || ""
                        },
                        {
                            jam: document.querySelector('input[name="interval_jam_2"]')?.value || "",
                            skor: document.querySelector('input[name="skor_2"]')?.value || "",
                            keterangan: document.querySelector('input[name="keterangan_2"]')?.value || ""
                        },
                        {
                            jam: document.querySelector('input[name="interval_jam_3"]')?.value || "",
                            skor: document.querySelector('input[name="skor_3"]')?.value || "",
                            keterangan: document.querySelector('input[name="keterangan_3"]')?.value || ""
                        }
                    ]
                };

                let totalScore = 0;
                if (scoreData.aldrete_data.aktivitas_motorik) totalScore += parseInt(scoreData.aldrete_data.aktivitas_motorik);
                if (scoreData.aldrete_data.respirasi) totalScore += parseInt(scoreData.aldrete_data.respirasi);
                if (scoreData.aldrete_data.sirkulasi) totalScore += parseInt(scoreData.aldrete_data.sirkulasi);
                if (scoreData.aldrete_data.kesadaran) totalScore += parseInt(scoreData.aldrete_data.kesadaran);
                if (scoreData.aldrete_data.warna_kulit) totalScore += parseInt(scoreData.aldrete_data.warna_kulit);

                scoreData.aldrete_data.total_score = totalScore;
                scoreData.aldrete_data.conclusion = totalScore >= 8 ? "Boleh pindah ruang" : "Tidak Boleh pindah ruang";

                const conclusionElements = aldreteScoreForm.querySelectorAll('.bg-success');
                conclusionElements.forEach(element => {
                    element.innerHTML = `<strong>Kesimpulan : </strong> ${scoreData.aldrete_data.conclusion}`;
                    if (scoreData.aldrete_data.conclusion === "Boleh pindah ruang") {
                        element.classList.remove('bg-danger');
                        element.classList.add('bg-success');
                    } else {
                        element.classList.remove('bg-success');
                        element.classList.add('bg-danger');
                    }
                });

                updateJSONData();
            }

            // PADDS Score - Unchanged
            if (paddsScoreForm) {
                const paddsInputs = paddsScoreForm.querySelectorAll('input, select');
                paddsInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        collectPADDSData();
                    });
                });
            }

            function collectPADDSData() {
                const tandaVital = document.querySelector('select[name="padds_tanda_vital"]')?.value || "";
                const aktivitas = document.querySelector('select[name="padds_aktivitas"]')?.value || "";
                const mualMuntah = document.querySelector('select[name="padds_mual_muntah"]')?.value || "";
                const perdarahan = document.querySelector('select[name="padds_perdarahan"]')?.value || "";
                const nyeri = document.querySelector('select[name="padds_nyeri"]')?.value || "";

                let totalScore = 0;
                if (tandaVital) totalScore += parseInt(tandaVital);
                if (aktivitas) totalScore += parseInt(aktivitas);
                if (mualMuntah) totalScore += parseInt(mualMuntah);
                if (perdarahan) totalScore += parseInt(perdarahan);
                if (nyeri) totalScore += parseInt(nyeri);

                const conclusion = totalScore >= 9 ? "Boleh pindah ruang" : "Tidak Boleh pindah ruang";

                scoreData.padds_data = {
                    tanda_vital: tandaVital,
                    aktivitas: aktivitas,
                    mual_muntah: mualMuntah,
                    perdarahan: perdarahan,
                    nyeri: nyeri,
                    total_score: totalScore,
                    conclusion: conclusion,
                    tanggal_jam: document.querySelector('input[name="padds_tanggal_jam"]')?.value || "",
                    observations: []
                };

                const kesimpulanElement = document.getElementById('paddsKesimpulan');
                const kesimpulanInput = document.getElementById('paddsKesimpulanInput');
                if (kesimpulanElement) {
                    kesimpulanElement.textContent = conclusion;
                    if (conclusion === "Boleh pindah ruang") {
                        kesimpulanElement.style.backgroundColor = '#28a745';
                    } else {
                        kesimpulanElement.style.backgroundColor = '#dc3545';
                    }
                }
                if (kesimpulanInput) {
                    kesimpulanInput.value = conclusion;
                }

                const finalKesimpulanElement = document.getElementById('paddsFinalKesimpulan');
                const finalKesimpulanInput = document.getElementById('paddsFinalKesimpulanInput');
                if (finalKesimpulanElement) {
                    finalKesimpulanElement.textContent = conclusion;
                    if (conclusion === "Boleh pindah ruang") {
                        finalKesimpulanElement.style.backgroundColor = '#28a745';
                    } else {
                        finalKesimpulanElement.style.backgroundColor = '#dc3545';
                    }
                }
                if (finalKesimpulanInput) {
                    finalKesimpulanInput.value = conclusion;
                }

                updateJSONData();
            }

            if (paddsScoreForm) {
                const paddsTanggalJam = document.getElementById('paddsTanggalJam');
                const paddsTimeTable = document.getElementById('paddsTimeTable');

                if (paddsTanggalJam && paddsTimeTable) {
                    paddsTanggalJam.addEventListener('change', function() {
                        const currentScore = getCalculatedPADDSScore();
                        const conclusion = currentScore >= 9 ? "Boleh pindah ruang" : "Tidak Boleh pindah ruang";

                        paddsTimeTable.innerHTML = '';

                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td><i class="far fa-clock me-2"></i> ${this.value}</td>
                            <td><strong>${currentScore}</strong></td>
                            <td><span class="badge ${conclusion === 'Boleh pindah ruang' ? 'bg-success' : 'bg-danger'}">${conclusion}</span></td>
                        `;
                        paddsTimeTable.appendChild(newRow);

                        if (!scoreData.padds_data.observations) {
                            scoreData.padds_data.observations = [];
                        }

                        scoreData.padds_data.observations.push({
                            datetime: this.value,
                            score: currentScore,
                            conclusion: conclusion
                        });

                        updateJSONData();
                    });
                }
            }

            function getCalculatedPADDSScore() {
                const tandaVital = document.querySelector('select[name="padds_tanda_vital"]')?.value || 0;
                const aktivitas = document.querySelector('select[name="padds_aktivitas"]')?.value || 0;
                const mualMuntah = document.querySelector('select[name="padds_mual_muntah"]')?.value || 0;
                const perdarahan = document.querySelector('select[name="padds_perdarahan"]')?.value || 0;
                const nyeri = document.querySelector('select[name="padds_nyeri"]')?.value || 0;

                return parseInt(tandaVital) + parseInt(aktivitas) + parseInt(mualMuntah) + 
                    parseInt(perdarahan) + parseInt(nyeri);
            }

            function updateJSONData() {
                if (patientScoreDataJSON) {
                    patientScoreDataJSON.value = JSON.stringify(scoreData);
                }
            }

            // Initialize on page load
            function initializeOnLoad() {
                // Set the select value if data exists
                if (scoreData.selected_score && skalaPasien) {
                    skalaPasien.value = scoreData.selected_score;
                    
                    // Show the appropriate form
                    hideForms();
                    switch (scoreData.selected_score) {
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
                updateJSONData();
            }

            // Initialize when page loads
            initializeOnLoad();
        });

        /*
        4. Evaluasi Pra Anestesi dan Sedasi
        menghitung IMT dan Luas Permukaan Tubuh (LPT)
        */
        document.addEventListener('DOMContentLoaded', function() {
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

            // Fungsi untuk menghitung Luas Permukaan Tubuh (LPT) menggunakan rumus Mosteller
            function hitungLPT(berat, tinggi) {
                // Konversi tinggi ke meter jika dalam cm
                const tinggiMeter = tinggi > 3 ? tinggi / 100 : tinggi;

                if (berat && tinggiMeter) {
                    // Rumus Mosteller yang lebih presisi
                    const lpt = Math.sqrt(berat * tinggiMeter) / 60;
                    return lpt.toFixed(2);
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

            // Event listener untuk input berat badan dan tinggi badan
            function calculateMetrics() {
                const berat = parseNumericInput(beratInput);
                const tinggi = parseNumericInput(tinggiInput);

                if (berat && tinggi) {
                    // Konversi tinggi ke meter jika dalam cm
                    const tinggiMeter = tinggi > 3 ? tinggi / 100 : tinggi;

                    // Hitung IMT
                    const imt = hitungIMT(berat, tinggiMeter);
                    imtInput.value = `${imt} (${kategorikanIMT(parseFloat(imt))})`;

                    // Hitung LPT menggunakan rumus Mosteller
                    const lpt = Math.sqrt(berat * tinggiMeter) / 60;
                    lptInput.value = lpt.toFixed(2);
                } else {
                    imtInput.value = '';
                    lptInput.value = '';
                }
            }

            // Tambahkan event listener untuk input berat dan tinggi
            beratInput.addEventListener('input', calculateMetrics);
            tinggiInput.addEventListener('input', calculateMetrics);
        });

        // bagian Score Aldrete
        // Ambil semua input field
        const aktivitas = document.getElementById('aktivitas');
        const sirkulasi = document.getElementById('sirkulasi');
        const pernafasan = document.getElementById('pernafasan');
        const kesadaran = document.getElementById('kesadaran');
        const warnaKulit = document.getElementById('warna_kulit');
        const total = document.getElementById('total');

        // Fungsi untuk menghitung total
        function hitungTotal() {
            const nilaiAktivitas = parseInt(aktivitas.value) || 0;
            const nilaiSirkulasi = parseInt(sirkulasi.value) || 0;
            const nilaiPernafasan = parseInt(pernafasan.value) || 0;
            const nilaiKesadaran = parseInt(kesadaran.value) || 0;
            const nilaiWarnaKulit = parseInt(warnaKulit.value) || 0;
            
            // Hitung total
            const totalScore = nilaiAktivitas + nilaiSirkulasi + nilaiPernafasan + 
                            nilaiKesadaran + nilaiWarnaKulit;
            
            // Tampilkan hasil di field total
            total.value = totalScore;
        }

        // Tambahkan event listener ke setiap input
        aktivitas.addEventListener('input', hitungTotal);
        sirkulasi.addEventListener('input', hitungTotal);
        pernafasan.addEventListener('input', hitungTotal);
        kesadaran.addEventListener('input', hitungTotal);
        warnaKulit.addEventListener('input', hitungTotal);

        // Hitung total saat halaman pertama kali dimuat (jika ada nilai default)
        hitungTotal();
    </script>
@endpush
