@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-end">
                <div class="col-md-2">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGeneralConsentModal"
                            type="button">
                            <i class="ti-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-sm table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal dan Jam</th>
                            <th>Petugas</th>
                            <th>Penanggung Jawab</th>
                            <th>Saksi</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($generalConsent as $item)
                            <tr>
                                <td>{{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i', strtotime($item->jam)) }}
                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->pj_nama }}</td>
                                <td>{{ $item->saksi_nama }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-primary btn-show-consent"
                                            data-gc="{{ $item->id }}" data-bs-target="#showGeneralConsentModal">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <a href="{{ route('general-consent.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-primary btn-sm" title="Cetak" target="_blank">
                                            <i class="ti-printer"></i>
                                        </a>

                                        <form
                                            action="{{ route('general-consent.delete', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $item->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn btn-sm btn-danger btn-del-consent">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.general-consent.modal')
@endsection


@push('js')
    <script>
        $('.btn-del-consent').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });


        $('.btn-show-consent').click(function(e) {
            let $this = $(this);
            let dataId = $this.attr('data-gc');
            let target = $this.attr('data-bs-target');

            $.ajax({
                type: "post",
                url: "{{ route('general-consent.show', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    datagc: dataId
                },
                beforeSend: function() {
                    // Ubah teks tombol dan tambahkan spinner
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
                },
                dataType: "json",
                success: function(res) {
                    let status = res.status;
                    let msg = res.msg;
                    let data = res.data;

                    if (status == 'error') {
                        Swal.fire({
                            title: "Error",
                            text: msg,
                            icon: "error"
                        });

                        return false;
                    }

                    // success
                    $(target).find('#tanggal').val(data.tanggal);
                    $(target).find('#jam').val(data.jam);
                    $(target).find('#pj_nama').val(data.pj_nama);
                    $(target).find('#pj_tgl_lahir').val(data.pj_tgl_lahir);
                    $(target).find('#pj_alamat').val(data.pj_alamat);
                    $(target).find('#pj_nohp').val(data.pj_nohp);
                    $(target).find('#pj_hubungan_pasien').val(data.pj_hubungan_pasien);
                    $(target).find('#saksi_nama').val(data.saksi_nama);
                    $(target).find('#saksi_tgl_lahir').val(data.saksi_tgl_lahir);
                    $(target).find('#saksi_alamat').val(data.saksi_alamat);
                    $(target).find('#saksi_nohp').val(data.saksi_nohp);
                    $(target).find('#saksi_hubungan_pasien').val(data.saksi_hubungan_pasien);
                    $(target).find('#setuju_perawatan').val(data.setuju_perawatan);
                    $(target).find('#setuju_barang').val(data.setuju_barang);
                    $(target).find('#info_nama_1').val(data.info_nama_1);
                    $(target).find('#info_hubungan_pasien_1').val(data.info_hubungan_pasien_1);
                    $(target).find('#info_nama_2').val(data.info_nama_2);
                    $(target).find('#info_hubungan_pasien_2').val(data.info_hubungan_pasien_2);
                    $(target).find('#info_nama_3').val(data.info_nama_3);
                    $(target).find('#info_hubungan_pasien_3').val(data.info_hubungan_pasien_3);
                    $(target).find('#setuju_hak').val(data.setuju_hak);
                    $(target).find('#setuju_akses_privasi').val(data.setuju_akses_privasi);
                    $(target).find('#akses_privasi_keterangan').val(data.akses_privasi_keterangan);
                    $(target).find('#setuju_privasi_khusus').val(data.setuju_privasi_khusus);
                    $(target).find('#privasi_khusus_keterangan').val(data.privasi_khusus_keterangan);
                    $(target).find('#rawat_inap_keterangan').val(data.rawat_inap_keterangan);
                    $(target).find('#vii_biaya_umum').val() == data.biaya_status ? $(target).find(
                        '#vii_biaya_umum').prop('checked', true) : '';
                    $(target).find('#vii_biaya_asuransi').val() == data.biaya_status ? $(target).find(
                        '#vii_biaya_asuransi').prop('checked', true) : '';
                    $(target).find('#biaya_setuju').val(data.biaya_setuju);

                    $(target).modal('show');


                },
                error: function() {
                    Swal.fire({
                        title: "Error",
                        text: "Internal Server Error !",
                        icon: "error"
                    });
                },
                complete: function() {
                    $this.html(
                        '<i class="fas fa-eye"></i>'
                    );
                    $this.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
