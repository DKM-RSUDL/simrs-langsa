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

    {{-- Order / Mutasi Pasien --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#orderMenu">
                <i class="bi bi-arrow-left-right me-2"></i> Order / Mutasi Pasien
            </button>
        </h2>
        <div id="orderMenu" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordion">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/transfer-pasien-antar-ruang"
                        class="list-group-item list-group-item-action">
                        Pindah Ruangan Rawat Inap
                    </a>
                    <a href="{{ $pelayananUrl }}/order-hd" class="list-group-item list-group-item-action">
                        Hemodialisa (HD)
                    </a>
                    <a href="{{ $pelayananUrl }}/operasi-ibs" class="list-group-item list-group-item-action">
                        Operasi (IBS)
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
            <a href="{{ $pelayananUrl }}/asuhan-keperawatan" class="list-group-item list-group-item-action">
                <i class="bi bi-heart-pulse me-2"></i> Asuhan Keperawatan
            </a>
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
                                // Build show route if possible; expect routes named 'rawat-inap.operasi-ibs.show'
                                $showUrl = isset($dataMedis)
                                    ? route('rawat-inap.operasi.show', [
                                        $dataMedis->kd_unit,
                                        $dataMedis->kd_pasien,
                                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                        $dataMedis->urut_masuk,
                                        date('Y-m-d', strtotime($op->tgl_op)),
                                        date('H:i:s', strtotime($op->jam_op))
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
</div>
