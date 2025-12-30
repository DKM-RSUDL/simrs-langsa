@extends('layouts.administrator.master')

@section('content')
    <x-content-card>
        <div class="table-responsive">
            <table class="table table-bordered dataTable">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 80%">Nama Berkas</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </x-content-card>
    @php
        $idData = null;
    @endphp
    <x-modal id="BerkasUpdateModal" size="lg" title="Edit Berkas" confirm="{{ true }}" action="#"
        idForm="FormUpdateBerkas">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-3">
            <label for="Nama_Berkas" class="form-label">Nama Berkas</label>

            <input type="text" class="form-control" id="Nama_Berkas" name="nama_berkas" disabled
                placeholder="Masukkan nama berkas" required>
        </div>


        <div class="mb-3">
            <label class="form-label d-block">Status</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="Status_Berkas" name="aktif">
                <label class="form-check-label" for="Status_Berkas">
                    Aktif
                </label>
            </div>
        </div>

        <!-- Hidden ID -->
        <input type="hidden" id="Berkas_ID" name="id">
    </x-modal>
@endsection

@push('js')
    <script>
        $(document).on('click', '#UpdateBerkas', function() {
            let $this = $(this);
            const id = $this.data('id')

            $.ajax({
                url: "{{ route('berkas-digital.setting.show', ['id' => 'DATA_ID']) }}".replace('DATA_ID',
                    id),
                type: 'GET',
                beforeSend: function() {
                    $this.data('orig-html', $this.html());
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        );
                    $this.attr('disabled', true);
                },
                success: function(res) {
                    const data = res.data;
                    // console.log(data)
                    // console.log(data.aktif)
                    $('#FormUpdateBerkas').attr('action',
                            "{{ route('berkas-digital.setting.update', ['id' => 'DATA_ID']) }}".replace(
                                'DATA_ID', id)),
                        $('#Nama_Berkas').val(data.nama_berkas);
                    $('#Status_Berkas').prop('checked', data.aktif == '1');
                    $('#Status_Berkas').val(data.aktif);
                    $('#BerkasUpdateModal').modal('show');
                },
                complete: function() {
                    const orig = $this.data('orig-html');
                    if (typeof orig !== 'undefined') {
                        $this.html(orig);
                        $this.removeData('orig-html');
                    }
                    $this.attr('disabled', false);
                }
            })
        })

        $('#Status_Berkas').on('click', function() {
            const value = $('#Status_Berkas').val();

            $('#Status_Berkas').val(value == '1' ? '0' : '1');
            console.log($('#Status_Berkas').val())
        });

        $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('berkas-digital.setting.index') }}",
            columnDefs: [{
                    targets: [1, 2],
                    className: "text-start"
                },
                {
                    targets: [3],
                    className: "text-center"
                }
            ],
            columns: [{
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_berkas',
                    name: 'nama_berkas'
                },
                {
                    data: 'aktif',
                    name: 'aktif',
                    render: function(data) {
                        return data == 1 ?
                            '<span class="badge bg-success">Aktif</span>' :
                            '<span class="badge bg-danger">Nonaktif</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>
@endpush
