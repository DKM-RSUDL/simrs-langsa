<!-- Modal Show Rujukan Antar RS -->
<div class="modal fade" id="showRujukAntarRs" tabindex="-1" aria-labelledby="showRujukAntarRsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="showRujukAntarRsLabel">Detail Rujukan Antar Rumah Sakit</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="showRujukAntarRsBody">
                <div class="text-center">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning edit-from-show" data-bs-toggle="modal" data-bs-target="#editRujukAntarRs">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $(document).on('click', '.show-btn', function() {
            const id = $(this).data('id');
            const kd_pasien = '{{ $dataMedis->kd_pasien ?? '' }}';
            const tgl_masuk = '{{ $dataMedis->tgl_masuk ?? date('Y-m-d') }}';
            const urut_masuk = '{{ $dataMedis->urut_masuk ?? '' }}';
            window.currentShowId = id;

            $('#showRujukAntarRsBody').html(`
                <div class="text-center">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: `/unit-pelayanan/gawat-darurat/pelayanan/${kd_pasien}/${tgl_masuk}/${urut_masuk}/rujuk-antar-rs/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log("Show data received:", data);
                    formatDetailView(data);
                },
                error: function(xhr) {
                    $('#showRujukAntarRsBody').html(`
                        <div class="alert alert-danger" role="alert">
                            Error: ${xhr.status} - ${xhr.statusText}
                        </div>
                    `);
                }
            });
        });

        $(document).on('click', '.edit-from-show', function() {
            $('#showRujukAntarRs').modal('hide');
            if (window.currentShowId) $('.edit-btn[data-id="' + window.currentShowId + '"]').trigger('click');
        });

        function formatTime(time) {
            if (!time) return 'N/A';
            const [hours, minutes] = time.split(':');
            return `${hours}:${minutes}`;
        }

        function formatDetailView(data) {
            const pendamping = {
                dokter: data.pendamping_dokter === '1',
                perawat: data.pendamping_perawat === '1',
                keluarga: data.pendamping_keluarga === '1',
                detail_keluarga: data.detail_keluarga || 'Tidak disebutkan',
                tidak_ada: data.pendamping_tidak_ada === '0',
            };
            const alasan = {
                tempat_penuh: data.alasan_tempat_penuh === '1',
                permintaan_keluarga: data.alasan_permintaan_keluarga === '1',
                perawatan_khusus: data.alasan_perawatan_khusus === '1',
                lainnya: data.alasan_lainnya === '1',
                detail_lainnya: data.detail_alasan_lainnya || 'Tidak disebutkan',
            };

            const pendampingList = [
                pendamping.dokter ? '<li>Dokter</li>' : '',
                pendamping.perawat ? '<li>Perawat</li>' : '',
                pendamping.keluarga ? `<li>Keluarga: ${pendamping.detail_keluarga}</li>` : '',
                pendamping.tidak_ada ? '<li>Tidak ada</li>' : '',
            ].filter(item => item).join('') || '<li>Tidak ada pendamping</li>';

            const alasanList = [
                alasan.tempat_penuh ? '<li>Tempat penuh</li>' : '',
                alasan.permintaan_keluarga ? '<li>Permintaan keluarga</li>' : '',
                alasan.perawatan_khusus ? '<li>Perawatan khusus</li>' : '',
                alasan.lainnya ? `<li>Lainnya: ${alasan.detail_lainnya}</li>` : '',
            ].filter(item => item).join('') || '<li>Tidak ada alasan</li>';

            const alergiData = data.alergi ? (typeof data.alergi === 'string' ? JSON.parse(data.alergi) : data.alergi) : [];
            const diagnosisData = data.diagnosis ? (typeof data.diagnosis === 'string' ? JSON.parse(data.diagnosis) : data.diagnosis) : [];

            const html = `
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Informasi Rujukan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <p class="mb-1"><strong>Tanggal:</strong> ${data.tanggal || 'N/A'}</p>
                                <p class="mb-1"><strong>Jam:</strong> ${formatTime(data.jam) || 'N/A'}</p>
                                <p class="mb-1"><strong>Transportasi:</strong> ${data.transportasi || 'N/A'} ${data.detail_kendaraan ? `- ${data.detail_kendaraan}` : ''}</p>
                                <p class="mb-1"><strong>Nomor Polisi:</strong> ${data.nomor_polisi || 'N/A'}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="mb-1"><strong>Pendamping:</strong></p>
                                <ul class="list-unstyled">${pendampingList}</ul>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Tanda Vital:</strong></p>
                                <div class="row g-2">
                                    <div class="col-6 col-md-4"><span class="badge bg-secondary">Suhu:</span> ${data.suhu || 'N/A'} °C</div>
                                    <div class="col-6 col-md-4"><span class="badge bg-secondary">Sistole:</span> ${data.sistole || 'N/A'} mmHg</div>
                                    <div class="col-6 col-md-4"><span class="badge bg-secondary">Diastole:</span> ${data.diastole || 'N/A'} mmHg</div>
                                    <div class="col-6 col-md-4"><span class="badge bg-secondary">Nadi:</span> ${data.nadi || 'N/A'} bpm</div>
                                    <div class="col-6 col-md-4"><span class="badge bg-secondary">Respirasi:</span> ${data.respirasi || 'N/A'} rpm</div>
                                    <div class="col-6 col-md-4"><span class="badge bg-secondary">Status Nyeri:</span> ${data.status_nyeri || 'N/A'} / 10</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Alasan Pindah RS:</strong></p>
                                <ul class="list-unstyled">${alasanList}</ul>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Alergi:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    ${alergiData.length ? alergiData.map(al => `<span class="badge bg-primary">${al.name} - ${al.reaction}</span>`).join('') : '<span class="badge bg-secondary">Tidak ada</span>'}
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Alasan Masuk/Dirujuk:</strong></p>
                                <p class="text-muted">${data.alasan_masuk_dirujuk || 'N/A'}</p>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Hasil Pemeriksaan Penunjang:</strong></p>
                                <p class="text-muted">${data.hasil_pemeriksaan_penunjang || 'N/A'}</p>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Terapi/Pengobatan:</strong></p>
                                <p class="text-muted">${data.terapi || 'N/A'}</p>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Diagnosis:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    ${diagnosisData.length ? diagnosisData.map(d => `<span class="badge bg-success">${d.name}</span>`).join('') : '<span class="badge bg-secondary">Tidak ada</span>'}
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Tindakan/Prosedur:</strong></p>
                                <p class="text-muted">${data.tindakan || 'N/A'}</p>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <p class="mb-1"><strong>Edukasi Pasien:</strong></p>
                                <p class="text-muted">${data.edukasi_pasien || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#showRujukAntarRsBody').html(html);
        }
    });
</script>
@endpush
