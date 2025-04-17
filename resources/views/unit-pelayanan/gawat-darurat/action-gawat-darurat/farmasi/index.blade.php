@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* .header-background { background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");} */
        .modal-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
    }
    
    #editObatModal {
        z-index: 1060;
    }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep"
                                    type="button" role="tab" aria-controls="resep" aria-selected="true">E-Resep Obat &
                                    BMHP</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat"
                                    type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat
                                    Penggunaan Obat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="rekonsiliasi-tab" data-bs-toggle="tab" data-bs-target="#rekonsiliasi"
                                    type="button" role="tab" aria-controls="rekonsiliasi" aria-selected="false">Rekonsiliasi Obat</button>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel" aria-labelledby="resep-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.tabsresep')
                            </div>
                            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.tabsriwayat')
                            </div>
                            <div class="tab-pane fade" id="rekonsiliasi" role="tabpanel" aria-labelledby="rekonsiliasi-tab">
                                {{-- TAB 3. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.tabsrekonsiliasi')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
        $(document).ready(function() {


            // Simpan tab aktif ke localStorage saat tab berubah
            $('#myTab .nav-link').on('shown.bs.tab', function (e) {
                const activeTabId = $(e.target).attr('id'); // Misal: resep-tab, riwayat-tab, rekonsiliasi-tab
                localStorage.setItem('activeMainTab', activeTabId);
            });

            // Pulihkan tab aktif saat halaman dimuat
            const savedTab = localStorage.getItem('activeMainTab');
            if (savedTab) {
                $(`#${savedTab}`).tab('show'); // Aktifkan tab yang tersimpan
            }

            // ------------ 1. Variabel Global dan Inisialisasi ------------ //
            let daftarObat = [];
            let activeTab = 'Non Racikan';
            let selectedDokter;

            const dokterSelect = $('#dokterPengirim');

            @can('is-admin')
                // Enable the select field for admins
                dokterSelect
                    .prop('disabled', false)
                    .css({
                        'pointer-events': 'auto',
                        'background-color': '#ffffff',
                        'cursor': 'pointer'
                    })
                    .removeAttr('tabindex');
                
                // Update selectedDokter when admin changes the selection
                dokterSelect.on('change', function() {
                    selectedDokter = $(this).val();
                });
            @else
                // Keep disabled state for non-admin users
                dokterSelect
                    .prop('disabled', true)
                    .css({
                        'pointer-events': 'none',
                        'background-color': '#e9ecef',
                        'cursor': 'not-allowed'
                    })
                    .attr('tabindex', '-1');
            @endcan

            // Initialize selectedDokter with the current value
            selectedDokter = dokterSelect.val();

            $('#tambahResep').on('show.bs.modal', function () {
                selectedDokter = dokterSelect.val();
            });

            // ------------ 2. Event Listener untuk Pengguna ------------ //
            $('#obatTabs .nav-link').on('shown.bs.tab', function (e) {
                activeTab = $(e.target).text().trim();
            });

            // Fungsi untuk menambahkan obat ke daftar dan menampilkan di tabel
            $('#tambahObatNonRacikan, #tambahObatRacikan').on('click', function() {
                var obatName = $('#cariObat').val();
                var obatId = $('#selectedObatId').val();
                var dosis = $('#dosis').val();
                var frekuensi = $('#frekuensi').val();
                var jumlah = $('#jumlah').val();
                var sebelumSesudahMakan = $('#sebelumSesudahMakan').val();
                var aturanTambahan = $('#aturanTambahan').val();
                var satuanObat = $('#satuanObat').val();
                var hargaObat = parseFloat($('#hargaObat').val());
                var catracikan = $('#cat_racikan').val();

                if (!obatId) {
                    iziToast.error({
                        title: 'Error',
                        message: "Pilih obat terlebih dahulu.",
                        position: 'topRight'
                    });
                    return;
                }

                if (!jumlah || isNaN(jumlah)) {
                    iziToast.error({
                        title: 'Error',
                        message: "Masukkan Jumlah Obat.",
                        position: 'topRight'
                    });
                    return;
                }

                // Cek jika obat sudah ada dalam daftar
                const exists = daftarObat.some(obat => obat.id === obatId);
                if (exists) {
                    iziToast.warning({
                        title: 'Perhatian',
                        message: "Obat sudah ada dalam daftar.",
                        position: 'topRight'
                    });
                    return;
                }

                // tAMBAH ke daftar obat
                daftarObat.push({
                    id: obatId,
                    nama: obatName,
                    dosis: dosis,
                    frekuensi: frekuensi,
                    jumlah: parseInt(jumlah),
                    sebelumSesudahMakan: sebelumSesudahMakan,
                    aturanTambahan: aturanTambahan,
                    harga: hargaObat,
                    satuan: satuanObat,
                    jenisObat: activeTab,
                    kd_dokter: selectedDokter
                });

                renderDaftarObat();
                resetInputObat();
            });


            $(document).on('click', '.copy-obat', function() {
                var obatData = $(this).data('obat');
                $('#modal-overlay').show();

                var editModal = new bootstrap.Modal($('#editObatModal'), {
                    backdrop: 'static',
                });
                editModal.show();

                $('#editObatModal').css({
                    'position': 'absolute',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });

                openEditModal(obatData);
            });

            $('#editObatModal').on('hidden.bs.modal', function () {
                // Sembunyikan overlay ketika modal edit ditutup
                $('#modal-overlay').hide();
            });

            function openEditModal(obatData) {
                var caraPakai = obatData.cara_pakai ? obatData.cara_pakai.split(',') : [];
                var frekuensi = caraPakai[0] ? caraPakai[0].trim() : 'N/A';
                var sebelumSesudahMakan = caraPakai[1] ? caraPakai[1].trim() : 'N/A';

                // Isi modal edit dengan data obat dari elemen yang diklik
                $('#editNamaObat').val(obatData.nama_obat || 'Tidak ada informasi');
                $('#editJumlahHari').val(obatData.jumlah_hari || '7');
                $('#editFrekuensi').val(frekuensi || '');
                $('#editDosis').val(obatData.jumlah_takaran || '');
                $('#editSatuanObat').val(obatData.satuan_takaran || '');
                $('#editJumlah').val(parseInt(obatData.jumlah) || 1);
                $('#editSebelumSesudahMakan').val(sebelumSesudahMakan || 'Sesudah Makan');
                $('#editKeterangan').val(obatData.ket || '');

                $('#saveEditObat').off('click');

                $('#saveEditObat').on('click', function() {
                    saveEditedObat(obatData);
                });

                $('#editObatModal').modal('show');
            }

            function saveEditedObat(originalObatData) {
                var editedData = {
                    id: originalObatData.kd_prd,
                    nama: originalObatData.nama_obat || 'Tidak ada informasi',
                    jumlah_hari: $('#editJumlahHari').val(),
                    frekuensi: $('#editFrekuensi').val(),
                    dosis: $('#editDosis').val(),
                    satuan: $('#editSatuanObat').val(),
                    jumlah: parseInt($('#editJumlah').val()),
                    sebelumSesudahMakan: $('#editSebelumSesudahMakan').val(),
                    aturanTambahan: $('#editKeterangan').val(),
                    harga: parseFloat(originalObatData.harga) || 0,
                    jenisObat: 'Non Racikan',
                    kd_dokter: selectedDokter
                };

                const existingIndex = daftarObat.findIndex(obat => obat.id === editedData.id);
                if (existingIndex !== -1) {
                    // Update obat yang sudah ada
                    daftarObat[existingIndex] = editedData;
                    iziToast.info({
                        title: 'Info',
                        message: 'Obat sudah ada dalam daftar dan telah diperbarui.',
                        position: 'topRight'
                    });
                } else {
                    // Tambahkan obat baru ke daftar
                    daftarObat.push(editedData);
                    iziToast.success({
                        title: 'Sukses',
                        message: 'Obat berhasil ditambahkan ke daftar.',
                        position: 'topRight'
                    });
                }
                renderDaftarObat();
                $('#editObatModal').modal('hide');
                $('#modal-overlay').hide();
            }


            // ------------ 3. Fungsi CRUD Obat (Tambah, Hapus, Render) ------------ //
            function renderDaftarObat() {
                var tbody = $('#daftarObatBody');
                tbody.empty();

                let totalBiaya = 0;

                daftarObat.forEach(function(obat, index) {
                    let subtotal = obat.harga * obat.jumlah;
                    totalBiaya += subtotal;

                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${obat.jenisObat}</td>
                            <td>${obat.nama}</td>
                            <td>${obat.dosis} ${obat.satuan}</td>
                            <td>${obat.frekuensi}</td>
                            <td>${obat.jumlah}</td>
                            <td>${obat.sebelumSesudahMakan}</td>
                            <td>${obat.aturanTambahan || '-'}</td>
                            <td>Rp. ${subtotal.toLocaleString()}</td>
                            <td><button class="btn btn-danger btn-sm" onclick="removeObat(${index})">X</button></td>
                        </tr>
                    `);
                });

                // Tampilkan total item dan biaya
                $('.fw-bold:contains("Jumlah Item Obat")').text(`Jumlah Item Obat: ${daftarObat.length}`);
                $('.fw-bold:contains("Total Biaya Obat")').text(`Total Biaya Obat: Rp. ${totalBiaya.toLocaleString()}`);
            }

            // Fungsi untuk menghapus obat dari daftar
            window.removeObat = function(index) {
                daftarObat.splice(index, 1);
                renderDaftarObat();
            };

            // ------------ 4. Fungsi AJAX untuk Pengiriman Data ke Server ------------ //
            $(document).on('submit', '#resepForm', function(e) {
                e.preventDefault();

                // Validasi form sebelum mengirim
                if (daftarObat.length === 0) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Silakan tambahkan minimal satu obat sebelum mengirim resep.',
                        position: 'topRight'
                    });
                    return;
                }

                $('#loadingIndicator').removeClass('d-none');
                $('#orderButton').prop('disabled', true);

                var tanggal = $('#tanggalOrder').val();
                var waktu = $('#jamOrder').val();
                var tglOrder = formatDateTime(tanggal, waktu);
                var catRacikan = $('#cat_racikan').val();


                var formData = {
                    urut_masuk: "{{ $dataMedis->urut_masuk }}",
                    kd_dokter: selectedDokter,
                    tgl_order: tanggal,
                    jam_order: waktu,
                    cat_racikan: catRacikan,
                    obat: daftarObat.map(obat => ({
                        id: obat.id,
                        frekuensi: obat.frekuensi,
                        jumlah: obat.jumlah,
                        dosis: obat.dosis,
                        sebelumSesudahMakan: obat.sebelumSesudahMakan,
                        aturanTambahan: obat.aturanTambahan,
                        satuan: obat.satuan,
                    }))
                };

                // console.log('Sending data:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#loadingIndicator').addClass('d-none');
                        $('#orderButton').prop('disabled', false);

                        iziToast.success({
                            title: 'Sukses',
                            message: 'Resep berhasil disimpan dengan ID: ' + response.id_mrresep,
                            position: 'topRight'
                        });
                        daftarObat = [];
                        renderDaftarObat();
                        $('#resepForm')[0].reset();
                        $('#dokterPengirim').prop('disabled', false);
                        selectedDokter = null;

                        // Tutup modal dan refresh halaman
                        $('#tambahResep').modal('hide');
                        location.reload();
                    },
                    
                    error: function(xhr, status, error) {
                        $('#loadingIndicator').addClass('d-none');
                        $('#orderButton').prop('disabled', false);
                        var errorMessage = 'Terjadi kesalahan saat menyimpan resep.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += ' ' + xhr.responseJSON.message;
                        }
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = 'Validasi gagal:\n';
                            for (let field in xhr.responseJSON.errors) {
                                errorMessage += `${field}: ${xhr.responseJSON.errors[field].join(', ')}\n`;
                            }
                        }
                        alert(errorMessage);
                    }
                });
            });

            $(document).on('click', '#orderButton', function(e) {
                e.preventDefault();
                $('#resepForm').submit();
            });

            // ------------ 5. Fungsi Pendukung (Helper) ------------ //
            const cariObat = $('#cariObat');
            const clearObat = $('#clearObat');
            const obatList = $('#obatList');
            const selectedObatId = $('#selectedObatId');
            const satuanObat = $('#satuanObat');

            let searchTimeout;
            let lastQuery = '';
            let isSearching = false;

            cariObat.on('input', function() {
                const query = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length === 0) {
                    obatList.empty();
                    return;
                }
                
                if (query.length < 2) {
                    obatList.html('<div class="list-group-item text-muted">Ketik minimal 2 karakter...</div>');
                    return;
                }
                
                if (query === lastQuery) return;
                
                if (!isSearching) {
                    obatList.html(`
                        <div class="list-group-item text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);
                }
                
                searchTimeout = setTimeout(() => {
                    lastQuery = query;
                    isSearching = true;
                    
                    $.ajax({
                        url: '{{ route('farmasi.searchObat', ['kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk]) }}',
                        method: 'GET',
                        data: { term: query },
                        success: function(data) {
                            isSearching = false;
                            
                            if (query !== cariObat.val().trim()) return;
                            
                            let html = '';
                            if (data.length > 0) {
                                data.forEach(function(obat) {
                                    html += `
                                        <a href="#" class="list-group-item list-group-item-action py-2" 
                                        data-id="${obat.id}" 
                                        data-harga="${obat.harga}" 
                                        data-satuan="${obat.satuan}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-medium">${obat.text}</div>
                                                <small class="text-muted">Satuan: ${obat.satuan}</small>
                                            </div>
                                        </a>`;
                                });
                            } else {
                                html = '<div class="list-group-item text-muted">Tidak ada hasil yang ditemukan</div>';
                            }
                            obatList.html(html);
                        },
                        error: function() {
                            isSearching = false;
                            if (query === cariObat.val().trim()) {
                                obatList.html('<div class="list-group-item text-danger">Terjadi kesalahan saat mencari obat</div>');
                            }
                        }
                    });
                }, 300);
            });

            // Item selection dengan update satuan otomatis
            $(document).on('click', '#obatList a', function(e) {
                e.preventDefault();
                const $this = $(this);
                const obatSatuan = $this.data('satuan').toLowerCase();
                
                cariObat.val($this.find('.fw-medium').text()).prop('readonly', true);
                selectedObatId.val($this.data('id'));
                $('#hargaObat').val($this.data('harga'));
                
                // Update satuan obat berdasarkan data dari database
                const satuanMapping = {
                    'tablet': 'tablet',
                    'tab': 'tablet',
                    'kapsul': 'kapsul',
                    'caps': 'kapsul',
                    'botol': 'cc',
                    'btl': 'cc',
                    'bungkus': 'bungkus',
                    'bks': 'bungkus',
                    'ampul': 'ampul',
                    'amp': 'ampul',
                    'pcs': 'unit',
                    'unit': 'unit',
                    'tetes': 'tetes',
                    'cc': 'cc',
                    'ml': 'cc'
                };

                const matchedSatuan = satuanMapping[obatSatuan] || 'tablet';
                satuanObat.val(matchedSatuan);
                
                obatList.empty();
                clearObat.show();
            });

            clearObat.on('click', function() {
                cariObat.val('').prop('readonly', false).focus();
                selectedObatId.val('');
                $('#hargaObat').val('');
                clearObat.hide();
                obatList.empty();
            });

            function resetInputObat() {
                cariObat.val('').prop('readonly', false);
                selectedObatId.val('');
                $('#jumlah').val('12');
                $('#aturanTambahan').val('');
                $('#jumlahHari').val('');
                $('#hargaObat').val('');
                clearObat.hide();
                obatList.empty();
            }

            function resetInputObat() {
                $('#cariObat').val('').prop('readonly', false);
                $('#selectedObatId').val('');
                $('#jumlah').val('12');
                $('#aturanTambahan').val('');
                $('#jumlahHari').val('');
                $('#clearObat').hide();
                $('#obatList').html('');
            }


            //----------- Fungsi untuk menonaktifkan side column -------------//
            // const tab2 = document.getElementById('tab2-tab');
            // const sideColumn = document.getElementById('sideColumn');

            // function disableSideColumn() {
            //     sideColumn.style.pointerEvents = 'none';
            //     sideColumn.style.opacity = '0.5';
            //     sideColumn.style.backgroundColor = '#f0f0f0';
            // }

            // function enableSideColumn() {
            //     sideColumn.style.pointerEvents = 'auto';
            //     sideColumn.style.opacity = '1';
            //     sideColumn.style.backgroundColor = '';
            // }

            // tab2.addEventListener('shown.bs.tab', disableSideColumn);

            // document.querySelectorAll('.nav-tabs .nav-link:not(#tab2-tab)').forEach(tab => {
            //     tab.addEventListener('shown.bs.tab', enableSideColumn);
            // });
            //----------- End Fungsi untuk menonaktifkan side column---------- //

            function formatDateTime(date, time) {
                if (!date || !time) {
                    return '';
                }
                
                let formattedDate;
                if (date.includes('-')) {
                    formattedDate = date;
                } else if (date.includes('/')) {
                    const parts = date.split('/');
                    formattedDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                } else {
                    return '';
                }

                const formattedTime = time.length === 5 ? time + ':00' : time;
                return `${formattedDate} ${formattedTime}`;
            }

        });
    </script>
@endpush