@push('css')
    <style>
        .covid-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #5a67d8;
        }

        .form-header h4 {
            margin: 0;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-section {
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-content {
            padding: 20px;
        }

        .symptom-item, .risk-item, .comorbid-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .symptom-item:hover, .risk-item:hover, .comorbid-item:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-1px);
        }

        .form-check-input:checked {
            background-color: #48bb78;
            border-color: #48bb78;
        }

        .form-check-input:checked + .form-check-label {
            color: #2d3748;
            font-weight: 500;
        }

        .date-input {
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            transition: border-color 0.3s ease;
        }

        .date-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .assessment-section {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .assessment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .assessment-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .assessment-card:hover {
            border-color: #cbd5e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .assessment-card.selected {
            border-color: #48bb78;
            background: #f0fff4;
        }

        .assessment-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .assessment-desc {
            font-size: 0.9em;
            color: #4a5568;
            line-height: 1.5;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary-custom {
            background: #e2e8f0;
            color: #4a5568;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: #cbd5e0;
            color: #2d3748;
        }

        .alert-info-custom {
            background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%);
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .icon-symptom { color: #e53e3e; }
        .icon-risk { color: #d69e2e; }
        .icon-comorbid { color: #3182ce; }
        .icon-assessment { color: #805ad5; }

        .section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-title {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 20px;
            flex-wrap: wrap;
        }

        .radio-item {
            position: relative;
        }

        .radio-item input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: block;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px 35px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #4a5568;
            min-width: 150px;
        }

        .radio-label i {
            font-size: 2rem;
            margin-bottom: 8px;
            color: #667eea;
        }

        .radio-label:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .radio-item input[type="radio"]:checked + .radio-label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .radio-item input[type="radio"]:checked + .radio-label i {
            color: white;
        }

        .hidden-section {
            display: none;
        }

        .section-card .row {
            padding: 0 20px;
        }

        .section-card .row:last-child {
            padding-bottom: 20px;
        }

        .edit-header {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Show/hide keluarga section based on persetujuan_untuk selection
            $('input[name="persetujuan_untuk"]').change(function() {
                if ($(this).val() === 'keluarga') {
                    $('#keluarga-section').slideDown();
                } else {
                    $('#keluarga-section').slideUp();
                }
            });

            // Show/hide location input when travel history is checked
            $('#perjalanan').change(function() {
                if (this.checked) {
                    $('#lokasi_perjalanan').slideDown();
                } else {
                    $('#lokasi_perjalanan').slideUp();
                    $('input[name="lokasi_perjalanan"]').val('');
                }
            });

            // Assessment card selection (manual click)
            $('.assessment-card').click(function() {
                $('.assessment-card').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('.assessment-radio').prop('checked', true);

                // Update kesimpulan based on manual selection
                updateConclusionBasedOnAssessment($(this).data('value'));
            });

            // Mark currently selected assessment card on page load
            var currentAssessment = $('input[name="cara_penilaian"]:checked').val();
            if (currentAssessment) {
                $('.assessment-card[data-value="' + currentAssessment + '"]').addClass('selected');
            }

            // Function to update cara penilaian automatically
            function updateCaraPenilaian() {
                let demam = $('#demam').is(':checked');
                let ispa = $('#ispa').is(':checked');
                let ispaBerat = $('#ispa_berat').is(':checked');
                let kontakErat = $('#kontak_erat').is(':checked');
                let perjalanan = $('#perjalanan').is(':checked');

                let recommendedAssessment = '';

                // Logic for automatic assessment
                if (!demam && !ispa && !ispaBerat && kontakErat) {
                    recommendedAssessment = 'kontak_erat';
                } else if ((demam || ispa) && (kontakErat || perjalanan)) {
                    recommendedAssessment = 'suspek';
                } else if (ispaBerat) {
                    recommendedAssessment = 'suspek';
                } else {
                    recommendedAssessment = 'non_suspek';
                }

                // Update assessment card selection
                $('.assessment-card').removeClass('selected');
                $('.assessment-card[data-value="' + recommendedAssessment + '"]').addClass('selected');
                $('.assessment-card[data-value="' + recommendedAssessment + '"] .assessment-radio').prop('checked', true);

                return recommendedAssessment;
            }

            // Function to update conclusion based on assessment
            function updateConclusionBasedOnAssessment(assessment) {
                let title = $('#conclusion-title');
                let desc = $('#conclusion-desc');
                let kesimpulanInput = $('#kesimpulan');

                switch(assessment) {
                    case 'kontak_erat':
                        title.html('<i class="fas fa-user-friends text-warning"></i> KONTAK ERAT');
                        desc.text('Tanpa gejala + Faktor risiko utama no. 2 (Kasus konfirmasi/Probable*)');
                        kesimpulanInput.val('kontak_erat');
                        break;
                    case 'suspek':
                        title.html('<i class="fas fa-exclamation-triangle text-danger"></i> SUSPEK');
                        desc.html('• Gejala No.1 atau No.2 + Faktor risiko utama No.1 atau No.2<br>• Gejala No.4 DAN tidak ada penyebab lain berdasarkan gambaran klinis yang meyakinkan');
                        kesimpulanInput.val('suspek');
                        break;
                    case 'non_suspek':
                        title.html('<i class="fas fa-check-circle text-success"></i> NON SUSPEK');
                        desc.text('Tidak memenuhi kriteria kontak erat atau kasus suspek');
                        kesimpulanInput.val('non_suspek');
                        break;
                    default:
                        title.html('<i class="fas fa-spinner fa-spin"></i> Menghitung...');
                        desc.text('Silakan isi gejala dan faktor risiko untuk melihat kesimpulan.');
                        kesimpulanInput.val('');
                }
            }

            // Function to update both assessment and conclusion
            function updateAssessmentAndConclusion() {
                // Get recommended assessment based on symptoms and risk factors
                let recommendedAssessment = updateCaraPenilaian();

                // Update conclusion based on the recommended assessment
                updateConclusionBasedOnAssessment(recommendedAssessment);
            }

            // Trigger updates when checkboxes change
            $('input[type="checkbox"]').change(function() {
                updateAssessmentAndConclusion();
            });

            // Form validation
            $('#covid_form').submit(function(e) {
                let hasSymptoms = false;
                $('input[name^="gejala"]').each(function() {
                    if ($(this).is(':checked')) {
                        hasSymptoms = true;
                        return false;
                    }
                });

                let hasPersetujuanUntuk = $('input[name="persetujuan_untuk"]:checked').length > 0;
                let hasCaraPenilaian = $('input[name="cara_penilaian"]:checked').length > 0;

                if (!hasPersetujuanUntuk) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Persetujuan Untuk Siapa?',
                        text: 'Mohon pilih persetujuan untuk diri sendiri atau keluarga/wali.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                if (!hasCaraPenilaian) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Cara Penilaian Belum Dipilih!',
                        text: 'Mohon pilih cara penilaian terlebih dahulu.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                // Validate keluarga section if selected
                if ($('input[name="persetujuan_untuk"]:checked').val() === 'keluarga') {
                    let namaKeluarga = $('#nama_keluarga').val().trim();
                    let hubunganKeluarga = $('#hubungan_keluarga').val().trim();

                    if (!namaKeluarga || !hubunganKeluarga) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Data Keluarga/Wali Tidak Lengkap!',
                            text: 'Mohon lengkapi minimal nama dan hubungan keluarga/wali.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return false;
                    }
                }
            });

            // Initialize on page load
            updateAssessmentAndConclusion();
        });
    </script>
@endpush
