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
                margin: 2rem 0;
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

            /* 7. resiko jatuh */
            .risk-form {
            display: none;
        }

        .conclusion {
            background-color: #198754;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }

        .conclusion.warning {
            background-color: #ffc107;
        }

        .conclusion.danger {
            background-color: #dc3545;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section h6 {
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        </style>
    @endpush

    @push('js')
        <script>
            $(document).ready(function() {
                $('.diagnosis-row input[type="radio"]').prop('disabled', true);
            });

            // Tindakan Keperawatan
            $('.btn-tindakan-keperawatan').click(function(e) {
                let $this = $(this);
                let target = $this.attr('data-bs-target');
                $(target).modal('show');
            });

            $('.btn-save-tindakan-keperawatan').click(function(e) {
                let $this = $(this);
                let section = $this.attr('data-section');
                let modal = $this.closest('.modal');

                let selectedTindakanArr = [];
                let selectedItem = $(modal).find('.form-check-input:checked');

                $(selectedItem).each(function(i, el) {
                    selectedTindakanArr.push($(el).attr('value'));
                });

                // Update the display
                updateSelectedTindakan(selectedTindakanArr, section);
                $(modal).modal('hide');

            })

            function updateSelectedTindakan(dataArr, tindakanListEl) {
                let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
                let listHtml = '';

                dataArr.forEach(i => {
                    listHtml += `<div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${i}</span>
                                    <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                    <input type="hidden" name="${tindakanListEl}_tindakan_keperawatan[]" value="${i}">
                                </div>`;
                });

                $(elListTindakan).html(listHtml);
            }

            $(document).on('click', '.btn-del-tindakan-keperawatan-list', function(e) {
                let $this = $(this);
                let elList = $this.closest('.selected-item');
                $(elList).remove();
            })

            // Diagnosis Keperawatan
            $('.diagnose-prwt-checkbox').change(function(e) {
                let $this = $(this);
                let hasil = $this.is(':checked');
                let diagnosisWrap = $this.closest('.diagnosis-row');

                if (hasil) {
                    $(diagnosisWrap).find('input[type="radio"]').prop('disabled', false);
                    $(diagnosisWrap).find('input[type="radio"]').prop('required', false);
                } else {
                    $(diagnosisWrap).find('input[type="radio"]').prop('disabled', true);
                    $(diagnosisWrap).find('input[type="radio"]').prop('required', false);
                }

            });

            // 7. Resiko Jantung
            // Konfigurasi form dan threshold
        const forms = {
            umum: { threshold: 1, type: 'boolean' },
            morse: { low: 0, medium: 25, high: 45, type: 'score' },
            ontario: { low: 0, medium: 4, high: 9, type: 'score' },
            humpty: { low: 0, high: 12, type: 'score' }
        };

        // Fungsi untuk menampilkan form yang dipilih
        function showForm(formType) {
            document.querySelectorAll('.risk-form').forEach(form => {
                form.style.display = 'none';
            });

            if (formType === 'lainnya') {
                alert('Silahkan hubungi petugas untuk penilaian risiko jatuh lainnya');
                document.getElementById('risikoJatuhSkala').value = ''; // Reset pilihan ke default
                return;
            }

            if (formType) {
                const selectedForm = document.getElementById(formType + 'Form');
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                    resetForm(selectedForm);
                }
            }
        }

        // Reset form saat berganti
        function resetForm(form) {
            form.querySelectorAll('select').forEach(select => select.value = '');
            const formType = form.id.replace('skala_', '').replace('Form', '');
            const conclusionDiv = form.querySelector('.conclusion');

            // Reset kesimpulan ke default
            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion bg-success';
                conclusionDiv.querySelector('p').textContent = 'Kesimpulan : ' +
                    (formType === 'umum' ? 'Tidak berisiko jatuh' : 'Risiko Rendah');
            }
        }

        // Update kesimpulan berdasarkan pilihan
        function updateConclusion(formType) {
            const form = document.getElementById('skala_' + formType + 'Form');
            const selects = form.querySelectorAll('select');
            let score = 0;
            let hasYes = false;

            // Hitung skor
            selects.forEach(select => {
                if (select.value === 'ya') {
                    hasYes = true;
                }
                score += parseInt(select.value) || 0;
            });

            // Dapatkan div kesimpulan dari form yang aktif
            const conclusionDiv = form.querySelector('.conclusion');
            let conclusion = '';
            let bgClass = '';

            // Tentukan kesimpulan berdasarkan tipe form
            switch (formType) {
                case 'umum':
                    if (hasYes) {
                        conclusion = 'Berisiko jatuh';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Tidak berisiko jatuh';
                        bgClass = 'bg-success';
                    }
                    break;

                case 'morse':
                    if (score >= 45) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else if (score >= 25) {
                        conclusion = 'Risiko Sedang';
                        bgClass = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ' (Skor: ' + score + ')';
                    break;

                case 'humpty':
                    if (score >= 12) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    break;

                case 'ontario':
                    if (score >= 9) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else if (score >= 4) {
                        conclusion = 'Risiko Sedang';
                        bgClass = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    break;
            }

            // Update tampilan kesimpulan
            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion ' + bgClass;
                conclusionDiv.querySelector('p').textContent = 'Kesimpulan : ' + conclusion;
            }
        }
        </script>
    @endpush
