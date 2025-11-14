<script>
    // Foto Upload
    $('#fotoPasienlabel').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('#foto_pasien').trigger('click');
    });

    $('#foto_pasien').on('change', function (e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
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
    $('.doa-check').change(function (e) {
        // kalau ada checkbox doa yang di check disable semua checkbox non DOA
        let doaChecked = $('.doa-check:checked').length > 0;
        $('input[type="checkbox"]').not('.doa-check').prop('disabled', doaChecked);

        updateTriaseStatus();
    });

    // perubahan pada checkbox non DOA
    $('input[type="checkbox"]').not('.doa-check').change(function (e) {
        // kalau ada checkbox non doa di check maka disable semua checkbox doa
        let nonDoaChecked = $('input[type="checkbox"]:checked').not('.doa-check').length > 0;
        $('input[type="checkbox"].doa-check').prop('disabled', nonDoaChecked);

        updateTriaseStatus();
    });

    function updateTriaseStatus() {
        var status = '';
        var kode_triase = '';

        // Menetapkan prioritas dari tinggi ke rendah
        if ($('.doa-check:checked').length > 0) {
            status = 'DOA';
            kode_triase = 5;
        } else if ($('.resusitasi-check:checked').length > 0) {
            status = 'RESUSITASI (segera)';
            kode_triase = 4;
        } else if ($('.emergency-check:checked').length > 0) {
            status = 'EMERGENCY (10 menit)';
            kode_triase = 3;
        } else if ($('.urgent-check:checked').length > 0) {
            status = 'URGENT (30 menit)';
            kode_triase = 2;
        } else if ($('.false-emergency-check:checked').length > 0) {
            status = 'FALSE EMERGENCY (60 menit)';
            kode_triase = 1;
        }

        $('#triaseStatusLabel').text(status).attr('class', determineClass(status));
        $('#kd_triase').val(kode_triase);
        $('#ket_triase').val(status);
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

    $('#kodeTriaseModal .btn-triase-label').click(function () {
        let $this = $(this);
        let triaseLabel = $this.attr('data-triase');
        let kdTriase = $this.attr('data-kode');

        $('#triaseStatusLabel').text(triaseLabel).attr('class', determineClass(triaseLabel));
        $('#kd_triase').val(kdTriase);
        $('#ket_triase').val(triaseLabel);

        $('#kodeTriaseModal').modal('hide');
    });

    // Input Rujukan Change
    $('input[name="rujukan"]').change(function (e) {
        let $this = $(this);
        let rujukanValue = $this.val();


        // kalau value y input rujukan ket required, kalau n input rujukan ket disabled
        if (rujukanValue == '1') {
            $('#rujukan_ket').prop('required', true);
            $('#rujukan_ket').prop('readonly', false);
        } else {
            $('#rujukan_ket').val('');
            $('#rujukan_ket').prop('required', false);
            $('#rujukan_ket').prop('readonly', true);
        }
    });

    // Reinisialisasi Select2 ketika modal dibuka
    $('#addPatientTriage').on('shown.bs.modal', function () {
        let $this = $(this);

        @cannot('is-admin')
        @cannot('is-perawat')
        @cannot('is-bidan')
        $this.find('#dokter_triase').mousedown(function (e) {
            e.preventDefault();
        });
        @endcannot
        @endcannot
        @endcannot

        // Destroy existing Select2 instance before reinitializing
        initSelect2();
    });

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
    $('#button-nik-pasien').click(function (e) {

        let $this = $(this);
        let $nikEl = $('#nik_pasien');
        let nikPasien = $nikEl.val();


        if (nikPasien.length == 16 || nikPasien.length == 10) {
            let nowDate = getWaktuSekarang();
            $('#nik_pasien').val(nikPasien);
            $('#tgl_masuk').val(nowDate.formatTanggal);
            $('#jam_masuk').val(nowDate.formatWaktu);

        } else {
            showToast('error', 'NIK pasien harus di isi 16 angka atau No RM dengan format 0-00-00-00!');

            $('#no_rm_label').text('');
            $('input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
            $('input, select').prop('readonly', false);

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
            beforeSend: function () {
                // Ubah teks tombol dan tambahkan spinner
                $nikEl.prop('disabled', true);
                $this.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
            },
            complete: function () {
                // Ubah teks tombol jadi icon search dan disable nonaktif
                $nikEl.prop('disabled', false);
                $this.html('<i class="ti ti-search"></i>');
                $this.prop('disabled', false);
            },
            success: function (res) {
                showToast(res.status, res.message);

                if (res.status == 'success') {
                    let data = res.data;

                    // set value
                    $('#no_rm_label').text(data.kd_pasien);
                    $('#no_rm').val(data.kd_pasien);

                    $('#nama_pasien').val(data.nama);
                    $('#nama_pasien').prop('readonly', true);

                    $('#alamat_pasien').val(data.alamat);
                    $('#alamat_pasien').prop('readonly', true);

                    $('#jenis_kelamin').val(data.jenis_kelamin);
                    $('#jenis_kelamin').prop('readonly', true);

                    let umur = hitungUmur(data.tgl_lahir);
                    $('#usia_tahun').val(umur.tahun);
                    $('#usia_bulan').val(umur.bulan);
                    $('#usia_tahun').prop('readonly', true);
                    $('#usia_bulan').prop('readonly', true);
                }
            },
            error: function (xhr, status, error) {
                showToast('error', 'Internal server error');
            }
        });


    });

    // Search name
    $('#button-nama-pasien').click(function (e) {

        let $this = $(this);
        let $namaEl = $('#nama_pasien');
        let namaPasien = $namaEl.val();

        if (namaPasien.length > 0) {
            let nowDate = getWaktuSekarang();
            $('#tgl_masuk').val(nowDate.formatTanggal);
            $('#jam_masuk').val(nowDate.formatWaktu);

        } else {
            showToast('error', 'Nama Pasien tidak boleh kosong!');

            $('#no_rm_label').text('');
            $('input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
            $('input, select').prop('readonly', false);

            return false;
        }


        $.ajax({
            type: "post",
            url: "{{ route('gawat-darurat.get-patient-bynama-ajax') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'nama': namaPasien
            },
            dataType: "json",
            beforeSend: function () {
                // Ubah teks tombol dan tambahkan spinner
                $namaEl.prop('disabled', true);
                $this.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
            },
            complete: function () {
                // Ubah teks tombol jadi icon search dan disable nonaktif
                $namaEl.prop('disabled', false);
                $this.html('<i class="ti ti-search"></i>');
                $this.prop('disabled', false);
            },
            success: function (res) {
                showToast(res.status, res.message);


                if (res.status == 'success') {
                    let data = res.data;

                    let html = '';
                    $.each(data, function (i, e) {
                        html += `<tr>
                                        <td align="middle">${i + 1}</td>
                                        <td align="middle">${e.kd_pasien}</td>
                                        <td>${e.nama}</td>
                                        <td align="middle">${e.no_pengenal != null ? e.no_pengenal : '-'}</td>
                                        <td align="middle">${hitungUmur(e.tgl_lahir).tahun}</td>
                                        <td>${e.alamat}</td>
                                        <td align="middle">
                                            <button class="btn btn-sm btn-success btn-select-pasien" data-rm="${e.kd_pasien}" data-nama="${e.nama}" data-lahir="${e.tgl_lahir}" data-alamat="${e.alamat}" data-nik="${e.no_pengenal == null ? '' : e.no_pengenal}" data-gender="${e.jenis_kelamin}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>`;

                    });

                    $('#daftarPasienTriaseModal table tbody').html(html);
                    $('#list-pasien-triase').dataTable();
                    $('#daftarPasienTriaseModal').modal('show');

                    // let umur = hitungUmur(data.tgl_lahir);
                    // $('#usia_tahun').val(umur.tahun);
                    // $('#usia_bulan').val(umur.bulan);
                    // $('#usia_tahun').prop('readonly', true);
                    // $('#usia_bulan').prop('readonly', true);
                }
            },
            error: function (xhr, status, error) {
                showToast('error', 'Internal server error');
            }
        });
    });

    // Search name
    $('#button-alamat-pasien').click(function (e) {

        let $this = $(this);
        let $alamatEl = $('#alamat_pasien');
        let alamatPasien = $alamatEl.val();

        if (alamatPasien.length > 0) {
            let nowDate = getWaktuSekarang();
            $('#tgl_masuk').val(nowDate.formatTanggal);
            $('#jam_masuk').val(nowDate.formatWaktu);

        } else {
            showToast('error', 'Alamat Pasien tidak boleh kosong!');

            $('#no_rm_label').text('');
            $('input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
            $('input, select').prop('readonly', false);

            return false;
        }


        $.ajax({
            type: "post",
            url: "{{ route('gawat-darurat.get-patient-byalamat-ajax') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'alamat': alamatPasien
            },
            dataType: "json",
            beforeSend: function () {
                // Ubah teks tombol dan tambahkan spinner
                $alamatEl.prop('disabled', true);
                $this.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
            },
            complete: function () {
                // Ubah teks tombol jadi icon search dan disable nonaktif
                $alamatEl.prop('disabled', false);
                $this.html('<i class="ti ti-search"></i>');
                $this.prop('disabled', false);
            },
            success: function (res) {
                showToast(res.status, res.message);


                if (res.status == 'success') {
                    let data = res.data;

                    let html = '';
                    $.each(data, function (i, e) {
                        html += `<tr>
                                        <td align="middle">${i + 1}</td>
                                        <td align="middle">${e.kd_pasien}</td>
                                        <td>${e.nama}</td>
                                        <td align="middle">${e.no_pengenal != null ? e.no_pengenal : '-'}</td>
                                        <td align="middle">${hitungUmur(e.tgl_lahir).tahun}</td>
                                        <td>${e.alamat}</td>
                                        <td align="middle">
                                            <button class="btn btn-sm btn-success btn-select-pasien" data-rm="${e.kd_pasien}" data-nama="${e.nama}" data-lahir="${e.tgl_lahir}" data-alamat="${e.alamat}" data-nik="${e.no_pengenal == null ? '' : e.no_pengenal}" data-gender="${e.jenis_kelamin}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>`;

                    });

                    $('#daftarPasienTriaseModal table tbody').html(html);
                    $('#list-pasien-triase').dataTable();
                    $('#daftarPasienTriaseModal').modal('show');

                    // let umur = hitungUmur(data.tgl_lahir);
                    // $('#usia_tahun').val(umur.tahun);
                    // $('#usia_bulan').val(umur.bulan);
                    // $('#usia_tahun').prop('readonly', true);
                    // $('#usia_bulan').prop('readonly', true);
                }
            },
            error: function (xhr, status, error) {
                showToast('error', 'Internal server error');
            }
        });
    });

    $('#daftarPasienTriaseModal').on('click', '.btn-select-pasien', function () {
        let $this = $(this);
        let rm = $this.attr('data-rm');
        let nama = $this.attr('data-nama');
        let lahir = $this.attr('data-lahir');
        let alamat = $this.attr('data-alamat');
        let nik = $this.attr('data-nik');
        let gender = $this.attr('data-gender');

        // set value
        $('#no_rm_label').text(rm);
        $('#no_rm').val(rm);

        $('#nama_pasien').val(nama);
        $('#nama_pasien').prop('readonly', true);

        $('#alamat_pasien').val(alamat);
        $('#alamat_pasien').prop('readonly', true);

        $('#jenis_kelamin').val(gender);
        $('#jenis_kelamin').prop('readonly', true);

        let umur = hitungUmur(lahir);
        $('#usia_tahun').val(umur.tahun);
        $('#usia_bulan').val(umur.bulan);
        $('#usia_tahun').prop('readonly', true);
        $('#usia_bulan').prop('readonly', true);

        $('#daftarPasienTriaseModal').modal('hide');
    });
</script>