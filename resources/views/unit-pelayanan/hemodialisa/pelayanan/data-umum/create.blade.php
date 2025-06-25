@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-row label {
            min-width: 200px;
            margin-bottom: 0;
            margin-right: 1rem;
        }

        .form-row .form-control {
            flex: 1;
        }

        .checkbox-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 0.5rem;
            font-weight: 600;
            text-align: center;
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="hemodialisisForm" method="POST" action="#">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Form Data Pasien Hemodialisis</h4>
                            </div>

                            <!-- DATA PASIEN -->
                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">DATA PASIEN</div>

                                    <div class="form-row">
                                        <label for="agama"><strong>Agama</strong></label>
                                        <label for="">{{ str()->title($dataMedis->pasien->agama->agama) }}</label>
                                    </div>

                                    <div class="form-row">
                                        <label for="pendidikan"><strong>Pendidikan</strong></label>
                                        <label
                                            for="">{{ str()->title($dataMedis->pasien->pendidikan->pendidikan) }}</label>
                                    </div>

                                    <div class="form-row">
                                        <label for="status_pernikahan"><strong>Status Pernikahan</strong></label>
                                        <label for="">{{ $dataMedis->pasien->marital->jenis }}</label>
                                    </div>

                                    <div class="form-row">
                                        <label for="pekerjaan"><strong>Pekerjaan</strong></label>
                                        <label
                                            for="">{{ str()->title($dataMedis->pasien->pekerjaan->pekerjaan) }}</label>
                                    </div>

                                    <div class="form-row">
                                        <label for="alamat_lengkap"><strong>Alamat lengkap</strong></label>
                                        <label for="">
                                            {{ str()->title($dataMedis->pasien->alamat) . ', ' . str()->title($dataMedis->pasien->kelurahan->kelurahan) . ', ' . str()->title($dataMedis->pasien->kelurahan->kecamatan->kecamatan) . ', ' . str()->title($dataMedis->pasien->kelurahan->kecamatan->kabupaten->kabupaten) . ', ' . str()->title($dataMedis->pasien->kelurahan->kecamatan->kabupaten->propinsi->propinsi) }}
                                        </label>
                                    </div>

                                    <div class="form-row">
                                        <label for="no_identitas"><strong>No Identitas</strong></label>
                                        <label for="">{{ $dataMedis->pasien->no_pengenal }}</label>
                                    </div>

                                    <div class="form-row">
                                        <label for="no_kartu_bpjs"><strong>No Kartu BPJS</strong></label>
                                        <label for="">{{ $dataMedis->pasien->no_asuransi }}</label>
                                    </div>

                                    <div class="form-row">
                                        <label for="pasien_no_telpon"><strong>No Telpon/ HP</strong></label>
                                        <input type="text" name="pasien_no_telpon" id="pasien_no_telpon"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">RIWAYAT ALERGI</div>

                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                        id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                        <i class="ti-plus"></i> Tambah Alergi
                                    </button>
                                    <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="createAlergiTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="20%">Jenis Alergi</th>
                                                    <th width="25%">Alergen</th>
                                                    <th width="25%">Reaksi</th>
                                                    <th width="20%">Tingkat Keparahan</th>
                                                    <th width="10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="no-alergi-row">
                                                    <td colspan="5" class="text-center text-muted">Tidak ada data alergi
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- IDENTITAS PENANGGUNG JAWAB PASIEN -->
                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">IDENTITAS PENANGGUNG JAWAB PASIEN</div>

                                    <div class="form-row">
                                        <label for="pj_nama">Nama</label>
                                        <input type="text" name="pj_nama" id="pj_nama" class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="pj_hubungan_keluarga">Hubungan keluarga</label>
                                        <input type="text" name="pj_hubungan_keluarga" id="pj_hubungan_keluarga"
                                            class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="pj_alamat">Alamat</label>
                                        <input type="text" name="pj_alamat" id="pj_alamat" class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="pj_pekerjaan">Pekerjaan</label>
                                        <input type="text" name="pj_pekerjaan" id="pj_pekerjaan" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- DATA HEMODIALISIS -->
                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">DATA HEMODIALISIS (Diisi petugas HD)</div>

                                    <div class="form-row">
                                        <label for="hd_pertama_kali">HD pertama kali tanggal</label>
                                        <input type="text" name="hd_pertama_kali" id="hd_pertama_kali"
                                            class="form-control date" readonly>
                                    </div>

                                    <div class="form-row">
                                        <label for="mulai_hd_rutin">Mulai HD rutin tanggal</label>
                                        <input type="text" name="mulai_hd_rutin" id="mulai_hd_rutin"
                                            class="form-control date" readonly>
                                    </div>

                                    <div class="form-row">
                                        <label for="frekuensi_hd">Frekuensi HD</label>
                                        <input type="text" name="frekuensi_hd" id="frekuensi_hd"
                                            class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="status_pembayaran">Status pembayaran</label>
                                        <input type="text" name="status_pembayaran" id="status_pembayaran"
                                            class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="dokter_pengirim">Dokter pengirim</label>
                                        <select name="dokter_pengirim" id="dokter_pengirim" class="form-control select2">
                                            <option value="">--Pilih Dokter--</option>

                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}">{{ $item->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-row">
                                        <label for="asal_rujukan">Asal rujukan</label>
                                        <input type="text" name="asal_rujukan" id="asal_rujukan"
                                            class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="diagnosis">Diagnosis</label>
                                        <input type="text" name="diagnosis" id="diagnosis" class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="etiologi">Etiologi</label>
                                        <input type="text" name="etiologi" id="etiologi" class="form-control">
                                    </div>

                                    <div class="form-row">
                                        <label for="penyakit_penyerta">Penyakit penyerta</label>
                                        <input type="text" name="penyakit_penyerta" id="penyakit_penyerta"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Alergi -->
    <div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Input Alergi -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                    <select class="form-select" id="modal_jenis_alergi">
                                        <option value="">-- Pilih Jenis Alergi --</option>
                                        <option value="Obat">Obat</option>
                                        <option value="Makanan">Makanan</option>
                                        <option value="Udara">Udara</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal_alergen" class="form-label">Alergen</label>
                                    <input type="text" class="form-control" id="modal_alergen"
                                        placeholder="Contoh: Paracetamol, Seafood, Debu">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal_reaksi" class="form-label">Reaksi</label>
                                    <input type="text" class="form-control" id="modal_reaksi"
                                        placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                    <select class="form-select" id="modal_tingkat_keparahan">
                                        <option value="">-- Pilih Tingkat Keparahan --</option>
                                        <option value="Ringan">Ringan</option>
                                        <option value="Sedang">Sedang</option>
                                        <option value="Berat">Berat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                    <i class="bi bi-plus"></i> Tambah ke Daftar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Alergi -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                            <span class="badge bg-primary" id="alergiCount">0</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="20%">Jenis Alergi</th>
                                            <th width="25%">Alergen</th>
                                            <th width="25%">Reaksi</th>
                                            <th width="20%">Tingkat Keparahan</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalAlergiList">
                                        <!-- Data akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                                <i class="bi bi-info-circle"></i> Belum ada data alergi
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="saveAlergiData">
                        <i class="bi bi-check"></i> Simpan Data Alergi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // Manajemen Data Alergi Modal - SIMPLE FIX
            // ==========================================

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Cek apakah data alergi dari PHP ada
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners dengan pengecekan element
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Fungsi update modal list
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            // Fungsi update main table
            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Fungsi global untuk onclick
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Load awal
            updateMainAlergiTable();
        });
    </script>
@endpush
