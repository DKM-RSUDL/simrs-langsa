@php
    if (!function_exists('getAvpuText')) {
        function getAvpuText($value)
        {
            switch ($value) {
                case 0:
                    return 'Sadar Baik/Alert : 0';
                case 1:
                    return 'Berespon dengan kata-kata/Voice: 1';
                case 2:
                    return 'Hanya berespon jika dirangsang nyeri/pain: 2';
                case 3:
                    return 'Pasien tidak sadar/unresponsive: 3';
                case 4:
                    return 'Gelisah atau bingung: 4';
                case 5:
                    return 'Acute Confusional States: 5';
                default:
                    return '';
            }
        }
    }

    if (!function_exists('getDukunganOksigenText')) {
        function getDukunganOksigenText($value)
        {
            switch ($value) {
                case 1:
                    return 'Udara Bebas';
                case 2:
                    return 'Kanul Nasal';
                case 3:
                    return 'Simple Mark';
                case 4:
                    return 'Rebreathing Mark';
                case 5:
                    return 'No-Rebreathing Mark';
                default:
                    return '';
            }
        }
    }
@endphp

@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        // 5. Pemantauan Selama Anestesi dan Sedasi (PSAS)
        document.addEventListener('DOMContentLoaded', function () {
            // Direct JSON initialization for chart display
            const jsonData = @json($okPraInduksi->okPraInduksiPsas->all_monitoring_data ?? '[]');
            let monitoringData = [];

            try {
                monitoringData = JSON.parse(jsonData);
                if (!Array.isArray(monitoringData)) {
                    monitoringData = [];
                    console.error('Parsed data is not an array');
                }
            } catch (error) {
                console.error('Error parsing JSON data:', error);
            }

            // Extract chart data directly from the parsed JSON
            const chartLabels = monitoringData.map(item => item.time || '');
            const tekananDarahData = monitoringData.map(item => item.tekananDarah || 0);
            const nadiData = monitoringData.map(item => item.nadi || 0);
            const nafasData = monitoringData.map(item => item.nafas || 0);
            const spo2Data = monitoringData.map(item => item.spo2 || 0);

            console.log('Monitoring data:', monitoringData);
            console.log('Chart labels:', chartLabels);
            console.log('Data arrays:', {
                tekananDarah: tekananDarahData,
                nadi: nadiData,
                nafas: nafasData,
                spo2: spo2Data
            });

            // Get chart element
            const chartElement = document.getElementById('vitalSignsChartPSAS');

            if (!chartElement) {
                console.error('Chart element not found');
                return;
            }

            const ctx = chartElement.getContext('2d');

            // Create chart
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
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
                            label: 'SpO₂',
                            data: spo2Data,
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
                            if (bromageScoreForm) {
                                bromageScoreForm.style.display = 'block';
                                restoreBromageData();
                            }
                            break;
                        case 'steward':
                            if (stewardScoreForm) {
                                stewardScoreForm.style.display = 'block';
                                restoreStewardData();
                            }
                            break;
                        case 'aldrete':
                            if (aldreteScoreForm) {
                                aldreteScoreForm.style.display = 'block';
                                restoreAldreteData();
                            }
                            break;
                        case 'padds':
                            if (paddsScoreForm) {
                                paddsScoreForm.style.display = 'block';
                                restorePADDSData();
                            }
                            break;
                    }
                }
                updateJSONData();
            }

            // Restore Bromage data from JSON
            function restoreBromageData() {
                if (!scoreData.bromage_data) return;
                
                const data = scoreData.bromage_data;
                
                // Restore time inputs
                if (data.time_inputs) {
                    Object.keys(data.time_inputs).forEach(key => {
                        const input = document.querySelector(`input[name="bromage_${key}"]`);
                        if (input) input.value = data.time_inputs[key];
                    });
                }

                // Restore radio selections
                if (data.time_observations) {
                    Object.keys(data.time_observations).forEach(timeKey => {
                        const time = timeKey.replace('time_', '');
                        const observation = data.time_observations[timeKey];
                        const radio = document.querySelector(`input[name="bromage_time_${time}"][data-group="${observation.selected_option}"]`);
                        if (radio) radio.checked = true;
                    });
                }

                // Restore jam pindah
                if (data.jam_pindah) {
                    const jamPindah = document.querySelector('input[name="bromage_jam_pindah"]');
                    if (jamPindah) jamPindah.value = data.jam_pindah;
                }

                // Update displays
                if (data.total_score !== undefined) {
                    document.getElementById('bromage_total_score').textContent = data.total_score;
                    document.getElementById('bromage_total_score_value').value = data.total_score;
                    
                    const statusBadge = document.getElementById('bromage_status');
                    if (data.total_score >= 2) {
                        statusBadge.textContent = '✓ Pasien BOLEH dipindah ke ruang perawatan';
                        statusBadge.className = 'badge bg-success';
                    } else {
                        statusBadge.textContent = '✗ Pasien BELUM BOLEH dipindah (score harus ≥ 2)';
                        statusBadge.className = 'badge bg-danger';
                    }
                }
            }

            // Restore Steward data from JSON
            function restoreStewardData() {
                if (!scoreData.steward_data) return;
                
                const data = scoreData.steward_data;
                
                // Restore radio selections
                if (data.time_observations) {
                    Object.keys(data.time_observations).forEach(time => {
                        const observation = data.time_observations[time];
                        ['kesadaran', 'respirasi', 'motorik'].forEach(category => {
                            if (observation[category] && observation[category].value) {
                                const radio = document.querySelector(`input[name="steward_${category}_${time}"][value="${observation[category].value}"]`);
                                if (radio) radio.checked = true;
                            }
                        });
                    });
                }

                // Restore jam pindah
                if (data.jam_pindah) {
                    const jamPindah = document.querySelector('input[name="steward_jam_pindah"]');
                    if (jamPindah) jamPindah.value = data.jam_pindah;
                }

                // Update displays
                if (data.total_score !== undefined) {
                    document.getElementById('steward_total_score').textContent = data.total_score;
                    document.getElementById('steward_total_score_value').value = data.total_score;
                    
                    const statusBadge = document.getElementById('steward_status');
                    if (data.total_score >= 5) {
                        statusBadge.textContent = '✓ Pasien BOLEH dipindah ke ruang perawatan';
                        statusBadge.className = 'badge bg-success';
                    } else {
                        statusBadge.textContent = '✗ Pasien BELUM BOLEH dipindah (score harus ≥ 5)';
                        statusBadge.className = 'badge bg-danger';
                    }
                }
            }

            // Restore Aldrete data from JSON
            function restoreAldreteData() {
                if (!scoreData.aldrete_data) return;
                
                const data = scoreData.aldrete_data;
                
                // Restore select values
                const fields = ['aktivitas_motorik', 'respirasi', 'aldrete_sirkulasi', 'aldrete_kesadaran', 'aldrete_warna_kulit'];
                fields.forEach(field => {
                    const select = document.querySelector(`select[name="${field}"]`);
                    if (select && data[field.replace('aldrete_', '')]) {
                        select.value = data[field.replace('aldrete_', '')];
                    }
                });

                // Restore datetime
                if (data.tanggal_pasca_anestesi) {
                    const datetime = document.querySelector('input[name="aldrete_tanggal"]');
                    if (datetime) datetime.value = data.tanggal_pasca_anestesi;
                }

                // Restore intervals
                if (data.intervals) {
                    data.intervals.forEach((interval, index) => {
                        const jamInput = document.querySelector(`input[name="interval_jam_${index + 1}"]`);
                        const skorInput = document.querySelector(`input[name="skor_${index + 1}"]`);
                        const keteranganInput = document.querySelector(`input[name="keterangan_${index + 1}"]`);
                        
                        if (jamInput) jamInput.value = interval.jam;
                        if (skorInput) skorInput.value = interval.skor;
                        if (keteranganInput) keteranganInput.value = interval.keterangan;
                    });
                }

                // Update conclusion display
                if (data.conclusion) {
                    const conclusionElements = aldreteScoreForm.querySelectorAll('.bg-success, .bg-danger');
                    conclusionElements.forEach(element => {
                        element.innerHTML = `<strong>Kesimpulan : </strong> ${data.conclusion}`;
                        if (data.conclusion === "Boleh pindah ruang") {
                            element.classList.remove('bg-danger');
                            element.classList.add('bg-success');
                        } else {
                            element.classList.remove('bg-success');
                            element.classList.add('bg-danger');
                        }
                    });
                }
            }

            // Restore PADDS data from JSON
            function restorePADDSData() {
                if (!scoreData.padds_data) return;
                
                const data = scoreData.padds_data;
                
                // Restore select values
                const fields = ['padds_tanda_vital', 'padds_aktivitas', 'padds_mual_muntah', 'padds_perdarahan', 'padds_nyeri'];
                fields.forEach(field => {
                    const select = document.querySelector(`select[name="${field}"]`);
                    const dataKey = field.replace('padds_', '').replace('_', '_');
                    if (select && data[dataKey]) {
                        select.value = data[dataKey];
                    }
                });

                // Restore datetime
                if (data.tanggal_jam) {
                    const datetime = document.querySelector('input[name="padds_tanggal_jam"]');
                    if (datetime) datetime.value = data.tanggal_jam;
                }

                // Update conclusion display
                if (data.conclusion) {
                    const kesimpulanElement = document.getElementById('paddsKesimpulan');
                    const kesimpulanInput = document.getElementById('paddsKesimpulanInput');
                    if (kesimpulanElement) {
                        kesimpulanElement.textContent = data.conclusion;
                        kesimpulanElement.style.backgroundColor = data.conclusion === "Boleh pindah ruang" ? '#28a745' : '#dc3545';
                    }
                    if (kesimpulanInput) kesimpulanInput.value = data.conclusion;

                    const finalKesimpulanElement = document.getElementById('paddsFinalKesimpulan');
                    const finalKesimpulanInput = document.getElementById('paddsFinalKesimpulanInput');
                    if (finalKesimpulanElement) {
                        finalKesimpulanElement.textContent = data.conclusion;
                        finalKesimpulanElement.style.backgroundColor = data.conclusion === "Boleh pindah ruang" ? '#28a745' : '#dc3545';
                    }
                    if (finalKesimpulanInput) finalKesimpulanInput.value = data.conclusion;
                }
            }

            // Initialize when page loads
            initializeOnLoad();
        });
    </script>
@endpush
