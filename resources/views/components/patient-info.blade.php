@props([
    'dataMedis' => null,
    'photo' => asset('assets/img/profile.jpg'),
    'showMenu' => true,
])

<div {{ $attributes->merge(['class' => 'card h-auto sticky-top', 'style' => 'top:1rem; z-index: 99;']) }}>
    <div class="card-body">
        <div class="position-absolute top-0 end-0 p-3 d-flex flex-column align-items-center gap-1">
            <span class="d-block rounded-circle bg-danger" style="width:8px;height:8px;"></span>
            <span class="d-block rounded-circle bg-warning" style="width:8px;height:8px;"></span>
            <span class="d-block rounded-circle bg-success" style="width:8px;height:8px;"></span>
        </div>

        <div class="row g-3">
            {{-- Foto pasien --}}
            <div class="col-5">
                <img src="{{ $photo }}" alt="Patient Photo" class="object-fit-cover rounded w-100 h-100">
            </div>

            {{-- Info pasien --}}
            <div class="col-7 col-md-12 d-flex flex-column justify-content-center">
                <h6 class="h6 mb-1 fw-semibold">
                    {{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}
                </h6>

                <p class="mb-1">
                    @if ($dataMedis?->pasien?->jenis_kelamin == 1)
                        Laki-laki
                    @elseif ($dataMedis?->pasien?->jenis_kelamin == 0)
                        Perempuan
                    @else
                        Tidak Diketahui
                    @endif
                </p>

                <div class="small text-body-secondary mb-2">
                    {{ !empty($dataMedis->pasien->tgl_lahir) ? hitungUmur($dataMedis->pasien->tgl_lahir) : 'Tidak Diketahui' }}
                    Thn
                    (
                    {{ $dataMedis->pasien->tgl_lahir
                        ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y')
                        : 'Tidak Diketahui' }}
                    )
                </div>

                <div class="d-flex flex-column gap-1">
                    <div class="fw-semibold">
                        RM: {{ $dataMedis->pasien->kd_pasien ?? '-' }}
                    </div>

                    <div class="d-inline-flex align-items-center gap-2">
                        <i class="bi bi-calendar3"></i>
                        <span>
                            {{ $dataMedis->tgl_masuk ? \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="d-inline-flex align-items-start gap-2">
                        <i class="bi bi-hospital"></i>
                        <span>
                            {{ $dataMedis->unit->bagian->bagian ?? '-' }}
                            @php
                                $isRanap = $dataMedis?->unit?->kd_bagian == 1;
                                $namaUnit = null;

                                if ($isRanap) {
                                    $nginap = \App\Models\Nginap::join(
                                        'unit as u',
                                        'nginap.kd_unit_kamar',
                                        '=',
                                        'u.kd_unit',
                                    )
                                        ->where('nginap.kd_pasien', $dataMedis->kd_pasien ?? null)
                                        ->where('nginap.kd_unit', $dataMedis->kd_unit ?? null)
                                        ->where('nginap.tgl_masuk', $dataMedis->tgl_masuk ?? null)
                                        ->where('nginap.urut_masuk', $dataMedis->urut_masuk ?? null)
                                        ->where('nginap.akhir', 1)
                                        ->first();

                                    $namaUnit = $nginap->nama_unit ?? null;
                                } else {
                                    $namaUnit = $dataMedis->unit->nama_unit ?? null;
                                }
                            @endphp
                            ({{ $namaUnit ?? '-' }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Footer - Tombol Menu & Offcanvas --}}
    @if ($showMenu && $dataMedis)
        @php
            // Deteksi kode bagian dari unit
            $kdBagian = $dataMedis->unit->kd_bagian ?? null;

            // Generate base URL untuk pelayanan berdasarkan kd_bagian
            $baseSegment = '';

            switch ($kdBagian) {
                case 1: // Rawat Inap - PAKAI /unit/
                    $baseSegment = 'rawat-inap/unit/' . $dataMedis->kd_unit;
                    break;
                case 2: // Rawat Jalan - PAKAI /unit/
                    $baseSegment = 'rawat-jalan/unit/' . $dataMedis->kd_unit;
                    break;
                case 3: // Rawat Darurat (IGD) - TIDAK PAKAI /unit/
                    $baseSegment = 'gawat-darurat';
                    break;
                case 8: // Bedah Sentral (Operasi) - TIDAK PAKAI /unit/
                    $baseSegment = 'operasi';
                    break;
                case 72: // Hemodialisa - TIDAK PAKAI /unit/
                    $baseSegment = 'hemodialisa';
                    break;
                case 74: // Rehab Medik - TIDAK PAKAI /unit/
                    $baseSegment = 'rehab-medis';
                    break;
                default:
                    $baseSegment = null;
            }

            $pelayananUrl = $baseSegment
                ? url(
                    'unit-pelayanan/' .
                        $baseSegment .
                        '/pelayanan/' .
                        $dataMedis->kd_pasien .
                        '/' .
                        $dataMedis->tgl_masuk .
                        '/' .
                        $dataMedis->urut_masuk,
                )
                : null;
        @endphp

        @if ($pelayananUrl)
            <hr class="m-0">
            <div class="p-3">
                <button class="btn btn-primary w-100" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#patientMenuOffcanvas">
                    <i class="bi bi-list-ul me-2"></i> Menu lainnya
                </button>
            </div>

            {{-- Offcanvas untuk Menu - PINDAH KE DALAM SCOPE --}}
            <div class="offcanvas offcanvas-end" style="width: 280px; z-index: 99999;" tabindex="-1"
                id="patientMenuOffcanvas" aria-labelledby="patientMenuOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="patientMenuOffcanvasLabel">
                        <i class="bi bi-list-ul me-2"></i> Menu Pelayanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    {{-- Load menu component berdasarkan kd_bagian --}}
                    @switch($kdBagian)
                        @case(1)
                            {{-- Rawat Inap --}}
                            <x-patient-menus.rawat-inap :pelayananUrl="$pelayananUrl" />
                        @break

                        @case(2)
                            {{-- Rawat Jalan --}}
                            <x-patient-menus.rawat-jalan :pelayananUrl="$pelayananUrl" />
                        @break

                        @case(3)
                            {{-- Gawat Darurat --}}
                            <x-patient-menus.gawat-darurat :pelayananUrl="$pelayananUrl" />
                        @break

                        @case(8)
                            {{-- Bedah Sentral / Operasi --}}
                            <x-patient-menus.operasi :pelayananUrl="$pelayananUrl" />
                        @break

                        @case(72)
                            {{-- Hemodialisa --}}
                            <x-patient-menus.hemodialisa :pelayananUrl="$pelayananUrl" />
                        @break

                        @case(74)
                            {{-- Rehab Medik --}}
                            <x-patient-menus.rehab-medik :pelayananUrl="$pelayananUrl" />
                        @break

                        @default
                            <div class="alert alert-warning m-3">
                                Menu tidak tersedia untuk unit ini.
                            </div>
                    @endswitch
                </div>
            </div>
        @endif
    @endif
</div>
