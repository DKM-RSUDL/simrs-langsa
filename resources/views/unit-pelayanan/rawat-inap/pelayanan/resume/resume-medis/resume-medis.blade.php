<div>
    <div class="d-flex justify-content-between m-3">
        <div class="row">
            <!-- Select Option -->
            <div class="col-md-2">
                <select class="form-select" id="SelectOption" aria-label="Pilih...">
                    <option value="semua" selected>Semua Episode</option>
                    <option value="option1">Episode Sekarang</option>
                    <option value="option2">1 Bulan</option>
                    <option value="option3">3 Bulan</option>
                    <option value="option4">6 Bulan</option>
                    <option value="option5">9 Bulan</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="col-md-2">
                <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
            </div>

            <!-- End Date -->
            <div class="col-md-2">
                <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
            </div>
            <div class="col-md-2">
                <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                        class="bi bi-funnel-fill"></i></a>
            </div>

            <!-- Search Bar -->
            <div class="col-md-4">
                <form method="GET"
                    action="{{ route('rawat-inap.rawat-inap-resume.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}">

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama dokter"
                            aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Jenis Pelayanan</th>
                    <th>Dokter (DPJP)</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>LOS</th>
                    <th>Kinik/Ruang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="table-resume">
                @foreach ($dataGet as $post)
                    <tr id="index_{{ $post->id }}">
                        <td>Rawat Inap</td>
                        <td>{{ $dataMedis->dokter->nama_lengkap ?? '-' }}</td>
                        <td>
                            {{ $post->tgl_masuk ? \Carbon\Carbon::parse($post->tgl_masuk)->format('Y-m-d') : '-' }}
                        </td>
                        <td>
                            {{ $dataMedis->tgl_keluar ? \Carbon\Carbon::parse($dataMedis->tgl_keluar)->format('Y-m-d') : '-' }}
                        </td>
                        <td>-</td>
                        <td>{{ $dataMedis->unit->nama_unit }}</td>
                        <td>
                            @if ($post->status == 0)
                                <a href="javascript:void(0)" class="btn btn-sm btn-success mb-2"
                                    data-id="{{ $post->id }}" id="btn-edit-resume">Validasi</a>
                            @elseif ($post->status == 1)
                                <a href="javascript:void(0)" class="btn btn-sm btn-info mb-2"
                                    data-id="{{ $post->id }}" id="btn-view-resume">Lihat</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataGet->withQueryString()->links() }}
    </div>
</div>

@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-create')
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-view-resume')

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // Filter by period
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var kd_unit = "{{ $dataMedis->kd_unit }}";
                var kd_pasien = "{{ $dataMedis->kd_pasien }}";
                var tgl_masuk = "{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') }}";
                var urut_masuk = "{{ $dataMedis->urut_masuk }}";

                var queryString = '?periode=' + periode;
                window.location.href = "/unit-pelayanan/rawat-inap/unit/" + kd_unit + "/pelayanan/" +
                    kd_pasien + "/" +
                    tgl_masuk + "/" + urut_masuk + "/rawat-inap-resume/" + queryString;
            });

            // Filter by start date and end date
            $('#filterButton').click(function(e) {
                e.preventDefault();

                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                var kd_unit = "{{ $dataMedis->kd_unit }}";
                var kd_pasien = "{{ $dataMedis->kd_pasien }}";
                var tgl_masuk = "{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') }}";
                var urut_masuk = "{{ $dataMedis->urut_masuk }}";

                if (!startDate || !endDate) {
                    alert('Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu.');
                    return;
                }

                var queryString = '?start_date=' + startDate + '&end_date=' + endDate;
                window.location.href = "/unit-pelayanan/rawat-inap/unit/" + kd_unit + "/pelayanan/" +
                    kd_pasien + "/" +
                    tgl_masuk + "/" + urut_masuk + "/rawat-inap-resume/" + queryString;


            });
        });
    </script>
@endpush

