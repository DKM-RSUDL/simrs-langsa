@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Tambah Data Asesmen Medis',
                    'description' =>
                        'Tambah data asesmen medis pasien gawat darurat dengan mengisi formulir di bawah ini.',
                ])

                {{-- FORM ASESMEN MEDIS GAWAT DARURAT --}}
                <form method="POST"
                    action="{{ route('asesmen.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- DATA TRIASE --}}
                    <div class="section-separator mt-0" id="data-triase">
                        <h5 class="section-title">Data Triase</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal/Jam</th>
                                        <th>Dokter</th>
                                        <th>Triage</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataMedis->dataTriase)
                                        <tr>
                                            <td>{{ date('d-m-Y H:i', strtotime($dataMedis->dataTriase->tanggal_triase)) }}
                                            </td>
                                            <td>
                                                @if ($dataMedis->dataTriase->dokter)
                                                    {{ $dataMedis->dataTriase->dokter->nama_lengkap }}
                                                @else
                                                    Tidak Ada Dokter
                                                @endif
                                            </td>
                                            <td>
                                                <div class="rounded-circle {{ $triageClass ?? 'bg-secondary' }}"
                                                    style="width: 35px; height: 35px;"></div>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Tidak ada data triase untuk pasien ini
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TANGGAL DAN JAM PENGISIAN --}}
                    <div class="section-separator" id="data-masuk">
                        <h6 class="mb-3">Tanggal dan Jam Pengisian</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jam</label>
                                    <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                        value="{{ date('H:i') }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TINDAKAN RESUSITASI --}}
                        <h6 class="mb-3">Tindakan Resusitasi</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Air Way</th>
                                        <th class="text-center">Breathing</th>
                                        <th class="text-center">Circulation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-3">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[air_way][]" value="Hyperekstesi"
                                                    id="hyperekstesi">
                                                <label class="form-check-label" for="hyperekstesi">Hyperekstesi</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[air_way][]" value="Bersihkan jalan nafas"
                                                    id="bersihkanJalanNafas">
                                                <label class="form-check-label" for="bersihkanJalanNafas">Bersihkan
                                                    jalan nafas</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[air_way][]" value="Intubasi" id="intubasi">
                                                <label class="form-check-label" for="intubasi">Intubasi</label>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[breathing][]" value="Bag and Mask"
                                                    id="bagAndMask">
                                                <label class="form-check-label" for="bagAndMask">Bag and
                                                    Mask</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[breathing][]" value="Bag and Tube"
                                                    id="bagAndTube">
                                                <label class="form-check-label" for="bagAndTube">Bag and
                                                    Tube</label>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[circulation][]" value="Kompresi jantung"
                                                    id="kompresiJantung">
                                                <label class="form-check-label" for="kompresiJantung">Kompresi
                                                    jantung</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[circulation][]" value="Balut tekan"
                                                    id="balutTekan">
                                                <label class="form-check-label" for="balutTekan">Balut
                                                    tekan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    name="tindakan_resusitasi[circulation][]" value="Operasi"
                                                    id="operasi">
                                                <label class="form-check-label" for="operasi">Operasi</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ANAMNESIS --}}
                    <div class="section-separator" id="anamnesis">
                        <h5 class="section-title">1. Anamnesis</h5>

                        <div class="form-group mb-3">
                            <label class="form-label required">Keluhan Utama/Alasan Masuk RS</label>
                            <textarea class="form-control" name="keluhan_utama" rows="3"
                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Riwayat Penyakit Pasien</label>
                            <textarea class="form-control" rows="3" name="riwayat_penyakit" placeholder="Isikan riwayat penyakit pasien"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Riwayat Penyakit Keluarga</label>
                            <textarea class="form-control" rows="3" name="riwayat_penyakit_keluarga"
                                placeholder="Isikan riwayat penyakit keluarga"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Riwayat Pengobatan</label>
                            <textarea class="form-control" rows="3" name="riwayat_pengobatan"
                                placeholder="Isikan riwayat pengobatan pasien"></textarea>
                        </div>

                        {{-- ALERGI --}}
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary mb-3" id="openAlergiModal"
                                data-bs-toggle="modal" data-bs-target="#alergiModal">
                                <i class="ti-plus"></i> Tambah Alergi
                            </button>
                            <input type="hidden" name="alergis" id="alergisInput" value="[]">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="createAlergiTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jenis Alergi</th>
                                            <th>Alergen</th>
                                            <th>Reaksi</th>
                                            <th>Tingkat Keparahan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="no-alergi-row">
                                            <td colspan="5" class="text-center text-muted">Tidak ada data
                                                alergi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- VITAL SIGN --}}
                    <div class="section-separator" id="vital-sign">
                        <h5 class="section-title">2. Vital Sign</h5>

                        @if ($triaseVitalSign)
                            <div class="alert alert-info mb-3">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Data dari Triase Terakhir:</strong> Form telah diisi otomatis dengan data
                                vital sign dari triase terakhir. Anda dapat mengubah nilai sesuai kebutuhan.
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="vital-sign-group">
                                    <div class="form-group mb-3">
                                        <label class="form-label">TD Sistole (mmHg)</label>
                                        <input type="number" class="form-control" name="vital_sign[td_sistole]"
                                            value="{{ $triaseVitalSign['sistole'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">TD Diastole (mmHg)</label>
                                        <input type="number" class="form-control" name="vital_sign[td_diastole]"
                                            value="{{ $triaseVitalSign['diastole'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Nadi (x/menit)</label>
                                        <input type="number" class="form-control" name="vital_sign[nadi]"
                                            value="{{ $triaseVitalSign['nadi'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Suhu (°C)</label>
                                        <input type="text" step="0.1" class="form-control"
                                            name="vital_sign[suhu]" value="{{ $triaseVitalSign['suhu'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">TB (cm)</label>
                                        <input type="number" class="form-control" name="antropometri[tb]"
                                            id="tbInput" onchange="hitungIMT()"
                                            value="{{ $triaseVitalSign['tinggi_badan'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">BB (kg)</label>
                                        <input type="number" step="0.1" class="form-control"
                                            name="antropometri[bb]" id="bbInput" onchange="hitungIMT()"
                                            value="{{ $triaseVitalSign['berat_badan'] ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="vital-sign-group">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Respirasi (x/menit)</label>
                                        <input type="number" class="form-control" name="vital_sign[respirasi]"
                                            value="{{ $triaseVitalSign['respiration'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">SpO2 tanpa O2 (%)</label>
                                        <input type="number" class="form-control" name="vital_sign[spo2_tanpa_o2]"
                                            value="{{ $triaseVitalSign['spo2_tanpa_o2'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">SpO2 dengan O2 (%)</label>
                                        <input type="number" class="form-control" name="vital_sign[spo2_dengan_o2]"
                                            value="{{ $triaseVitalSign['spo2_dengan_o2'] ?? '' }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">GCS</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="vital_sign[gcs]"
                                                id="gcsInput" placeholder="Contoh: 15 E4 V5 M6" readonly>
                                            <button type="button" class="btn btn-outline-primary"
                                                onclick="openGCSModal()" title="Buka Kalkulator GCS">
                                                <i class="ti-calculator"></i> Hitung GCS
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Lingkar Kepala (cm)</label>
                                        <input type="number" step="0.1" class="form-control"
                                            name="antropometri[lpt]">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">IMT (kg/m²)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control"
                                                name="antropometri[imt]" id="imtInput" readonly>
                                            <span class="input-group-text" id="imtKategori">Normal</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PENGKAJIAN STATUS NYERI --}}
                    <div class="section-separator" id="status-nyeri">
                        <h5 class="section-title">3. Pengkajian Status Nyeri</h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="pain-scale-input">
                                    <label class="form-label">Skala Nyeri (0-10)</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="number" class="form-control" name="skala_nyeri"
                                            style="width: 100px;" value="0" min="0" max="10">
                                        <button type="button" class="btn btn-success" id="skalaNyeriBtn">
                                            Tidak Nyeri
                                        </button>
                                        <input type="hidden" name="skala_nyeri_nilai" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="pain-scale-buttons mb-3">
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn-outline-primary" data-scale="numeric">
                                            A. Numeric Rating Pain Scale
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-scale="wong-baker">
                                            B. Wong Baker Faces Pain Scale
                                        </button>
                                    </div>
                                </div>

                                <div class="pain-scale-images">
                                    <div id="numericScale" class="pain-scale-image" style="display: none;">
                                        <img src="{{ asset('assets/img/asesmen/numerik.png') }}" alt="Numeric Pain Scale"
                                            class="img-fluid">
                                    </div>
                                    <div id="wongBakerScale" class="pain-scale-image" style="display: none;">
                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                            alt="Wong Baker Pain Scale" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" name="lokasi"
                                        placeholder="Contoh: Kepala, Dada">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Pemberat</label>
                                    <select class="form-select" name="faktor_pemberat">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorpemberat as $pemberat)
                                            <option value="{{ $pemberat->id }}">{{ $pemberat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Kualitas</label>
                                    <select class="form-select" name="kualitas">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kualitasnyeri as $kualitas)
                                            <option value="{{ $kualitas->id }}">{{ $kualitas->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Menjalar</label>
                                    <select class="form-select" name="menjalar">
                                        <option value="">--Pilih--</option>
                                        @foreach ($menjalar as $menj)
                                            <option value="{{ $menj->id }}">{{ $menj->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Efek Nyeri</label>
                                    <select class="form-select" name="efek_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($efeknyeri as $efek)
                                            <option value="{{ $efek->id }}">{{ $efek->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Durasi</label>
                                    <input type="text" class="form-control" name="durasi"
                                        placeholder="Contoh: 2 jam, 30 menit">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Peringan</label>
                                    <select class="form-select" name="faktor_peringan">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorperingan as $peringan)
                                            <option value="{{ $peringan->id }}">{{ $peringan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Frekuensi</label>
                                    <select class="form-select" name="frekuensi">
                                        <option value="">--Pilih--</option>
                                        @foreach ($frekuensinyeri as $frekuensi)
                                            <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Jenis</label>
                                    <select class="form-select" name="jenis_nyeri">
                                        <option value="">--Pilih--</option>
                                        @foreach ($jenisnyeri as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PEMERIKSAAN FISIK --}}
                    <div class="section-separator" id="pemeriksaan-fisik">
                        <h5 class="section-title">4. Pemeriksaan Fisik</h5>
                        <div class="pemeriksaan-fisik-info mb-4">
                            <p class="text-muted small">
                                Centang "Normal" jika pemeriksaan fisik normal. Klik tombol "+" untuk menambah
                                keterangan
                                jika ditemukan kelainan. Jika tidak dipilih salah satunya, maka pemeriksaan tidak
                                dilakukan.
                            </p>
                        </div>

                        <div class="row">
                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                <div class="col-md-6">
                                    @foreach ($chunk as $item)
                                        <div class="pemeriksaan-item mb-3">
                                            <div
                                                class="d-flex align-items-center justify-content-between border rounded p-3">
                                                <div class="flex-grow-1">
                                                    <strong>{{ $item->nama }}</strong>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="{{ $item->id }}-normal"
                                                            name="{{ $item->id }}-normal" checked>
                                                        <label class="form-check-label" for="{{ $item->id }}-normal">
                                                            Normal
                                                        </label>
                                                    </div>
                                                    <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                        type="button" data-target="{{ $item->id }}-keterangan">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                style="display:none;">
                                                <input type="text" class="form-control"
                                                    name="{{ $item->id }}_keterangan"
                                                    placeholder="Tambah keterangan jika tidak normal...">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- PEMERIKSAAN PENUNJANG KLINIS --}}
                    <div class="section-separator" id="pemeriksaan-penunjang">
                        <h5 class="section-title">5. Pemeriksaan Penunjang Klinis</h5>

                        {{-- LABORATORIUM --}}
                        <h6 class="mb-3">Laboratorium</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Pemeriksaan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($laborData ?? [] as $data)
                                        <tr>
                                            <td>{{ $data['Tanggal-Jam'] ?? '-' }}</td>
                                            <td>{{ $data['Nama pemeriksaan'] ?? '-' }}</td>
                                            <td>{{ $data['Status'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada data
                                                laboratorium</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- RADIOLOGI --}}
                        <h6 class="mb-3">Radiologi</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal dan Jam</th>
                                        <th>Nama Pemeriksaan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($radiologiData ?? [] as $rad)
                                        <tr>
                                            <td>{{ $rad['Tanggal-Jam'] ?? '-' }}</td>
                                            <td>{{ $rad['Nama Pemeriksaan'] ?? '-' }}</td>
                                            <td>{{ $rad['Status'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada data
                                                radiologi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- TINDAKAN --}}
                        <h6 class="mb-3">Tindakan</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal dan Jam</th>
                                        <th>Nama Tindakan</th>
                                        <th>Dokter</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tindakanData ?? [] as $tindakan)
                                        <tr>
                                            <td>{{ $tindakan['Tanggal-Jam'] ?? '-' }}</td>
                                            <td>{{ $tindakan['Nama Tindakan'] ?? '-' }}</td>
                                            <td>{{ $tindakan['Dokter'] ?? '-' }}</td>
                                            <td>{{ $tindakan['Unit'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada data
                                                tindakan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- E-RESEP --}}
                        <h6 class="mb-3">E-Resep</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Obat</th>
                                        <th>Dosis</th>
                                        <th>Cara Pemberian</th>
                                        <th>PPA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayatObat ?? [] as $resep)
                                        @php
                                            $cara_pakai_parts = explode(',', $resep->cara_pakai ?? '');
                                            $frekuensi = trim($cara_pakai_parts[0] ?? '');
                                            $keterangan = trim($cara_pakai_parts[1] ?? '');
                                        @endphp
                                        <tr>
                                            <td>{{ isset($resep->tgl_order) ? \Carbon\Carbon::parse($resep->tgl_order)->format('d M Y H:i') : '-' }}
                                            </td>
                                            <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                                            <td>{{ $resep->jumlah_takaran ?? '' }}
                                                {{ isset($resep->satuan_takaran) ? Str::title($resep->satuan_takaran) : '' }}
                                            </td>
                                            <td>{{ $keterangan ?: '-' }}</td>
                                            <td>{{ $resep->nama_dokter ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada resep obat
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- DIAGNOSIS --}}
                    <div class="section-separator" id="diagnosis">
                        <h5 class="section-title">6. Diagnosis</h5>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="btnTambahDiagnosis">
                                <i class="ti-plus"></i> Tambah Diagnosis
                            </button>
                        </div>

                        <div id="diagnosisInputContainer"></div>

                        <div id="diagnosisList" class="diagnosis-list">
                            <!-- Diagnosis items will be added here dynamically -->
                        </div>

                        <div id="noDiagnosisMessage" class="text-center text-muted py-2"
                            style="border: 2px dashed #dee2e6; border-radius: 0.5rem;">
                            <i class="ti-file-text" style="font-size: 2rem; opacity: 0.5;"></i>
                            <p class="mb-0 mt-2">Belum ada diagnosis yang ditambahkan</p>
                            <small>Klik tombol "Tambah Diagnosis" untuk menambah diagnosis</small>
                        </div>
                    </div>

                    {{-- ALAT YANG TERPASANG --}}
                    <div class="section-separator" id="alat-terpasang">
                        <h5 class="section-title">7. Alat yang Terpasang</h5>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="btnTambahAlat"
                                data-bs-toggle="modal" data-bs-target="#alatModal">
                                <i class="ti-plus"></i> Tambah Alat
                            </button>
                        </div>

                        <input type="hidden" name="alat_terpasang_data" id="alatTerpasangData" value="[]">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="alatTerpasangTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Alat yang Terpasang</th>
                                        <th>Lokasi</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="no-alat-row">
                                        <td colspan="5" class="text-center text-muted">Tidak ada alat yang
                                            terpasang</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- RETRIASE/OBSERVASI LANJUTAN --}}
                    <div class="section-separator" id="retriase">
                        <h5 class="section-title">8. Retriase/Observasi Lanjutan</h5>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="btnTambahRetriase"
                                data-bs-toggle="modal" data-bs-target="#retriaseModal">
                                <i class="ti-plus"></i> Tambah Retriase
                            </button>
                        </div>

                        <input type="hidden" name="retriase_data" id="retriaseData" value="[]">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="retriaseTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>GCS</th>
                                        <th>Temp</th>
                                        <th>RR</th>
                                        <th>SpO2 (tanpa O2)</th>
                                        <th>SpO2 (dengan O2)</th>
                                        <th>TD (Sistole)</th>
                                        <th>TD (Diastole)</th>
                                        <th>Keluhan</th>
                                        <th>Retriase</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="no-alat-row">
                                        <td colspan="12" class="text-center text-muted">Tidak ada retriase</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- KONDISI PASIEN MENINGGALKAN IGD --}}
                    <div class="section-separator" id="kondisi-pasien">
                        <h5 class="section-title">9. Kondisi Pasien Meninggalkan IGD</h5>

                        <div class="form-group mb-3">
                            <label class="form-label">Kondisi Pasien</label>
                            <textarea class="form-control" name="kondisi_pasien" rows="3"
                                placeholder="Deskripsikan kondisi pasien saat meninggalkan IGD..."></textarea>
                        </div>
                    </div>

                    {{-- TINDAK LANJUT PELAYANAN --}}
                    <div class="section-separator" id="tindak-lanjut">
                        <h5 class="section-title">10. Tindak Lanjut Pelayanan</h5>

                        <div class="mb-3">
                            <div class="alert alert-info">
                                <i class="ti-info-alt"></i>
                                <span class="text-muted">Pilih salah satu tindak lanjut pelayanan yang sesuai
                                    dengan kondisi pasien saat meninggalkan IGD.</span>
                            </div>
                        </div>

                        <div class="tindak-lanjut-options mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formRawatInap">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="rawatInap" id="rawatInap">
                                            <label class="form-check-label" for="rawatInap">
                                                <i class="ti-home me-2"></i>Rawat Inap
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formRujukKeluar">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="rujukKeluar" id="rujukKeluar">
                                            <label class="form-check-label" for="rujukKeluar">
                                                <i class="ti-export me-2"></i>Rujuk Keluar RS Lain
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formpulangSembuh">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="pulangSembuh" id="pulangSembuh">
                                            <label class="form-check-label" for="pulangSembuh">
                                                <i class="ti-check me-2"></i>Pulang
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formberobatJalan">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="berobatJalan" id="berobatJalan">
                                            <label class="form-check-label" for="berobatJalan">
                                                <i class="ti-calendar me-2"></i>Berobat Jalan Ke Poli
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formMenolakRawatInap">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="menolakRawatInap" id="menolakRawatInap">
                                            <label class="form-check-label" for="menolakRawatInap">
                                                <i class="ti-close me-2"></i>Menolak Rawat Inap
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formmeninggalDunia">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="meninggalDunia" id="meninggalDunia">
                                            <label class="form-check-label" for="meninggalDunia">
                                                <i class="ti-heart-broken me-2"></i>Meninggal Dunia
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="radio-option" data-target="formDOA">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="tindakLanjut"
                                                value="deathoffarrival" id="deathoffarrival">
                                            <label class="form-check-label" for="deathoffarrival">
                                                <i class="ti-pulse me-2"></i>DOA (Death on Arrival)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM RAWAT INAP --}}
                        <div class="conditional-form" id="formRawatInap" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-home me-2"></i>Detail Rawat Inap</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggalRawatInap"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Jam</label>
                                                <input type="time" class="form-control" name="jamRawatInap"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Keluhan Utama & Riwayat Penyakit</label>
                                        <textarea class="form-control" name="keluhanUtama_ranap" rows="3"
                                            placeholder="Deskripsikan keluhan utama dan riwayat penyakit pasien..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Hasil Pemeriksaan Penunjang Klinis</label>
                                        <textarea class="form-control" name="hasilPemeriksaan_ranap" rows="3"
                                            placeholder="Hasil laboratorium, radiologi, dan pemeriksaan penunjang lainnya..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Jalannya Penyakit & Hasil Konsultasi</label>
                                        <textarea class="form-control" name="jalannyaPenyakit_ranap" rows="3"
                                            placeholder="Perjalanan penyakit dan hasil konsultasi dengan dokter spesialis..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Diagnosis</label>
                                        <textarea class="form-control" name="diagnosis_ranap" rows="3"
                                            placeholder="Diagnosis utama dan diagnosis sekunder..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Tindakan yang Telah Dilakukan</label>
                                        <textarea class="form-control" name="tindakan_ranap" rows="3"
                                            placeholder="Tindakan medis yang telah dilakukan di IGD..."></textarea>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="form-label">Anjuran</label>
                                        <textarea class="form-control" name="anjuran_ranap" rows="3"
                                            placeholder="Anjuran untuk perawatan selanjutnya..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM RUJUK KELUAR --}}
                        <div class="conditional-form" id="formRujukKeluar" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-export me-2"></i>Detail Rujukan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label required">Tujuan Rujuk</label>
                                        <input type="text" class="form-control" name="tujuan_rujuk"
                                            placeholder="Nama rumah sakit/fasilitas kesehatan tujuan">
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Alasan Rujuk</label>
                                                <select class="form-select" name="alasan_rujuk">
                                                    <option value="" selected disabled>Pilih Alasan Rujuk
                                                    </option>
                                                    <option value="1">Indikasi Medis</option>
                                                    <option value="2">Kamar Penuh</option>
                                                    <option value="3">Permintaan Pasien</option>
                                                    <option value="4">Keterbatasan Fasilitas</option>
                                                    <option value="5">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Transportasi Rujuk</label>
                                                <select class="form-select" name="transportasi_rujuk">
                                                    <option value="" selected disabled>Pilih Transportasi
                                                        Rujuk</option>
                                                    <option value="1">Ambulance</option>
                                                    <option value="2">Kendaraan Pribadi</option>
                                                    <option value="3">Kendaraan Umum</option>
                                                    <option value="4">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="form-label">Keterangan Tambahan</label>
                                        <textarea class="form-control" name="keterangan_rujuk" rows="3"
                                            placeholder="Keterangan tambahan mengenai rujukan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM PULANG --}}
                        <div class="conditional-form" id="formpulangSembuh" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-check me-2"></i>Detail Kepulangan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Tanggal Pulang</label>
                                                <input type="date" class="form-control" name="tanggalPulang"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Jam Pulang</label>
                                                <input type="time" class="form-control" name="jamPulang"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Alasan Pulang</label>
                                                <select class="form-select" name="alasan_pulang">
                                                    <option value="" selected disabled>Pilih Alasan Pulang
                                                    </option>
                                                    <option value="1">Sembuh</option>
                                                    <option value="2">Indikasi Medis</option>
                                                    <option value="3">Permintaan Pasien</option>
                                                    <option value="4">Pulang Paksa</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Kondisi Pulang</label>
                                                <select class="form-select" name="kondisi_pulang">
                                                    <option value="" selected disabled>Pilih Kondisi Pulang
                                                    </option>
                                                    <option value="1">Mandiri</option>
                                                    <option value="2">Tidak Mandiri</option>
                                                    <option value="3">Dengan Bantuan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM BEROBAT JALAN --}}
                        <div class="conditional-form" id="formberobatJalan" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-calendar me-2"></i>Detail Berobat Jalan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Tanggal Berobat</label>
                                                <input type="date" class="form-control" name="tanggal_rajal">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Poli Tujuan</label>
                                                <select class="form-select" name="poli_unit_tujuan">
                                                    <option value="" selected disabled>Pilih Poli</option>
                                                    @foreach ($unitPoli as $poli)
                                                        <option value="{{ $poli->kd_unit }}">
                                                            {{ $poli->nama_unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="form-label">Catatan untuk Poli</label>
                                        <textarea class="form-control" name="catatan_rajal" rows="3"
                                            placeholder="Catatan khusus untuk poli tujuan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM MENOLAK RAWAT INAP --}}
                        <div class="conditional-form" id="formMenolakRawatInap" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-close me-2"></i>Detail Penolakan Rawat Inap
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label required">Alasan Menolak</label>
                                        <textarea class="form-control" name="alasanMenolak" rows="3"
                                            placeholder="Jelaskan alasan pasien/keluarga menolak rawat inap..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM MENINGGAL DUNIA --}}
                        <div class="conditional-form" id="formmeninggalDunia" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-heart-broken me-2"></i>Detail Kematian</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Tanggal Meninggal</label>
                                                <input type="date" class="form-control" name="tanggalMeninggal"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Jam Meninggal</label>
                                                <input type="time" class="form-control" name="jamMeninggal"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Keterangan Kematian</label>
                                        <textarea class="form-control" name="penyebab_kematian" rows="3"
                                            placeholder="Jelaskan penyebab kematian berdasarkan kondisi klinis..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM DOA --}}
                        <div class="conditional-form" id="formDOA" style="display: none;">
                            <div class="">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti-pulse me-2"></i>Detail DOA (Death on Arrival)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Tanggal Tiba</label>
                                                <input type="date" class="form-control" name="tanggalDoa"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required">Jam Tiba</label>
                                                <input type="time" class="form-control" name="jamDoa"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan_doa" rows="3"
                                            placeholder="Tindakan yang telah dilakukan (jika ada)..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="tindak_lanjut_data" id="tindakLanjutData" value="">

                    </div>

                    {{-- MODAL DIAGNOSIS --}}
                    <div class="modal fade" id="diagnosisModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="diagnosisModalTitle">Tambah Diagnosis</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label required">Nama Diagnosis</label>
                                        <input class="form-control" id="namaDiagnosis" name="namaDiagnosis"
                                            placeholder="Masukkan nama diagnosis...">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" id="btnSimpanDiagnosis">
                                        <i class="ti-check"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="text-end">
                        <x-button-submit />
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-alatyangterpasang-new')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.include')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-create-alergi')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.gcs-modal')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-retriase')
