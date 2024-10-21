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
                    action="{{ route('resume.index', ['kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => $dataMedis->tgl_masuk]) }}">

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari" aria-label="Cari"
                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>


        </div>
    </div>

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
                    <td>Gawat Darurat</td>
                    <td>{{ $post->kunjungan->dokter->nama_lengkap ?? '-' }}</td>
                    <td>
                        {{ $post->tgl_masuk ? substr($post->tgl_masuk, 0, 10) : '-' }}
                    </td>
                    <td>
                        {{ $post->kunjungan->tgl_keluar ? substr($post->kunjungan->tgl_keluar, 0, 10) : '-' }}
                    </td>
                    <td>-</td>
                    <td>{{ $post->kunjungan->unit->nama_unit }}</td>
                    {{-- <td>
                        @switch($post->rmeResumeDet->tindak_lanjut_code)
                            @case(1)
                                Ranap
                            @break

                            @case(2)
                                Kontrol Ulang
                            @break

                            @case(3)
                                Selesai di Unit
                            @break

                            @case(4)
                                Rujuk Internal
                            @break

                            @case(5)
                                Rujuk RS Lain
                            @break

                            @default
                                -
                        @endswitch
                    </td> --}}

                    <td>
                        @if ($post->status == 0)
                            <a href="javascript:void(0)" class="btn btn-sm btn-success mb-2"
                                data-id="{{ $post->id }}" id="btn-edit-resume">Validasi</a>
                        @elseif ($post->status == 1)
                            <a href="javascript:void(0)" class="btn btn-sm btn-info mb-2" data-id="{{ $post->id }}"
                                id="btn-view-resume">Lihat</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-create')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-view-resume')

<script type="text/javascript">
    $(document).ready(function() {
        // Filter by period
        $('#SelectOption').change(function() {
            var periode = $(this).val();
            var kd_pasien =
            "{{ $dataMedis->kd_pasien }}"; // Pastikan variabel ini tersedia dari controller atau blade
            var tgl_masuk =
            "{{ $dataMedis->tgl_masuk }}"; // Pastikan variabel ini tersedia dari controller atau blade

            var queryString = '?periode=' + periode;
            window.location.href = "/unit-pelayanan/gawat-darurat/pelayanan/" + kd_pasien + "/" +
                tgl_masuk + "/resume" + queryString;
        });

        // Filter by start date and end date
        $('#filterButton').click(function(e) {
            e.preventDefault();

            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var kd_pasien =
            "{{ $dataMedis->kd_pasien }}"; // Pastikan variabel ini tersedia dari controller atau blade
            var tgl_masuk =
            "{{ $dataMedis->tgl_masuk }}"; // Pastikan variabel ini tersedia dari controller atau blade

            if (!startDate || !endDate) {
                alert('Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu.');
                return;
            }

            var queryString = '?start_date=' + startDate + '&end_date=' + endDate;

            window.location.href = "/unit-pelayanan/gawat-darurat/pelayanan/" + kd_pasien + "/" +
                tgl_masuk + "/resume" + queryString;
        });
    });
</script>
