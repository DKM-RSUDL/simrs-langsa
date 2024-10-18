<div class="modal fade" id="modal-edit-resume" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header  bg-primary">
                <h5 class="modal-title text-white" id="extraLargeModalLabel">Resume Medis Gawat Darurat</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($dataResume)
                    <form
                        action="{{ route('resume.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataResume->id]) }}"
                        method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="post_id">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="patient-card">
                                    <div class="patient-photo">
                                        <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
                                    </div>

                                    <div class="patient-info">
                                        <h6><strong>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</strong></h6>
                                        <small class="mb-0">
                                            {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }},
                                            {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
                                            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})
                                        </small>
                                        <p class="mb-0 fw-bold">RM:
                                            {{ $dataMedis->pasien->kd_pasien ?? '-' }}</p>

                                        <div class="patient-meta mt-2">
                                            <p class="mb-0">
                                                <i class="bi bi-calendar3"></i>
                                                {{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') ?? '-' }}
                                            </p>
                                            <p>
                                                <i class="bi bi-hospital"></i>
                                                {{ $dataMedis->unit->bagian->bagian ?? '-' }}
                                                ({{ $dataMedis->unit->nama_unit ?? '-' }})
                                            </p>
                                        </div>
                                    </div>

                                    <div class="info__pasien">
                                        <div class="bg-secondary rounded-2 p-1">
                                            <h6 class="text-white text-center">Informasi Pasien</h6>
                                        </div>
                                        <div class="info__pasien">
                                            <div class="row mt-3">
                                                <div class="col-5">
                                                    <h6 class="fw-bold">ALERGI</h6>
                                                </div>
                                                <div class="col-7">
                                                    <a href="javascript:void(0)"
                                                        class="text-secondary text-decoration-none fw-bold"
                                                        id="btn-create-alergi"><i class="bi bi-plus-square"></i>
                                                        Tambah</a>
                                                </div>
                                                <hr class="text-secondary">
                                            </div>
                                            <ul class="p-2">
                                                <li>Paracetamol</li>
                                                <li>Ikan tongkol</li>
                                            </ul>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <h6 class="fw-bold">GOL. DARAH</h6>
                                                    <hr class="text-secondary">
                                                    <span>{{ $dataMedis->pasien->golonganDarah->jenis ?? 'Tidak Diketahui' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="col__dua">
                                    <label class="form-label fw-bold">Anamnesis/ Keluhan Utama</label>
                                    <textarea class="form-control" rows="3" id="anamnesis">{{ $dataResume->anamnesis ?? '-' }}</textarea>

                                    <div class="mt-4">
                                        <strong class="fw-bold">Pemeriksaan Fisik</strong>
                                        {{-- {{ $dataResume->konpas }} --}}

                                        <div class="bg-light p-3 border rounded">
                                            <div class="row">
                                                <div class="col-6 col-md-4">
                                                    <small>TD:
                                                        {{ $dataResume->konpas['sistole']['hasil'] ?? '__' }} /
                                                        {{ $dataResume->konpas['diastole']['hasil'] ?? '__' }} mmHg
                                                    </small><br>
                                                    <small>Temp: {{ $dataResume->konpas['suhu']['hasil'] ?? '__' }}
                                                        C</small><br>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <small>
                                                        RR:
                                                        {{ $dataResume->konpas['respiration_rate']['hasil'] ?? '__' }}
                                                        x/mnt
                                                    </small><br>
                                                    <small>Resp: {{ $dataResume->konpas['nadi']['hasil'] ?? '__' }}
                                                        x/mnt</small>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <small>TB:
                                                        {{ $dataResume->konpas['tinggi_badan']['hasil'] ?? '__' }}
                                                        M</small><br>
                                                    <small>BB:
                                                        {{ $dataResume->konpas['berat_badan']['hasil'] ?? '__' }}
                                                        Kg</small><br>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="fw-bold">Hasil Pemeriksaan Laboratorium</strong>
                                        <div class="bg-light p-3 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Pemeriksaan</th>
                                                            <th>Tgl</th>
                                                            <th>Status</th>
                                                            <th>Hasil</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $counter = 1;
                                                        @endphp
                                                        @foreach ($dataLabor as $order)
                                                            @foreach ($order->details as $detail)
                                                                <tr>
                                                                    <td>{{ $counter++ }}</td>
                                                                    <td>
                                                                        {{ $detail->produk->deskripsi ?? 'Tidak ada deskripsi' }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($detail->tgl_order)->format('d M Y H:i') }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusOrder = $detail->status_order;
                                                                            $statusLabel = '';

                                                                            if ($statusOrder == 0) {
                                                                                $statusLabel = 'Diproses';
                                                                            }
                                                                            if ($statusOrder == 1) {
                                                                                $statusLabel = 'Diorder';
                                                                            }
                                                                            if ($statusOrder == 2) {
                                                                                $statusLabel = 'Selesai';
                                                                            }
                                                                        @endphp

                                                                        {!! $statusLabel !!}
                                                                    </td>
                                                                    <td><a href="#">Lihat Hasil</a></td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="fw-bold">Hasil Pemeriksaan Radiologi</strong>
                                        <div class="bg-light p-3 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Pemeriksaan</th>
                                                            <th>Tgl</th>
                                                            <th>Status</th>
                                                            <th>Hasil</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $counter = 1;
                                                        @endphp
                                                        @foreach ($dataRagiologi as $order)
                                                            @foreach ($order->details as $radiologi)
                                                                <tr>
                                                                    <td>{{ $counter++ }}</td>
                                                                    <td>
                                                                        {{ $radiologi->produk->deskripsi ?? 'Tidak ada deskripsi' }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($radiologi->tgl_order)->format('d M Y H:i') }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusOrder = $radiologi->status_order;
                                                                            $statusLabel = '';

                                                                            if ($statusOrder == 0) {
                                                                                $statusLabel = 'Diproses';
                                                                            }
                                                                            if ($statusOrder == 1) {
                                                                                $statusLabel = 'Diorder';
                                                                            }
                                                                            if ($statusOrder == 2) {
                                                                                $statusLabel = 'Selesai';
                                                                            }
                                                                        @endphp

                                                                        {!! $statusLabel !!}
                                                                    </td>
                                                                    <td><a href="#">Lihat Hasil</a></td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="fw-bold">Hasil Pemeriksaan Penunjang Lainnya</strong>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="pemeriksaan_penunjang">{{ $dataResume->pemeriksaan_penunjang ?? '-' }}</textarea>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="fw-bold">
                                            Diagnosis
                                            <a href="javascript:void(0)"
                                                class="text-secondary text-decoration-none fw-bold ms-3"
                                                id="btn-diagnosis"><i class="bi bi-plus-square"></i> Tambah</a>
                                        </strong>

                                        <div class="bg-light p-3 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplay">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="fw-bold">Kode ICD 10 (Koder)
                                            <a href="javascript:void(0)"
                                                class="text-secondary text-decoration-none fw-bold ms-3"
                                                id="btn-kode-icd">
                                                <i class="bi bi-plus-square"></i> Tambah
                                            </a>
                                        </strong>
                                        <div class="bg-light p-3 border rounded">
                                            <ul class="list" id="icdList">
                                                <!-- Kode ICD akan ditambahkan di sini -->
                                            </ul>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-5">
                                <strong class="fw-bold">Tindakan/Prosedur</strong>
                                <div class="bg-light p-3 border rounded">
                                    <div style="max-height: 150px; overflow-y: auto;">
                                        <ol type="1">
                                            <li>
                                                <a href="#"
                                                    class="fw-bold">{{ $dataResume->listTindakanPasien->produk->deskripsi }}</a>
                                            </li>
                                        </ol>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Kode ICD-9 CM (Koder)
                                        <a href="javascript:void(0)"
                                            class="text-secondary text-decoration-none fw-bold ms-3"
                                            id="btn-kode-icd9">
                                            <i class="bi bi-plus-square"></i> Tambah</a>
                                    </strong>
                                    <div class="bg-light p-3 border rounded">
                                        <ul class="list" id="icd9List">
                                            {{-- Daftar Kode ICD-9 akan muncul di sini --}}
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Resep Obat</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Nama Obat</th>
                                                            <th>Dosis</th>
                                                            <th>Frek</th>
                                                            <th>Qty</th>
                                                            <th>Rate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- {{ $dataResepObat }} --}}
                                                        @foreach ($riwayatObat as $obat)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    {{ $obat->nama_obat ?? '-' }}
                                                                </td>
                                                                <td>{{ $obat->jumlah_takaran }}
                                                                    {{ $obat->satuan_takaran }}
                                                                </td>
                                                                <td>{{ explode(',', $obat->cara_pakai)[0] }}</td>
                                                                <td>{{ (int) $obat->jumlah ?? '-' }}</td>
                                                                <td>-</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Tindak Lanjut</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="#"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="selesai" name="tindakLanjut"
                                                        class="form-check-input me-2">
                                                    <label
                                                        for="selesai">{{ $dataResume->rmeResumeDet->tindak_lanjut_name }}</label>
                                                </a>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-6">
                                                <a href="#"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="kontrol" name="tindakLanjut"
                                                        class="form-check-input me-2">
                                                    <label for="kontrol">Kontrol ulang, tgl:</label>
                                                    <input type="date" id="kontrolDate" class="form-control mt-1"
                                                        style="display: none;">
                                                </a>

                                                <a href="javascript:void(0)"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none"
                                                    id="btn-konsul-rujukan">
                                                    <input type="radio" id="konsul" name="tindakLanjut"
                                                        class="form-check-input me-2">
                                                    <label for="konsul">Konsul/Rujuk Internal Ke:</label>
                                                    <input type="text" id="konsulText" class="form-control mt-1"
                                                        style="display: none;">
                                                </a>

                                                <a href="#"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="selesai" name="tindakLanjut"
                                                        class="form-check-input me-2">
                                                    <label for="selesai">Selesai di Klinik ini</label>
                                                </a>
                                            </div>

                                            <div class="col-md-6">
                                                <a href="#"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="rujuk" name="tindakLanjut"
                                                        class="form-check-input me-2">
                                                    <label for="rujuk">Rujuk RS lain bagian:</label>
                                                    <input type="text" id="rujukText" class="form-control mt-1"
                                                        style="display: none;">
                                                </a>

                                                <a href="#"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="rawat" name="tindakLanjut"
                                                        class="form-check-input me-2">
                                                    <label for="rawat">Rawat Inap</label>
                                                </a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                @else
                    <p>No resume data available.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-info"><i class="bi bi-printer"></i> Print</button>
                <button type="button" class="btn btn-sm btn-primary" id="update">Simpan</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-create-diagnosi')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-input-diagnosis')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-kode-icd')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-kode-icd9')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-konsul-rujukan')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-create-alergi')

<script>
    $(document).ready(function() {
        // Gunakan delegasi event untuk tombol edit
        $('#table-resume').on('click', '.btn-edit-resume', function() {
            let data = $(this).data('id');

            // Fetch detail resume with ajax
            $.ajax({
                url: `pelayanan/resume/${data}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    // Fill data to form
                    $('#post_id').val(response.data.id);
                    $('#anamnesis').val(response.data.anamnesis);
                    $('#pemeriksaan_penunjang').val(response.data.pemeriksaan_penunjang);

                    // Populate diagnose display
                    if (response.data.diagnosis) {
                        $('#diagnoseDisplay').html(JSON.parse(response.data.diagnosis).join('<br>'));
                    }

                    // Populate ICD-10 list
                    if (response.data.icd_10) {
                        $('#icdList').html(JSON.parse(response.data.icd_10).map(icd => `<li>${icd}</li>`).join(''));
                    }

                    // Populate ICD-9 list
                    if (response.data.icd_9) {
                        $('#icd9List').html(JSON.parse(response.data.icd_9).map(icd => `<li>${icd}</li>`).join(''));
                    }

                    // Open modal
                    $('#modal-edit-resume').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    alert("Terjadi kesalahan saat mengambil data. Silakan coba lagi.");
                }
            });
        });

        // Action update resume
        $('#update').click(function(e) {
            e.preventDefault();

            let post_id = $('#post_id').val();
            let formData = new FormData();

            // Append only the fields that are in the controller update method
            formData.append('anamnesis', $('#anamnesis').val());
            formData.append('pemeriksaan_penunjang', $('#pemeriksaan_penunjang').val());
            formData.append('diagnosis', JSON.stringify($('#diagnoseDisplay').html().split('<br>')));
            formData.append('icd_10', JSON.stringify($('#icdList').children().map((_, li) => $(li).text()).get()));
            formData.append('icd_9', JSON.stringify($('#icd9List').children().map((_, li) => $(li).text()).get()));
            formData.append('status', '1');  // Assuming status is always set to 1 in the controller

            formData.append('_method', 'PUT');

            $.ajax({
                url: `/resume/${post_id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    $('#modal-edit-resume').modal('hide');
                    // Optionally, update the page content here
                },
                error: function(xhr, status, error) {
                    console.error("Error updating data:", error);
                    let errorMessage = "Terjadi kesalahan saat memperbarui data.";
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage += " Detail: " + Object.values(xhr.responseJSON.errors).join(", ");
                    }
                    alert(errorMessage);
                }
            });
        });
    });
    </script>
