@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .progress-wrapper {
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
        }

        .progress-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-percentage {
            color: #198754;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            background-color: #097dd6;
            transition: width 0.6s ease;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-row {
            padding: 0.5rem 1rem;
            border-color: #dee2e6 !important;
        }

        .diagnosis-item {
            background-color: transparent;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .pain-scale-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .pain-scale-image {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown-menu {
            display: none;
            position: fixed;
            /* Ubah ke absolute */
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            transform: translateY(5px);
            /* Tambahkan sedikit offset */
            max-height: 400px;
            overflow-y: auto;
        }

        /* Tambahkan wrapper untuk positioning yang lebih baik */
        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        /*  */
        .form-check {
            flex: 0 0 25%;
        }

        /*  */
        .risk-form {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .conclusion {
            margin-top: 1.5rem;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 5px solid;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .section-separator {
            padding: 2rem;
            border: 2px solid #dee2e6;
            border-radius: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #0d6efd;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 0.5rem;
            margin-bottom: 2rem;
            font-weight: 700;
        }
        .score-display {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .factor-card {
            background: white;
            border: 1px solid #e3e6f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .factor-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }
        .factor-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        .score-badge {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            min-width: 60px;
            text-align: center;
        }
        .total-score-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0,123,255,0.3);
            margin: 2rem 0;
        }
        .risk-level-cards {
            display: flex;
            gap: 1rem;
            margin: 1.5rem 0;
            flex-wrap: wrap;
        }
        .risk-card {
            flex: 1;
            min-width: 200px;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .risk-card.active {
            transform: scale(1.05);
            border-color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .risk-low {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        .risk-medium {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        .risk-high {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }
        .question-card {
            background: white;
            border-left: 4px solid #007bff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .question-text {
            font-weight: 500;
            margin-bottom: 1rem;
            color: #495057;
        }
        .custom-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .custom-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        .sub-question-card {
            background: #f8f9fa;
            border-left: 3px solid #6c757d;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            margin-left: 1rem;
        }
        .parameter-section {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: white;
        }
        .parameter-title {
            font-weight: 700;
            color: #495057;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

    </style>
@endpush

@push('js')
    <script>
        // Riwayat Konsumsi
        document.addEventListener('DOMContentLoaded', function() {
            // Handle alkohol/obat radio buttons
            const alkoholRadios = document.querySelectorAll('input[name="alkohol_obat"]');
            const alkoholDetail = document.querySelector('.alkohol-detail');

            alkoholRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'ya') {
                        alkoholDetail.style.display = 'block';
                    } else {
                        alkoholDetail.style.display = 'none';
                        // Clear inputs when hidden
                        alkoholDetail.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                });
            });

            // Handle merokok radio buttons
            const merokokRadios = document.querySelectorAll('input[name="merokok"]');
            const merokokDetail = document.querySelector('.merokok-detail');

            merokokRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'ya') {
                        merokokDetail.style.display = 'block';
                    } else {
                        merokokDetail.style.display = 'none';
                        // Clear inputs when hidden
                        merokokDetail.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                });
            });
        });

        // 5. PENGKAJIAN STATUS NUTRISI
        // Script untuk menghitung total skor otomatis
        document.addEventListener('DOMContentLoaded', function() {
            const radioInputs = document.querySelectorAll('input[type="radio"]');
            const totalSkorInput = document.getElementById('total_skor_nutrisi');
            const totalSkorDisplay = document.getElementById('total_skor_display');

            function calculateTotal() {
                let total = 0;

                // Skor dari penurunan BB
                const bbTurunRadio = document.querySelector('input[name="bb_turun"]:checked');
                if (bbTurunRadio) {
                    total += parseInt(bbTurunRadio.value);
                }

                // Skor dari range penurunan BB
                const bbRangeRadio = document.querySelector('input[name="bb_turun_range"]:checked');
                if (bbRangeRadio) {
                    total += parseInt(bbRangeRadio.value);
                }

                // Skor dari nafsu makan
                const nafsuMakanRadio = document.querySelector('input[name="nafsu_makan"]:checked');
                if (nafsuMakanRadio) {
                    total += parseInt(nafsuMakanRadio.value);
                }

                // Update total score input and display
                totalSkorInput.value = total;
                totalSkorDisplay.textContent = total;

                // Highlight jika skor >= 2
                if (total >= 2) {
                    totalSkorDisplay.className = 'display-1 text-danger fw-bold';
                } else {
                    totalSkorDisplay.className = 'display-1 text-primary fw-bold';
                }
            }

            radioInputs.forEach(radio => {
                radio.addEventListener('change', calculateTotal);
            });
        });

        // Fungsi Skala Nyeri
        $(document).ready(function() {
            initSkalaNyeri();
        });

        function initSkalaNyeri() {
            const input = $('#skalaNyeriInput');
            const button = $('#skalaNyeriBtn');
            const tipeSkalaHidden = $('#tipeSkalaHidden');
            const numericBtn = $('#numericBtn');
            const wongBakerBtn = $('#wongBakerBtn');
            const numericScale = $('#numericScale');
            const wongBakerScale = $('#wongBakerScale');

            // Debug elements
            const debugNilai = $('#debugNilai');
            const debugTipe = $('#debugTipe');

            // Set tipe skala default berdasarkan hidden input saat load
            const currentScale = tipeSkalaHidden.val();
            if (currentScale === 'wong-baker') {
                showWongBakerScale();
            } else {
                showNumericScale();
            }

            // Update debug info saat pertama load
            updateDebugInfo();

            // Trigger saat pertama kali load
            updateButton(parseInt(input.val()) || 0);

            // Event handler untuk input nilai nyeri
            input.on('input change', function() {
                let nilai = parseInt($(this).val()) || 0;

                // Batasi nilai antara 0-10
                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);

                updateButton(nilai);
                updateDebugInfo();
            });

            // Event handler untuk tombol Numeric Scale
            numericBtn.on('click', function() {
                showNumericScale();
                tipeSkalaHidden.val('numeric');
                updateDebugInfo();
                console.log('Switched to Numeric Scale');
            });

            // Event handler untuk tombol Wong Baker Scale
            wongBakerBtn.on('click', function() {
                showWongBakerScale();
                tipeSkalaHidden.val('wong-baker');
                updateDebugInfo();
                console.log('Switched to Wong Baker Scale');
            });

            // Fungsi untuk menampilkan skala numeric
            function showNumericScale() {
                numericBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                wongBakerBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                numericScale.show();
                wongBakerScale.hide();
            }

            // Fungsi untuk menampilkan skala Wong Baker
            function showWongBakerScale() {
                wongBakerBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                numericBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                wongBakerScale.show();
                numericScale.hide();
            }

            // Fungsi untuk update button status nyeri
            function updateButton(nilai) {
                let buttonClass, textNyeri;

                switch (true) {
                    case nilai === 0:
                        buttonClass = 'btn-success';
                        textNyeri = 'Tidak Nyeri';
                        break;
                    case nilai >= 1 && nilai <= 3:
                        buttonClass = 'btn-success';
                        textNyeri = 'Nyeri Ringan';
                        break;
                    case nilai >= 4 && nilai <= 5:
                        buttonClass = 'btn-warning';
                        textNyeri = 'Nyeri Sedang';
                        break;
                    case nilai >= 6 && nilai <= 7:
                        buttonClass = 'btn-warning';
                        textNyeri = 'Nyeri Berat';
                        break;
                    case nilai >= 8 && nilai <= 9:
                        buttonClass = 'btn-danger';
                        textNyeri = 'Nyeri Sangat Berat';
                        break;
                    case nilai >= 10:
                        buttonClass = 'btn-danger';
                        textNyeri = 'Nyeri Tak Tertahankan';
                        break;
                }

                button
                    .removeClass('btn-success btn-warning btn-danger')
                    .addClass(buttonClass)
                    .text(textNyeri);
            }

            // Fungsi untuk update debug info
            function updateDebugInfo() {
                debugNilai.text(input.val() || '0');
                debugTipe.text(tipeSkalaHidden.val());
            }

            // Event listener untuk tracking perubahan (untuk debugging)
            input.add(tipeSkalaHidden).on('change', function() {
                console.log({
                    skala_nyeri: input.val(),
                    tipe_skala_nyeri: tipeSkalaHidden.val()
                });
            });
        }

        // Lokasi nyeri
        $(document).ready(function() {
            // Enable/disable input text untuk durasi nyeri lokasi
            $('input[name="durasi_nyeri_menjalar"]').on('change', function() {
                const lokasiInput = $('#durasi_nyeri_lokasi');
                if ($(this).val() === 'Ya') {
                    lokasiInput.prop('disabled', false).focus();
                } else {
                    lokasiInput.prop('disabled', true).val('');
                }
            });

            // Enable/disable input text untuk faktor peringan lainnya
            $('#faktor_peringan_lainnya').on('change', function() {
                const lainnyaInput = $('#faktor_peringan_lainnya_text');
                if ($(this).is(':checked')) {
                    lainnyaInput.prop('disabled', false).focus();
                } else {
                    lainnyaInput.prop('disabled', true).val('');
                }
            });

            // Enable/disable input text untuk efek nyeri lainnya
            $('#efek_nyeri_lainnya_efek').on('change', function() {
                const lainnyaInput = $('#efek_nyeri_lainnya_text');
                if ($(this).is(':checked')) {
                    lainnyaInput.prop('disabled', false).focus();
                } else {
                    lainnyaInput.prop('disabled', true).val('');
                }
            });

            // Initialize state pada page load
            if ($('input[name="durasi_nyeri_menjalar"]:checked').val() !== 'Ya') {
                $('#durasi_nyeri_lokasi').prop('disabled', true);
            }

            if (!$('#faktor_peringan_lainnya').is(':checked')) {
                $('#faktor_peringan_lainnya_text').prop('disabled', true);
            }

            if (!$('#efek_nyeri_lainnya_efek').is(':checked')) {
                $('#efek_nyeri_lainnya_text').prop('disabled', true);
            }
        });

        //============================================================//
        // Event handler untuk skala risiko jatuh
        //============================================================//
        // Initialize all forms to hidden
        document.addEventListener('DOMContentLoaded', function() {
            const riskForms = document.querySelectorAll('.risk-form');
            riskForms.forEach(form => form.style.display = 'none');
        });

        // Show form based on selection
        function showForm(formType) {
            // Hide all forms first
            const riskForms = document.querySelectorAll('.risk-form');
            riskForms.forEach(form => form.style.display = 'none');

            // Reset all risk cards
            document.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

            // Handle "Lainnya" option
            if (formType === '5') {
                alert('Perhatian: Pasien tidak dapat dinilai status resiko jatuh');
                return;
            }

            // Form mapping
            const formMapping = {
                '1': 'skala_umumForm',
                '2': 'skala_morseForm',
                '3': 'skala_humptyForm',
                '4': 'skala_ontarioForm'
            };

            // Show selected form
            if (formType && formMapping[formType]) {
                document.getElementById(formMapping[formType]).style.display = 'block';
                resetForm(formMapping[formType]);
            }
        }

        function showDecubitusForm(formType) {
            if (formType === 'norton') {
                document.getElementById('skala_nortonForm').style.display = 'block';
                resetForm('skala_nortonForm');
            }
        }

        function showADLForm(formType) {
            if (formType === 'adl') {
                document.getElementById('skala_adlForm').style.display = 'block';
                resetForm('skala_adlForm');
            }
        }

        // Reset form to default state
        function resetForm(formId) {
            const form = document.getElementById(formId);
            const selects = form.querySelectorAll('select');
            selects.forEach(select => select.value = '');

            // Reset all score badges
            form.querySelectorAll('.score-badge').forEach(badge => badge.textContent = '0');

            // Reset conclusions based on form type
            if (formId.includes('umum')) {
                document.getElementById('kesimpulanUmum').textContent = 'Tidak berisiko jatuh';
                document.getElementById('risiko_jatuh_umum_kesimpulan').value = 'Tidak berisiko jatuh';
            } else if (formId.includes('morse')) {
                document.getElementById('totalSkorMorse').textContent = '0';
                document.getElementById('kesimpulanMorse').textContent = 'Risiko Rendah';
            } else if (formId.includes('ontario')) {
                document.getElementById('totalSkorOntario').textContent = '0';
                document.getElementById('kesimpulanOntario').textContent = 'Risiko Rendah';
            } else if (formId.includes('norton')) {
                document.getElementById('totalSkorNorton').textContent = '0';
                document.getElementById('kesimpulanNorton').textContent = 'Risiko Rendah';
            } else if (formId.includes('adl')) {
                document.getElementById('totalSkorADL').textContent = '0';
                document.getElementById('kesimpulanADL').textContent = 'Mandiri (Skor: 0)';
            }

            // Reset risk cards
            form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));
        }

        // Update conclusion based on form type
        function updateConclusion(formType) {
            if (formType === 'umum') {
                updateUmumConclusion();
            } else if (formType === 'morse') {
                updateMorseConclusion();
            } else if (formType === 'ontario') {
                updateOntarioConclusion();
            } else if (formType === 'norton') {
                updateNortonConclusion();
            } else if (formType === 'adl') {
                updateADLConclusion();
            }
        }

        // Update Umum conclusion
        function updateUmumConclusion() {
            const form = document.getElementById('skala_umumForm');
            const selects = form.querySelectorAll('select');
            let hasYes = false;

            selects.forEach(select => {
                if (select.value === '1') {
                    hasYes = true;
                }
            });

            const conclusion = hasYes ? 'Berisiko jatuh' : 'Tidak berisiko jatuh';
            const alertClass = hasYes ? 'alert-danger' : 'alert-success';

            document.getElementById('kesimpulanUmum').textContent = conclusion;
            document.getElementById('risiko_jatuh_umum_kesimpulan').value = conclusion;

            const conclusionDiv = form.querySelector('.conclusion');
            conclusionDiv.className = `conclusion alert ${alertClass}`;
        }

        // Update Morse conclusion
        function updateMorseConclusion() {
            const form = document.getElementById('skala_morseForm');
            const selects = form.querySelectorAll('select');
            let totalScore = 0;

            // Update individual scores and calculate total
            const scoreElements = {
                'risiko_jatuh_morse_riwayat_jatuh': 'score_riwayat_jatuh',
                'risiko_jatuh_morse_diagnosis_sekunder': 'score_diagnosis_sekunder',
                'risiko_jatuh_morse_bantuan_ambulasi': 'score_bantuan_ambulasi',
                'risiko_jatuh_morse_terpasang_infus': 'score_terpasang_infus',
                'risiko_jatuh_morse_cara_berjalan': 'score_cara_berjalan',
                'risiko_jatuh_morse_status_mental': 'score_status_mental'
            };

            Object.entries(scoreElements).forEach(([name, elementId]) => {
                const select = form.querySelector(`select[name="${name}"]`);
                const score = parseInt(select?.value) || 0;
                document.getElementById(elementId).textContent = score;
                totalScore += score;
            });

            document.getElementById('totalSkorMorse').textContent = totalScore;

            // Reset risk cards
            form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

            let conclusion = '';
            let alertClass = '';

            if (totalScore >= 45) {
                conclusion = 'Risiko Tinggi';
                alertClass = 'alert-danger';
                document.getElementById('resikoTinggiMorse').classList.add('active');
            } else if (totalScore >= 25) {
                conclusion = 'Risiko Sedang';
                alertClass = 'alert-warning';
                document.getElementById('resikoSedangMorse').classList.add('active');
            } else {
                conclusion = 'Risiko Rendah';
                alertClass = 'alert-success';
                document.getElementById('resikoRendahMorse').classList.add('active');
            }

            conclusion += ` (Skor: ${totalScore})`;

            document.getElementById('kesimpulanMorse').textContent = conclusion;
            document.getElementById('risiko_jatuh_morse_kesimpulan').value = conclusion;

            const conclusionDiv = form.querySelector('.conclusion');
            conclusionDiv.className = `conclusion alert ${alertClass}`;
        }

        // Update Ontario conclusion
        function updateOntarioConclusion() {
            const form = document.getElementById('skala_ontarioForm');
            let totalScore = 0;

            // Calculate individual sections
            let riwayatJatuhScore = Math.max(
                parseInt(document.querySelector('select[name="ontario_jatuh_saat_masuk"]')?.value) || 0,
                parseInt(document.querySelector('select[name="ontario_jatuh_2_bulan"]')?.value) || 0
            );

            let statusMentalScore = Math.max(
                parseInt(document.querySelector('select[name="ontario_delirium"]')?.value) || 0,
                parseInt(document.querySelector('select[name="ontario_disorientasi"]')?.value) || 0,
                parseInt(document.querySelector('select[name="ontario_agitasi"]')?.value) || 0
            );

            let penglihatanScore = Math.max(
                parseInt(document.querySelector('select[name="ontario_kacamata"]')?.value) || 0,
                parseInt(document.querySelector('select[name="ontario_penglihatan_buram"]')?.value) || 0,
                parseInt(document.querySelector('select[name="ontario_glaukoma"]')?.value) || 0
            );

            let berkemihScore = parseInt(document.querySelector('select[name="ontario_berkemih"]')?.value) || 0;

            let transferScore = parseInt(document.querySelector('select[name="ontario_transfer"]')?.value) || 0;
            let mobilitasScore = parseInt(document.querySelector('select[name="ontario_mobilitas"]')?.value) || 0;

            // Transfer + Mobilitas logic
            let transferMobilitasTotal = transferScore + mobilitasScore;
            let transferMobilitasScore = transferMobilitasTotal > 6 ? 3 : 0;

            // Update individual score displays
            document.getElementById('skor_riwayat_jatuh').textContent = riwayatJatuhScore;
            document.getElementById('skor_status_mental').textContent = statusMentalScore;
            document.getElementById('skor_penglihatan').textContent = penglihatanScore;
            document.getElementById('skor_berkemih').textContent = berkemihScore;
            document.getElementById('skor_transfer_mobilitas').textContent = transferMobilitasScore;

            // Calculate total
            totalScore = riwayatJatuhScore + statusMentalScore + penglihatanScore + berkemihScore + transferMobilitasScore;
            document.getElementById('totalSkorOntario').textContent = totalScore;

            // Reset risk cards
            form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

            let conclusion = '';
            let alertClass = '';

            if (totalScore >= 17) {
                conclusion = 'Risiko Tinggi';
                alertClass = 'alert-danger';
                document.getElementById('resikoTinggiOntario').classList.add('active');
            } else if (totalScore >= 6) {
                conclusion = 'Risiko Sedang';
                alertClass = 'alert-warning';
                document.getElementById('resikoSedangOntario').classList.add('active');
            } else {
                conclusion = 'Risiko Rendah';
                alertClass = 'alert-success';
                document.getElementById('resikoRendahOntario').classList.add('active');
            }

            conclusion += ` (Skor: ${totalScore})`;

            document.getElementById('kesimpulanOntario').textContent = conclusion;
            document.getElementById('risiko_jatuh_lansia_kesimpulan').value = conclusion;

            const conclusionDiv = form.querySelector('.conclusion');
            conclusionDiv.className = `conclusion alert ${alertClass}`;
        }

        // Update Norton conclusion
        function updateNortonConclusion() {
            const form = document.getElementById('skala_nortonForm');
            let totalScore = 0;

            // Calculate scores for each factor
            const scoreElements = {
                'norton_kondisi_fisik': 'skor_kondisi_fisik',
                'norton_kondisi_mental': 'skor_kondisi_mental',
                'norton_aktivitas': 'skor_aktivitas',
                'norton_mobilitas': 'skor_mobilitas',
                'norton_inkontinensia': 'skor_inkontinensia'
            };

            Object.entries(scoreElements).forEach(([name, elementId]) => {
                const select = form.querySelector(`select[name="${name}"]`);
                const score = parseInt(select?.value) || 0;
                document.getElementById(elementId).textContent = score;
                totalScore += score;
            });

            document.getElementById('totalSkorNorton').textContent = totalScore;

            // Reset risk cards
            form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

            let conclusion = '';
            let alertClass = '';

            if (totalScore < 12) {
                conclusion = 'Risiko Tinggi';
                alertClass = 'alert-danger';
                document.getElementById('resikoTinggiNorton').classList.add('active');
            } else if (totalScore <= 15) {
                conclusion = 'Risiko Sedang';
                alertClass = 'alert-warning';
                document.getElementById('resikoSedangNorton').classList.add('active');
            } else {
                conclusion = 'Risiko Rendah';
                alertClass = 'alert-success';
                document.getElementById('resikoRendahNorton').classList.add('active');
            }

            conclusion += ` (Skor: ${totalScore})`;

            document.getElementById('kesimpulanNorton').textContent = conclusion;
            document.getElementById('risiko_norton_kesimpulan').value = conclusion;

            const conclusionDiv = form.querySelector('.conclusion');
            conclusionDiv.className = `conclusion alert ${alertClass}`;
        }

        // Update ADL conclusion
        function updateADLConclusion() {
            const form = document.getElementById('skala_adlForm');
            let totalScore = 0;

            // Calculate scores for each activity
            const scoreElements = {
                'adl_makan': 'skor_makan',
                'adl_berjalan': 'skor_berjalan',
                'adl_mandi': 'skor_mandi'
            };

            Object.entries(scoreElements).forEach(([name, elementId]) => {
                const select = form.querySelector(`select[name="${name}"]`);
                const score = parseInt(select?.value) || 0;
                document.getElementById(elementId).textContent = score;
                totalScore += score;
            });

            document.getElementById('totalSkorADL').textContent = totalScore;

            let conclusion = '';
            if (totalScore === 0) {
                conclusion = 'Mandiri';
            } else if (totalScore <= 3) {
                conclusion = 'Bantuan Minimal';
            } else if (totalScore <= 6) {
                conclusion = 'Bantuan Sedang';
            } else {
                conclusion = 'Bantuan Total';
            }

            conclusion += ` (Skor: ${totalScore})`;

            document.getElementById('kesimpulanADL').textContent = conclusion;
            document.getElementById('adl_kesimpulan').value = conclusion;
        }

        // Discharge Planning
        document.addEventListener('DOMContentLoaded', function () {
            const selectElements = {
                age: document.querySelector('select[name="usia_lanjut"]'),
                mobility: document.querySelector('select[name="hambatan_mobilisasi"]'),
                medService: document.querySelector('select[name="penggunaan_media_berkelanjutan"]'),
                medication: document.querySelector('select[name="ketergantungan_aktivitas"]')
            };

            const alerts = {
                info: document.querySelector('#reason-alert'),
                warning: document.querySelector('#special-plan-alert'),
                success: document.querySelector('#no-special-plan-alert')
            };

            const hiddenInput = document.querySelector('#kesimpulan');

            // Check if all required elements exist
            if (!Object.values(selectElements).every(el => el) || !Object.values(alerts).every(el => el) || !hiddenInput) {
                console.error('One or more required elements are missing');
                return;
            }

            function calculateConclusion() {
                let needsSpecialPlan = false;
                let reasons = [];

                // Check each condition
                if (selectElements.age.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Pasien berusia lanjut (>60 tahun)');
                }
                if (selectElements.mobility.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Terdapat hambatan mobilitas');
                }
                if (selectElements.medService.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan pelayanan medis berkelanjutan');
                }
                if (selectElements.medication.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan bantuan dalam konsumsi obat dan aktivitas harian');
                }

                // Reset alerts
                Object.values(alerts).forEach(alert => alert.classList.add('d-none'));

                // Update UI based on conditions
                if (needsSpecialPlan) {
                    alerts.warning.classList.remove('d-none');
                    alerts.info.classList.remove('d-none');
                    alerts.info.innerHTML = '<strong>Alasan:</strong><br>- ' + (reasons.length > 0 ? reasons.join('<br>- ') : 'Tidak ada alasan spesifik');
                    hiddenInput.value = 'Membutuhkan rencana pulang khusus';
                } else {
                    alerts.success.classList.remove('d-none');
                    hiddenInput.value = 'Tidak membutuhkan rencana pulang khusus';
                }
            }

            // Add event listeners to all select elements
            Object.values(selectElements).forEach(select => {
                select.addEventListener('change', calculateConclusion);
            });

            // Initial calculation
            calculateConclusion();
        });


        $('.rencana-perawatan-row-1').change(function() {
            let rowCount = $('.rencana-perawatan-row-1:checked').length > 0;

            if(rowCount) {
                $('#rencana_bersihan_jalan_nafas').css('display', 'block');
            } else {
                $('#rencana_bersihan_jalan_nafas').css('display', 'none');
            }

        });

        // 13. MASALAH/ DIAGNOSIS KEPERAWATAN
        function toggleRencana(diagnosisType) {
            const checkbox = document.getElementById('diag_' + diagnosisType);
            const rencanaDiv = document.getElementById('rencana_' + diagnosisType);

            if (checkbox && rencanaDiv) {
                if (checkbox.checked) {
                    rencanaDiv.style.display = 'block';
                } else {
                    rencanaDiv.style.display = 'none';
                    // Uncheck all rencana checkboxes when diagnosis is unchecked
                    const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                    rencanaCheckboxes.forEach(cb => cb.checked = false);
                }
            }
        }

        // Set current date and time
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);

            const tanggalInput = document.querySelector('input[name="tanggal_diagnosis"]');
            const jamInput = document.querySelector('input[name="jam_diagnosis"]');

            if (tanggalInput) tanggalInput.value = today;
            if (jamInput) jamInput.value = currentTime;
        });
    </script>
@endpush
