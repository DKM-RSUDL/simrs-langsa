@props([
    'dataMedis' => null,
    'photo' => asset('assets/img/profile.jpg'),
    'showMenu' => true,
])

<div {{ $attributes->merge(['class' => 'card h-auto sticky-top', 'style' => 'top:1rem; z-index: 0;']) }}>
    <span class="bagian-info w-min rounded-t-none badge bg-primary shadow-sm">
        {{ $dataMedis->unit->bagian->bagian ?? '-' }}</span>
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
                    ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})
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

                    {{-- BAGIAN UNIT & RUANGAN (YANG DIUBAH) --}}
                    @php
                        $isRanap = $dataMedis?->unit?->kd_bagian == 1;
                        $namaUnit = null;
                        $unitUrl = null;

                        if ($isRanap) {
                            $nginap = \App\Models\Nginap::join('unit as u', 'nginap.kd_unit_kamar', '=', 'u.kd_unit')
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

                        $kdBagian = $dataMedis->unit->kd_bagian ?? null;
                        switch ($kdBagian) {
                            case 1:
                                $unitUrl = url('unit-pelayanan/rawat-inap/unit/' . $dataMedis->kd_unit);
                                break;
                            case 2:
                                $unitUrl = url('unit-pelayanan/rawat-jalan/unit/' . $dataMedis->kd_unit);
                                break;
                            case 3:
                                $unitUrl = url('unit-pelayanan/gawat-darurat');
                                break;
                            case 72:
                                $unitUrl = url('unit-pelayanan/hemodialisa');
                                break;
                            case 74:
                                $unitUrl = url('unit-pelayanan/rehab-medis');
                                break;
                            case 71:
                                $unitUrl = url('unit-pelayanan/operasi');
                                break;
                        }
                    @endphp

                    {{-- Unit Info Card --}}
                    <div class="unit-info-box mt-2 position-relative">
                        @if ($namaUnit && $unitUrl)
                            <a href="{{ $unitUrl }}" class="d-inline-flex align-items-start text-decoration-none gap-2"
                                title="Lihat {{ $namaUnit }}">
                                <i class="bi bi-hospital"></i>
                                <span>{{ $namaUnit }}</span>
                            </a>
                        @elseif ($namaUnit)
                            <a href="{{ $unitUrl }}" class="d-inline-flex align-items-start text-decoration-none gap-2"
                                title="Lihat {{ $namaUnit }}">
                                <i class="bi bi-hospital"></i>
                                <span>{{ $namaUnit }}</span>
                            </a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- CHECK BUTTON I-CARE --}}
        @if (in_array($dataMedis->unit->kd_bagian ?? null, [2, 3]))
            <div class="pt-3">
                <button class="btn btn-warning w-100" id="btnIcare" type="button">
                    <i class="bi bi-info-circle me-2"></i> I-Care
                </button>
            </div>
        @endif
    </div>

    {{-- Card Footer - Tombol Menu & Offcanvas --}}
    @if ($showMenu && $dataMedis)
        @php
            $kdBagian = $dataMedis->unit->kd_bagian ?? null;
            $baseSegment = '';

            switch ($kdBagian) {
                case 1:
                    $baseSegment = 'rawat-inap/unit/' . $dataMedis->kd_unit;
                    break;
                case 2:
                    $baseSegment = 'rawat-jalan/unit/' . $dataMedis->kd_unit;
                    break;
                case 3:
                    $baseSegment = 'gawat-darurat';
                    break;
                case 72:
                    $baseSegment = 'hemodialisa';
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
        @endif
    @endif
</div>

{{-- Offcanvas untuk Menu --}}
<div class="offcanvas offcanvas-end" style="width: 280px; z-index: 99999;" tabindex="-1" id="patientMenuOffcanvas"
    aria-labelledby="patientMenuOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title font-semibold" id="patientMenuOffcanvasLabel">
            <i class="bi bi-list-ul me-2"></i> Menu Pelayanan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        @switch($kdBagian)
            @case(1)
                <x-patient-menus.rawat-inap :pelayananUrl="$pelayananUrl" :dataMedis="$dataMedis" />
            @break

            @case(2)
                <x-patient-menus.rawat-jalan :pelayananUrl="$pelayananUrl" :dataMedis="$dataMedis" />
            @break

            @case(3)
                <x-patient-menus.gawat-darurat :pelayananUrl="$pelayananUrl" :dataMedis="$dataMedis" />
            @break

            @case(72)
                <x-patient-menus.hemodialisa :pelayananUrl="$pelayananUrl" />
            @break

            @default
                <div class="alert alert-warning m-3">
                    Menu tidak tersedia untuk unit ini (kd_bagian: {{ $kdBagian }}).
                </div>
        @endswitch
    </div>
</div>

{{-- Modal Foto Triase (tetap sama) --}}
<div class="modal fade" id="fotoTriaseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="fotoTriaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="fotoTriaseModalLabel">Foto Triase Pasien</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-body">
                    <input type="hidden" name="triase_id" id="triase_id">
                    <div class="form-group mb-3">
                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="nama_pasien_triase" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <img src="{{ asset('assets/images/avatar1.png') }}" alt="Foto Triase" class="img-fluid"
                            style="max-height: 200px;">
                    </div>
                    <div class="form-group mt-3">
                        <label for="foto_pasien" class="form-label">Foto Pasien</label>
                        <input type="file" name="foto_pasien" class="form-control" id="foto_pasien">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
    <style>
        .bagian-info {
            border-top-right-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-foto-triase', function(e) {
                e.preventDefault();
                let $this = $(this);
                let kdKasir = $this.data('kasir');
                let noTrx = $this.data('transaksi');

                if (!kdKasir || !noTrx || kdKasir === '' || noTrx === '') {
                    Swal.fire({
                        title: 'Perhatian!',
                        html: 'Data kasir atau transaksi tidak tersedia.<br>Silakan refresh halaman atau hubungi administrator.',
                        icon: 'warning'
                    });
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('gawat-darurat.get-triase-data') }}",
                    data: {
                        "kd_kasir": kdKasir,
                        "no_transaksi": noTrx,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memuat...',
                            text: 'Sedang mengambil data triase',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function(res) {
                        Swal.close();
                        if (res.status === 'success' && res.data) {
                            let data = res.data;
                            let kunjungan = data.kunjungan;
                            let triase = data.triase;

                            $('#fotoTriaseModal #nama_pasien_triase').val(kunjungan.pasien
                                .nama);
                            $('#fotoTriaseModal #triase_id').val(kunjungan.triase_id);

                            let action =
                                "{{ route('gawat-darurat.ubah-foto-triase', [':kdKasir', ':noTrx']) }}"
                                .replace(':kdKasir', kunjungan.kd_kasir)
                                .replace(':noTrx', kunjungan.no_transaksi);
                            $('#fotoTriaseModal form').attr('action', action);

                            let img = "{{ asset('assets/images/avatar1.png') }}";
                            if (triase && triase.foto_pasien) {
                                img = "{{ asset('storage/') }}/" + triase.foto_pasien;
                            }
                            $('#fotoTriaseModal img').attr('src', img);
                            $('#fotoTriaseModal').modal('show');
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Format data tidak valid',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan pada server';
                        if (xhr.responseJSON && xhr.responseJSON.message) errorMsg = xhr
                            .responseJSON.message;
                        else if (xhr.status === 404) errorMsg = 'Data triase tidak ditemukan';
                        else if (xhr.status === 500) errorMsg = 'Internal Server Error';
                        Swal.fire({
                            title: 'Error!',
                            text: errorMsg,
                            icon: 'error'
                        });
                    }
                });
            });

            $('#btnIcare').click(function() {
                let $this = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('bpjs.icare') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'kd_unit': "{{ $dataMedis->kd_unit }}",
                        'kd_pasien': "{{ $dataMedis->kd_pasien }}",
                        'tgl_masuk': "{{ date('Y-m-d', strtotime($dataMedis->tgl_masuk)) }}",
                        'urut_masuk': "{{ $dataMedis->urut_masuk }}",
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $this.prop('disabled', true).text('Memproses');
                    },
                    success: function(res) {
                        if (res.status == 'error') {
                            showToast('error', res.message);
                            return false;
                        }
                        window.open(res.data, "_blank");
                    },
                    error: function() {
                        $this.prop('disabled', true).html(
                            '<i class="bi bi-info-circle me-2"></i> I-Care');
                    },
                    complete: function() {
                        $this.prop('disabled', false).html(
                            '<i class="bi bi-info-circle me-2"></i> I-Care');
                    }
                });
            });
        });
    </script>
@endpush
