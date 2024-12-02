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
        </style>
    @endpush

    @push('js')
        <script>
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
        </script>
    @endpush
