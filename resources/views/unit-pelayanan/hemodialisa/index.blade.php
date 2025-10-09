@extends('layouts.administrator.master')

@push('css')
    <style>
        .badge {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .badge-triage-yellow {
            background-color: #ffeb3b;
        }

        .badge-triage-red {
            background-color: #f44336;
        }

        .badge-triage-green {
            background-color: #4caf50;
        }

        /* Custom CSS for profile */
        .profile {
            display: flex;
            align-items: center;
        }

        .profile img {
            margin-right: 10px;
            border-radius: 50%;
        }

        .profile .info {
            display: flex;
            flex-direction: column;
        }

        .profile .info strong {
            font-size: 14px;
        }

        .profile .info span {
            font-size: 12px;
            color: #777;
        }

        .emergency__container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .custom__card {
            border-radius: 15px;
            padding: 8px 15px;
            width: fit-content;
            min-width: 150px;
            display: flex;
            align-items: center;
            gap: 20px
        }

        .all__patients {
            background: linear-gradient(to bottom, #e0f7ff, #a5d8ff);
            border: 2px solid #a100c9;
        }

        .Pending {
            background: linear-gradient(to bottom, #ffffff, #ffe499);
            border: 2px solid #ffbb00;
        }

        .custom__icon {
            margin-bottom: 5px;
        }

        .card__content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .check__icon {
            color: #00cc00;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
        }

        .emergency__container a {
            text-decoration: none;
            color: #000;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-submenu>a.dropdown-toggle {
            position: relative;
            padding-right: 30px;
        }

        .dropdown-submenu>a.dropdown-toggle::after {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .dropdown-submenu:hover>a.dropdown-toggle::after {
            transform: translateY(-50%) rotate(-90deg);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="emergency__container">
                <h4 class="fw-bold">Hemodialisa</h4>

                <a href="{{ route('hemodialisa.index') }}">
                    <div class="custom__card all__patients">
                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        <div class="text-center">
                            <p class="m-0 p-0">Aktif</p>
                            <p class="m-0 p-0 fs-4 fw-bold">{{ countUnfinishedPatientWithTglKeluar(72) }}</p>
                        </div>
                    </div>
                </a>

                <a href="#">
                    <div class="custom__card Pending">
                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        <div class="text-center">
                            <p class="m-0 p-0">Pending Order Masuk</p>
                            <p class="m-0 p-0 fs-4 fw-bold">0</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="d-flex justify-content-end align-items-end gap-3">
                <div class="d-flex align-items-center">
                    <label for="dokterSelect" class="form-label me-2">Dokter:</label>
                    <select class="form-select" id="dokterSelect" aria-label="Pilih dokter">
                        <option value="" selected>Semua</option>
                        @foreach ($dokter as $d)
                            <option value="{{ $d->dokter->kd_dokter }}">{{ $d->dokter->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable" id="hemodialisaTable">
                    <thead>
                        <tr>
                            <th width="100px">Aksi</th>
                            <th>Pasien</th>
                            <th>Bed</th>
                            <th>No RM / Reg</th>
                            <th>Alamat</th>
                            <th>Jaminan</th>
                            <th>Tgl Masuk</th>
                            <th>Dokter</th>
                            <th>Instruksi</th>
                            <th>Del</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Tabel diisi oleh DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var hdIndexUrl = "{{ route('hemodialisa.index') }}";
        var hdPelayananUrl = "{{ url('unit-pelayanan/hemodialisa/pelayanan/') }}/";
        // Untuk persetujuan transfusi darah, gunakan URL yang sesuai dengan route
        // var persetujuanTransfusiUrl = "{{ url('unit-pelayanan/hemodialisa/pelayanan/') }}/";

        $(document).ready(function() {
            $('#hemodialisaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: hdIndexUrl,
                    data: function(d) {
                        d.dokter = $('#dokterSelect').val();
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <div class="d-flex justify-content-center">
                            <a href="${hdPelayananUrl + row.kd_pasien}/${row.tgl_masuk}/${row.urut_masuk}"
                                class="btn btn-outline-primary btn-sm me-1">
                                <i class="ti-pencil-alt"></i>
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="${hdPelayananUrl + row.kd_pasien}/${row.tgl_masuk}/${row.urut_masuk}/persetujuan-transfusi-darah">Persetujuan Transfusi Darah</a></li>
                                </ul>
                            </div>
                        </div>`;
                        }
                    },
                    {
                        data: 'profile',
                        name: 'profile',
                        render: function(data, type, row) {
                            let imageUrl = row.foto_pasien ? "{{ asset('storage/') }}" + '/' + row
                                .foto_pasien : "{{ asset('assets/images/avatar1.png') }}";
                            let gender = row.pasien.jenis_kelamin == '1' ? 'Laki-Laki' :
                                'Perempuan';
                            return `
                                <div class="profile">
                                    <img src="${imageUrl}" alt="Profile" width="50" height="50" class="rounded-circle"/>
                                    <div class="info">
                                        <strong>${row.pasien.nama}</strong>
                                        <span>${gender} / ${row.umur} Tahun</span>
                                    </div>
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'bed',
                        name: 'bed',
                        defaultContent: ''
                    },
                    {
                        data: 'kd_pasien',
                        name: 'kd_pasien',
                        render: function(data, type, row) {
                            // Assuming row.kd_pasien is the "RM" and row.reg_number is the "Reg" value
                            return `
                            <div class="rm-reg">
                                RM: ${row.kd_pasien ? row.kd_pasien : 'N/A'}<br>
                                Reg: ${row.reg_number ? row.reg_number : 'N/A'}
                            </div>
                        `;
                        },
                        defaultContent: ''
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        defaultContent: ''
                    },
                    {
                        data: 'jaminan',
                        name: 'jaminan',
                        defaultContent: ''
                    },
                    {
                        data: 'waktu_masuk',
                        name: 'tgl_masuk',
                        defaultContent: 'null'
                    },
                    {
                        data: 'kd_dokter',
                        name: 'kd_dokter',
                        defaultContent: 'null'
                    },
                    {
                        data: 'instruksi',
                        name: 'instruksi',
                        defaultContent: ''
                    },
                    {
                        data: 'del',
                        name: 'del',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="#" class="edit btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>';
                        }
                    },
                ],
                deferRender: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                paging: true,
                lengthChange: true,
                searching: true,
                orderCellsTop: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
            });

            initSelect2();

            let rujukanVal = $('#addPatientTriage input[name="rujukan"]').val();
            if (rujukanVal == '1') $('#addPatientTriage #rujukan_ket').prop('required', true);


            $('.dropdown-submenu').hover(
                function() {
                    $(this).find('.dropdown-menu').addClass('show');
                },
                function() {
                    $(this).find('.dropdown-menu').removeClass('show');
                }
            );
        });


        // Foto Upload
        $('#fotoPasienlabel').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#foto_pasien').trigger('click');
        });

        $('#foto_pasien').on('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (e.target && e.target.result) {
                        $('#fotoPasienlabel .text-center').html(`<img src="${e.target.result}" width="200">`);
                    } else {
                        showToast('error', 'Terjadi kesalahan server saat memilih file gambar!');
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Triase Item Check
        // Perubahan pada checkbox DOA
        $('#addPatientTriage .doa-check').change(function(e) {
            // kalau ada checkbox doa yang di check disable semua checkbox non DOA
            let doaChecked = $('#addPatientTriage .doa-check:checked').length > 0;
            $('#addPatientTriage input[type="checkbox"]').not('.doa-check').prop('disabled', doaChecked);

            updateTriaseStatus();
        });

        // perubahan pada checkbox non DOA
        $('#addPatientTriage input[type="checkbox"]').not('.doa-check').change(function(e) {
            // kalau ada checkbox non doa di check maka disable semua checkbox doa
            let nonDoaChecked = $('#addPatientTriage input[type="checkbox"]:checked').not('.doa-check').length > 0;
            $('#addPatientTriage input[type="checkbox"].doa-check').prop('disabled', nonDoaChecked);

            updateTriaseStatus();
        });

        function updateTriaseStatus() {
            var status = '';
            var kode_triase = '';

            // Menetapkan prioritas dari tinggi ke rendah
            if ($('#addPatientTriage .doa-check:checked').length > 0) {
                status = 'DOA';
                kode_triase = 5;
            } else if ($('#addPatientTriage .resusitasi-check:checked').length > 0) {
                status = 'RESUSITASI (segera)';
                kode_triase = 4;
            } else if ($('#addPatientTriage .emergency-check:checked').length > 0) {
                status = 'EMERGENCY (10 menit)';
                kode_triase = 3;
            } else if ($('#addPatientTriage .urgent-check:checked').length > 0) {
                status = 'URGENT (30 menit)';
                kode_triase = 2;
            } else if ($('#addPatientTriage .false-emergency-check:checked').length > 0) {
                status = 'FALSE EMERGENCY (60 menit)';
                kode_triase = 1;
            }

            $('#addPatientTriage #triaseStatusLabel').text(status).attr('class', determineClass(status));
            $('#addPatientTriage #kd_triase').val(kode_triase);
            $('#addPatientTriage #ket_triase').val(status);
        }

        function determineClass(status) {
            switch (status) {
                case 'RESUSITASI (segera)':
                    return 'btn btn-block btn-danger ms-3 w-100';
                case 'EMERGENCY (10 menit)':
                    return 'btn btn-block btn-danger ms-3 w-100';
                case 'URGENT (30 menit)':
                    return 'btn btn-block btn-warning ms-3 w-100';
                case 'FALSE EMERGENCY (60 menit)':
                    return 'btn btn-block btn-success ms-3 w-100';
                case 'DOA':
                    return 'btn btn-block btn-dark ms-3 w-100';
                default:
                    return 'btn btn-block ms-3 w-100';
            }
        }

        // Input Rujukan Change
        $('#addPatientTriage input[name="rujukan"]').change(function(e) {
            let $this = $(this);
            let rujukanValue = $this.val();


            // kalau value y input rujukan ket required, kalau n input rujukan ket disabled
            if (rujukanValue == '1') {
                $('#addPatientTriage #rujukan_ket').prop('required', true);
                $('#addPatientTriage #rujukan_ket').prop('readonly', false);
            } else {
                $('#addPatientTriage #rujukan_ket').val('');
                $('#addPatientTriage #rujukan_ket').prop('required', false);
                $('#addPatientTriage #rujukan_ket').prop('readonly', true);
            }
        });

        // Reinisialisasi Select2 ketika modal dibuka
        $('#addPatientTriage').on('shown.bs.modal', function() {
            let $this = $(this);

            @cannot('is-admin')
                @cannot('is-perawat')
                    @cannot('is-bidan')
                        $this.find('#dokter_triase').mousedown(function(e) {
                            e.preventDefault();
                        });
                    @endcannot
                @endcannot
            @endcannot

            // Destroy existing Select2 instance before reinitializing
            initSelect2();
        });

        function initSelect2() {
            $('#addPatientTriage .select2').select2({
                dropdownParent: $('#addPatientTriage'),
                width: '100%'
            });
        }

        function isNumber(value) {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }

        function hitungUmur(tanggalLahir) {
            // Parsing tanggal lahir
            const tglLahir = new Date(tanggalLahir);

            // Tanggal hari ini
            const hariIni = new Date();

            // Menghitung selisih tahun
            let tahun = hariIni.getFullYear() - tglLahir.getFullYear();
            let bulan = hariIni.getMonth() - tglLahir.getMonth();

            // Menyesuaikan jika bulan lahir belum terlewati tahun ini
            if (bulan < 0 || (bulan === 0 && hariIni.getDate() < tglLahir.getDate())) {
                tahun--;
                bulan += 12;
            }

            // Menghitung sisa bulan
            bulan = bulan % 12;

            return {
                tahun,
                bulan
            };
        }

        function getWaktuSekarang() {
            const sekarang = new Date();

            // Format tanggal (Y-m-d)
            const tahun = sekarang.getFullYear();
            const bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
            const tanggal = String(sekarang.getDate()).padStart(2, '0');
            const formatTanggal = `${tahun}-${bulan}-${tanggal}`;

            // Format waktu (H:i)
            const jam = String(sekarang.getHours()).padStart(2, '0');
            const menit = String(sekarang.getMinutes()).padStart(2, '0');
            const formatWaktu = `${jam}:${menit}`;

            return {
                formatTanggal,
                formatWaktu
            };
        }

        // Search Nik
        $('#addPatientTriage #button-nik-pasien').click(function(e) {
            let $this = $(this);
            let $nikEl = $('#addPatientTriage #nik_pasien');
            let nikPasien = $nikEl.val();

            if (nikPasien == '' || nikPasien.length != 16 || !isNumber(nikPasien)) {
                showToast('error', 'NIK pasien harus di isi 16 angka!');

                $('#addPatientTriage #no_rm_label').text('');
                $('#addPatientTriage input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
                $('#addPatientTriage input, select').prop('readonly', false);

                let nowDate = getWaktuSekarang();
                $('#addPatientTriage #nik_pasien').val(nikPasien);
                $('#addPatientTriage #tgl_masuk').val(nowDate.formatTanggal);
                $('#addPatientTriage #jam_masuk').val(nowDate.formatWaktu);
                return false;
            }

            $.ajax({
                type: "post",
                url: "{{ route('gawat-darurat.get-patient-bynik-ajax') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nik': nikPasien
                },
                dataType: "json",
                beforeSend: function() {
                    // Ubah teks tombol dan tambahkan spinner
                    $nikEl.prop('disabled', true);
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
                },
                complete: function() {
                    // Ubah teks tombol jadi icon search dan disable nonaktif
                    $nikEl.prop('disabled', false);
                    $this.html('<i class="ti ti-search"></i>');
                    $this.prop('disabled', false);
                },
                success: function(res) {
                    showToast(res.status, res.message);

                    if (res.status == 'success') {
                        let data = res.data;
                        console.log(data);

                        // set value
                        $('#addPatientTriage #no_rm_label').text(data.kd_pasien);
                        $('#addPatientTriage #no_rm').val(data.kd_pasien);

                        $('#addPatientTriage #nama_pasien').val(data.nama);
                        $('#addPatientTriage #nama_pasien').prop('readonly', true);

                        $('#addPatientTriage #jenis_kelamin').val(data.jenis_kelamin);
                        $('#addPatientTriage #jenis_kelamin').prop('readonly', true);

                        let umur = hitungUmur(data.tgl_lahir);
                        $('#addPatientTriage #usia_tahun').val(umur.tahun);
                        $('#addPatientTriage #usia_bulan').val(umur.bulan);
                        $('#addPatientTriage #usia_tahun').prop('readonly', true);
                        $('#addPatientTriage #usia_bulan').prop('readonly', true);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });


        });

        $('#dokterSelect').on('change', function() {
            $('#hemodialisaTable').DataTable().ajax.reload();
        });
    </script>
@endpush
