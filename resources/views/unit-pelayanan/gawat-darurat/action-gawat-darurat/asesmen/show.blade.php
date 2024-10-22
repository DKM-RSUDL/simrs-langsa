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
                                    <small> {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn </small>

                                    <div class="patient-meta mt-2">
                                        <p class="mb-0"><i
                                                class="bi bi-file-earmark-medical"></i>RM:{{ $dataMedis->pasien->kd_pasien }}
                                        </p>
                                        <p class="mb-0"><i
                                                class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') }}
                                        </p>
                                        <p><i class="bi bi-hospital"></i>{{ $dataMedis->unit->bagian->bagian }}
                                            ({{ $dataMedis->unit->nama_unit }})</p>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="card-header">
                                        <h4 class="text-primary">Informasi Pasien:</h4>
                                    </div>
                                    <div class="card-body">
                                        <p style="margin-bottom: 5px;"><strong>Alergi</strong></p>
                                        <ul style="margin-bottom: 5px; padding-left: 15px;">
                                            <li>Ikan Tongkol</li>
                                            <li>Asap</li>
                                        </ul>
                                        <p style="margin-bottom: 5px;"><strong>Golongan Darah</strong></p>
                                        <p style="margin-bottom: 5px;">A+</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content Area -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-primary">Asesmen Awal Gawat Darurat Medis</h4>
                                    <p>Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="card w-100 h-100">
                                        <div class="card-body">

                                            <div class="form-line">
                                                <h6>Triage Pasien</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal/Jam</th>
                                                                <th>Dokter</th>
                                                                <th>Triage</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> {{ $dataMedis->waktu_masuk }} </td>
                                                                <td> {{ $dataMedis->nama_dokter ?? 'Tidak Ada Dokter' }}
                                                                </td>
                                                                <td>
                                                                    <div class="rounded-circle {{ $triageClass }}"
                                                                        style="width: 35px; height: 35px;"></div>
                                                                </td>
                                                                <td><a href="#">detail</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

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
                                                                <td class="show-air-way">
                                                                </td>
                                                                <td class="show-breathing">
                                                                </td>
                                                                <td class="show-circulation">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Keluhan/Anamnesis</h6>
                                                <textarea class="form-control mb-2" rows="3" name="anamnesis" readonly
                                                    placeholder="Isikan keluhan dan anamnesis pasien, jika terjadi cidera jelaskan mekanisme cideranya"></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Penyakit Pasien</h6>
                                                <textarea class="form-control mb-2" rows="3" name="riwayat_penyakit" readonly
                                                    placeholder="Isikan riwayat penyakit pasien"></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Pengobatan</h6>
                                                <textarea class="form-control mb-2" rows="3" name="riwayat_pengobatan" readonly
                                                    placeholder="Isikan riwayat pengobatan pasien"></textarea>
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

{{-- @push('js')
    <script>
        function showAsesmen(id) {
            // Inisialisasi modal
            const modal = new bootstrap.Modal(document.getElementById('showasesmenModal'));

            // Tampilkan loading
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch data
            $.ajax({
                url: `asesmen/${id}/show`,
                method: 'GET',
                success: function(response) {
                    if (response.status == 'success') {
                        const data = response.data;

                        handleTindakanResusitasi(data.asesmen.tindakan_resusitasi);
                        handleTextareaData(data.asesmen);
                        // ... kode lainnya untuk data yang lain ...
                        Swal.close();
                        modal.show();
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan saat memuat data', 'error');
                }
            });
        }

        function handleTextareaData(asesmen) {
            // Isi textarea dan set disabled
            $('textarea[name="anamnesis"]')
                .val(asesmen.anamnesis || '-')
                .prop('disabled', true);

            $('textarea[name="riwayat_penyakit"]')
                .val(asesmen.riwayat_penyakit || '-')
                .prop('disabled', true);

            $('textarea[name="riwayat_pengobatan"]')
                .val(asesmen.riwayat_pengobatan || '-')
                .prop('disabled', true);
        }

        $('#showasesmenModal').on('hidden.bs.modal', function() {
            // Reset semua textarea
            $(this).find('textarea').val('');
        });

        function handleTindakanResusitasi(tindakanData) {
            const createItemElement = (text) =>
                `<div class="selected-item"><i class="fas fa-check text-success"></i> ${text}</div>`;

            $('.show-air-way, .show-breathing, .show-circulation').empty();

            if (tindakanData && tindakanData.air_way && tindakanData.air_way.length > 0) {
                const airWayHtml = tindakanData.air_way
                    .map(item => createItemElement(item))
                    .join('');
                $('.show-air-way').html(airWayHtml);
            } else {
                $('.show-air-way').html('<em>Tidak ada tindakan</em>');
            }

            if (tindakanData && tindakanData.breathing && tindakanData.breathing.length > 0) {
                const breathingHtml = tindakanData.breathing
                    .map(item => createItemElement(item))
                    .join('');
                $('.show-breathing').html(breathingHtml);
            } else {
                $('.show-breathing').html('<em>Tidak ada tindakan</em>');
            }

            // Handle Circulation
            if (tindakanData && tindakanData.circulation && tindakanData.circulation.length > 0) {
                const circulationHtml = tindakanData.circulation
                    .map(item => createItemElement(item))
                    .join('');
                $('.show-circulation').html(circulationHtml);
            } else {
                $('.show-circulation').html('<em>Tidak ada tindakan</em>');
            }
        }

        // Style untuk tampilan
        const style = `
    <style>
        .selected-item {
            padding: 5px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .selected-item i {
            font-size: 14px;
        }
    </style>
    `;

        // Tambahkan style ke head
        $('head').append(style);
    </script>
@endpush --}}
