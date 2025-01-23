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
                                                <h6>Riwayat Penyakit Keluarga Pasien</h6>
                                                <textarea class="form-control mb-2" rows="3" name="riwayat_penyakit_keluarga" readonly></textarea>
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
                                                            <input type="number" name="show_skala_nyeri"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label>Lokasi Nyeri</label>
                                                            <input type="text" name="show_lokasi"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label>Durasi</label>
                                                            <input type="text" name="show_durasi"
                                                                class="form-control" readonly>
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
                                                    <input class="form-control" name="show_faktor_pemberat" readonly>
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

                                            <div class="form-line">
                                                <div class="pemeriksaan-fisik">
                                                    <h6>Pemeriksaan Fisik</h6>
                                                    <p class="text-small">Centang normal jika fisik yang dinilai
                                                        normal,
                                                        pilih tanda tambah
                                                        untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                        Jika
                                                        tidak dipilih salah satunya, maka pemeriksaan tidak
                                                        dilakukan.
                                                    </p>
                                                    <div class="row" id="show_pemeriksaan_fisik_container">
                                                        @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                            <div class="col-md-6">
                                                                @foreach ($chunk as $item)
                                                                    <div class="pemeriksaan-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1">
                                                                                {{ $item->nama }}</div>
                                                                            <div class="form-check me-2">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="{{ $item->id }}-normal">
                                                                                <label class="form-check-label"
                                                                                    for="{{ $item->id }}-normal">Normal</label>
                                                                            </div>
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                type="button"
                                                                                data-target="{{ $item->id }}-keterangan">+</button>
                                                                        </div>
                                                                        <div class="keterangan mt-2"
                                                                            id="{{ $item->id }}-keterangan"
                                                                            style="display:none;">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Keterangan">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Pemeriksaan Penunjang Klinis</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ asset('assets/img/icons/test_tube.png') }}">
                                                    <h6 class="mb-0 me-3">Laboratorium</h6>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Nama Pemeriksaan</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($laborData as $data)
                                                                <tr>
                                                                    <td>{{ $data['Tanggal-Jam'] }}</td>
                                                                    <td>{{ $data['Nama pemeriksaan'] }}</td>
                                                                    <td>
                                                                        @if ($data['Status'] == 'Diorder')
                                                                            <i
                                                                                class="bi bi-check-circle-fill text-secondary"></i>
                                                                            Diorder
                                                                        @elseif ($data['Status'] == 'Selesai')
                                                                            <i
                                                                                class="bi bi-check-circle-fill text-success"></i>
                                                                            <p class="text-success">Selesai</p>
                                                                        @else
                                                                            {{ $data['Status'] }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center">Tidak
                                                                        ada
                                                                        data laboratorium</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="d-flex align-items-center mb-3">
                                                    <img
                                                        src="{{ asset('assets/img/icons/microbeam_radiation_therapy.png') }}">
                                                    <h6 class="mb-0 me-3">Radiologi</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Nama Pemeriksaan</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($radiologiData as $rad)
                                                                <tr>
                                                                    <td>{{ $rad['Tanggal-Jam'] }}</td>
                                                                    <td>{{ $rad['Nama Pemeriksaan'] }}</td>
                                                                    <td>{!! $rad['Status'] !!}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center">Tidak
                                                                        ada
                                                                        data radiologi</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ asset('assets/img/icons/pill.png') }}">
                                                    <h6 class="mb-0 me-3">E-Resep</h6>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Nama Obat</th>
                                                                <th>Dosis</th>
                                                                <th>Cara Pemberian</th>
                                                                <th>PPA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($riwayatObat as $resep)
                                                                @php
                                                                    $cara_pakai_parts = explode(
                                                                        ',',
                                                                        $resep->cara_pakai,
                                                                    );
                                                                    $frekuensi = trim($cara_pakai_parts[0] ?? '');
                                                                    $keterangan = trim($cara_pakai_parts[1] ?? '');
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ \Carbon\Carbon::parse($resep->tgl_order)->format('d M Y H:i') }}
                                                                    </td>
                                                                    <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}
                                                                    </td>
                                                                    <td>{{ $resep->jumlah_takaran }}
                                                                        {{ Str::title($resep->satuan_takaran) }}
                                                                    </td>
                                                                    <td>{{ $keterangan }}</td>
                                                                    <td>{{ $resep->nama_dokter }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center">Tidak
                                                                        ada Resep Obat</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Diagnosis</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="bg-secondary-subtle rounded-2 p-3">
                                                            <textarea name="show_diagnosis" class="form-control" readonly></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Observasi Lanjutan/Re-Triase</h6>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered" id="ShowreTriaseTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Keluhan</th>
                                                                <th>Vital Sign</th>
                                                                <th>Re-Triase/EWS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data re-triase akan ditampilkan di sini -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Alat yang Terpasang</h6>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered" id="showAlatTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Alat yang terpasang</th>
                                                                <th>Lokasi</th>
                                                                <th>Ket</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data akan ditampilkan di sini -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Kondisi Pasien sebelum meninggalkan IGD</h6>
                                                <textarea class="form-control mb-2" rows="3" name="show_kondisi_pasien" readonly></textarea>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Tindak Lanjut Pelayanan</h6>
                                                </div>
                                                <div id="showTindakLanjutInfo"></div>
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
                <button type="button" class="btn btn-primary" onclick="printAsesmenReport()">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
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
                        handleReTriase(response.data.asesmen.retriase_data);
                        handleAlatTerpasang(response.data.asesmen.alat_terpasang);
                        handleTindakLanjut(response.data.asesmen.tindaklanjut);
                        handlePemeriksaanFisik(response.data.asesmen.pemeriksaan_fisik);
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
            $('textarea[name="riwayat_penyakit_keluarga"]').val(asesmen.riwayat_penyakit_keluarga || '-');
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
            $('textarea[name="show_kondisi_pasien"]').val(asesmen.show_kondisi_pasien || '-');

            // Handle diagnosis format for array data
            let formattedDiagnosis = '-';
            if (Array.isArray(asesmen.show_diagnosis) && asesmen.show_diagnosis.length > 0) {
                formattedDiagnosis = asesmen.show_diagnosis
                    .map((diag, index) => `${index + 1}. ${diag.trim()}`)
                    .join('\n');
            }

            $('.bg-secondary-subtle .form-control').replaceWith(`
                <textarea class="form-control" name="show_diagnosis" readonly rows="${Math.max(formattedDiagnosis.split('\n').length, 1)}">${formattedDiagnosis}</textarea>
            `);
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

        function handleAlatTerpasang(alatTerpasang) {
            const tbody = $('#showAlatTable tbody');
            tbody.empty();

            if (typeof alatTerpasang === 'string') {
                try {
                    alatTerpasang = JSON.parse(alatTerpasang);
                } catch (e) {
                    console.error('Error data:', e);
                    alatTerpasang = null;
                }
            }

            if (!alatTerpasang || alatTerpasang.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada data Alat Terpasang</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alatTerpasang.forEach(function(alat) {
                const row = `
                    <tr>
                        <td>${alat.nama || '-'}</td>
                        <td>${alat.lokasi || '-'}</td>
                        <td>${alat.keterangan || '-'}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleVitalSign(vitalSignData) {

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
            $('input[name="show_vital_sign_gcs"]').val(vitalSignData.gcs.total || '-');
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

        function handleReTriase(retriaseData) {
            console.log(retriaseData);

            const tbody = $('#ShowreTriaseTable tbody');
            tbody.empty();

            if (!retriaseData || retriaseData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada data re-triase</em>
                        </td>
                    </tr>
                `);
                return;
            }

            retriaseData.forEach(function(triase) {
                // Parse triase JSON if needed
                const vitalSignData = typeof triase.vitalsign_retriase === 'string' ?
                    JSON.parse(triase.vitalsign_retriase) : triase.vitalsign_retriase;

                // Format vital signs
                const formattedVitalSigns = `
                    <ul class="list-unstyled mb-0">
                        ${vitalSignData.td_sistole ? `<li>TD: ${vitalSignData.td_sistole}/${vitalSignData.td_diastole} mmHg</li>` : ''}
                        ${vitalSignData.nadi ? `<li>Nadi: ${vitalSignData.nadi} x/mnt</li>` : ''}
                        ${vitalSignData.resp ? `<li>Resp: ${vitalSignData.resp} x/mnt</li>` : ''}
                        ${vitalSignData.suhu ? `<li>Suhu: ${vitalSignData.suhu}°C</li>` : ''}
                        ${vitalSignData.spo2_tanpa_o2 ? `<li>SpO2 (tanpa O2): ${vitalSignData.spo2_tanpa_o2}%</li>` : ''}
                        ${vitalSignData.spo2_dengan_o2 ? `<li>SpO2 (dengan O2): ${vitalSignData.spo2_dengan_o2}%</li>` : ''}
                        ${vitalSignData.gcs ? `<li>GCS: ${vitalSignData.gcs}</li>` : ''}
                        ${vitalSignData.avpu ? `<li>AVPU: ${vitalSignData.avpu}</li>` : ''}
                    </ul>
                `;

                // Get triase status style
                const getTriaseClass = (kodeTriase) => {
                    switch (parseInt(kodeTriase)) {
                        case 5:
                            return 'bg-dark text-white';
                        case 4:
                            return 'bg-danger text-white';
                        case 3:
                            return 'bg-danger text-white';
                        case 2:
                            return 'bg-warning text-dark';
                        case 1:
                            return 'bg-success text-white';
                        default:
                            return 'bg-secondary text-white';
                    }
                };

                const row = `
                    <tr>
                        <td>${triase.tanggal_triase}</td>
                        <td>${triase.anamnesis_retriase  || '-'}</td>
                        <td>${formattedVitalSigns}</td>
                        <td>
                            <span class="badge ${getTriaseClass(triase.kode_triase)}">
                                ${triase.hasil_triase || '-'}
                            </span>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function handleTindakLanjut(tindakLanjutData) {
            const container = $('#showTindakLanjutInfo');
            container.empty();

            // Check if tindakLanjutData is array and has data
            if (!tindakLanjutData || !Array.isArray(tindakLanjutData) || tindakLanjutData.length === 0) {
                container.html(`
                    <div class="alert alert-info">
                        <em>Tidak ada data tindak lanjut</em>
                    </div>
                `);
                return;
            }

            // Get the first tindak lanjut data (since it's in array)
            const data = tindakLanjutData[0];

            // Get badge color based on tindak_lanjut_code
            const getBadgeClass = (code) => {
                switch (parseInt(code)) {
                    case 1:
                        return 'bg-primary'; // Rawat Inap
                    case 2:
                        return 'bg-success'; // Kontrol Ulang
                    case 3:
                        return 'bg-secondary'; // Selesai di Unit
                    case 4:
                        return 'bg-info'; // Rujuk Internal
                    case 5:
                        return 'bg-warning'; // Rujuk RS Lain
                    default:
                        return 'bg-secondary';
                }
            };

            // Format tanggal dan jam meninggal jika ada
            // const meninggalInfo = data.tanggal_meninggal ? `
        //     <div class="col-md-12 mt-3">
        //         <label class="fw-bold">Waktu Meninggal:</label>
        //         <p class="mb-0">${data.tanggal_meninggal} ${data.jam_meninggal || ''}</p>
        //     </div>
        // ` : '';

            // Format tanggal kontrol jika ada
            const kontrolInfo = data.tgl_kontrol_ulang ? `
                <div class="col-md-12 mt-3">
                    <label class="fw-bold">Tanggal Kontrol:</label>
                    <p class="mb-0">${data.tgl_kontrol_ulang}</p>
                </div>
            ` : '';

            const infoBox = `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Tindak Lanjut:</label>
                                <div class="mt-2">
                                    <span class="badge ${getBadgeClass(data.tindak_lanjut_code)}">
                                        ${data.tindak_lanjut_name || '-'}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Keterangan:</label>
                                <p class="mb-0">${data.keterangan || '-'}</p>
                            </div>
                            ${kontrolInfo}
                        </div>
                    </div>
                </div>
            `;

            container.html(infoBox);
        }


        function handlePemeriksaanFisik(pemeriksaanFisik) {
            const container = $('#show_pemeriksaan_fisik_container'); // Updated container ID for 'show'

            container.empty();

            pemeriksaanFisik.forEach(function(item) {
                // Determine checked status based on is_normal value
                const isChecked = item.is_normal === '1' ? 'checked' : '';
                const keterangan = item.keterangan || '';

                // Append item to the pemeriksaan fisik section
                const itemHtml = `
                    <div class="col-md-6 pemeriksaan-item mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">${item.nama_item}</div>
                            <div class="form-check me-2">
                                <input type="checkbox" class="form-check-input" id="show_${item.id_item_fisik}_normal" ${isChecked} disabled>
                                <label class="form-check-label" for="show_${item.id_item_fisik}_normal">${isChecked ? 'Normal' : 'Tidak Normal'}</label>
                            </div>
                            ${keterangan ? `<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#show_keterangan_${item.id_item_fisik}">Lihat Keterangan</button>` : ''}
                        </div>
                        ${keterangan ? `<div id="show_keterangan_${item.id_item_fisik}" class="collapse mt-2"><input type="text" class="form-control" value="${keterangan}" readonly></div>` : ''}
                    </div>
                `;
                container.append(itemHtml);
            });
        }


    </script>
@endpush
