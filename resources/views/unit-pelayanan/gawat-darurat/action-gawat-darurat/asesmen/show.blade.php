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
    </script>
@endpush
