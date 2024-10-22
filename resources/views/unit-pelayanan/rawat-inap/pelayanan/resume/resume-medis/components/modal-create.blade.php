<div class="modal fade" id="modal-edit-resume" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header  bg-primary">
                <h5 class="modal-title text-white" id="extraLargeModalLabel">Resume Medis Rawat Inap</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                                <textarea class="form-control" id="pemeriksaan_penunjang" rows="3">{{ $dataResume->pemeriksaan_penunjang ?? '-' }}</textarea>
                            </div>

                            <div class="mt-3">
                                <strong class="fw-bold">
                                    Diagnosis
                                    <a href="javascript:void(0)"
                                        class="text-secondary text-decoration-none fw-bold ms-3" id="btn-diagnosis"><i
                                            class="bi bi-plus-square"></i> Tambah</a>
                                </strong>

                                <div class="bg-light p-3 border rounded">
                                    <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplay">

                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <strong class="fw-bold">Kode ICD 10 (Koder)
                                    <a href="javascript:void(0)"
                                        class="text-secondary text-decoration-none fw-bold ms-3" id="btn-kode-icd">
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
                                            class="fw-bold">{{ $dataResume->listTindakanPasien->produk->deskripsi ?? '-' }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="mt-3">
                            <strong class="fw-bold">Kode ICD-9 CM (Koder)
                                <a href="javascript:void(0)" class="text-secondary text-decoration-none fw-bold ms-3"
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
                                            <input type="radio" id="kontrol" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Kontrol ulang, tgl:"
                                                data-code="2">
                                            <label for="kontrol">Kontrol ulang, tgl:</label>
                                        </a>

                                        <a href="j#"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="konsul" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Konsul/Rujuk Internal Ke:"
                                                data-code="4">
                                            <label for="konsul">Konsul/Rujuk Internal Ke:</label>
                                        </a>
                                        {{-- <a href="javascript:void(0)" class="tindak-lanjut-option d-block mb-2 text-decoration-none" id="btn-konsul-rujukan">
                                            <input type="radio" id="konsul" name="tindak_lanjut_name" class="form-check-input me-2" value="Konsul/Rujuk Internal Ke:" data-code="2">
                                            <label for="konsul">Konsul/Rujuk Internal Ke:</label>
                                        </a> --}}

                                        <a href="#"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="selesai" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Selesai di Klinik ini"
                                                data-code="3">
                                            <label for="selesai">Selesai di Klinik ini</label>
                                        </a>
                                    </div>

                                    <div class="col-md-6">
                                        <a href="#"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="rujuk" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Rujuk RS lain bagian:"
                                                data-code="5">
                                            <label for="rujuk">Rujuk RS lain bagian:</label>
                                        </a>

                                        <a href="#"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="rawat" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Rawat Inap" data-code="1">
                                            <label for="rawat">Rawat Inap</label>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-info"><i class="bi bi-printer"></i>
                    Print</button>
                <button type="button" class="btn btn-sm btn-primary" id="update">Simpan</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-create-diagnosi')
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-input-diagnosis')
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-kode-icd')
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-kode-icd9')
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-konsul-rujukan')
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-create-alergi')


<script type="text/javascript">
    $('#btn-edit-resume').on('click', function() {
        $('#modal-edit-resume').modal('show');
    });

    $('#update').click(function(e) {
        e.preventDefault();

        // Ambil resume_id, biarkan null jika tidak ada
        const resume_id = '{{ $dataResume->id ?? null }}';

        if (!resume_id) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Data resume belum tersedia. Silahkan buat resume baru terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Jika ada resume_id, lanjutkan dengan proses update
        let formData = new FormData();

        if (!validateForm()) {
            return;
        }

        formData.append('anamnesis', $('#anamnesis').val().trim());
        formData.append('pemeriksaan_penunjang', $('#pemeriksaan_penunjang').val().trim());

        const diagnosisArray = $('#diagnoseDisplay').children()
            .map(function() {
                return $(this).find('.fw-bold').text().trim();
            }).get().filter(Boolean);

        if (diagnosisArray.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Minimal satu diagnosis harus diisi'
            });
            return;
        }
        formData.append('diagnosis', JSON.stringify(diagnosisArray));

        // Ambil data ICD
        const icd10Array = $('#icdList').children()
            .map(function() {
                return $(this).text().trim().split(' ')[0];
            }).get().filter(Boolean);
        formData.append('icd_10', JSON.stringify(icd10Array));

        const icd9Array = $('#icd9List').children()
            .map(function() {
                return $(this).text().trim().split(' ')[0];
            }).get().filter(Boolean);
        formData.append('icd_9', JSON.stringify(icd9Array));

        // Validasi tindak lanjut
        const tindakLanjutElement = $('input[name="tindak_lanjut_name"]:checked');
        if (tindakLanjutElement.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Mohon pilih tindak lanjut'
            });
            return;
        }

        formData.append('tindak_lanjut_name', tindakLanjutElement.val());
        formData.append('tindak_lanjut_code', tindakLanjutElement.data('code'));
        formData.append('_method', 'PUT');

        // Build URL
        const url =
            `{{ route('rawat-inap.rawat-inap-resume.update', [
                'kd_unit' => $dataMedis->kd_unit,
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => $dataMedis->tgl_masuk,
                'urut_masuk' => $dataMedis->urut_masuk,
                'id' => ':id',
            ]) }}`
            .replace(':id', resume_id);

        // Konfirmasi sebelum update
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin memperbarui data resume?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Pembarui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim request
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message ||
                                    'Terjadi kesalahan saat memperbarui data'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat memperbarui data';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                errorMessage = Object.values(xhr.responseJSON.errors).join(
                                    '\n');
                            } else if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    });

    function validateForm() {
        const requiredFields = ['anamnesis', 'pemeriksaan_penunjang'];
        let isValid = true;

        requiredFields.forEach(field => {
            const value = $(`#${field}`).val().trim();
            if (!value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `${field.replace('_', ' ')} wajib diisi`
                });
                isValid = false;
                return false;
            }
        });

        return isValid;
    }
</script>
