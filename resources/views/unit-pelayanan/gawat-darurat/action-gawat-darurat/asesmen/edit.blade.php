<!-- Modal Edit -->
<div class="modal fade" id="editAsesmenModal" tabindex="-1" aria-labelledby="editAsesmenLabel" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAsesmenLabel">Edit Asesmen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="editAsesmenForm">
                        <!-- Tindakan Resusitasi -->
                        <div class="form-line">
                            <h6>Tindakan Resusitasi</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Air Way</th>
                                            <th>Breathing</th>
                                            <th>Circulation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[air_way][]" value="Hyperekstesi"
                                                        id="edit_hyperekstesi">
                                                    <label class="form-check-label"
                                                        for="edit_hyperekstesi">Hyperekstesi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[air_way][]"
                                                        value="Bersihkan jalan nafas" id="edit_bersihkanJalanNafas">
                                                    <label class="form-check-label"
                                                        for="edit_bersihkanJalanNafas">Bersihkan jalan nafas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[air_way][]" value="Intubasi"
                                                        id="edit_intubasi">
                                                    <label class="form-check-label" for="edit_intubasi">Intubasi</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[breathing][]"
                                                        value="Bag and Mask" id="edit_bagAndMask">
                                                    <label class="form-check-label" for="edit_bagAndMask">Bag and
                                                        Mask</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[breathing][]"
                                                        value="Bag and Tube" id="edit_bagAndTube">
                                                    <label class="form-check-label" for="edit_bagAndTube">Bag and
                                                        Tube</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[circulation][]"
                                                        value="Kompresi jantung" id="edit_kompresiJantung">
                                                    <label class="form-check-label" for="edit_kompresiJantung">Kompresi
                                                        jantung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[circulation][]"
                                                        value="Balut tekan" id="edit_balutTekan">
                                                    <label class="form-check-label" for="edit_balutTekan">Balut
                                                        tekan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[circulation][]" value="Operasi"
                                                        id="edit_operasi">
                                                    <label class="form-check-label" for="edit_operasi">Operasi</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Form fields -->
                        <div class="form-line">
                            <h6>Keluhan/Anamnesis</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_anamnesis"></textarea>
                        </div>

                        <div class="form-line">
                            <h6>Riwayat Penyakit Pasien</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_riwayat_penyakit"></textarea>
                        </div>

                        <div class="form-line">
                            <h6>Riwayat Pengobatan</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_riwayat_pengobatan"></textarea>
                        </div>

                        <div class="form-line">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Riwayat Alergi</h6>
                                <button type="button" class="btn btn-sm" id="editAddAlergi">
                                    <i class="bi bi-plus-square"></i> Tambah
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="editAlergiTable">
                                    <thead>
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Alergen</th>
                                            <th>Reaksi</th>
                                            <th>Serve</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Vital Sign</h6>
                            <div class="row mb-3">
                                <div class="col">
                                    <label>TD (Sistole)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_td_sistole">
                                </div>
                                <div class="col">
                                    <label>TD (Diastole)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_td_diastole">
                                </div>
                                <div class="col">
                                    <label>Nadi (x/mnt)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_nadi">
                                </div>
                                <div class="col">
                                    <label>Resp (x/mnt)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_resp">
                                </div>
                                <div class="col">
                                    <label>Suhu (°C)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_suhu">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>GCS</label>
                                    <select class="form-select" name="edit_vital_sign_gcs">
                                        <option selected disabled>Pilih</option>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label>AVPU</label>
                                    <select class="form-select" name="edit_vital_sign_avpu">
                                        <option selected disabled>Pilih</option>
                                        <option>Sadar Baik/Alert : 0</option>
                                        <option>Berespon dengan kata-kata/Voice: 1</option>
                                        <option>Hanya berespon jika dirangsang nyeri/pain: 2</option>
                                        <option>Pasien tidak sadar/unresponsive: 3</option>
                                        <option>Gelisah atau bingung: 4</option>
                                        <option>Acute Confusional States: 5</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label>SpO2 (tanpa O2)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_spo2_tanpa_o2">
                                </div>
                                <div class="col-3">
                                    <label>SpO2 (dengan O2)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_spo2_dengan_o2">
                                </div>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Antropometri</h6>
                            <div class="row mb-3">
                                <div class="col">
                                    <label>TB (meter)</label>
                                    <input type="number" class="form-control" name="edit_antropometri_tb">
                                </div>
                                <div class="col">
                                    <label>BB (kg)</label>
                                    <input type="number" class="form-control" name="edit_antropometri_bb">
                                </div>
                                <div class="col">
                                    <label>Ling. Kepala</label>
                                    <input type="number" class="form-control" name="edit_antropometri_ling_kepala">
                                </div>
                                <div class="col">
                                    <label>LPT</label>
                                    <input type="number" class="form-control" name="edit_antropometri_lpt">
                                </div>
                                <div class="col">
                                    <label>IMT</label>
                                    <input type="number" class="form-control" name="edit_antropometri_imt">
                                </div>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Skala Nyeri Visual Analog</h6>
                            <p class="text-muted">*Pilih angka pada skala nyeri yang sesuai</p>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                        alt="Descriptive Alt Text" style="width: 100%; height: auto;">
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3">Karakteristik Nyeri</h6>
                                    <div class="mb-2">
                                        <label>Skala Nyeri</label>
                                        <input type="number" name="edit_skala_nyeri" min="0" max="10"
                                            class="form-control" value="0">
                                    </div>
                                    <div class="mb-2">
                                        <label>Lokasi Nyeri</label>
                                        <input type="text" name="edit_lokasi" class="form-control"
                                            placeholder="Lokasi Nyeri">
                                    </div>
                                    <div class="mb-2">
                                        <label>Durasi</label>
                                        <input type="text" name="edit_durasi" class="form-control"
                                            placeholder="Durasi Nyeri">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="manjalar">Manjalar</label>
                                <select class="form-select" name="edit_menjalar">
                                    <option selected disabled>Pilih</option>
                                    @foreach ($menjalar as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mt-3">
                                <label for="frekuensi">Frekuensi</label>
                                <select class="form-select" name="edit_frekuensi">
                                    <option selected disabled>Pilih</option>
                                    @foreach ($frekuensinyeri as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mt-3">
                                <label for="kualitas">Kualitas</label>
                                <select class="form-select" name="edit_kualitas">
                                    <option selected disabled>Pilih</option>
                                    @foreach ($kualitasnyeri as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mt-3">
                                <label for="faktor-pemberat">Faktor Pemberat</label>
                                <select class="form-select" name="edit_faktor_pemberat">
                                    <option selected disabled>Pilih</option>
                                    @foreach ($faktorpemberat as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mt-3">
                                <label for="faktor-peringanan">Faktor Peringanan</label>
                                <select class="form-select" name="edit_faktor_peringan">
                                    <option selected disabled>Pilih</option>
                                    @foreach ($faktorperingan as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mt-3">
                                <label for="efek-nyeri">Efek Nyeri</label>
                                <select class="form-select" name="edit_efek_nyeri">
                                    <option selected disabled>Pilih</option>
                                    @foreach ($efeknyeri as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnUpdateAsesmen">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Variable global
        let originalAlergiData = [];

        // Fungsi edit
        function editAsesmen(id) {
            const button = event.target.closest('button');
            const url = button.dataset.url;

            const modal = new bootstrap.Modal(document.getElementById('editAsesmenModal'));

            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log('Success Response:', response);
                    Swal.close();
                    if (response.status === 'success') {
                        fillEditForm(response.data.asesmen);
                        window.currentAsesmenId = id;
                        modal.show();
                    } else {
                        Swal.fire('Error', 'Data tidak ditemukan', 'error');
                    }
                },
                error: function(xhr) {
                    console.log('Error Response:', xhr.responseJSON);
                    Swal.close();
                    Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
                }
            });
        }

        let originalResusitasiData = null;
        // Fungsi mengisi form
        function fillEditForm(data) {
            // Fill textarea data
            $('textarea[name="edit_anamnesis"]').val(data.anamnesis || '');
            $('textarea[name="edit_riwayat_penyakit"]').val(data.riwayat_penyakit || '');
            $('textarea[name="edit_riwayat_pengobatan"]').val(data.riwayat_pengobatan || '');
            $('input[name="edit_skala_nyeri"]').val(data.show_skala_nyeri || '');
            $('input[name="edit_lokasi"]').val(data.show_lokasi || '');
            $('input[name="edit_durasi"]').val(data.show_durasi || '');
            $('select[name="edit_menjalar"]').val(data.asesmen.menjalar_id);
            $('select[name="edit_frekuensi"]').val(data.asesmen.frekuensi_nyeri_id);
            $('select[name="edit_kualitas"]').val(data.asesmen.kualitas_nyeri_id);
            $('select[name="edit_faktor_pemberat"]').val(data.asesmen.faktor_pemberat_id);
            $('select[name="edit_faktor_peringan"]').val(data.asesmen.faktor_peringan_id);
            $('select[name="edit_efek_nyeri"]').val(data.asesmen.efek_nyeri.id);
            
            console.log(data.asesmen);
            
            originalResusitasiData = data.tindakan_resusitasi;

            const tindakanResusitasi = typeof data.tindakan_resusitasi === 'string' ?
                JSON.parse(data.tindakan_resusitasi) : data.tindakan_resusitasi;
            fillEditTindakanResusitasi(tindakanResusitasi);

            // Isi vital sign
            if (data.vital_sign) {
                const vitalSign = typeof data.vital_sign === 'string' ?
                    JSON.parse(data.vital_sign) : data.vital_sign;

                $('input[name="edit_vital_sign_td_sistole"]').val(vitalSign.td_sistole || '');
                $('input[name="edit_vital_sign_td_diastole"]').val(vitalSign.td_diastole || '');
                $('input[name="edit_vital_sign_nadi"]').val(vitalSign.nadi || '');
                $('input[name="edit_vital_sign_resp"]').val(vitalSign.resp || '');
                $('input[name="edit_vital_sign_suhu"]').val(vitalSign.suhu || '');
                $('select[name="edit_vital_sign_gcs"]').val(vitalSign.gcs || '');
                $('select[name="edit_vital_sign_avpu"]').val(vitalSign.avpu || '');
                $('input[name="edit_vital_sign_spo2_tanpa_o2"]').val(vitalSign.spo2_tanpa_o2 || '');
                $('input[name="edit_vital_sign_spo2_dengan_o2"]').val(vitalSign.spo2_dengan_o2 || '');
            }

            // Isi antropometri
            if (data.antropometri) {
                const antropometri = typeof data.antropometri === 'string' ?
                    JSON.parse(data.antropometri) : data.antropometri;

                $('input[name="edit_antropometri_tb"]').val(antropometri.tb || '');
                $('input[name="edit_antropometri_bb"]').val(antropometri.bb || '');
                $('input[name="edit_antropometri_ling_kepala"]').val(antropometri.ling_kepala || '');
                $('input[name="edit_antropometri_lpt"]').val(antropometri.lpt || '');
                $('input[name="edit_antropometri_imt"]').val(antropometri.imt || '');
            }

            // Parse dan isi riwayat alergi
            const riwayatAlergi = typeof data.riwayat_alergi === 'string' ?
                JSON.parse(data.riwayat_alergi) : data.riwayat_alergi;

            // Simpan data alergi awal
            originalAlergiData = riwayatAlergi || [];

            fillEditAlergiTable(riwayatAlergi);
        }

        // Fungsi mengisi tindakan resusitasi
        function fillEditTindakanResusitasi(tindakanData) {
            $('input[name^="edit_tindakan_resusitasi"]').each(function() {
                $(this).prop('checked', false).data('original-state', false);
            });

            if (!tindakanData) return;

            // Parse data jika dalam bentuk string
            if (typeof tindakanData === 'string') {
                try {
                    tindakanData = JSON.parse(tindakanData);
                } catch (e) {
                    console.error('Error parsing tindakan resusitasi:', e);
                    return;
                }
            }

            if (tindakanData.air_way && Array.isArray(tindakanData.air_way)) {
                tindakanData.air_way.forEach(item => {
                    const checkbox = $(`input[name="edit_tindakan_resusitasi[air_way][]"][value="${item}"]`);
                    checkbox.prop('checked', true).data('original-state', true);
                });
            }

            if (tindakanData.breathing && Array.isArray(tindakanData.breathing)) {
                tindakanData.breathing.forEach(item => {
                    const checkbox = $(`input[name="edit_tindakan_resusitasi[breathing][]"][value="${item}"]`);
                    checkbox.prop('checked', true).data('original-state', true);
                });
            }

            if (tindakanData.circulation && Array.isArray(tindakanData.circulation)) {
                tindakanData.circulation.forEach(item => {
                    const checkbox = $(`input[name="edit_tindakan_resusitasi[circulation][]"][value="${item}"]`);
                    checkbox.prop('checked', true).data('original-state', true);
                });
            }
        }

        // Event handler untuk delete alergi
        $(document).on('click', '.delete-edit-alergi', function() {
            $('#editAddAlergi').data('hasChanges', true);

            $(this).closest('tr').remove();

            if ($('#editAlergiTable tbody tr').length === 0) {
                $('#editAlergiTable tbody').html(`
                <tr>
                    <td colspan="5" class="text-center">
                        <em>Tidak ada data alergi</em>
                    </td>
                </tr>
            `);
            }
        });

        // Fungsi mengisi tabel alergi
        function fillEditAlergiTable(alergiData) {
            const tbody = $('#editAlergiTable tbody');
            tbody.empty();

            if (!alergiData || !Array.isArray(alergiData) || alergiData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            <em>Tidak ada data alergi</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alergiData.forEach((alergi, index) => {
                const row = `
                    <tr>
                        <td>${alergi.jenis || '-'}</td>
                        <td>${alergi.alergen || '-'}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.keparahan || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete-edit-alergi" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function collectEditTindakanResusitasi() {

            let air_way_all = $('#editAsesmenModal input[name="edit_tindakan_resusitasi[air_way][]"]:checkbox:checked').map(
                function() {
                    return $(this).val();
                }).get();

            let breathing_all = $('#editAsesmenModal input[name="edit_tindakan_resusitasi[breathing][]"]:checkbox:checked')
                .map(function() {
                    return $(this).val();
                }).get();

            let circulation_all = $(
                '#editAsesmenModal input[name="edit_tindakan_resusitasi[circulation][]"]:checkbox:checked').map(
                function() {
                    return $(this).val();
                }).get();

            return {
                air_way: air_way_all,
                breathing: breathing_all,
                circulation: circulation_all
            };
        }

        // Fungsi collect data alergi
        function collectEditAlergi() {
            if (!$('#editAddAlergi').data('hasChanges')) {
                return originalAlergiData;
            }

            const uniqueAlergis = new Set();
            const alergiData = [];

            $('#editAlergiTable tbody tr').each(function() {
                const $row = $(this);
                const jenis = $row.find('td:eq(0)').text();

                if (jenis === 'Tidak ada data alergi' || jenis === '-') {
                    return;
                }

                const alergen = $row.find('td:eq(1)').text();
                const reaksi = $row.find('td:eq(2)').text();
                const keparahan = $row.find('td:eq(3)').text();

                const key = `${jenis}-${alergen}-${reaksi}-${keparahan}`;

                if (!uniqueAlergis.has(key)) {
                    uniqueAlergis.add(key);
                    alergiData.push({
                        jenis: jenis,
                        alergen: alergen,
                        reaksi: reaksi,
                        keparahan: keparahan
                    });
                }
            });

            return alergiData;
        }

        $('#btnUpdateAsesmen').click(function(event) {
            event.preventDefault();

            // if ($(this).prop('disabled')) return;
            $(this).prop('disabled', true);
            const menjalarId = $('select[name="edit_menjalar"]').val();
            const frekuensiId = $('select[name="edit_frekuensi"]').val();
            const kualitasId = $('select[name="edit_kualitas"]').val();
            const faktorPemberatId = $('select[name="edit_faktor_pemberat"]').val();
            const faktorPeringanId = $('select[name="edit_faktor_peringan"]').val();
            const efekNyeriId = $('select[name="edit_efek_nyeri"]').val();

            const formData = {
                _method: 'PUT',
                tindakan_resusitasi: collectEditTindakanResusitasi(),
                anamnesis: $('textarea[name="edit_anamnesis"]').val(),
                riwayat_penyakit: $('textarea[name="edit_riwayat_penyakit"]').val(),
                riwayat_pengobatan: $('textarea[name="edit_riwayat_pengobatan"]').val(),
                vital_sign: {
                    td_sistole: $('input[name="edit_vital_sign_td_sistole"]').val() || null,
                    td_diastole: $('input[name="edit_vital_sign_td_diastole"]').val() || null,
                    nadi: $('input[name="edit_vital_sign_nadi"]').val() || null,
                    resp: $('input[name="edit_vital_sign_resp"]').val() || null,
                    suhu: $('input[name="edit_vital_sign_suhu"]').val() || null,
                    gcs: $('select[name="edit_vital_sign_gcs"]').val() || null,
                    avpu: $('select[name="edit_vital_sign_avpu"]').val() || null,
                    spo2_tanpa_o2: $('input[name="edit_vital_sign_spo2_tanpa_o2"]').val() || null,
                    spo2_dengan_o2: $('input[name="edit_vital_sign_spo2_dengan_o2"]').val() || null
                },
                antropometri: {
                    tb: $('input[name="edit_antropometri_tb"]').val() || null,
                    bb: $('input[name="edit_antropometri_bb"]').val() || null,
                    ling_kepala: $('input[name="edit_antropometri_ling_kepala"]').val() || null,
                    lpt: $('input[name="edit_antropometri_lpt"]').val() || null,
                    imt: $('input[name="edit_antropometri_imt"]').val() || null

                },
                riwayat_alergi: collectEditAlergi(),
                skala_nyeri: $('input[name="edit_skala_nyeri"]').val(),
                lokasi: $('input[name="edit_lokasi"]').val(),
                durasi: $('input[name="edit_durasi"]').val(),
                menjalar_id: menjalarId,
                frekuensi_nyeri_id: frekuensiId,
                kualitas_nyeri_id: kualitasId,
                faktor_pemberat_id: faktorPemberatId,
                faktor_peringan_id: faktorPeringanId,
                efek_nyeri: efekNyeriId
                
            };

            const editButton = $(`button[onclick="editAsesmen('${window.currentAsesmenId}')"]`);
            const baseUrl = editButton.data('url');
            const updateUrl = baseUrl.replace('/show', '');

            $.ajax({
                url: updateUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(response) {
                    console.log('Success Response:', response);
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data berhasil diupdate',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'Gagal menyimpan data', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseJSON);
                    Swal.fire('Error', xhr.responseJSON?.message ||
                        'Terjadi kesalahan saat menyimpan data', 'error');
                },
                complete: function() {
                    $('#btnUpdateAsesmen').prop('disabled', false);
                }
            });
        });

        // Reset flags saat modal dibuka/ditutup
        $('#editAsesmenModal').on('show.bs.modal', function() {
            $('#editAddAlergi').data('hasChanges', false);
        });

        $('#editAsesmenModal').on('hidden.bs.modal', function() {
            $('#editAddAlergi').data('hasChanges', false);
            originalAlergiData = [];
        });
    </script>
@endpush
