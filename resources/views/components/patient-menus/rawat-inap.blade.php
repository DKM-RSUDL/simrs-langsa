@props(['pelayananUrl', 'dataMedis' => null])

<div class="accordion accordion-flush" id="patientMenuAccordion">
    {{-- Persetujuan --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#persetujuanMenu">
                <i class="bi bi-file-earmark-check me-2"></i> Persetujuan
            </button>
        </h2>
        <div id="persetujuanMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/informed-consent" class="list-group-item list-group-item-action">
                        Informed Concent
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

    {{-- Order Penunjang --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#orderMenu">
                <i class="bi bi-arrow-left-right me-2"></i> Order Penunjang
            </button>
        </h2>
        <div id="orderMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/order-hd" class="list-group-item list-group-item-action">
                        Hemodialisa (HD)
                    </a>
                    <a href="{{ $pelayananUrl }}/operasi-ibs" class="list-group-item list-group-item-action">
                        Operasi (IBS)
                    </a>
                    <a href="{{ $pelayananUrl }}/order-rehab" class="list-group-item list-group-item-action">
                        Rehab Medik
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Mutasi/Transfer Pasien --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#mutasiMenu">
                <i class="bi bi-arrow-left-right me-2"></i> Transfer/Mutasi Pasien
            </button>
        </h2>
        <div id="mutasiMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/transfer-pasien-antar-ruang"
                        class="list-group-item list-group-item-action">
                        Pindah Ruangan
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Surat-Surat --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#suratMenu">
                <i class="bi bi-envelope me-2"></i> Surat-Surat
            </button>
        </h2>
        <div id="suratMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/surat-kematian" class="list-group-item list-group-item-action">
                        Surat Kematian
                    </a>
                    <a href="{{ $pelayananUrl }}/pernyataan-dpjp" class="list-group-item list-group-item-action">
                        Pernyataan DPJP
                    </a>
                    <a href="{{ $pelayananUrl }}/paps" class="list-group-item list-group-item-action">
                        PAPS
                    </a>
                    <a href="{{ $pelayananUrl }}/meninggalkan-perawatan"
                        class="list-group-item list-group-item-action">
                        Meninggalkan Perawatan
                    </a>
                    <a href="{{ $pelayananUrl }}/rohani" class="list-group-item list-group-item-action">
                        Pelayanan Rohani
                    </a>
                    <a href="{{ $pelayananUrl }}/privasi" class="list-group-item list-group-item-action">
                        Permintaan Privasi
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
                    <a href="{{ $pelayananUrl }}/pengawasan-transportasi"
                        class="list-group-item list-group-item-action">
                        Pengawasan Transportasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Transfusi Darah --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#transfusiMenu">
                <i class="bi bi-droplet me-2"></i> Transfusi Darah
            </button>
        </h2>
        <div id="transfusiMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
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

    {{-- Menu Direct (tanpa submenu) --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/orientasi-pasien-baru" class="list-group-item list-group-item-action">
                <i class="bi bi-info-circle me-2"></i> Orientasi Pasien Baru
            </a>
        </div>
    </div>

    {{-- Daftar Operasi --}}
    @php
        // Safe: hanya query jika $dataMedis ada di scope
        $operasiCount = 0;
        $operasis = collect();

        if (isset($dataMedis)) {
            try {
                $cacheKey =
                    'operasi:list:' .
                    ($dataMedis->kd_kasir ?? 'none') .
                    ':' .
                    ($dataMedis->no_transaksi ?? 'none') .
                    ':' .
                    date('Y-m-d');

                $operasis = \Illuminate\Support\Facades\Cache::remember($cacheKey, 60, function () use ($dataMedis) {
                    return \App\Models\OrderOK::where('kd_kasir', $dataMedis->kd_kasir)
                        ->where('no_transaksi', $dataMedis->no_transaksi)
                        ->where('status', 1)
                        ->orderBy('tgl_op')
                        ->orderBy('jam_op')
                        ->get(['tgl_op', 'jam_op']);
                });

                $operasiCount = $operasis->count();
            } catch (\Exception $e) {
                // jika query gagal, tetap jangan break tampilan menu
                $operasiCount = 0;
                $operasis = collect();
            }
        }
    @endphp

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#daftarOperasiMenu">
                <i class="bi bi-droplet me-2"></i> Daftar Operasi
                <span class="badge bg-primary rounded-pill ms-2">{{ $operasiCount }}</span>
            </button>
        </h2>
        <div id="daftarOperasiMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    @if ($operasiCount > 0)
                        @foreach ($operasis as $idx => $op)
                            @php
                                $number = $idx + 1;
                                $showUrl = isset($dataMedis)
                                    ? route('rawat-inap.operasi.show', [
                                        $dataMedis->kd_unit,
                                        $dataMedis->kd_pasien,
                                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                        $dataMedis->urut_masuk,
                                        date('Y-m-d', strtotime($op->tgl_op)),
                                        date('H:i:s', strtotime($op->jam_op)),
                                    ])
                                    : '#';
                            @endphp
                            <a href="{{ $showUrl }}" class="list-group-item list-group-item-action">Operasi
                                {{ $number }}</a>
                        @endforeach
                    @else
                        <div class="list-group-item">Tidak ada data operasi.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Print --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#daftarPrintMenuRanap">
                <i class="bi bi-printer me-2"></i> Daftar Print
            </button>
        </h2>
        <div id="daftarPrintMenuRanap" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    @if (isset($dataMedis) && $dataMedis)
                        <a href="#" class="list-group-item list-group-item-action btn-print-all-labor"
                            data-pasien="{{ $dataMedis->kd_pasien ?? '' }}"
                            data-tglmasuk="{{ $dataMedis->tgl_masuk ?? '' }}"
                            data-unit="{{ $dataMedis->kd_unit ?? '' }}"
                            data-urut="{{ $dataMedis->urut_masuk ?? '' }}">
                            Laboratorium
                        </a>
                        <a href="{{ route('rawat-inap.radiologi.print-all', [$dataMedis?->kd_unit ?? '', $dataMedis?->kd_pasien ?? '', isset($dataMedis->tgl_masuk) ? date('Y-m-d', strtotime($dataMedis->tgl_masuk)) : '', $dataMedis?->urut_masuk ?? '']) }}"
                            target="_blank" class="list-group-item list-group-item-action btn-print-all-radiologi"
                            data-pasien="{{ $dataMedis->kd_pasien ?? '' }}"
                            data-tglmasuk="{{ $dataMedis->tgl_masuk ?? '' }}"
                            data-unit="{{ $dataMedis->kd_unit ?? '' }}"
                            data-urut="{{ $dataMedis->urut_masuk ?? '' }}">
                            Radiologi
                        </a>
                        <a href="{{ route('rawat-inap.tindakan.print-pdf', [$dataMedis?->kd_unit ?? '', $dataMedis?->kd_pasien ?? '', $dataMedis?->tgl_masuk ?? '', $dataMedis?->urut_masuk ?? '']) }}"
                            target="_blank" class="list-group-item list-group-item-action">
                            Tindakan
                        </a>
                        <a href="{{ route('rawat-inap.cppt.print-pdf', [
                            'kd_unit' => $dataMedis?->kd_unit ?? '',
                            'kd_pasien' => $dataMedis?->kd_pasien ?? '',
                            'tgl_masuk' => $dataMedis?->tgl_masuk ?? '',
                            'urut_masuk' => $dataMedis?->urut_masuk ?? '',
                        ]) }}"
                            target="_blank" class="list-group-item list-group-item-action">
                            CPPT
                        </a>
                        @if (isset($dataMedis) && $dataMedis)
                            <a href="{{ route('rawat-inap.triase.print-pdf', [
                                'kd_unit' => $dataMedis?->kd_unit ?? '',
                                'kd_pasien' => $dataMedis?->kd_pasien ?? '',
                                'tgl_masuk' => $dataMedis?->tgl_masuk ?? '',
                                'urut_masuk' => $dataMedis?->urut_masuk ?? '',
                            ]) }}"
                                target="_blank" class="list-group-item list-group-item-action">
                                Triase
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Print Single Labor (dari modal)
        $(document).on('click', '.btn-print-labor', function() {
            let $this = $(this);
            let kasir = $this.data('kasir');
            let transaksi = $this.data('transaksi');
            let pasien = $this.data('pasien');
            let tglmasuk = $this.data('tglmasuk');

            if (!kasir || !transaksi || !pasien || !tglmasuk) {
                Swal.fire({
                    title: "Error",
                    text: "Data pasien tidak lengkap!",
                    icon: "error",
                });
                return false;
            }

            $.ajax({
                type: "post",
                url: `/unit-pelayanan/rawat-inap/pelayanan/${pasien}/${tglmasuk}/cetak`,
                data: {
                    _token: "{{ csrf_token() }}",
                    no_transaksi: transaksi
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

        // Print All Labor (dari menu)
        $(document).on('click', '.btn-print-all-labor', function(e) {
            e.preventDefault();
            let $this = $(this);
            let pasien = $this.data('pasien');
            let tglmasuk = $this.data('tglmasuk');
            let unit = $this.data('unit');
            let urut = $this.data('urut');

            if (!pasien || !tglmasuk || !unit || !urut) {
                Swal.fire({
                    title: "Error",
                    text: "Data pasien tidak lengkap!",
                    icon: "error",
                });
                return false;
            }

            let originalText = $this.html();

            // Format tgl_masuk menjadi Y-m-d jika masih dalam format datetime
            let tglFormatted = tglmasuk.split(' ')[0];

            $.ajax({
                type: "post",
                url: `/unit-pelayanan/rawat-inap/unit/${unit}/pelayanan/${pasien}/${tglFormatted}/${urut}/lab-patologi-klinik/print-all`,
                data: {
                    _token: "{{ csrf_token() }}"
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

                    // Buka semua file laboratorium di tab baru
                    if (data.files && data.files.length > 0) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: `Membuka ${data.count} hasil laboratorium...`,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Buka setiap file dengan delay agar tidak di-block browser
                        data.files.forEach((file, index) => {
                            setTimeout(() => {
                                window.open(file.file_url, '_blank');
                            }, index * 300); // delay 300ms antar file
                        });
                    }
                },
                complete: function() {
                    $this.html(originalText);
                    $this.prop('disabled', false);
                },
                error: function(xhr) {
                    let errorMsg = "Internal server error!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: "Error",
                        text: errorMsg,
                        icon: "error",
                    });
                }
            });
        });

        // Print All Radiologi (dari menu)
        $(document).on('click', '.btn-print-all-radiologi', function(e) {
            e.preventDefault();
            let $this = $(this);
            let pasien = $this.data('pasien');
            let tglmasuk = $this.data('tglmasuk');
            let unit = $this.data('unit');
            let urut = $this.data('urut');

            if (!pasien || !tglmasuk || !unit || !urut) {
                Swal.fire({
                    title: "Error",
                    text: "Data pasien tidak lengkap!",
                    icon: "error",
                });
                return false;
            }

            let originalText = $this.html();

            // Format tgl_masuk menjadi Y-m-d jika masih dalam format datetime
            let tglFormatted = tglmasuk.split(' ')[0];

            $.ajax({
                type: "get",
                url: `/unit-pelayanan/rawat-inap/unit/${unit}/pelayanan/${pasien}/${tglFormatted}/${urut}/radiologi/print-all`,
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

                    if (data.files && data.files.length > 0) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: `Membuka ${data.count} hasil radiologi...`,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        data.files.forEach((file, index) => {
                            setTimeout(() => {
                                window.open(file.file_url, '_blank');
                            }, index * 300);
                        });
                    }
                },
                complete: function() {
                    $this.html(originalText);
                    $this.prop('disabled', false);
                },
                error: function(xhr) {
                    let errorMsg = "Internal server error!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: "Error",
                        text: errorMsg,
                        icon: "error",
                    });
                }
            });
        });
    </script>
@endpush
