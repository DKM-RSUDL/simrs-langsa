<script>
    // ===========================================
    // GLOBAL VARIABLES DAN DATA
    // ===========================================

    // Data instruksi PPA untuk setiap CPPT (dari blade)
    const cpptInstruksiPpaData = {
        @if(!empty($cppt) && empty($isEdit))
            @foreach ($cppt as $key => $value)
                            '{{ $value['urut_total'] }}': [
                @if (!empty($value['instruksi_ppa']))
                    @foreach ($value['instruksi_ppa'] as $instruksi)
                                                                {
                            ppa: '{{ $instruksi->ppa }}',
                            instruksi: '{{ addslashes($instruksi->instruksi) }}'
                        },
                    @endforeach
                @endif
                            ],
            @endforeach
        @endif
    };

    // Tambah diagnosis ke list
    let DiagnoseArrayTemp = []
    $('#addDiagnosisModal #btnAddListDiagnosa').off('click')
    .on('click', function (e) {
        e.preventDefault();
        var searchInputValue = $('#addDiagnosisModal #searchInput').val().trim();
        console.log("Tambah Data")

        if (searchInputValue != '') {
        // Cek apakah sudah ada
        var exists = false;
        $('#addDiagnosisModal #listDiagnosa li').each(function () {
            var liText = $(this).text().trim();
            if (liText === searchInputValue) {
            exists = true;
            return false;
            }
        });

        if (!exists) {
            // Hapus placeholder jika ada
            var firstLi = $('#addDiagnosisModal #listDiagnosa li:first');
            if (
            firstLi.length > 0 &&
            (
                firstLi.hasClass('text-muted') ||
                firstLi.hasClass('text-danger') ||
                firstLi.text().includes('Memuat') ||
                firstLi.text().includes('Tidak ada')
            )
            ) {
            firstLi.remove();
            }
            DiagnoseArrayTemp.push(searchInputValue)
            if (searchInputValue != '') {
                let ListData = $('#listDiagnosa')
                ListData.empty()
                   
                DiagnoseArray.map((item)=>{
                        ListData.append(`<li>${item}</li>`)
                })

                DiagnoseArrayTemp.map((item)=>{
                        ListData.append(`<li>${item}</li>`)
                })    

                $('#addDiagnosisModal #searchInput').val('');
                console.log("Temp Data :", searchInputValue,DiagnoseArrayTemp)
            }
        } else {
            if (typeof showToast === 'function') {
            showToast('warning', 'Diagnosis sudah ada dalam daftar!');
            } else {
            alert('Diagnosis sudah ada dalam daftar!');
            }
        }
        }
    });

    $(document).on('click', '.CancelDiagnose', function () {
        const isEdit_Adime = "{{ !empty($lastDiagnose) ? 1 : 0 }}"
        if (DiagnoseArrayTemp.length > 0) {
            DiagnoseArrayTemp = []
        }
        
    })

    // Data karyawan
    const instruksiPpaKaryawanData = {
        @if (isset($karyawan) && count($karyawan) > 0)
            @foreach ($karyawan as $item)
                @php
                    $nama_lengkap = '';
                    if (!empty($item->gelar_depan)) {
                        $nama_lengkap .= $item->gelar_depan . ' ';
                    }
                    $nama_lengkap .= $item->nama;
                    if (!empty($item->gelar_belakang)) {
                        $nama_lengkap .= ', ' . $item->gelar_belakang;
                    }
                    $nama_lengkap_escaped = str_replace("'", "\\'", $nama_lengkap);
                @endphp
                    '{{ $item->kd_karyawan }}': '{{ $nama_lengkap_escaped }}',
            @endforeach
        @endif
        };

    // Convert ke array untuk pencarian
    const karyawanArray = Object.keys(instruksiPpaKaryawanData).map(kode => ({
        kode: kode,
        nama: instruksiPpaKaryawanData[kode]
    }));

    // Global Variables untuk ADD Modal
    let addInstruksiPpaCounter = 0;
    let addInstruksiPpaData = [];
    let addSelectedPerawat = null;

    // Global Variables untuk EDIT Modal
    let editInstruksiPpaCounter = 0;
    let editInstruksiPpaData = [];
    let editSelectedPerawat = null;

    // Global Variables untuk edit CPPT
    var tanggal, urut, unit, button;
    var editDataListDiagnose = $('#editDiagnosisModal #dataList');
    var editSearchInputDiagnose = $('#editDiagnosisModal #searchInput');

    // ===========================================
    // HELPER FUNCTIONS
    // ===========================================

    function getPerawatNamaByKode(kode) {
        return instruksiPpaKaryawanData[kode] || kode;
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function (m) {
            return map[m];
        });
    }

    function showInstruksiAlert(type, message) {
        if (typeof showToast === 'function') {
            showToast(type, message);
        } else {
            console.log(`${type}: ${message}`);
        }
    }

    // Debug helper function
    // function debugInstruksiPpaData(context = '') {
    //     console.log(`=== DEBUG INSTRUKSI PPA (${context}) ===`);
    //     console.log('editInstruksiPpaData:', editInstruksiPpaData.length, 'items');
    //     console.log('tempEditInstruksiPpaData:', window.tempEditInstruksiPpaData ? window.tempEditInstruksiPpaData.length : 'undefined');
    //     console.log('editInstruksiPpaBackup:', window.editInstruksiPpaBackup ? window.editInstruksiPpaBackup.length : 'undefined');
    //     console.log('currentEditInstruksiPpaData:', window.currentEditInstruksiPpaData ? window.currentEditInstruksiPpaData.length : 'undefined');
    //     console.log('===========================================');
    // }

    // ===========================================
    // ADD MODAL FUNCTIONS
    // ===========================================

    function initAddInstruksiPpaSearchableSelect() {
        const searchInput = $('#instruksi_ppa_search_input');
        const dropdown = $('#instruksi_ppa_dropdown');
        const hiddenInput = $('#instruksi_ppa_selected_value');

        // Clear previous events
        searchInput.off('input focus blur keydown');
        dropdown.off('click mouseenter');

        // Event ketik di input
        searchInput.on('input', function () {
            const query = $(this).val().toLowerCase();
            filterAddKaryawan(query);
        });

        // Event focus - tampilkan dropdown
        searchInput.on('focus', function () {
            dropdown.show();
            filterAddKaryawan($(this).val().toLowerCase());
        });

        // Event blur - sembunyikan dropdown setelah delay
        searchInput.on('blur', function () {
            setTimeout(() => {
                dropdown.hide();
            }, 200);
        });

        // Event keydown untuk navigasi
        searchInput.on('keydown', function (e) {
            const items = dropdown.find('.dropdown-item:visible');
            const active = dropdown.find('.dropdown-item.active');

            if (e.keyCode === 40) {
                e.preventDefault();
                if (active.length === 0) {
                    items.first().addClass('active');
                } else {
                    active.removeClass('active');
                    const next = active.nextAll('.dropdown-item:visible').first();
                    if (next.length > 0) {
                        next.addClass('active');
                    } else {
                        items.first().addClass('active');
                    }
                }
            } else if (e.keyCode === 38) {
                e.preventDefault();
                if (active.length === 0) {
                    items.last().addClass('active');
                } else {
                    active.removeClass('active');
                    const prev = active.prevAll('.dropdown-item:visible').first();
                    if (prev.length > 0) {
                        prev.addClass('active');
                    } else {
                        items.last().addClass('active');
                    }
                }
            } else if (e.keyCode === 13) {
                e.preventDefault();
                if (active.length > 0) {
                    active.click();
                }
            }
        });

        generateAddDropdownItems();
    }

    function generateAddDropdownItems() {
        const dropdown = $('#instruksi_ppa_dropdown');
        dropdown.empty();

        dropdown.append(`
            <div class="dropdown-item" data-kode="" data-nama="">
                <span class="text-muted">-- Pilih Perawat/PPA --</span>
            </div>
        `);

        karyawanArray.forEach(item => {
            dropdown.append(`
                <div class="dropdown-item" data-kode="${item.kode}" data-nama="${escapeHtml(item.nama)}">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    ${escapeHtml(item.nama)}
                </div>
            `);
        });

        dropdown.on('click', '.dropdown-item', function () {
            const kode = $(this).data('kode');
            const nama = $(this).data('nama');
            selectAddPerawat(kode, nama);
            dropdown.hide();
        });

        dropdown.on('mouseenter', '.dropdown-item', function () {
            dropdown.find('.dropdown-item.active').removeClass('active');
            $(this).addClass('active');
        });
    }

    function filterAddKaryawan(query) {
        const dropdown = $('#instruksi_ppa_dropdown');
        const items = dropdown.find('.dropdown-item');

        if (query === '') {
            items.show();
            return;
        }

        items.each(function () {
            const nama = $(this).text().toLowerCase();
            if (nama.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        dropdown.find('.dropdown-item.active').removeClass('active');
    }

    function selectAddPerawat(kode, nama) {
        const searchInput = $('#instruksi_ppa_search_input');
        const hiddenInput = $('#instruksi_ppa_selected_value');

        addSelectedPerawat = kode ? {
            kode: kode,
            nama: nama
        } : null;

        searchInput.val(nama || '');
        hiddenInput.val(kode || '');

        if (kode) {
            searchInput.removeClass('is-invalid').addClass('is-valid');
        } else {
            searchInput.removeClass('is-valid is-invalid');
        }
    }

    function updateAddInstruksiPpaTable() {
        const tbody = $('#instruksi_ppa_table_body');
        tbody.empty();

        if (addInstruksiPpaData.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada instruksi yang ditambahkan
                    </td>
                </tr>
            `);
        } else {
            addInstruksiPpaData.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center fw-bold">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                <div>
                                    <strong>${escapeHtml(item.perawat_nama)}</strong><br>
                                    <small class="text-muted">${escapeHtml(item.perawat_kode)}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">${escapeHtml(item.instruksi)}</div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="hapusAddInstruksiPpa(${item.id})"
                                    title="Hapus Instruksi">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }
    }

    function updateAddInstruksiPpaHiddenInputs() {
        const container = $('#instruksi_ppa_hidden_inputs');

        container.empty();

        addInstruksiPpaData.forEach((item, index) => {
            container.append(`
                <input type="hidden" name="perawat_kode[]" value="${escapeHtml(item.perawat_kode)}">
                <input type="hidden" name="perawat_nama[]" value="${escapeHtml(item.perawat_nama)}">
                <input type="hidden" name="instruksi_text[]" value="${escapeHtml(item.instruksi)}">
            `);
        });

         $('#instruksi_ppa_json_input').val(JSON.stringify(addInstruksiPpaData));
    }

    function updateAddInstruksiPpaCountBadge() {
        const count = addInstruksiPpaData.length;
        const badge = $('#instruksi_ppa_count_badge');

        badge.text(count);
        badge.removeClass('bg-primary bg-success bg-warning bg-danger bg-secondary');

        if (count === 0) {
            badge.addClass('bg-secondary');
        } else if (count <= 2) {
            badge.addClass('bg-success');
        } else if (count <= 5) {
            badge.addClass('bg-primary');
        } else {
            badge.addClass('bg-warning');
        }
    }

    function resetAddInstruksiPpaData() {
        addInstruksiPpaData = [];
        addInstruksiPpaCounter = 0;
        addSelectedPerawat = null;

        updateAddInstruksiPpaTable();
        updateAddInstruksiPpaCountBadge();

        selectAddPerawat('', '');
        $('#instruksi_ppa_text_input').val('');
    }

    function hapusAddInstruksiPpa(id) {
        const instruksi = addInstruksiPpaData.find(item => item.id === id);
        if (!instruksi) return;

        if (confirm(`Apakah Anda yakin ingin menghapus instruksi untuk: ${instruksi.perawat_nama}?`)) {
            addInstruksiPpaData = addInstruksiPpaData.filter(item => item.id !== id);
            updateAddInstruksiPpaTable();
            updateAddInstruksiPpaHiddenInputs();
            updateAddInstruksiPpaCountBadge();
            showInstruksiAlert('success', 'Instruksi berhasil dihapus!');
        }
    }

    /* Diagnosis Loader Helper */
    function ensureDiagnosisLoader() {
        if (!$('#diagnosisLoader').length) {
            $('body').append(`
                    <div id="diagnosisLoader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                        background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
                        <div class="loader-box" style="background: white; padding: 30px; border-radius: 10px; text-align: center;">
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <h6 class="mb-1 text-primary fw-bold" id="diagnosisLoaderTitle">Memuat Data...</h6>
                            <small class="text-muted d-block" id="diagnosisLoaderDesc">Silakan tunggu sebentar</small>
                            <div class="progress mt-3" style="height: 5px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                `);
        }
    }

    function showDiagnosisLoading(title = 'Memuat Data...', desc = 'Silakan tunggu sebentar') {
        ensureDiagnosisLoader();
        $('#diagnosisLoaderTitle').text(title);
        $('#diagnosisLoaderDesc').text(desc);
        $('#diagnosisLoader').css('display', 'flex').hide().fadeIn(200);
    }

    function hideDiagnosisLoading(delay = 200) {
        setTimeout(() => $('#diagnosisLoader').fadeOut(200), delay);
    }

    // ===========================================
    // EDIT MODAL FUNCTIONS
    // ===========================================

    function initEditInstruksiPpaSearchableSelect() {
        const searchInput = $('#edit_instruksi_ppa_search_input');
        const dropdown = $('#edit_instruksi_ppa_dropdown');
        const hiddenInput = $('#edit_instruksi_ppa_selected_value');

        // Clear previous events
        searchInput.off('input focus blur keydown');
        dropdown.off('click mouseenter');

        // Event ketik di input
        searchInput.on('input', function () {
            const query = $(this).val().toLowerCase();
            filterEditKaryawan(query);
        });

        // Event focus - tampilkan dropdown
        searchInput.on('focus', function () {
            dropdown.show();
            filterEditKaryawan($(this).val().toLowerCase());
        });

        // Event blur - sembunyikan dropdown setelah delay
        searchInput.on('blur', function () {
            setTimeout(() => {
                dropdown.hide();
            }, 200);
        });

        // Event keydown untuk navigasi
        searchInput.on('keydown', function (e) {
            const items = dropdown.find('.dropdown-item:visible');
            const active = dropdown.find('.dropdown-item.active');

            if (e.keyCode === 40) {
                e.preventDefault();
                if (active.length === 0) {
                    items.first().addClass('active');
                } else {
                    active.removeClass('active');
                    const next = active.nextAll('.dropdown-item:visible').first();
                    if (next.length > 0) {
                        next.addClass('active');
                    } else {
                        items.first().addClass('active');
                    }
                }
            } else if (e.keyCode === 38) {
                e.preventDefault();
                if (active.length === 0) {
                    items.last().addClass('active');
                } else {
                    active.removeClass('active');
                    const prev = active.prevAll('.dropdown-item:visible').first();
                    if (prev.length > 0) {
                        prev.addClass('active');
                    } else {
                        items.last().addClass('active');
                    }
                }
            } else if (e.keyCode === 13) {
                e.preventDefault();
                if (active.length > 0) {
                    active.click();
                }
            }
        });

        generateEditDropdownItems();
    }

    function generateEditDropdownItems() {
        const dropdown = $('#edit_instruksi_ppa_dropdown');
        dropdown.empty();

        dropdown.append(`
            <div class="dropdown-item" data-kode="" data-nama="">
                <span class="text-muted">-- Pilih Perawat/PPA --</span>
            </div>
        `);

        karyawanArray.forEach(item => {
            dropdown.append(`
                <div class="dropdown-item" data-kode="${item.kode}" data-nama="${escapeHtml(item.nama)}">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    ${escapeHtml(item.nama)}
                </div>
            `);
        });

        dropdown.on('click', '.dropdown-item', function () {
            const kode = $(this).data('kode');
            const nama = $(this).data('nama');
            selectEditPerawat(kode, nama);
            dropdown.hide();
        });

        dropdown.on('mouseenter', '.dropdown-item', function () {
            dropdown.find('.dropdown-item.active').removeClass('active');
            $(this).addClass('active');
        });
    }

    function filterEditKaryawan(query) {
        const dropdown = $('#edit_instruksi_ppa_dropdown');
        const items = dropdown.find('.dropdown-item');

        if (query === '') {
            items.show();
            return;
        }

        items.each(function () {
            const nama = $(this).text().toLowerCase();
            if (nama.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        dropdown.find('.dropdown-item.active').removeClass('active');
    }

    function selectEditPerawat(kode, nama) {
        const searchInput = $('#edit_instruksi_ppa_search_input');
        const hiddenInput = $('#edit_instruksi_ppa_selected_value');

        editSelectedPerawat = kode ? {
            kode: kode,
            nama: nama
        } : null;

        searchInput.val(nama || '');
        hiddenInput.val(kode || '');

        if (kode) {
            searchInput.removeClass('is-invalid').addClass('is-valid');
        } else {
            searchInput.removeClass('is-valid is-invalid');
        }
    }

    function updateEditInstruksiPpaTable() {
        const tbody = $('#edit_instruksi_ppa_table_body');
        tbody.empty();

        if (editInstruksiPpaData.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada instruksi yang ditambahkan
                    </td>
                </tr>
            `);
        } else {
            editInstruksiPpaData.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center fw-bold">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                <div>
                                    <strong>${escapeHtml(item.perawat_nama)}</strong><br>
                                    <small class="text-muted">${escapeHtml(item.perawat_kode)}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">${escapeHtml(item.instruksi)}</div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="hapusEditInstruksiPpa(${item.id})"
                                    title="Hapus Instruksi">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }
    }

    function updateEditInstruksiPpaHiddenInputs() {
        const container = $('#edit_instruksi_ppa_hidden_inputs');
        container.empty();

        editInstruksiPpaData.forEach((item, index) => {
            container.append(`
                <input type="hidden" name="perawat_kode[]" value="${escapeHtml(item.perawat_kode)}">
                <input type="hidden" name="perawat_nama[]" value="${escapeHtml(item.perawat_nama)}">
                <input type="hidden" name="instruksi_text[]" value="${escapeHtml(item.instruksi)}">
            `);
        });
    }

    function updateEditInstruksiPpaCountBadge() {
        const count = editInstruksiPpaData.length;
        const badge = $('#edit_instruksi_ppa_count_badge');

        badge.text(count);
        badge.removeClass('bg-primary bg-success bg-warning bg-danger bg-secondary');

        if (count === 0) {
            badge.addClass('bg-secondary');
        } else if (count <= 2) {
            badge.addClass('bg-success');
        } else if (count <= 5) {
            badge.addClass('bg-primary');
        } else {
            badge.addClass('bg-warning');
        }
    }

    function loadEditInstruksiPpaFromAjaxData(instruksiPpaArray) {
        // console.log('Loading instruksi PPA data:', instruksiPpaArray);

        // Reset data
        editInstruksiPpaData = [];
        editInstruksiPpaCounter = 0;

        if (instruksiPpaArray && Array.isArray(instruksiPpaArray)) {
            instruksiPpaArray.forEach(function (item) {
                editInstruksiPpaCounter++;
                editInstruksiPpaData.push({
                    id: editInstruksiPpaCounter,
                    perawat_kode: item.ppa,
                    perawat_nama: getPerawatNamaByKode(item.ppa),
                    instruksi: item.instruksi,
                    created_at: new Date().toLocaleString('id-ID')
                });

               
            });
        }

        // Update tampilan
        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaHiddenInputs();
        updateEditInstruksiPpaCountBadge();

        // CRITICAL: Simpan sebagai backup
        window.editInstruksiPpaBackup = JSON.parse(JSON.stringify(editInstruksiPpaData));

        // console.log('Instruksi PPA berhasil dimuat:', editInstruksiPpaData.length, 'items');
    }

    function ensureEditInstruksiPpaData() {
        if ((!editInstruksiPpaData || editInstruksiPpaData.length === 0) &&
            window.editInstruksiPpaBackup && window.editInstruksiPpaBackup.length > 0) {

            // console.log('Mengembalikan data PPA dari backup...');
            editInstruksiPpaData = JSON.parse(JSON.stringify(window.editInstruksiPpaBackup));
            updateEditInstruksiPpaTable();
            updateEditInstruksiPpaHiddenInputs();
            updateEditInstruksiPpaCountBadge();
        }
    }

    function resetEditInstruksiPpaData() {
        editInstruksiPpaData = [];
        editInstruksiPpaCounter = 0;
        editSelectedPerawat = null;

        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaCountBadge();

        selectEditPerawat('', '');
        $('#edit_instruksi_ppa_text_input').val('');

        // Clear backups
        delete window.editInstruksiPpaBackup;
        delete window.tempEditInstruksiPpaData;
        delete window.currentEditInstruksiPpaData;
    }

    function hapusEditInstruksiPpa(id) {
        const instruksi = editInstruksiPpaData.find(item => item.id === id);
        if (!instruksi) return;

        if (confirm(`Apakah Anda yakin ingin menghapus instruksi untuk: ${instruksi.perawat_nama}?`)) {
            editInstruksiPpaData = editInstruksiPpaData.filter(item => item.id !== id);
            updateEditInstruksiPpaTable();
            updateEditInstruksiPpaHiddenInputs();
            updateEditInstruksiPpaCountBadge();

            // Update backup
            window.editInstruksiPpaBackup = JSON.parse(JSON.stringify(editInstruksiPpaData));

            showInstruksiAlert('success', 'Instruksi berhasil dihapus!');
        }
    }

    // ===========================================
    // CPPT FUNCTIONS (ADD)
    // ===========================================

    // add
    var searchInputDiagnose = $('#addDiagnosisModal #searchInput');
    var dataListDiagnose = $('#addDiagnosisModal #dataList');

    // Function BARU untuk load dari database (hanya dipanggil jika form kosong)
    function loadPreviousDiagnosesFromDatabase(first=false) {
        $('#addDiagnosisModal #listDiagnosa').html('<li class="text-muted">Memuat diagnosis...</li>');

        showDiagnosisLoading('Mengambil Diagnosis Terakhir', 'Memuat riwayat diagnosis...');

        $.ajax({
            url: '{{ route("rawat-inap.cppt.get-last-diagnoses", [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                kd_unit: '{{ $dataMedis->kd_unit }}',
                kd_pasien: '{{ $dataMedis->kd_pasien }}',
                tgl_masuk: '{{ date("Y-m-d", strtotime($dataMedis->tgl_masuk)) }}',
                urut_masuk: '{{ $dataMedis->urut_masuk }}'
            },
            success: function (response) {
                // console.log('Response dari database:', response);

                $('#addDiagnosisModal #listDiagnosa').empty();

                if (response.status === 'success' && response.data && response.data.length > 0) {
                    // console.log('Jumlah diagnosis dari DB:', response.data.length);

                    // response.data.forEach(function (diagnosis, index) {
                    //     // console.log('Menambah diagnosis ke-' + (index + 1) + ':', diagnosis);
                    //     $('#addDiagnosisModal #listDiagnosa').append(`<li>${escapeHtml(diagnosis)}</li>`);
                    // });
                    
                    if(first){
                        const dignoseListContent = render_list_diagonis_content(response.data)
                        const ListData = $('#diagnoseList');
                        
                        ListData.empty()
                        DiagnoseArray = response.data
                        ListData.html(dignoseListContent);

                        setupDiagnosisDrag(ListData)
                    }
                   

                    // console.log('Total <li> di modal:', $('#addDiagnosisModal #listDiagnosa li').length);
                } else {
                    $('#addDiagnosisModal #listDiagnosa').append('<li class="text-muted">Tidak ada diagnosis sebelumnya</li>');
                }
            },
            error: function (xhr, status, error) {
                // console.error('Error loading previous diagnoses:', error);
                $('#addDiagnosisModal #listDiagnosa').empty();
                $('#addDiagnosisModal #listDiagnosa').append('<li class="text-danger">Gagal memuat data</li>');
            },
            complete: function () {
                hideDiagnosisLoading();
            }
        });
    }



    // Simpan diagnosis dari modal ke form
    function setupDiagnosisDrag($container) {
        setTimeout(() => {
            const el = $container[0];
            if (el?.sortable) el.sortable.destroy();

            el.sortable = Sortable.create(el, {
                animation: 180,
                handle: '.drag-handle',
                ghostClass: 'bg-primary',
                onEnd: () => {
                    $container.find('.diag-item-wrap').each(function (i) {
                        $(this).find('.order-input').val(i);
                        $(this).find('.btnListDiagnose').attr('data-id', i);
                    });
                }
            });
        }, 100);
        
    }

    $('#addDiagnosisModal #btnSaveDiagnose').off('click').on('click', function (e) {
        e.preventDefault();

        let html = '';
        let index = 0;

        $('#addDiagnosisModal #listDiagnosa li').each(function () {
            let text = $(this).text().trim();
            if (text && !text.includes('Tidak ada') && !text.includes('Gagal') && !text.includes('Memuat')) {
                html += `
                    <div class="diag-item-wrap position-relative bg-white border rounded mb-2 p-3 shadow-sm" style="user-select:none;">
                        <div class="drag-handle position-absolute start-0 top-0 bottom-0 d-flex align-items-center ps-3 text-muted fw-bold" 
                            style="cursor:grab; font-size:22px; width:50px;">
                            ⋮⋮
                        </div>
                        <div class="d-flex align-items-center justify-content-between ps-5 pe-2">
                            <p class="m-0 fw-bold flex-fill">${escapeHtml(text)}</p>
                            <span class="btnListDiagnose text-danger" data-id="${index}" data-name="${escapeHtml(text)}" style="cursor:pointer;">
                                <i class="ti ti-close"></i>
                            </span>
                        </div>
                        <input type="hidden" name="diagnose_name[]" value="${escapeHtml(text)}">
                        <input type="hidden" name="diagnose_order[]" value="${index}" class="order-input">
                    </div>`;
                index++;
            }
            
        });

        const $target = $('#addCpptModal').children().length === 0 
            ? $('#diagnoseList') 
            : $('#addCpptModal #diagnoseList');

        DiagnoseArrayTemp.map((item)=>{
          DiagnoseArray.push(item)
        })

        DiagnoseArrayTemp = []


        $target.html(html);
        $('#addDiagnosisModal').modal('hide');

        setupDiagnosisDrag($target);
    });

    $('#editDiagnosisModal #btnSaveDiagnose').off('click').on('click', function (e) {
        e.preventDefault();

        let html = '';
        let index = 0;

        $('#editDiagnosisModal #listDiagnosa li').each(function () {
            let text = $(this).text().trim();
            if (text && !text.includes('Tidak ada') && !text.includes('Gagal') && !text.includes('Memuat')) {
                html += `
                    <div class="diag-item-wrap position-relative bg-white border rounded mb-2 p-3 shadow-sm" style="user-select:none;">
                        <div class="drag-handle position-absolute start-0 top-0 bottom-0 d-flex align-items-center ps-3 text-muted fw-bold" 
                            style="cursor:grab; font-size:22px; width:50px;">
                            ⋮⋮
                        </div>
                        <div class="d-flex align-items-center justify-content-between ps-5 pe-2">
                            <p class="m-0 fw-bold flex-fill">${escapeHtml(text)}</p>
                            <span class="btnListDiagnose text-danger" data-id="${index}" data-name="${escapeHtml(text)}" style="cursor:pointer;">
                                <i class="ti ti-close"></i>
                            </span>
                        </div>
                        <input type="hidden" name="diagnose_name[]" value="${escapeHtml(text)}">
                        <input type="hidden" name="diagnose_order[]" value="${index}" class="order-input">
                    </div>`;
                index++;
            }
        });

        DiagnoseArrayTemp.map((item)=>{
          DiagnoseArray.push(item)
        })

        DiagnoseArrayTemp = []

        const $target = $('#editCpptModal').find('#diagnoseList'); // sesuaikan kalau beda
        $target.html(html);
        $('#editDiagnosisModal').modal('hide');

        setupDiagnosisDrag($target);
    });

    // Event handler untuk tombol "Gunakan" diagnosis sebelumnya
    $(document).on('click', '.btn-use-previous', function () {
        var diagnosis = $(this).data('diagnosis');

        // Cek apakah sudah ada di list
        var exists = false;
        $('#addDiagnosisModal #listDiagnosa li').each(function () {
            if ($(this).text().trim() === diagnosis) {
                exists = true;
                return false;
            }
        });

        if (!exists) {
            $('#addDiagnosisModal #listDiagnosa').append(`<li>${diagnosis}</li>`);
        }

        $(this).prop('disabled', true).html('<i class="bi bi-check me-1"></i>Sudah Ditambahkan');
    });

    // Event saat modal diagnosis dibuka
    // $('#addDiagnosisModal').on('shown.bs.modal', function () {
    //     // console.log('Modal diagnosis dibuka, load dari form CPPT...');

    //     // JANGAN load dari database, tapi ambil dari form CPPT yang sudah ada
    //     // $('#addDiagnosisModal #listDiagnosa').empty();

    //     // Ambil diagnosis yang sudah ada di form CPPT
    //     let existingDiagnoses = [];
    //     $('#addCpptModal #diagnoseList .diag-item-wrap p').each(function () {
    //         let diagnosisText = $(this).text().trim();
    //         if (diagnosisText) {
    //             existingDiagnoses.push(diagnosisText);
    //         }
    //     });

    //     // console.log('Diagnosis yang sudah ada di form:', existingDiagnoses.length);

    //     // Tampilkan di modal
    //     if (existingDiagnoses.length > 0) {
    //         existingDiagnoses.forEach(function (diagnosis) {
    //             $('#addDiagnosisModal #listDiagnosa').append(`<li>${escapeHtml(diagnosis)}</li>`);
    //         });

           
    //     }

    // });

    // Load Previous Diagnoses - untuk modal diagnosis
    function loadPreviousDiagnoses() {
        $('#addDiagnosisModal #listDiagnosa').html('<li class="text-muted">Memuat diagnosis...</li>');

        showDiagnosisLoading('Mengambil Diagnosis Terakhir', 'Memuat riwayat diagnosis...');

        $.ajax({
            url: '{{ route("rawat-inap.cppt.get-last-diagnoses", [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                kd_unit: '{{ $dataMedis->kd_unit }}',
                kd_pasien: '{{ $dataMedis->kd_pasien }}',
                tgl_masuk: '{{ date("Y-m-d", strtotime($dataMedis->tgl_masuk)) }}',
                urut_masuk: '{{ $dataMedis->urut_masuk }}'
            },
            success: function (response) {
                // console.log('Response dari server:', response);

                // Clear list dulu
                $('#addDiagnosisModal #listDiagnosa').empty();

                if (response.status === 'success' && response.data && response.data.length > 0) {
                    // console.log('Jumlah diagnosis:', response.data.length);

                    // Masukkan satu per satu
                    response.data.forEach(function (diagnosis, index) {
                        console.log('Menambah diagnosis ke-' + (index + 1) + ':', diagnosis);
                        
                        $('#addDiagnosisModal #listDiagnosa').append(`<li>${escapeHtml(diagnosis)}</li>`);
                    });

                    // console.log('Total <li> di modal:', $('#addDiagnosisModal #listDiagnosa li').length);
                } else {
                    $('#addDiagnosisModal #listDiagnosa').append('<li class="text-muted">Tidak ada diagnosis sebelumnya</li>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading previous diagnoses:', error);
                $('#addDiagnosisModal #listDiagnosa').empty();
                $('#addDiagnosisModal #listDiagnosa').append('<li class="text-danger">Gagal memuat data</li>');
            },
            complete: function () {
                hideDiagnosisLoading();
            }
        });
    }

    


    // Function terpisah untuk initial load
    function loadInitialDiagnoses() {
        showDiagnosisLoading('Menyiapkan Form CPPT', 'Memuat diagnosis terakhir...');

        $.ajax({
            url: '{{ route("rawat-inap.cppt.get-last-diagnoses", [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                kd_unit: '{{ $dataMedis->kd_unit }}',
                kd_pasien: '{{ $dataMedis->kd_pasien }}',
                tgl_masuk: '{{ date("Y-m-d", strtotime($dataMedis->tgl_masuk)) }}',
                urut_masuk: '{{ $dataMedis->urut_masuk }}'
            },
            success: function (response) {
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    
                    const dignoseListContent = render_list_diagonis_content(response.data)
                    $('#addCpptModal #diagnoseList').html(dignoseListContent);

                    const target = $('#addCpptModal #diagnoseList')
                    setupDiagnosisDrag(target)

                    if (typeof showToast === 'function') {
                        showToast('success', `${response.data.length} diagnosis terakhir dimuat otomatis`);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading initial diagnoses:', error);
            },
            complete: function () {
                hideDiagnosisLoading();
            }
        });
    }

    const render_list_diagonis_content = (data)=>{
            var dignoseListContent = '';

            data.forEach(function (diagnosis, index) {
                dignoseListContent += `
                     <div class="diag-item-wrap position-relative bg-white border rounded mb-2 p-3 shadow-sm" style="user-select:none;">
                        <div class="drag-handle position-absolute start-0 top-0 bottom-0 d-flex align-items-center ps-3 text-muted fw-bold" 
                            style="cursor:grab; font-size:22px; width:50px;">
                            ⋮⋮
                        </div>
                        <div class="d-flex align-items-center justify-content-between ps-5 pe-2">
                            <p class="m-0 fw-bold flex-fill">${escapeHtml(diagnosis)}</p>
                            <span class="btnListDiagnose text-danger" data-id="${index}" data-name="${escapeHtml(diagnosis)}" style="cursor:pointer;">
                                <i class="ti ti-close"></i>
                            </span>
                        </div>
                        <input type="hidden" name="diagnose_name[]" value="${escapeHtml(diagnosis)}">
                        <input type="hidden" name="diagnose_order[]" value="${index}" class="order-input">
                    </div>`;
            });
            return dignoseListContent
    }

    $('#addCpptModal input[name="skala_nyeri"]').change(function (e) {
        var $this = $(this);
        var skalaValue = $this.val();

        if (skalaValue > 10) {
            skalaValue = 10;
            $this.val(10);
        }

        if (skalaValue < 0) {
            skalaValue = 0;
            $this.val(0);
        }

        var valColor = 'btn-success';
        let skalaLabel = 'Tidak Nyeri'

        if (skalaValue > 1 && skalaValue <= 3) skalaLabel = "Nyeri Ringan";
        if (skalaValue > 3 && skalaValue <= 5) skalaLabel = "Nyeri Sedang";
        if (skalaValue > 5 && skalaValue <= 7) skalaLabel = "Nyeri Parah";
        if (skalaValue > 7 && skalaValue <= 9) skalaLabel = "Nyeri Sangat Parah";
        if (skalaValue > 9) skalaLabel = "Nyeri Terburuk";

        if (skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
        if (skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-success');
        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-warning');
        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-danger');
        $('#addCpptModal #skalaNyeriBtn').addClass(valColor);
        $('#addCpptModal #skalaNyeriBtn').text(skalaLabel);
    });

    // Submit validation
    $('#formAddCppt').submit(function (e) {
        let $this = $(this);
        let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');
        once = 0;

        if (diagnoseNameEl.length < 1) {
            e.preventDefault();
            if (typeof showToast === 'function') {
                showToast('error', 'Diagnosa harus ditambah minimal 1!');
            } else {
                alert('Diagnosa harus ditambah minimal 1!');
            }
            return false;
        }

        showDiagnosisLoading('Menyimpan CPPT', 'Sedang menyimpan data...');
    });

    // Auto-hide loader
    window.addEventListener('load', () => hideDiagnosisLoading(50));

    // Initialize
    $(document).ready(function () {
        ensureDiagnosisLoader();
    });

    // ===========================================
    // CPPT FUNCTIONS (EDIT) - FIXED VERSION
    // ===========================================

    // GANTI KODE EDIT CPPT YANG SUDAH ADA DENGAN INI
    $('.btn-edit-cppt').click(function (e) {
        e.preventDefault();

        DiagnoseArray = []
        DiagnoseArrayTemp = []

        var $this = $(this);
        var tanggalData = $this.attr('data-tgl');
        var urutData = $this.attr('data-urut');
        var urutTotalData = $this.attr('data-urut-total');
        var unitData = $this.attr('data-unit');
        var transaksiData = $this.attr('data-transaksi');
        var target = $this.attr('data-bs-target');
        var tipe_data=  $this.attr('data-tipe-cppt');

        

        tanggal = tanggalData;
        urut = urutData;
        unit = unitData;
        button = $this;

        // Ubah teks tombol dan tambahkan spinner
        $this.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...'
        );
        $this.prop('disabled', true);

        if(tipe_data==4){
            // Template URL dari Laravel, tapi kita sisipkan placeholder
       let url = "{{ route('rawat-inap.cppt.get-cppt-adime', [$dataMedis->kd_unit,$dataMedis->kd_pasien,$dataMedis->tgl_masuk,$dataMedis->urut_masuk])}}";

        url = url
            .replace('TANGGAL', tanggal)
            .replace('URUT', urut);

        const queryString = new URLSearchParams({
            urut_masuk: "{{ $dataMedis->urut_masuk }}",
            no_transaksi: "{{ $dataMedis->no_transaksi }}",
            tanggal: tanggal,
            urut: urut,
            
        }).toString();

        location.href = `${url}?${queryString}`;

        }else{
          let url =
            "{{ route('rawat-inap.cppt.get-cppt-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}";

            $.ajax({
                type: "post",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    kd_pasien: "{{ $dataMedis->kd_pasien }}",
                    no_transaksi: "{{ $dataMedis->no_transaksi }}",
                    tanggal: tanggal,
                    urut: urut,
                    kd_unit: unit
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        var data = response.data;

                        for (let key in data) {
                            if (data.hasOwnProperty(key)) {
                                let patient = data[key];

                                // Set key to input
                                $(target).find('input[name="tgl_cppt"]').val(tanggalData);
                                $(target).find('input[name="urut_cppt"]').val(urutData);
                                $(target).find('input[name="urut_total_cppt"]').val(urutTotalData);
                                $(target).find('input[name="unit_cppt"]').val(unitData);
                                $(target).find('input[name="no_transaksi"]').val(transaksiData);
                                $(target).find('#anamnesis').val(patient.anamnesis);
                                $(target).find('#lokasi').val(patient.lokasi);
                                $(target).find('#durasi').val(patient.durasi);
                                $(target).find('#pemeriksaan_fisik').val(patient.pemeriksaan_fisik);
                                $(target).find('#data_objektif').val(patient.obyektif);
                                $(target).find('#planning').val(patient.planning);

                                // skala nyeri set value
                                var skalaNyeri = patient.skala_nyeri;
                                var valColor = 'btn-success';
                                let skalaLabel = 'Tidak Nyeri'

                                if (skalaNyeri > 1 && skalaNyeri <= 3) skalaLabel = "Nyeri Ringan";
                                if (skalaNyeri > 3 && skalaNyeri <= 5) skalaLabel = "Nyeri Sedang";
                                if (skalaNyeri > 5 && skalaNyeri <= 7) skalaLabel = "Nyeri Parah";
                                if (skalaNyeri > 7 && skalaNyeri <= 9) skalaLabel =
                                    "Nyeri Sangat Parah";
                                if (skalaNyeri > 9) skalaLabel = "Nyeri Terburuk";

                                if (skalaNyeri > 3 && skalaNyeri <= 7) valColor = 'btn-warning';
                                if (skalaNyeri > 7 && skalaNyeri <= 10) valColor = 'btn-danger';

                                $(target).find('#skalaNyeriBtn').removeClass(
                                    'btn-success btn-warning btn-danger').addClass(valColor);
                                $(target).find('#skalaNyeriBtn').text(skalaLabel);
                                $(target).find('#skala_nyeri').val(skalaNyeri);

                                // tanda vital set value
                                var kondisi = patient.kondisi;
                                var konpas = kondisi.konpas;

                                for (let i in konpas) {
                                    if (konpas.hasOwnProperty(i)) {
                                        let kondisi = konpas[i];
                                        $(target).find(`#kondisi${kondisi.id_kondisi}`).val(kondisi
                                            .hasil);
                                    }
                                }

                                // set pemberat value
                                $(target).find(
                                    `#pemberat option[value="${patient?.pemberat?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                    `#peringan option[value="${patient?.peringan?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                    `#kualitas_nyeri option[value="${patient?.kualitas?.id || ''}"]`
                                ).attr('selected', 'selected');
                                $(target).find(
                                    `#frekuensi_nyeri option[value="${patient?.frekuensi?.id || ''}"]`
                                ).attr('selected', 'selected');
                                $(target).find(
                                    `#menjalar option[value="${patient?.menjalar?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                    `#jenis_nyeri option[value="${patient?.jenis?.id || ''}"]`)
                                    .attr('selected', 'selected');

                                                                // diagnosis set value
                                var penyakit = patient.cppt_penyakit;
                                var dignoseListContent = '';
                                let index = 0;

                                // Kosongkan array biar gak double
                                DiagnoseArray = [];
                                DiagnoseArrayTemp = [];

                                // Loop penyakit
                                for (let d in penyakit) {
                                    if (penyakit.hasOwnProperty(d)) {
                                        let diag = penyakit[d];
                                        DiagnoseArray.push(diag.nama_penyakit);

                                        dignoseListContent += `
                                            <div class="diag-item-wrap position-relative bg-white border rounded mb-2 p-3 shadow-sm" style="user-select:none;">
                                                
                                                <!-- DRAG HANDLE -->
                                                <div class="drag-handle position-absolute start-0 top-0 bottom-0 d-flex align-items-center ps-3 text-muted fw-bold" 
                                                     style="cursor:grab; font-size:22px; width:50px; user-select:none;">
                                                    ⋮⋮
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between ps-5 pe-2">
                                                    <p class="m-0 fw-bold flex-fill">${escapeHtml(diag.nama_penyakit)}</p>
                                                    <span class="btnListDiagnose text-danger" 
                                                          data-id="${index}" 
                                                          data-name="${escapeHtml(diag.nama_penyakit)}" 
                                                          style="cursor:pointer; z-index:10;">
                                                        <i class="ti ti-close"></i>
                                                    </span>
                                                </div>

                                                <input type="hidden" name="diagnose_name[]" value="${escapeHtml(diag.nama_penyakit)}">
                                                <input type="hidden" name="diagnose_order[]" value="${index}" class="order-input">
                                            </div>`;

                                        index++;
                                    }
                                }

                                // INI YANG BENAR: Cari #diagnoseList DI DALAM MODAL YANG SEDANG DIBUKA!
                                const $currentModal = $(target); // modal yang diklik (data-bs-target)
                                const $diagnoseList = $currentModal.find('#diagnoseList');

                                // Tempel data
                                $diagnoseList.html(dignoseListContent);

                                // RE-INIT SORTABLE DENGAN ELEMENT YANG BENAR
                                setTimeout(() => {
                                    const el = $diagnoseList[0];

                                    if (el && el.sortable) {
                                        el.sortable.destroy();
                                    }

                                    if (el) {
                                        el.sortable = Sortable.create(el, {
                                            animation: 180,
                                            handle: '.drag-handle',
                                            ghostClass: 'bg-primary',
                                            onEnd: () => {
                                                $diagnoseList.find('.diag-item-wrap').each(function(idx) {
                                                    $(this).find('.order-input').val(idx);
                                                    $(this).find('.btnListDiagnose').attr('data-id', idx);
                                                });
                                            }
                                        });

                                        console.log("%cEDIT CPPT: DRAG & DROP SUDAH AKTIF! BISA GESER PAKE ⋮⋮", "background:#00aa00;color:white;padding:10px 20px;font-size:16px;border-radius:8px;");
                                    }
                                }, 150);

                                // Simpan data PPA
                                window.MASTER_EDIT_INSTRUKSI_PPA = patient.instruksi_ppa || [];

                                

                                // CRITICAL: Simpan data instruksi PPA ke GLOBAL variable yang persisten
                                window.MASTER_EDIT_INSTRUKSI_PPA = patient.instruksi_ppa || [];
                                // console.log('MASTER PPA DATA SAVED:', window.MASTER_EDIT_INSTRUKSI_PPA.length, 'items');
                            }
                        }
                    }

                    // Tampilkan modal dulu
                    $(target).modal('show');

                    // CRITICAL: Tunggu modal benar-benar muncul, JANGAN reset data
                    setTimeout(() => {
                        try {
                            // console.log('Initializing edit modal with PPA data...');

                            // Initialize searchable select TANPA reset data
                            initEditInstruksiPpaSearchableSelect();

                            // Load data PPA dari MASTER variable
                            if (window.MASTER_EDIT_INSTRUKSI_PPA && Array.isArray(window
                                .MASTER_EDIT_INSTRUKSI_PPA)) {
                                loadEditInstruksiPpaFromAjaxDataFinal(window
                                    .MASTER_EDIT_INSTRUKSI_PPA);
                                
                                // console.log('PPA data loaded successfully:', editInstruksiPpaData.length, 'items');
                            } else {
                                // console.warn('No master PPA data found');
                                loadEditInstruksiPpaFromAjaxDataFinal([]);
                            }

                        } catch (error) {
                            console.error('Error initializing edit modal:', error);
                        }
                    }, 1200);

                    // Ubah teks tombol jadi edit
                    button.html('Edit');
                    button.prop('disabled', false);
                },
                error: function (xhr, status, error) {
                    showToast('error', 'internal server error');
                    button.html('Edit');
                    button.prop('disabled', false);
                }
                });
        }
        
    });

    

  // Delete diagnosis dari list
    $(document).on('click', '.btnListDiagnose', function (e) {
        e.preventDefault();

        const name = $(this).data('name'); // ✅ ambil nama dari data-id

        console.log('DiagnoseArray sebelum hapus:', DiagnoseArray);
        const index = DiagnoseArray.findIndex((item) => item === name);

        if (index !== -1) {
            DiagnoseArray.splice(index, 1); // ✅ hapus elemen berdasarkan index
        }

        console.log('DiagnoseArray setelah hapus:', DiagnoseArray);

        // render ulang tampilan
        const ListData = $('#diagnoseList');
        ListData.empty();

        const dignoseListContent = render_list_diagonis_content(DiagnoseArray);
        ListData.html(dignoseListContent);
    });



    $(document).on('click', '#addCpptModal .btnListDiagnose', function (e) {
        e.preventDefault();
        var $this = $(this);
        $(this).closest('.diag-item-wrap').remove();
    });

    $(document).on('click', '#editCpptModal .btnListDiagnose', function (e) {
        e.preventDefault();
        var $this = $(this);
        $(this).closest('.diag-item-wrap').remove();
    });

    // ===========================================
    // DIAGNOSIS MODAL HANDLERS - FIXED VERSION
    // ===========================================

    $('#editDiagnosisModal #btnAddListDiagnosa').click(function (e) {
        e.preventDefault();
        var searchInputValue = $(editSearchInputDiagnose).val();

        if (searchInputValue != '') {
            if($('#editDiagnosisModal').children.length > 0){
                console.log("Masuk Edit")

                DiagnoseArrayTemp.push(searchInputValue)
                
                let ListData = $('#editDiagnosisModal #listDiagnosa')
                ListData.empty()
                   
                DiagnoseArray.map((item)=>{
                        ListData.append(`<li>${item}</li>`)
                })

                DiagnoseArrayTemp.map((item)=>{
                        ListData.append(`<li>${item}</li>`)
                })    

                $('#addDiagnosisModal #searchInput').val('');
                console.log("Temp Data :", searchInputValue,DiagnoseArrayTemp)

                $(editSearchInputDiagnose).val('');
            }else{
                $('#listDiagnosa').append(`<li>${searchInputValue}</li>`);
            }
           
        }
    });

  

    // Event handler untuk buka modal diagnosis dengan proteksi data PPA
    $('#editCpptModal #openEditDiagnosisModal').click(function (e) {
        e.preventDefault();

        // console.log('Opening diagnosis modal, current PPA data:', editInstruksiPpaData.length);

        // Simpan ke SEMUA backup locations yang mungkin
        window.PRE_DIAGNOSIS_BACKUP = JSON.parse(JSON.stringify(editInstruksiPpaData));
        window.tempEditInstruksiPpaData = JSON.parse(JSON.stringify(editInstruksiPpaData));
        window.editInstruksiPpaBackup = JSON.parse(JSON.stringify(editInstruksiPpaData));
        window.ULTRA_SAFE_BACKUP = JSON.parse(JSON.stringify(editInstruksiPpaData));

        // Juga backup dari master data
        if (window.MASTER_EDIT_INSTRUKSI_PPA) {
            window.MASTER_BACKUP = JSON.parse(JSON.stringify(window.MASTER_EDIT_INSTRUKSI_PPA));
        }

        // console.log('Created multiple PPA backups:', window.PRE_DIAGNOSIS_BACKUP.length, 'items');

        var $this = $(this);
        var target = $this.attr('data-bs-target');

        var modalKedua = new bootstrap.Modal($(target), {
            backdrop: 'static',
            keyboard: false
        });

        $(target).modal('show');
    });

    $('#editCpptModal #editDiagnosisModal').on('show.bs.modal', function (e) {
        var $this = $(this);
        var penyakitList = $('#editCpptModal #diagnoseList p');
        let listNamaPenyakitHtml = '';

        $.each(penyakitList, function (i, el) {
            var nmDiag = $(el).text();
            if (nmDiag != '') {
                listNamaPenyakitHtml += `<li>${nmDiag}</li>`;
            }
        });

        $this.find('#listDiagnosa').html(listNamaPenyakitHtml);
    });

    // Event handler untuk restore data PPA saat modal diagnosis ditutup
    $('#editDiagnosisModal').on('hidden.bs.modal', function () {
        // console.log('Diagnosis modal closed, final PPA restore...');

        // Final restore attempt jika data masih kosong
        if (!editInstruksiPpaData || editInstruksiPpaData.length === 0) {
            var finalBackup = null;

            // Try all possible backup sources
            if (window.PRE_DIAGNOSIS_BACKUP && window.PRE_DIAGNOSIS_BACKUP.length > 0) {
                finalBackup = window.PRE_DIAGNOSIS_BACKUP;
                // console.log('Using PRE_DIAGNOSIS_BACKUP');
            } else if (window.ULTRA_SAFE_BACKUP && window.ULTRA_SAFE_BACKUP.length > 0) {
                finalBackup = window.ULTRA_SAFE_BACKUP;
                // console.log('Using ULTRA_SAFE_BACKUP');
            } else if (window.PERSISTENT_PPA_BACKUP && window.PERSISTENT_PPA_BACKUP.length > 0) {
                finalBackup = window.PERSISTENT_PPA_BACKUP;
                // console.log('Using PERSISTENT_PPA_BACKUP');
            } else if (window.MASTER_EDIT_INSTRUKSI_PPA && window.MASTER_EDIT_INSTRUKSI_PPA.length > 0) {
                // Convert dari format server
                finalBackup = [];
                window.MASTER_EDIT_INSTRUKSI_PPA.forEach(function (item, index) {
                    finalBackup.push({
                        id: index + 1,
                        perawat_kode: item.ppa,
                        perawat_nama: getPerawatNamaByKode(item.ppa),
                        instruksi: item.instruksi,
                        created_at: new Date().toLocaleString('id-ID')
                    });
                });
                // console.log('Using MASTER_EDIT_INSTRUKSI_PPA converted');
            }

            if (finalBackup) {
                editInstruksiPpaData = JSON.parse(JSON.stringify(finalBackup));
                editInstruksiPpaCounter = editInstruksiPpaData.length;

                updateEditInstruksiPpaTable();
                updateEditInstruksiPpaHiddenInputs();
                updateEditInstruksiPpaCountBadge();

                // console.log('Final restore successful:', editInstruksiPpaData.length, 'items');
            }
        }

        // Clean up temporary backups but keep persistent ones
        delete window.tempEditInstruksiPpaData;
        delete window.PRE_DIAGNOSIS_BACKUP;
        delete window.ULTRA_SAFE_BACKUP;
    });

    $('#editCpptModal input[name="skala_nyeri"]').change(function (e) {
        var $this = $(this);
        var skalaValue = $this.val();

        if (skalaValue > 10) {
            skalaValue = 10;
            $this.val(10);
        }

        if (skalaValue < 0) {
            skalaValue = 0;
            $this.val(0);
        }

        var valColor = 'btn-success';
        let skalaLabel = 'Tidak Nyeri'

        if (skalaValue > 1 && skalaValue <= 3) skalaLabel = "Nyeri Ringan";
        if (skalaValue > 3 && skalaValue <= 5) skalaLabel = "Nyeri Sedang";
        if (skalaValue > 5 && skalaValue <= 7) skalaLabel = "Nyeri Parah";
        if (skalaValue > 7 && skalaValue <= 9) skalaLabel = "Nyeri Sangat Parah";
        if (skalaValue > 9) skalaLabel = "Nyeri Terburuk";

        if (skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
        if (skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-success');
        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-warning');
        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-danger');
        $('#editCpptModal #skalaNyeriBtn').addClass(valColor);
        $('#editCpptModal #skalaNyeriBtn').text(skalaLabel);
    });

    $('#formEditCppt').submit(function (e) {
        let $this = $(this);
        let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');

        if (diagnoseNameEl.length < 1) {
            showToast('error', 'Diagnosa harus di tambah minimal 1!');
            return false;
        }
    });

    // ===========================================
    // EVENT HANDLERS - FIXED VERSION
    // ===========================================

    //GLOBAL VARIABEL dataListDiagnose
    let DiagnoseArray = []
    $(document).ready(function () {
        // Initialize ADD modal
        initAddInstruksiPpaSearchableSelect();
        // Auto load diagnosis

        const isTherelastDiagnose = "{{ !empty($lastDiagnoses) ? 1 : 0  }}";
        if (isTherelastDiagnose == 1) {
            let ArrayDataFromChildren = $('#listDiagnosa').children();
            console.log(ArrayDataFromChildren);

            ArrayDataFromChildren.each(function () {
                DiagnoseArray.push($(this).text().trim());
            });
        }
    });

    // Event handler untuk button tambah di ADD modal
    $(document).on('click', '#instruksi_ppa_tambah_btn', function () {
        const perawatKode = $('#instruksi_ppa_selected_value').val();
        const perawatNama = addSelectedPerawat ? addSelectedPerawat.nama : '';
        const instruksi = $('#instruksi_ppa_text_input').val().trim();

        if (!perawatKode || perawatKode === '') {
            showInstruksiAlert('warning', 'Silakan pilih nama perawat terlebih dahulu!');
            $('#instruksi_ppa_search_input').removeClass('is-valid').addClass('is-invalid').focus();
            return;
        }

        if (!instruksi) {
            showInstruksiAlert('warning', 'Silakan isi instruksi terlebih dahulu!');
            $('#instruksi_ppa_text_input').focus();
            return;
        }

        addInstruksiPpaCounter++;
        const newInstruksi = {
            id: addInstruksiPpaCounter,
            perawat_kode: perawatKode,
            perawat_nama: perawatNama,
            instruksi: instruksi,
            created_at: new Date().toLocaleString('id-ID')
        };

        addInstruksiPpaData.push(newInstruksi);

        updateAddInstruksiPpaTable();
        updateAddInstruksiPpaHiddenInputs();
        updateAddInstruksiPpaCountBadge();

        selectAddPerawat('', '');
        $('#instruksi_ppa_text_input').val('');
        $('#instruksi_ppa_search_input').focus();

        showInstruksiAlert('success', `Instruksi untuk ${perawatNama} berhasil ditambahkan!`);
    });

    // Event handler untuk button tambah di EDIT modal
    $(document).on('click', '#edit_instruksi_ppa_tambah_btn', function () {
        const perawatKode = $('#edit_instruksi_ppa_selected_value').val();
        const perawatNama = editSelectedPerawat ? editSelectedPerawat.nama : '';
        const instruksi = $('#edit_instruksi_ppa_text_input').val().trim();

        if (!perawatKode || perawatKode === '') {
            showInstruksiAlert('warning', 'Silakan pilih nama perawat terlebih dahulu!');
            $('#edit_instruksi_ppa_search_input').removeClass('is-valid').addClass('is-invalid').focus();
            return;
        }

        if (!instruksi) {
            showInstruksiAlert('warning', 'Silakan isi instruksi terlebih dahulu!');
            $('#edit_instruksi_ppa_text_input').focus();
            return;
        }

        editInstruksiPpaCounter++;
        const newInstruksi = {
            id: editInstruksiPpaCounter,
            perawat_kode: perawatKode,
            perawat_nama: perawatNama,
            instruksi: instruksi,
            created_at: new Date().toLocaleString('id-ID')
        };

        editInstruksiPpaData.push(newInstruksi);

        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaHiddenInputs();
        updateEditInstruksiPpaCountBadge();

        // Update backup setelah menambah data baru
        window.editInstruksiPpaBackup = JSON.parse(JSON.stringify(editInstruksiPpaData));

        selectEditPerawat('', '');
        $('#edit_instruksi_ppa_text_input').val('');
        $('#edit_instruksi_ppa_search_input').focus();

        showInstruksiAlert('success', `Instruksi untuk ${perawatNama} berhasil ditambahkan!`);
    });

    // Event handler untuk enter key
    $(document).on('keypress', '#instruksi_ppa_text_input', function (e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#instruksi_ppa_tambah_btn').click();
        }
    });

    $(document).on('keypress', '#edit_instruksi_ppa_text_input', function (e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#edit_instruksi_ppa_tambah_btn').click();
        }
    });

    // ===========================================
    // MODAL EVENT HANDLERS - FIXED VERSION
    // ===========================================

    // const ppa_init_proses = () => {
    //     // Reset data PPA
    //     resetAddInstruksiPpaData();

    //     setTimeout(() => {
    //         initAddInstruksiPpaSearchableSelect();
    //     }, 100);

    //     // HANYA load initial diagnosis SEKALI
    //     loadInitialDiagnoses();

    //     // Trigger skala nyeri
    //     $('#addCpptModal input[name="skala_nyeri"]').trigger('change');
    // }

    // // Event saat modal ADD dibuka
    // $('#addCpptModal').on('show.bs.modal', function () {
    //     ppa_init_proses()
    // });

    //gizi deooooo
    $(document).on('click','#instruksi_ppa_search_input', function () {
        console.log("CARIIIIIIIIIIIIIIIIIIIII")
        setTimeout(() => {
            initAddInstruksiPpaSearchableSelect();
        }, 100);
    });

    $(document).on('click',' #edit_instruksi_ppa_search_input', function () {
        console.log("CARIIIIIIIIIIIIIIIIIIIII")
        setTimeout(() => {
            initEditInstruksiPpaSearchableSelect();
        }, 100);
    });

    let once = 0;
    $('#addCpptModal').on('show.bs.modal', async function(){
        if(once === 0){
            DiagnoseArray = []
            DiagnoseArrayTemp = []
            const data = await loadPreviousDiagnosesFromDatabase(true);        
            once++
        }
    })

    // Event saat modal ADD ditutup
    // $('#addCpptModal').on('hidden.bs.modal', function () {
    //     resetAddInstruksiPpaData();
    // });

    // Event saat modal EDIT dibuka
    // $('#editCpptModal').on('show.bs.modal', function() {
    //     // Initialization akan dilakukan oleh button edit CPPT
    //     console.log('Edit CPPT modal opened');
    // });

    // // Event saat modal EDIT ditutup
    // $('#editCpptModal').on('hidden.bs.modal', function () {
    //     // console.log('Edit CPPT modal closed, cleaning up...');
    //     resetEditInstruksiPpaData();
    // });

    // check untuk memastikan data PPA tidak hilang
    $('#editCpptModal').on('focus', 'input:not([id^="edit_instruksi_ppa"]), textarea, select', function () {
        setTimeout(() => {
            ensureEditInstruksiPpaData();
        }, 50);
    });

    // Additional safety checks
    $(document).on('click', '#editCpptModal .modal-body', function () {
        setTimeout(() => {
            ensureEditInstruksiPpaData();
        }, 100);
    });

    // ===========================================
    // UTILITY FUNCTIONS
    // ===========================================

    // Function untuk manual restore data PPA
    function manualRestorePpaData() {
        // console.log('Manual restore PPA data...');

        var backupToUse = null;

        if (window.PERSISTENT_PPA_BACKUP && window.PERSISTENT_PPA_BACKUP.length > 0) {
            backupToUse = window.PERSISTENT_PPA_BACKUP;
        } else if (window.MASTER_EDIT_INSTRUKSI_PPA && window.MASTER_EDIT_INSTRUKSI_PPA.length > 0) {
            backupToUse = [];
            window.MASTER_EDIT_INSTRUKSI_PPA.forEach(function (item, index) {
                backupToUse.push({
                    id: index + 1,
                    perawat_kode: item.ppa,
                    perawat_nama: getPerawatNamaByKode(item.ppa),
                    instruksi: item.instruksi,
                    created_at: new Date().toLocaleString('id-ID')
                });
            });
        }

        if (backupToUse) {
            editInstruksiPpaData = JSON.parse(JSON.stringify(backupToUse));
            editInstruksiPpaCounter = editInstruksiPpaData.length;

            updateEditInstruksiPpaTable();
            updateEditInstruksiPpaHiddenInputs();
            updateEditInstruksiPpaCountBadge();

            // console.log('Manual restore completed:', editInstruksiPpaData.length, 'items');
            return true;
        }

        // console.warn('No backup data available for manual restore');
        return false;
    }

    // Auto-check setiap 2 detik jika data PPA hilang
    setInterval(function () {
        if ($('#editCpptModal').hasClass('show')) {
            if ((!editInstruksiPpaData || editInstruksiPpaData.length === 0) &&
                (window.PERSISTENT_PPA_BACKUP && window.PERSISTENT_PPA_BACKUP.length > 0)) {

                // console.log('Auto-restoring PPA data...');
                manualRestorePpaData();
            }
        }
    }, 2000);

    // DEBUG: Function untuk check semua backup data
    // function debugAllBackups() {
    //     console.log('=== DEBUG ALL PPA BACKUPS ===');
    //     console.log('editInstruksiPpaData:', editInstruksiPpaData ? editInstruksiPpaData.length : 'null');
    //     console.log('MASTER_EDIT_INSTRUKSI_PPA:', window.MASTER_EDIT_INSTRUKSI_PPA ? window.MASTER_EDIT_INSTRUKSI_PPA.length : 'null');
    //     console.log('PERSISTENT_PPA_BACKUP:', window.PERSISTENT_PPA_BACKUP ? window.PERSISTENT_PPA_BACKUP.length : 'null');
    //     console.log('editInstruksiPpaBackup:', window.editInstruksiPpaBackup ? window.editInstruksiPpaBackup.length : 'null');
    //     console.log('PRE_DIAGNOSIS_BACKUP:', window.PRE_DIAGNOSIS_BACKUP ? window.PRE_DIAGNOSIS_BACKUP.length : 'null');
    //     console.log('============================');
    // }

    // Function load data PPA yang TIDAK mereset data
    function loadEditInstruksiPpaFromAjaxDataFinal(instruksiPpaArray) {
        // console.log('loadEditInstruksiPpaFromAjaxDataFinal called with:', instruksiPpaArray.length, 'items');

        // JANGAN reset counter jika sudah ada data
        if (editInstruksiPpaData.length === 0) {
            editInstruksiPpaData = [];
            editInstruksiPpaCounter = 0;
        }

        if (instruksiPpaArray && Array.isArray(instruksiPpaArray)) {
            // Clear existing data only if new data is available
            editInstruksiPpaData = [];
            editInstruksiPpaCounter = 0;

            instruksiPpaArray.forEach(function (item) {
                editInstruksiPpaCounter++;
                editInstruksiPpaData.push({
                    id: editInstruksiPpaCounter,
                    perawat_kode: item.ppa,
                    perawat_nama: getPerawatNamaByKode(item.ppa),
                    instruksi: item.instruksi,
                    created_at: new Date().toLocaleString('id-ID')
                });
                console.log(item)
            });
        }

        // Update tampilan
        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaHiddenInputs();
        updateEditInstruksiPpaCountBadge();

        // Simpan multiple backup
        window.editInstruksiPpaBackup = JSON.parse(JSON.stringify(editInstruksiPpaData));
        window.PERSISTENT_PPA_BACKUP = JSON.parse(JSON.stringify(editInstruksiPpaData));

        // console.
        // log('PPA data loaded and backed up:', editInstruksiPpaData.length, 'items');
    }

    setTimeout(()=>{
       const isEditAdime = "{{ !empty($isEdit) ? 1 : 0 }}"
       if(isEditAdime==1){
            const instruksiPpaArray = JSON.parse("{{ !empty($cppt['instruksi_ppa']) ? $cppt['instruksi_ppa'] : '' }}".replace(/&quot;/g, '"'));
            editInstruksiPpaData = instruksiPpaArray
            console.log(editInstruksiPpaData)
            loadEditInstruksiPpaFromAjaxDataFinal(instruksiPpaArray)
       }
    },1000)

    function loadInstruksiPpa(urutTotal, containerId) {
        $.ajax({
            url: '{{ route('rawat-inap.cppt.get-instruksi-ppa', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                urut_total: urutTotal
            },
            success: function (response) {
                if (response.status === 'success') {
                    let html = '';
                    if (response.data.length > 0) {
                        response.data.forEach((item, index) => {
                            html += `
                                <tr>
                                    <td class="text-center fw-bold text-primary">${String(index + 1).padStart(2, '0')}</td>
                                    <td>
                                        <span class="badge bg-info text-dark me-2">PPA</span>
                                        <strong>${item.ppa}</strong>
                                    </td>
                                    <td class="text-wrap">${item.instruksi}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html = `
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox-fill fs-2 d-block mb-3 text-secondary"></i>
                                    <h6>Belum Ada Data Instruksi PPA</h6>
                                    <small>Data instruksi akan muncul di sini ketika tersedia</small>
                                </td>
                            </tr>
                        `;
                    }
                    $(`#${containerId} tbody`).html(html);
                }
            },
            error: function () {
                console.error('Error loading instruksi PPA');
            }
        });
    }

    $(document).on('click','.btn-close',function (){
        DiagnoseArrayTemp = [];
    })
</script>
