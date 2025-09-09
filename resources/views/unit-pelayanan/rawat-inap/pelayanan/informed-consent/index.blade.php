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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInformedConsentModal"
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
                            <th>Penerima Informasi</th>
                            <th>Saksi 1</th>
                            <th>Saksi 2</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($informedConsent as $item)
                            <tr>
                                <td>{{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i:s', strtotime($item->jam)) }}
                                </td>
                                <td>{{ $item->user->name ?? '' }}</td>
                                <td>{{ $item->nama_penerima_info }}</td>
                                <td>{{ $item->saksi1_nama }}</td>
                                <td>{{ $item->saksi2_nama }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-primary btn-show-consent"
                                            data-ic="{{ $item->id }}" data-bs-target="#showInformedConsentModal">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <a href="{{ route('rawat-inap.informed-consent.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-success btn-sm" title="Cetak" target="_blank">
                                            <i class="ti-printer"></i>
                                        </a>

                                        <form
                                            action="{{ route('rawat-inap.informed-consent.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $item->id]) }}"
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

    @include('unit-pelayanan.rawat-inap.pelayanan.informed-consent.modal')
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
            let dataId = $this.attr('data-ic');
            let target = $this.attr('data-bs-target');

            $.ajax({
                type: "post",
                url: "{{ route('rawat-inap.informed-consent.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    dataic: dataId
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

                    console.log(data);


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
                    $(target).find('#nama_pemberi_info').val(data.nama_pemberi_info);
                    $(target).find('#nama_penerima_info').val(data.nama_penerima_info);
                    $(target).find('#diagnosis').val(data.diagnosis);
                    $(target).find('#dasar_diagnosis').val(data.dasar_diagnosis);
                    $(target).find('#tindakan_kedokteran').val(data.tindakan_kedokteran);
                    $(target).find('#indikasi_tindakan').val(data.indikasi_tindakan);
                    $(target).find('#tata_cara').val(data.tata_cara);
                    $(target).find('#tujuan').val(data.tujuan);
                    $(target).find('#resiko').val(data.resiko);
                    $(target).find('#prognosis').val(data.prognosis);
                    $(target).find('#alternatif').val(data.alternatif);
                    $(target).find('#lainnya').val(data.lainnya);
                    $(target).find('#keluarga_nama').val(data.keluarga_nama);
                    $(target).find('#keluarga_umur').val(data.keluarga_umur);
                    $(target).find('#keluarga_jenis_kelamin').val(data.keluarga_jenis_kelamin);
                    $(target).find('#keluarga_alamat').val(data.keluarga_alamat);
                    $(target).find('#keluarga_hubungan_pasien').val(data.keluarga_hubungan_pasien);
                    $(target).find('#saksi1_nama').val(data.saksi1_nama);
                    $(target).find('#saksi1_tgl_lahir').val(data.saksi1_tgl_lahir);
                    $(target).find('#saksi1_alamat').val(data.saksi1_alamat);
                    $(target).find('#saksi1_nohp').val(data.saksi1_nohp);
                    $(target).find('#saksi1_hubungan_pasien').val(data.saksi1_hubungan_pasien);
                    $(target).find('#saksi2_nama').val(data.saksi2_nama);
                    $(target).find('#saksi2_tgl_lahir').val(data.saksi2_tgl_lahir);
                    $(target).find('#saksi2_alamat').val(data.saksi2_alamat);
                    $(target).find('#saksi2_nohp').val(data.saksi2_nohp);
                    $(target).find('#saksi2_hubungan_pasien').val(data.saksi2_hubungan_pasien);
                    $(target).find('#status_menerangkan_informasi').val(data
                        .status_menerangkan_informasi);
                    $(target).find('#status_persetujuan_keluarga').val(data
                    .status_persetujuan_keluarga);

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
