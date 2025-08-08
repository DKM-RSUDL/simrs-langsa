@extends('layouts.administrator.master')

@push('css')
    {{-- Jika ada CSS khusus, bisa ditambahkan di sini --}}
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            {{-- Kartu informasi pasien, diasumsikan sudah ada dan berfungsi --}}
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            {{-- Tombol kembali ke halaman index --}}
            <a href="{{ route('rawat-inap.pneumonia.psi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            {{-- Form untuk update data PSI --}}
            <form id="psiForm" method="POST"
                action="{{ route('rawat-inap.pneumonia.psi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataPsi->id]) }}">
                @csrf
                @method('PUT') {{-- Metode spoofing untuk request UPDATE --}}

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center text-primary fw-bold mb-4">Edit Form Pneumonia Severity Index (PSI)</h4>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Informasi Dasar</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal dan Jam Implementasi</label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal_implementasi"
                                                id="tanggal_implementasi" value="{{ date('Y-m-d', strtotime($dataPsi->tanggal_implementasi)) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Jam</label>
                                            <input type="time" class="form-control" name="jam_implementasi"
                                                id="jam_implementasi" value="{{ date('H:i', strtotime($dataPsi->jam_implementasi)) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Kriteria Pneumonia Severity Index (PSI)</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">Faktor Demografik</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th width="50%">Karakteristik Pasien</th>
                                                    <th width="20%" class="text-center">Nilai</th>
                                                    <th width="30%" class="text-center">Pilihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-semibold">Umur</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">- Laki-laki</td>
                                                    <td class="text-center">Umur (tahun)</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gender_age" value="male" id="male" {{ $dataPsi->gender_age == 'male' ? 'checked' : '' }} {{ $dataMedis->pasien->jenis_kelamin != 1 ? 'disabled' : '' }}>
                                                            <label class="form-check-label" for="male">
                                                                <input type="number" class="form-control form-control-sm d-inline-block" style="width: 80px;" name="umur_laki" id="umur_laki" min="0" value="{{ $dataPsi->umur_laki ?? $dataMedis->pasien->umur ?? 0 }}" {{ $dataMedis->pasien->jenis_kelamin != 1 ? 'readonly' : '' }}>
                                                            </label>
                                                        </div>
                                                        @if ($dataMedis->pasien->jenis_kelamin == 1)
                                                            <small class="text-muted">Skor: {{ $dataMedis->pasien->umur ?? 0 }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">- Perempuan</td>
                                                    <td class="text-center">Umur (tahun) - 10</td>
                                                    <td class="text-center">
                                                         <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gender_age" value="female" id="female" {{ $dataPsi->gender_age == 'female' ? 'checked' : '' }} {{ $dataMedis->pasien->jenis_kelamin != 0 ? 'disabled' : '' }}>
                                                            <label class="form-check-label" for="female">
                                                                <input type="number" class="form-control form-control-sm d-inline-block" style="width: 80px;" name="umur_perempuan" id="umur_perempuan" min="0" value="{{ $dataPsi->umur_perempuan ?? $dataMedis->pasien->umur ?? 0 }}" {{ $dataMedis->pasien->jenis_kelamin != 0 ? 'readonly' : '' }}>
                                                            </label>
                                                        </div>
                                                        @if ($dataMedis->pasien->jenis_kelamin == 0)
                                                            @php $skorPerempuan = max(0, ($dataMedis->pasien->umur ?? 0) - 10); @endphp
                                                            <small class="text-muted">Skor: {{ $skorPerempuan }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">- Penghuni Panti Werdha</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="panti_werdha" value="10" id="panti_werdha" {{ $dataPsi->panti_werdha ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="panti_werdha">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mb-4">
                                     <h6 class="fw-bold text-primary mb-3">Penyakit Komorbid</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Keganasan</td>
                                                    <td width="20%" class="text-center">+ 30</td>
                                                    <td width="30%" class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="keganasan" value="30" id="keganasan" {{ $dataPsi->keganasan ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="keganasan">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Hati</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="penyakit_hati" value="20" id="penyakit_hati" {{ $dataPsi->penyakit_hati ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="penyakit_hati">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Jantung Kongestif</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="jantung_kongestif" value="10" id="jantung_kongestif" {{ $dataPsi->jantung_kongestif ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="jantung_kongestif">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Serebrovaskular</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                         <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="serebrovaskular" value="10" id="serebrovaskular" {{ $dataPsi->serebrovaskular ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="serebrovaskular">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Ginjal</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="penyakit_ginjal" value="10" id="penyakit_ginjal" {{ $dataPsi->penyakit_ginjal ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="penyakit_ginjal">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mb-4">
                                     <h6 class="fw-bold text-primary mb-3">Pemeriksaan Fisik</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Gangguan Kesadaran</td>
                                                    <td width="20%" class="text-center">+ 20</td>
                                                    <td width="30%" class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="gangguan_kesadaran" value="20" id="gangguan_kesadaran" {{ $dataPsi->gangguan_kesadaran ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="gangguan_kesadaran">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Frekuensi nafas > 30 kali/menit</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="frekuensi_nafas" value="20" id="frekuensi_nafas" {{ $dataPsi->frekuensi_nafas ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="frekuensi_nafas">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tekanan Darah Sistolik < 90 mmHg</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="tekanan_sistolik" value="20" id="tekanan_sistolik" {{ $dataPsi->tekanan_sistolik ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="tekanan_sistolik">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Suhu Tubuh < 35°C atau > 40°C</td>
                                                    <td class="text-center">+ 15</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="suhu_tubuh" value="15" id="suhu_tubuh" {{ $dataPsi->suhu_tubuh ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="suhu_tubuh">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Frekuensi Nadi > 125 kali/menit</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="frekuensi_nadi" value="10" id="frekuensi_nadi" {{ $dataPsi->frekuensi_nadi ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="frekuensi_nadi">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mb-4">
                                     <h6 class="fw-bold text-primary mb-3">Hasil Laboratorium</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">pH < 7.35</td>
                                                    <td width="20%" class="text-center">+ 30</td>
                                                    <td width="30%" class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="ph_rendah" value="30" id="ph_rendah" {{ $dataPsi->ph_rendah ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ph_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Ureum > 64.2 mg/dL</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="ureum_tinggi" value="20" id="ureum_tinggi" {{ $dataPsi->ureum_tinggi ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ureum_tinggi">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Natrium < 130 mEq/L</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="natrium_rendah" value="20" id="natrium_rendah" {{ $dataPsi->natrium_rendah ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="natrium_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Glukosa > 250 mg/dL</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="glukosa_tinggi" value="10" id="glukosa_tinggi" {{ $dataPsi->glukosa_tinggi ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="glukosa_tinggi">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hematokrit < 30%</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="hematokrit_rendah" value="10" id="hematokrit_rendah" {{ $dataPsi->hematokrit_rendah ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="hematokrit_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tekanan O₂ darah arteri < 60 mmHg</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="o2_rendah" value="10" id="o2_rendah" {{ $dataPsi->o2_rendah ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="o2_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Efusi Pleura</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox" name="efusi_pleura" value="10" id="efusi_pleura" {{ $dataPsi->efusi_pleura ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="efusi_pleura">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="card bg-warning bg-opacity-25 border-warning">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h5 class="fw-bold mb-0">Total Skor PSI</h5>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="total_skor" class="fs-2 fw-bold text-primary">0</span>
                                                <input type="hidden" name="total_skor" id="total_skor_input" value="{{ $dataPsi->total_skor }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Interpretasi dan Rekomendasi</h5>
                            </div>
                            <div class="card-body">
                                <div id="current_result" class="p-3 border rounded bg-white">
                                    <h6 class="fw-bold text-primary mb-3">Hasil Penilaian PSI:</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <strong>Total Skor:</strong> <span id="display_skor" class="text-primary fw-bold">0</span>
                                        </div>
                                        <div class="col-md-8">
                                            <strong>Rekomendasi:</strong> <span id="display_rekomendasi" class="fw-bold">-</span>
                                        </div>
                                    </div>

                                    <div id="additional_criteria" class="d-none">
                                        <div class="alert alert-warning">
                                            <h6 class="fw-bold">Perhatian! Meskipun skor PSI < 70, pasien tetap perlu dirawat inap karena memenuhi kriteria berikut:</h6>
                                            <ul id="criteria_list" class="mb-0"></ul>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="rekomendasi_perawatan" id="rekomendasi_input" value="{{ $dataPsi->rekomendasi_perawatan }}">
                                <input type="hidden" name="kriteria_tambahan" id="kriteria_tambahan_input" value="{{ $dataPsi->kriteria_tambahan }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4" id="simpan">
                                <i class="ti-save me-2"></i> Update Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pemilihan elemen DOM
            const psiItems = document.querySelectorAll('.psi-item');
            const totalSkorDisplay = document.getElementById('total_skor');
            const totalSkorInput = document.getElementById('total_skor_input');
            const form = document.getElementById('psiForm');
            const submitBtn = document.getElementById('simpan');
            const umurLaki = document.getElementById('umur_laki');
            const umurPerempuan = document.getElementById('umur_perempuan');
            const additionalCriteria = document.getElementById('additional_criteria');
            const criteriaList = document.getElementById('criteria_list');

            const originalBtnContent = submitBtn.innerHTML;

            function calculateTotal() {
                let total = 0;

                // Kalkulasi skor berdasarkan umur dan jenis kelamin
                const selectedGender = document.querySelector('input[name="gender_age"]:checked');
                if (selectedGender) {
                    if (selectedGender.value === 'male') {
                        const umurLakiValue = parseInt(umurLaki.value) || 0;
                        total += umurLakiValue;
                    } else if (selectedGender.value === 'female') {
                        const umurPerempuanValue = parseInt(umurPerempuan.value) || 0;
                        total += Math.max(0, umurPerempuanValue - 10);
                    }
                }

                // Kalkulasi skor dari item-item PSI lainnya (checkboxes)
                psiItems.forEach(function(item) {
                    if (item.checked) {
                        total += parseInt(item.value) || 0;
                    }
                });

                // Update tampilan skor
                totalSkorDisplay.textContent = total;
                totalSkorInput.value = total;
                document.getElementById('display_skor').textContent = total;

                // Tampilkan interpretasi berdasarkan skor total
                showInterpretation(total);
            }

            function showInterpretation(skor) {
                let rekomendasi = '';
                let kriteriaTambahan = [];
                
                // Interpretasi dasar PSI
                if (skor >= 70) {
                    rekomendasi = 'Rawat Inap (Skor PSI ≥ 70)';
                    document.getElementById('display_rekomendasi').innerHTML = '<span class="badge bg-danger">Rawat Inap</span>';
                    additionalCriteria.classList.add('d-none');
                } else {
                    // Cek kriteria tambahan untuk rawat inap meskipun skor PSI < 70
                    const additionalCriteriaChecked = checkAdditionalCriteria();

                    if (additionalCriteriaChecked.length > 0) {
                        rekomendasi = 'Rawat Inap (Memenuhi kriteria tambahan meskipun PSI < 70)';
                        kriteriaTambahan = additionalCriteriaChecked;
                        document.getElementById('display_rekomendasi').innerHTML = '<span class="badge bg-warning text-dark">Rawat Inap (Kriteria Tambahan)</span>';

                        // Tampilkan peringatan kriteria tambahan
                        additionalCriteria.classList.remove('d-none');
                        criteriaList.innerHTML = '';
                        additionalCriteriaChecked.forEach(function(criteria) {
                            const li = document.createElement('li');
                            li.textContent = criteria;
                            criteriaList.appendChild(li);
                        });
                    } else {
                        rekomendasi = 'Rawat Jalan (Skor PSI < 70 dan tidak memenuhi kriteria tambahan)';
                        document.getElementById('display_rekomendasi').innerHTML = '<span class="badge bg-success">Rawat Jalan</span>';
                        additionalCriteria.classList.add('d-none');
                    }
                }

                // Set nilai untuk input tersembunyi yang akan dikirim ke server
                document.getElementById('rekomendasi_input').value = rekomendasi;
                document.getElementById('kriteria_tambahan_input').value = kriteriaTambahan.join('; ');
            }
            
            function checkAdditionalCriteria() {
                const criteria = [];
                if (document.getElementById('frekuensi_nafas').checked) {
                    criteria.push('Frekuensi nafas > 30 kali/menit');
                }
                if (document.getElementById('o2_rendah').checked) {
                    criteria.push('PaO2/FiO2 kurang dari 250 mmHg');
                }
                if (document.getElementById('tekanan_sistolik').checked) {
                    criteria.push('Tekanan sistolik < 90 mmHg');
                }
                return criteria;
            }
            
            // Event listener untuk setiap item PSI
            psiItems.forEach(function(item) {
                item.addEventListener('change', calculateTotal);
            });

            // Kalkulasi awal saat halaman dimuat
            // Ini akan menghitung skor berdasarkan data yang sudah ada (checked checkboxes)
            calculateTotal();
        });
    </script>
@endpush