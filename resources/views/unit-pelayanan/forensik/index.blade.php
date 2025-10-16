@extends('layouts.administrator.master')

@section('content')
    <x-content-card>
        <div class="content-wrapper">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Ruang/Klinik</h5>
                    <p class="text-muted mb-0">Pilih ruang/klinik pelayanan pasien</p>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" id="searchUnit" placeholder="Cari ruang/klinik..."
                            autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="row" id="unitContainer">
                <div class="col-md-2 p-2 unit-card" data-unit-name="{{ strtolower('Klinik') }}">
                    <a href="{{ route('forensik.unit', 228) }}" class="text-decoration-none card-hover">
                        <div class="card mb-3 rounded-2 bg-white dark:bg-dark text-dark dark:text-light">
                            <div class="card-body text-center d-flex flex-column">
                                <h6 class="fw-bold text-primary mb-2">Klinik</h6>
                                <div class="mt-auto">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('assets/img/Account.png') }}" alt="" width="20"
                                            class="me-2">
                                        <small class="text-muted">Pasien: <span
                                                class="fw-bold text-dark">{{ countUnfinishedPatientRajal(228) }}</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 p-2 unit-card" data-unit-name="{{ strtolower('Patologi') }}">
                    <a href="{{ route('forensik.unit', 76) }}" class="text-decoration-none card-hover">
                        <div class="card mb-3 rounded-2 bg-white dark:bg-dark text-dark dark:text-light">
                            <div class="card-body text-center d-flex flex-column">
                                <h6 class="fw-bold text-primary mb-2">Patologi</h6>
                                <div class="mt-auto">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('assets/img/Account.png') }}" alt="" width="20"
                                            class="me-2">
                                        <small class="text-muted">Pasien: <span
                                                class="fw-bold text-dark">{{ countUnfinishedPatientWithTglKeluar(76) }}</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            <!-- No Results Message -->
            <div id="noResults" class="text-center py-5" style="display: none;">
                <div class="text-muted">
                    <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                    <h6>Tidak ada ruang/klinik yang ditemukan</h6>
                    <p class="small">Coba gunakan kata kunci yang berbeda</p>
                </div>
            </div>
        </div>
    </x-content-card>
@endsection

@push('styles')
    <style>
        #searchUnit {
            border-radius: 0 10px 10px 0;
            box-shadow: none;
        }

        #searchUnit:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }

        .fade-out {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 180ms, transform 180ms;
        }

        .fade-in {
            opacity: 1;
            transform: scale(1);
            transition: opacity 180ms, transform 180ms;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#searchUnit').on('input', function() {
                const searchTerm = $(this).val().toLowerCase().trim();
                const unitCards = $('.unit-card');
                let visibleCards = 0;

                if (searchTerm === '') {
                    unitCards.removeClass('fade-out').addClass('fade-in').show();
                    $('#noResults').hide();
                    return;
                }

                unitCards.each(function() {
                    const unitName = ($(this).data('unit-name') || '').toString();
                    const $card = $(this);

                    if (unitName.includes(searchTerm)) {
                        $card.removeClass('fade-out').addClass('fade-in').show();
                        visibleCards++;
                    } else {
                        $card.removeClass('fade-in').addClass('fade-out');
                        setTimeout(() => {
                            if ($card.hasClass('fade-out')) {
                                $card.hide();
                            }
                        }, 200);
                    }
                });

                setTimeout(() => {
                    if (visibleCards === 0) {
                        $('#noResults').fadeIn();
                    } else {
                        $('#noResults').hide();
                    }
                }, 250);
            });

            $('#searchUnit').on('keydown', function(e) {
                if (e.key === 'Escape') {
                    $(this).val('').trigger('input');
                }
            });

            $(document).on('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'f') {
                    e.preventDefault();
                    $('#searchUnit').focus();
                }
            });
        });
    </script>
@endpush
