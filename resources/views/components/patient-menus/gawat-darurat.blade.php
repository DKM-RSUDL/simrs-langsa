@props(['pelayananUrl', 'dataMedis' => null])

@php
    $triaseProses = $dataMedis->triase_proses ?? 0;
@endphp

<div class="accordion accordion-flush" id="patientMenuAccordionIGD">
    {{-- Menu Khusus (Non-Accordion) --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/ubah-pasien" class="list-group-item list-group-item-action">
                <i class="bi bi-person-fill-gear me-2"></i> Ubah Data Pasien
            </a>
            <a href="#" class="list-group-item list-group-item-action btn-foto-triase"
                data-kasir="{{ $dataMedis?->kd_kasir ?? '' }}" data-transaksi="{{ $dataMedis?->no_transaksi ?? '' }}">
                <i class="bi bi-camera me-2"></i> Ubah Foto Triase
            </a>
        </div>
    </div>

    @if (!$triaseProses)
        {{-- Persetujuan --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#persetujuanMenuIGD">
                    <i class="bi bi-file-earmark-check me-2"></i> Persetujuan
                </button>
            </h2>
            <div id="persetujuanMenuIGD" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionIGD">
                <div class="accordion-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ $pelayananUrl }}/general-consent" class="list-group-item list-group-item-action">
                            General Consent
                        </a>
                        <a href="{{ $pelayananUrl }}/anestesi-sedasi" class="list-group-item list-group-item-action">
                            Anestesi dan Sedasi
                        </a>
                        <a href="{{ $pelayananUrl }}/persetujuan-transfusi-darah"
                            class="list-group-item list-group-item-action">
                            Persetujuan Transfusi Darah
                        </a>
                        <a href="{{ $pelayananUrl }}/covid-19" class="list-group-item list-group-item-action">
                            Covid 19
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mutasi Pasien --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mutasiMenuIGD">
                    <i class="bi bi-arrow-left-right me-2"></i> Mutasi Pasien
                </button>
            </h2>
            <div id="mutasiMenuIGD" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionIGD">
                <div class="accordion-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ $pelayananUrl }}/transfer-rwi" class="list-group-item list-group-item-action">
                            Pindah Ruangan / Rawat Inap
                        </a>
                        <a href="{{ $pelayananUrl }}/rujuk-antar-rs" class="list-group-item list-group-item-action">
                            Rujuk Keluar RS
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Transfusi Darah --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#transfusiMenuIGD">
                    <i class="bi bi-droplet me-2"></i> Transfusi Darah
                </button>
            </h2>
            <div id="transfusiMenuIGD" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionIGD">
                <div class="accordion-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ $pelayananUrl }}/permintaan-darah" class="list-group-item list-group-item-action">
                            Order
                        </a>
                        <a href="{{ $pelayananUrl }}/pengawasan-darah" class="list-group-item list-group-item-action">
                            Pengawasan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Surat-Surat --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#suratMenuIGD">
                    <i class="bi bi-envelope me-2"></i> Surat-Surat
                </button>
            </h2>
            <div id="suratMenuIGD" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionIGD">
                <div class="accordion-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ $pelayananUrl }}/surat-kematian" class="list-group-item list-group-item-action">
                            Kematian
                        </a>
                        <a href="{{ $pelayananUrl }}/paps" class="list-group-item list-group-item-action">
                            PAPS
                        </a>
                        <a href="{{ $pelayananUrl }}/penundaan" class="list-group-item list-group-item-action">
                            Penundaan Pelayanan
                        </a>
                        <a href="{{ $pelayananUrl }}/dnr" class="list-group-item list-group-item-action">
                            Penolakan Resusitasi
                        </a>
                        <a href="{{ $pelayananUrl }}/permintaan-second-opinion"
                            class="list-group-item list-group-item-action">
                            Permintaan Second Opinion
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Print --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#daftarPrintMenuIGD">
                    <i class="bi bi-printer me-2"></i> Daftar Print
                </button>
            </h2>
            <div id="daftarPrintMenuIGD" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionIGD">
                <div class="accordion-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('gawat-darurat.triase.printPDF', [$dataMedis?->kd_pasien ?? '', $dataMedis?->tgl_masuk ?? '']) }}"
                            class="list-group-item list-group-item-action">
                            Triase
                        </a>
                        <a href="#" class="list-group-item list-group-item-action btn-print-labor">
                            Laboratorium
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('js')
    <script>
        $('.btn-print-labor').click(function() {
            let $this = $(this);

            $.ajax({
                type: "post",
                url: "{{ url('unit-pelayanan/gawat-darurat/pelayanan/' . $dataMedis->kd_pasien . '/' . $dataMedis->tgl_masuk . '/cetak') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    no_transaksi: "{{ $dataMedis->no_transaksi }}"
                },
                dataType: "json",
                beforeSend: function() {
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                    $this.prop('disabled', true);
                },
                success: function(res) {
                    let status = res.status;
                    let msg = res.message;
                    let data = res.data;

                    if (status == 'error') {
                        Swal.fire({
                            title: "Error",
                            text: msg,
                            icon: "error",
                        });

                        return false;
                    }

                    window.open(data.file_url, '_blank');

                },
                complete: function() {
                    $this.html('Laboratorium');
                    $this.prop('disabled', false);
                },
                error: function() {
                    Swal.fire({
                        title: "Error",
                        text: "Internal server error !",
                        icon: "error",
                    });
                }
            });
        });
    </script>
@endpush
