<!-- Modal -->
<div class="modal fade" id="showasesmenModal" tabindex="-1" aria-labelledby="showasesmenLabel" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Side Column -->
                        <div class="col-md-3 border-right">
                            <div class="position-relative patient-card">
                                <div class="patient-photo-asesmen">
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
                                </div>

                                <div class="patient-info">
                                    <h6>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</h6>
                                    <p class="mb-0">
                                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
                                    </p>
                                    <small>{{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn</small>
                                </div>

                                <!-- Informasi lainnya -->
                            </div>
                        </div>

                        <!-- Main Content Area -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-primary">Asesmen Awal Gawat Darurat Medis</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="card w-100 h-100">
                                        <div class="card-body">
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
                                                                <td class="show-air-way"></td>
                                                                <td class="show-breathing"></td>
                                                                <td class="show-circulation"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Form fields -->
                                            <div class="form-line">
                                                <h6>Keluhan/Anamnesis</h6>
                                                <textarea class="form-control mb-2" rows="3" name="anamnesis" readonly></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Penyakit Pasien</h6>
                                                <textarea class="form-control mb-2" rows="3" name="riwayat_penyakit" readonly></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Pengobatan</h6>
                                                <textarea class="form-control mb-2" rows="3" name="riwayat_pengobatan" readonly></textarea>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Riwayat Alergi</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="showAlergiTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Jenis</th>
                                                                <th>Alergen</th>
                                                                <th>Reaksi</th>
                                                                <th>Serve</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- data --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Vital Sign</h6>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label>TD (Sistole)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_td_sistole" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>TD (Diastole)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_td_diastole" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Nadi (x/mnt)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_nadi" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Resp (x/mnt)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_resp" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Suhu (°C)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_suhu" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-2">
                                                        <label>GCS</label>
                                                        <input type="text" class="form-control"
                                                            name="show_vital_sign_gcs" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>AVPU</label>
                                                        <input type="text" class="form-control"
                                                            name="show_vital_sign_avpu" readonly>
                                                    </div>
                                                    <div class="col-3">
                                                        <label>SpO2 (tanpa O2)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_spo2_tanpa_o2" readonly>
                                                    </div>
                                                    <div class="col-3">
                                                        <label>SpO2 (dengan O2)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_vital_sign_spo2_dengan_o2" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Antropometri</h6>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label>TB (meter)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_antropometri_tb" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>BB (kg)</label>
                                                        <input type="number" class="form-control"
                                                            name="show_antropometri_bb" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Ling. Kepala</label>
                                                        <input type="number" class="form-control"
                                                            name="show_antropometri_ling_kepala" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>LPT</label>
                                                        <input type="number" class="form-control"
                                                            name="show_antropometri_lpt" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>IMT</label>
                                                        <input type="number" class="form-control"
                                                            name="show_antropometri_imt" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Skala Nyeri Visual Analog</h6>
                                                <p class="text-muted">*Pilih angka pada skala nyeri yang sesuai</p>
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-6">
                                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                            alt="Descriptive Alt Text"
                                                            style="width: 100%; height: auto;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="mb-3">Karakteristik Nyeri</h6>
                                                        <div class="mb-2">
                                                            <label>Skala Nyeri</label>
                                                            <input type="number" name="show_skala_nyeri" class="form-control" readonly>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label>Lokasi Nyeri</label>
                                                            <input type="text" name="show_lokasi" class="form-control" readonly>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label>Durasi</label>
                                                            <input type="text" name="show_durasi" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="manjalar">Manjalar</label>
                                                    <input class="form-control" name="show_menjalar" readonly>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="frekuensi">Frekuensi</label>
                                                    <input class="form-control" name="show_frekuensi" readonly>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="kualitas">Kualitas</label>
                                                    <input class="form-control" name="show_kualitas" readonly>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="faktor-pemberat">Faktor Pemberat</label>
                                                    <input  class="form-control" name="show_faktor_pemberat" readonly>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="faktor-peringanan">Faktor Peringanan</label>
                                                    <input class="form-control" name="show_faktor_peringan" readonly>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="efek-nyeri">Efek Nyeri</label>
                                                    <input class="form-control" name="show_efek_nyeri" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function showAsesmen(id) {
            const button = event.target.closest('button');
            const url = button.dataset.url;

            const modal = new bootstrap.Modal(document.getElementById('showasesmenModal'));

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
                        handleTindakanResusitasi(response.data.asesmen.tindakan_resusitasi);
                        handleTextareaData(response.data.asesmen);
                        handleRiwayatAlergi(response.data.asesmen.riwayat_alergi);
                        handleVitalSign(response.data.asesmen.vital_sign);
                        handleAntropometri(response.data.asesmen.antropometri);
                        modal.show();
                    } else {
                        Swal.fire('Error', 'Data tidak ditemukan', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error Response:', xhr.responseJSON);
                    Swal.close();
                    Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan saat memuat data',
                        'error');
                }
            });
        }

        function handleTextareaData(asesmen) {
            $('textarea[name="anamnesis"]').val(asesmen.anamnesis || '-');
            $('textarea[name="riwayat_penyakit"]').val(asesmen.riwayat_penyakit || '-');
            $('textarea[name="riwayat_pengobatan"]').val(asesmen.riwayat_pengobatan || '-');
            $('input[name="show_skala_nyeri"]').val(asesmen.show_skala_nyeri || '-');
            $('input[name="show_lokasi"]').val(asesmen.show_lokasi || '-');
            $('input[name="show_durasi"]').val(asesmen.show_durasi || '-');
            $('input[name="show_menjalar"]').val(asesmen.show_menjalar || '-');
            $('input[name="show_frekuensi"]').val(asesmen.show_frekuensi || '-');
            $('input[name="show_kualitas"]').val(asesmen.show_kualitas || '-');
            $('input[name="show_faktor_pemberat"]').val(asesmen.show_faktor_pemberat || '-');
            $('input[name="show_faktor_peringan"]').val(asesmen.show_faktor_peringan || '-');
            $('input[name="show_efek_nyeri"]').val(asesmen.show_efek_nyeri || '-');
        }

        function handleTindakanResusitasi(tindakanData) {
            if (!tindakanData) {
                $('.show-air-way, .show-breathing, .show-circulation').html('<em>Tidak ada tindakan</em>');
                return;
            }

            const createItemElement = (text) =>
                `<div class="selected-item"><i class="fas fa-check text-success"></i> ${text}</div>`;

            // Air Way
            if (tindakanData.air_way?.length > 0) {
                $('.show-air-way').html(tindakanData.air_way.map(createItemElement).join(''));
            } else {
                $('.show-air-way').html('<em>Tidak ada tindakan</em>');
            }

            // Breathing
            if (tindakanData.breathing?.length > 0) {
                $('.show-breathing').html(tindakanData.breathing.map(createItemElement).join(''));
            } else {
                $('.show-breathing').html('<em>Tidak ada tindakan</em>');
            }

            // Circulation
            if (tindakanData.circulation?.length > 0) {
                $('.show-circulation').html(tindakanData.circulation.map(createItemElement).join(''));
            } else {
                $('.show-circulation').html('<em>Tidak ada tindakan</em>');
            }
        }

        function handleRiwayatAlergi(alergiData) {
            const tbody = $('#showAlergiTable tbody');
            tbody.empty();

            if (typeof alergiData === 'string') {
                try {
                    alergiData = JSON.parse(alergiData);
                } catch (e) {
                    console.error('Error parsing alergi data:', e);
                    alergiData = null;
                }
            }

            if (!alergiData || alergiData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada data alergi</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alergiData.forEach(function(alergi) {
                const row = `
                    <tr>
                        <td>${alergi.jenis || '-'}</td>
                        <td>${alergi.alergen || '-'}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.keparahan || '-'}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleVitalSign(vitalSignData) {
            console.log('Handling vital sign data:', vitalSignData); // Debug log

            if (typeof vitalSignData === 'string') {
                try {
                    vitalSignData = JSON.parse(vitalSignData);
                } catch (e) {
                    console.error('Error parsing vital sign data:', e);
                    return;
                }
            }

            // Set nilai untuk setiap input
            $('input[name="show_vital_sign_td_sistole"]').val(vitalSignData.td_sistole || '-');
            $('input[name="show_vital_sign_td_diastole"]').val(vitalSignData.td_diastole || '-');
            $('input[name="show_vital_sign_nadi"]').val(vitalSignData.nadi || '-');
            $('input[name="show_vital_sign_resp"]').val(vitalSignData.resp || '-');
            $('input[name="show_vital_sign_suhu"]').val(vitalSignData.suhu || '-');
            $('input[name="show_vital_sign_gcs"]').val(vitalSignData.gcs || '-');
            $('input[name="show_vital_sign_avpu"]').val(vitalSignData.avpu || '-');
            $('input[name="show_vital_sign_spo2_tanpa_o2"]').val(vitalSignData.spo2_tanpa_o2 || '-');
            $('input[name="show_vital_sign_spo2_dengan_o2"]').val(vitalSignData.spo2_dengan_o2 || '-');
        }

        function handleAntropometri(AntropometriData) {
            if (typeof AntropometriData === 'string') {
                try {
                    AntropometriData = JSON.parse(AntropometriData);
                } catch (e) {
                    console.error('Error Antropometri data:', e);
                    return;
                }
            }

            $('input[name="show_antropometri_tb"]').val(AntropometriData.tb || '-');
            $('input[name="show_antropometri_bb"]').val(AntropometriData.bb || '-');
            $('input[name="show_antropometri_ling_kepala"]').val(AntropometriData.ling_kepala || '-');
            $('input[name="show_antropometri_lpt"]').val(AntropometriData.lpt || '-');
            $('input[name="show_antropometri_imt"]').val(AntropometriData.imt || '-');

        }
    </script>
@endpush
