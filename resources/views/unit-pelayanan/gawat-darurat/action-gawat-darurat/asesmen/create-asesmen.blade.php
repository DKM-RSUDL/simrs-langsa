<!-- Modal -->
<div class="modal fade" id="detailPasienModal" tabindex="-1" aria-labelledby="detailPasienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="asesmenForm" method="POST"
                action="{{ route('asesmen.store', [$dataMedis->pasien->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}">
                @csrf
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->pasien->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">
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
                                            <p>Riwayat Alergi:</p>
                                            <ul class="mb-3">
                                                @forelse($dataMedis->riwayat_alergi as $alergen)
                                                    <li>{{ $alergen }}</li>
                                                @empty
                                                    <li>Tidak ada riwayat alergi</li>
                                                @endforelse
                                            </ul>

                                            <p style="margin-bottom: 5px;"><strong>Golongan Darah</strong></p>
                                            <p style="margin-bottom: 5px;">-</p>
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
                                                                    <td>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[air_way][]"
                                                                                value="Hyperekstesi" id="hyperekstesi">
                                                                            <label class="form-check-label"
                                                                                for="hyperekstesi">Hyperekstesi</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[air_way][]"
                                                                                value="Bersihkan jalan nafas"
                                                                                id="bersihkanJalanNafas">
                                                                            <label class="form-check-label"
                                                                                for="bersihkanJalanNafas">Bersihkan
                                                                                jalan nafas</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[air_way][]"
                                                                                value="Intubasi" id="intubasi">
                                                                            <label class="form-check-label"
                                                                                for="intubasi">Intubasi</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[breathing][]"
                                                                                value="Bag and Mask" id="bagAndMask">
                                                                            <label class="form-check-label"
                                                                                for="bagAndMask">Bag and Mask</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[breathing][]"
                                                                                value="Bag and Tube" id="bagAndTube">
                                                                            <label class="form-check-label"
                                                                                for="bagAndTube">Bag and Tube</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[circulation][]"
                                                                                value="Kompresi jantung"
                                                                                id="kompresiJantung">
                                                                            <label class="form-check-label"
                                                                                for="kompresiJantung">Kompresi
                                                                                jantung</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[circulation][]"
                                                                                value="Balut tekan" id="balutTekan">
                                                                            <label class="form-check-label"
                                                                                for="balutTekan">Balut tekan</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                name="tindakan_resusitasi[circulation][]"
                                                                                value="Operasi" id="operasi">
                                                                            <label class="form-check-label"
                                                                                for="operasi">Operasi</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="form-line">
                                                    <h6>Keluhan/Anamnesis</h6>
                                                    <textarea class="form-control mb-2" rows="3" name="anamnesis"
                                                        placeholder="Isikan keluhan dan anamnesis pasien, jika terjadi cidera jelaskan mekanisme cideranya"></textarea>
                                                </div>

                                                <div class="form-line">
                                                    <h6>Riwayat Penyakit Pasien</h6>
                                                    <textarea class="form-control mb-2" rows="2" name="riwayat_penyakit"
                                                        placeholder="Isikan riwayat penyakit pasien"></textarea>
                                                </div>

                                                <div class="form-line">
                                                    <h6>Riwayat Penyakit Keluarga Pasien</h6>
                                                    <textarea class="form-control mb-2" rows="2" name="riwayat_penyakit_keluarga"
                                                        placeholder="Isikan riwayat penyakit keluarga pasien"></textarea>
                                                </div>

                                                <div class="form-line">
                                                    <h6>Riwayat Pengobatan</h6>
                                                    <textarea class="form-control mb-2" rows="2" name="riwayat_pengobatan"
                                                        placeholder="Isikan riwayat pengobatan pasien"></textarea>
                                                </div>

                                                <div class="form-line">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h6 class="mb-0 me-3">Riwayat Alergi</h6>
                                                        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-alergimodal')
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="createAlergiTable">
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
                                                                name="vital_sign[td_sistole]">
                                                        </div>
                                                        <div class="col">
                                                            <label>TD (Diastole)</label>
                                                            <input type="number" class="form-control"
                                                                name="vital_sign[td_diastole]">
                                                        </div>
                                                        <div class="col">
                                                            <label>Nadi (x/mnt)</label>
                                                            <input type="number" class="form-control"
                                                                name="vital_sign[nadi]">
                                                        </div>
                                                        <div class="col">
                                                            <label>Resp (x/mnt)</label>
                                                            <input type="number" class="form-control"
                                                                name="vital_sign[resp]">
                                                        </div>
                                                        <div class="col">
                                                            <label>Suhu (°C)</label>
                                                            <input type="number" class="form-control"
                                                                name="vital_sign[suhu]">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-2 position-relative">
                                                            <label>GCS</label>
                                                            <input type="text" class="form-control" id="gcsValue"
                                                                name="vital_sign[gcs_display]" value="15" readonly
                                                                onclick="openGCSModal()">
                                                            <i class="bi bi-pencil position-absolute"
                                                                style="top: 50%; right: 10px; transform: translateY(-50%);"
                                                                onclick="openGCSModal()"></i>
                                                            @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-gcs')
                                                        </div>

                                                        <div class="col-4">
                                                            <label>AVPU</label>
                                                            <select class="form-select" name="vital_sign[avpu]">
                                                                <option selected disabled>Pilih</option>
                                                                <option>Sadar Baik/Alert : 0</option>
                                                                <option>Berespon dengan kata-kata/Voice: 1</option>
                                                                <option>Hanya berespon jika dirangsang nyeri/pain: 2
                                                                </option>
                                                                <option>Pasien tidak sadar/unresponsive: 3</option>
                                                                <option>Gelisah atau bingung: 4</option>
                                                                <option>Acute Confusional States: 5</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label>SpO2 (tanpa O2)</label>
                                                            <input type="number" class="form-control"
                                                                name="vital_sign[spo2_tanpa_o2]">
                                                        </div>
                                                        <div class="col-3">
                                                            <label>SpO2 (dengan O2)</label>
                                                            <input type="number" class="form-control"
                                                                name="vital_sign[spo2_dengan_o2]">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-line">
                                                    <h6>Antropometri</h6>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label>TB (cm)</label>
                                                            <input type="number" class="form-control" name="antropometri[tb]" step="1" min="0" max="300" placeholder="Misal: 170">
                                                        </div>
                                                        <div class="col">
                                                            <label>BB (kg)</label>
                                                            <input type="number" class="form-control" name="antropometri[bb]" step="0.1" min="0" max="500" placeholder="Misal: 70.5">
                                                        </div>
                                                        <div class="col">
                                                            <label>Ling. Kepala</label>
                                                            <input type="number" class="form-control" name="antropometri[ling_kepala]">
                                                        </div>
                                                        <div class="col">
                                                            <label>LPT</label>
                                                            <input type="number" class="form-control" name="antropometri[lpt]" readonly>
                                                        </div>
                                                        <div class="col">
                                                            <label>IMT</label>
                                                            <input type="number" class="form-control" name="antropometri[imt]" readonly>
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
                                                                <input type="number" id="skalaNyeri"
                                                                    name="skala_nyeri" min="0" max="10"
                                                                    class="form-control" value="0">
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Lokasi Nyeri</label>
                                                                <input type="text" id="lokasiNyeri" name="lokasi"
                                                                    class="form-control" placeholder="Lokasi Nyeri">
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Durasi</label>
                                                                <input type="text" id="durasiNyeri" name="durasi"
                                                                    class="form-control" placeholder="Durasi Nyeri">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <!-- Manjalar -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold mb-2">Manjalar</label>
                                                            <div class="karakteristik-nyeri">
                                                                @foreach ($menjalar as $option)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="menjalar"
                                                                            id="manjalar-{{ $option->id }}"
                                                                            value="{{ $option->id }}">
                                                                        <label class="form-check-label"
                                                                            for="manjalar-{{ $option->id }}">
                                                                            {{ $option->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Frekuensi -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold mb-2">Frekuensi</label>
                                                            <div class="karakteristik-nyeri">
                                                                @foreach ($frekuensinyeri as $option)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="frekuensi"
                                                                            id="frekuensi-{{ $option->id }}"
                                                                            value="{{ $option->id }}">
                                                                        <label class="form-check-label"
                                                                            for="frekuensi-{{ $option->id }}">
                                                                            {{ $option->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Kualitas -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold mb-2">Kualitas</label>
                                                            <div class="karakteristik-nyeri">
                                                                @foreach ($kualitasnyeri as $option)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="kualitas"
                                                                            id="kualitas-{{ $option->id }}"
                                                                            value="{{ $option->id }}">
                                                                        <label class="form-check-label"
                                                                            for="kualitas-{{ $option->id }}">
                                                                            {{ $option->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Faktor Pemberat -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold mb-2">Faktor
                                                                Pemberat</label>
                                                            <div class="karakteristik-nyeri">
                                                                @foreach ($faktorpemberat as $option)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="faktor_pemberat"
                                                                            id="pemberat-{{ $option->id }}"
                                                                            value="{{ $option->id }}">
                                                                        <label class="form-check-label"
                                                                            for="pemberat-{{ $option->id }}">
                                                                            {{ $option->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Faktor Peringanan -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold mb-2">Faktor
                                                                Peringanan</label>
                                                            <div class="karakteristik-nyeri">
                                                                @foreach ($faktorperingan as $option)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="faktor_peringan"
                                                                            id="peringan-{{ $option->id }}"
                                                                            value="{{ $option->id }}">
                                                                        <label class="form-check-label"
                                                                            for="peringan-{{ $option->id }}">
                                                                            {{ $option->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Efek Nyeri -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold mb-2">Efek Nyeri</label>
                                                            <div class="karakteristik-nyeri">
                                                                @foreach ($efeknyeri as $option)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="efek_nyeri"
                                                                            id="efek-{{ $option->id }}"
                                                                            value="{{ $option->id }}">
                                                                        <label class="form-check-label"
                                                                            for="efek-{{ $option->id }}">
                                                                            {{ $option->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
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
                                                        <div class="row">
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
                                                                                        id="{{ $item->id }}-normal-index"
                                                                                        checked>
                                                                                    <label class="form-check-label"
                                                                                        for="{{ $item->id }}-normal-index">Normal</label>
                                                                                </div>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                    type="button"
                                                                                    data-target="{{ $item->id }}-keterangan-index">+</button>
                                                                            </div>
                                                                            <div class="keterangan mt-2"
                                                                                id="{{ $item->id }}-keterangan-index"
                                                                                style="display:none;">
                                                                                <input type="text"
                                                                                    class="form-control"
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
                                                        <img
                                                            src="{{ asset('assets/img/icons/tools.png') }}">
                                                        <h6 class="mb-0 me-3">Tindakan</h6>
                                                    </div>
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tanggal dan Jam</th>
                                                                    <th>Nama Tindakan</th>
                                                                    <th>Dokter</th>
                                                                    <th>Unit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($tindakanData as $tindakan)
                                                                    <tr>
                                                                        <td>{{ $tindakan['Tanggal-Jam'] }}</td>
                                                                        <td>{{ $tindakan['Nama Tindakan'] }}</td>
                                                                        <td>{{ $tindakan['Dokter'] }}</td>
                                                                        <td>{{ $tindakan['Unit'] }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">Tidak
                                                                            ada data tindakan</td>
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
                                                        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-diagnosis')
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="bg-secondary-subtle rounded-2 p-3"
                                                                id="diagnoseList">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-line">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h6 class="mb-0 me-3">Observasi Lanjutan/Re-Triase</h6>
                                                        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-retriase')
                                                    </div>
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-bordered" id="reTriaseTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tanggal dan Jam</th>
                                                                    <th>Keluhan</th>
                                                                    <th>Vital Sign</th>
                                                                    <th>Re-Triase/EWS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="4" class="text-center text-muted">
                                                                        Pasien perlu di observasi atau di re-triase jika kondisi dan kesadaran pasien berubah
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="form-line">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h6 class="mb-0 me-3">Alat yang Terpasang</h6>
                                                        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-alatyangterpasang')
                                                    </div>
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-bordered" id="alatTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Alat yang terpasang</th>
                                                                    <th>Lokasi</th>
                                                                    <th>Ket</th>
                                                                    <th>Aksi</th>
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
                                                    <textarea class="form-control mb-2" rows="3" name="kondisi_pasien" placeholder="Isikan Kondisi pasien"></textarea>
                                                </div>

                                                <div class="form-line">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h6 class="mb-0 me-3">Tindak Lanjut Pelayanan</h6>
                                                    </div>

                                                    <div class="mb-3">
                                                        {{-- <div>
                                                            <input type="radio" name="tindakLanjut" value="rawatInap" id="rawatInap"> 
                                                            <label for="rawatInap">Rawat Inap</label>
                                                        </div> --}}
                                                        {{-- <div>
                                                            <input type="radio" name="tindakLanjut" value="kamarOperasi" id="kamarOperasi">
                                                            <label for="kamarOperasi">Kamar Operasi</label> 
                                                        </div> --}}
                                                        <div>
                                                            <input type="radio" name="tindakLanjut" value="rujukKeluar" id="rujukKeluar">
                                                            <label for="rujukKeluar">Rujuk Keluar RS Lain</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="tindakLanjut" value="pulangSembuh" id="pulangSembuh">
                                                            <label for="pulangSembuh">Pulang</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="tindakLanjut" value="berobatJalan" id="berobatJalan">
                                                            <label for="berobatJalan">Berobat Jalan Ke Poli</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="tindakLanjut" value="menolakRawatInap" id="menolakRawatInap">
                                                            <label for="menolakRawatInap">Menolak Rawat Inap</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="tindakLanjut" value="meninggalDunia" id="meninggalDunia">
                                                            <label for="meninggalDunia">Meninggal Dunia</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="tindakLanjut" value="deathoffarrival" id="deathoffarrival">
                                                            <label for="deathoffarrival">DOA</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="formMenolakRawatInap" style="display: none;">
                                                        <label for="alasanMenolak" class="form-label">Alasan</label>
                                                        <textarea class="form-control" id="alasanMenolak" name="alasanMenolak" rows="3"></textarea>
                                                    </div>

                                                    <div class="mb-3" id="formRujukKeluar" style="display: none;">
                                                        <div class="mb-3">
                                                            <label for="tujuan_rujuk" class="form-label">Tujuan Rujuk</label>
                                                            <input type="text" class="form-control" id="tujuan_rujuk" name="tujuan_rujuk">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alasan_rujuk" class="form-label">Alasan Rujuk</label>
                                                            <select class="form-select" id="alasan_rujuk" name="alasan_rujuk">
                                                                <option selected disabled>Pilih Alasan Rujuk</option>
                                                                <option value="1">Indikasi Medis</option>
                                                                <option value="2">Kamar Penuh</option>
                                                                <option value="3">Permintaan Pasien</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="transportasi_rujuk" class="form-label">Transportasi Rujuk</label>
                                                            <select class="form-select" id="transportasi_rujuk" name="transportasi_rujuk">
                                                                <option selected disabled>Pilih Transportasi Rujuk</option>
                                                                <option value="1">Ambulance</option>
                                                                <option value="2">Kendaraan Pribadi</option>
                                                                <option value="3">Lainnya</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="formpulangSembuh" style="display: none;">
                                                        <label for="tanggalPulang" class="form-label">Tanggal Pulang</label>
                                                        <input type="date" class="form-control" id="tanggalPulang" name="tanggalPulang">
                                                        <label for="jamPulang" class="form-label mt-2">Jam Pulang</label>
                                                        <input type="time" class="form-control" id="jamPulang" name="jamPulang">
                                                        <div class="mb-3">
                                                            <label for="alasn_pulang" class="form-label">Alasan Pulang</label>
                                                            <select class="form-select" id="alasan_pulang" name="alasan_pulang">
                                                                <option selected disabled>Pilih Alasan Pulang</option>
                                                                <option value="1">Sembuh</option>
                                                                <option value="2">Indikasi Medis</option>
                                                                <option value="3">Permintaan Pasien</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kondisi_pulang" class="form-label">Kondisi Pulang</label>
                                                            <select class="form-select" id="kondisi_pulang" name="kondisi_pulang">
                                                                <option selected disabled>Pilih Kondisi Pulang</option>
                                                                <option value="1">Mandiri</option>
                                                                <option value="2">Tidak Mandiri</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="formberobatJalan" style="display: none;">
                                                        <label for="tanggal_rajal" class="form-label">Tanggal Berobat</label>
                                                        <input type="date" class="form-control mb-2" name="tanggal_rajal" id="tanggal_rajal">
                                                        <label for="poli_unit_tujuan" class="form-label">Poli</label>
                                                        <select class="form-select" id="poli_unit_tujuan" name="poli_unit_tujuan">
                                                            <option selected disabled>Pilih Poli</option>
                                                            @foreach($unitPoli as $poli)
                                                                <option value="{{ $poli->kd_unit }}">{{ $poli->nama_unit }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="formmeninggalDunia" style="display: none;">
                                                        <label for="tanggalMeninggal" class="form-label">Tanggal Meninggal</label>
                                                        <input type="date" class="form-control mb-2" name="tanggalMeninggal" id="tanggalMeninggal">
                                                        <label for="jamMeninggal" class="form-label mt-2">Jam Meninggal</label>
                                                        <input type="time" class="form-control" id="jamMeninggal" name="jamMeninggal">
                                                    </div>

                                                    <div class="mb-3" id="formDOA" style="display: none;">
                                                        <label for="tanggalDoa" class="form-label">Tanggal Meninggal</label>
                                                        <input type="date" class="form-control mb-2" name="tanggalDoa" id="tanggalDoa">
                                                        <label for="jamDoa" class="form-label mt-2">Jam Meninggal</label>
                                                        <input type="time" class="form-control" id="jamDoa" name="jamDoa">
                                                    </div>

                                                    <div class="mb-3" id="formRawatInap" style="display: none;">
                                                        <div class="mb-3">
                                                            <label for="tanggalRawatInap" class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control" id="tanggalRawatInap" name="tanggalRawatInap">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="jamRawatInap" class="form-label">Jam</label>
                                                            <input type="time" class="form-control" id="jamRawatInap" name="jamRawatInap">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="keluhanUtama_ranap" class="form-label">Keluhan Utama</label>
                                                            <textarea class="form-control" id="keluhanUtama_ranap" name="keluhanUtama_ranap" rows="3"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="hasilPemeriksaan_ranap" class="form-label">Hasil Pemeriksaan Penunjang Klinis</label>
                                                            <textarea class="form-control" id="hasilPemeriksaan_ranap" name="hasilPemeriksaan_ranap" rows="3"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="jalannyaPenyakit_ranap" class="form-label">Jalannya Penyakit & Hasil Konsultasi</label>
                                                            <textarea class="form-control" id="jalannyaPenyakit_ranap" name="jalannyaPenyakit_ranap" rows="3"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="diagnosis_ranap" class="form-label">Diagnosis</label>
                                                            <textarea class="form-control" id="diagnosis_ranap" name="diagnosis_ranap" rows="3"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="tindakan_ranap" class="form-label">Tindakan yang Telah Dilakukan</label>
                                                            <textarea class="form-control" id="tindakan_ranap" name="tindakan_ranap" rows="3"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="anjuran_ranap" class="form-label">Anjuran</label>
                                                            <textarea class="form-control" id="anjuran_ranap" name="anjuran_ranap" rows="3"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="formKamarOperasi" style="display: none;">
                                                        <label for="kamarOperasi" class="form-label">Kamar Operasi</label>
                                                        <input type="text" class="form-control" id="kamarOperasi" name="kamarOperasi">
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
                    <button class="btn btn-primary" id="saveForm">KIRIM ASESMEN</button>
                </div>
            </form>
        </div>
    </div>
</div>
