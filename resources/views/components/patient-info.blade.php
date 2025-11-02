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

        {{-- CHECK BUTTON I-CARE --}}

        @if (in_array(($dataMedis->unit->kd_bagian ?? null), [2,3]))
            <div class="px-3 pt-3">
                {{-- <form action="{{ route('rawat-jalan.pelayanan.icare', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="get"> --}}
                <button class="btn btn-warning w-100" id="btnIcare" type="button">
                    <i class="bi bi-info-circle me-2"></i> I-Care
                </button>
                {{-- </form> --}}
            </div>
        @endif
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
                case 72: // Hemodialisa - TIDAK PAKAI /unit/
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
        {{-- Load menu component berdasarkan kd_bagian --}}
        @switch($kdBagian)
            @case(1)
                {{-- Rawat Inap --}}
                <x-patient-menus.rawat-inap :pelayananUrl="$pelayananUrl" :dataMedis="$dataMedis" />
            @break

            @case(2)
                {{-- Rawat Jalan --}}
                <x-patient-menus.rawat-jalan :pelayananUrl="$pelayananUrl" />
            @break

            @case(3)
                {{-- Gawat Darurat --}}
                <x-patient-menus.gawat-darurat :pelayananUrl="$pelayananUrl" :dataMedis="$dataMedis" />
            @break

            @case(72)
                {{-- Hemodialisa --}}
                <x-patient-menus.hemodialisa :pelayananUrl="$pelayananUrl" />
            @break

            @default
                <div class="alert alert-warning m-3">
                    Menu tidak tersedia untuk unit ini (kd_bagian: {{ $kdBagian }}).
                </div>
        @endswitch
    </div>
</div>

{{-- Modal Foto Triase --}}
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

@push('js')
    <script>
        $(document).ready(function() {
            // Handler untuk tombol foto triase
            $(document).on('click', '.btn-foto-triase', function(e) {
                e.preventDefault();

                let $this = $(this);
                let kdKasir = $this.data('kasir');
                let noTrx = $this.data('transaksi');

                // Validasi data tersedia
                if (!kdKasir || !noTrx || kdKasir === '' || noTrx === '') {
                    Swal.fire({
                        title: 'Perhatian!',
                        html: 'Data kasir atau transaksi tidak tersedia.<br>Silakan refresh halaman atau hubungi administrator.',
                        icon: 'warning'
                    });
                    console.error('Data tidak lengkap:', {
                        kdKasir,
                        noTrx
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
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(res) {
                        Swal.close();

                        if (res.status === 'success' && res.data) {
                            let data = res.data;
                            let kunjungan = data.kunjungan;
                            let triase = data.triase;

                            // Set nama pasien
                            $('#fotoTriaseModal #nama_pasien_triase').val(kunjungan.pasien
                                .nama);
                            $('#fotoTriaseModal #triase_id').val(kunjungan.triase_id);

                            // Set action form
                            let action =
                                "{{ route('gawat-darurat.ubah-foto-triase', [':kdKasir', ':noTrx']) }}"
                                .replace(':kdKasir', kunjungan.kd_kasir)
                                .replace(':noTrx', kunjungan.no_transaksi);

                            $('#fotoTriaseModal form').attr('action', action);

                            // Set foto pasien
                            let img = "{{ asset('assets/images/avatar1.png') }}";
                            if (triase && triase.foto_pasien) {
                                img = "{{ asset('storage/') }}/" + triase.foto_pasien;
                            }

                            $('#fotoTriaseModal img').attr('src', img);

                            // Tampilkan modal
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

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.status === 404) {
                            errorMsg = 'Data triase tidak ditemukan';
                        } else if (xhr.status === 500) {
                            errorMsg = 'Internal Server Error';
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMsg,
                            icon: 'error'
                        });
                    }
                });
            });
        });

        $('#btnIcare').click(function() {
            let $this = $(this);
            let kd_unit = "{{ $dataMedis->kd_unit }}";
            let kd_pasien = "{{ $dataMedis->kd_pasien }}";
            let tgl_masuk = "{{ date('Y-m-d', strtotime($dataMedis->tgl_masuk)) }}";
            let urut_masuk = "{{ $dataMedis->urut_masuk }}";

            $.ajax({
                type: "POST",
                url: "{{ route('bpjs.icare') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'kd_unit': kd_unit,
                    'kd_pasien': kd_pasien,
                    'tgl_masuk': tgl_masuk,
                    'urut_masuk': urut_masuk,
                },
                dataType: "json",
                beforeSend: function() {
                    $this.prop('disabled', true);
                    $this.text('Memproses');
                },
                success: function(res) {
                    let status = res.status;
                    let msg = res.message;
                    let data = res.data;

                    if (status == 'error') {
                        showToast('error', msg);
                        return false;
                    }

                    window.open(data, "_blank");

                },
                error: function() {
                    $this.prop('disabled', true);
                    $this.html('<i class="bi bi-info-circle me-2"></i> I-Care');
                },
                complete: function() {
                    $this.prop('disabled', false);
                    $this.html('<i class="bi bi-info-circle me-2"></i> I-Care');
                }
            });
        });
    </script>
@endpush
