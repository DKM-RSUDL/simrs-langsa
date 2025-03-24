<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')
    @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.patient-card')
        </div>

        <div class="col-md-9">

            <form method="POST"
                action="{{ route('operasi.pelayanan.asesmen.pra-induksi.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">

                            <div class="px-3">
                                <div>
                                    <a href="{{ url()->previous() }}" class="btn">
                                        <i class="ti-arrow-left"></i> Kembali
                                    </a>

                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">1. Data Masuk</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>

                                            <input type="date" name="tgl_masuk_pra_induksi" id="tgl_masuk"
                                                class="form-control me-3">
                                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">2. Pra Induksi</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis</label>
                                            <input type="text" name="diagnosis" id="diagnosis" class="form-control"
                                                placeholder="diagnosis">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan</label>
                                            <input type="text" name="tindakan" id="tindakan" class="form-control"
                                                placeholder="jelaskan Tindakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Spesialis Anestesi</label>
                                            <input type="text" name="spesialis_anestesi" id="spesialis_anestesi"
                                                class="form-control" placeholder="obat yang digunakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penata Anestesi</label>
                                            <input type="text" name="penata_anestesi" id="penata_anestesi"
                                                class="form-control" placeholder="obat yang digunakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Spesialis Bedah</label>
                                            <input type="text" name="spesialis_bedah" id="spesialis_bedah"
                                                class="form-control" placeholder="obat yang digunakan">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencanaAnestesi">
                                        <h5 class="section-title">3. Rencana Anestesi dan Sedasi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal</label>
                                            <div class="input-group">
                                                <input type="date" name="ras_tanggal" id="tanggal_rencana"
                                                    class="form-control" placeholder="31 Jan 2025">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat Anestesi Dan Sedasi</label>
                                            <select name="ras_tingkat_anestesi" id="tingkat_anestesi" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Moderat">Moderat</option>
                                                <option value="Dalam">Dalam</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Sedasi</label>
                                            <select name="ras_jenis_sedasi" id="jenis_sedasi" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Oral">Oral</option>
                                                <option value="IM">IM</option>
                                                <option value="IV">IV</option>
                                                <option value="Rektal">Rektal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Analgesia Pasca Sedasi</label>
                                            <select name="ras_analgesia_pasca" id="analgesia_pasca" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Oral">Oral</option>
                                                <option value="IM">IM</option>
                                                <option value="IV">IV</option>
                                                <option value="Rektal">Rektal</option>
                                                <option value="Tidak Diberikan">Tidak Diberikan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jika Ada, Obat Yang Digunakan</label>
                                            <input type="text" name="ras_obat_digunakan" id="obat_digunakan"
                                                class="form-control" placeholder="obat yang digunakan">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="evaluasiPraAnestesi">
                                        <h5 class="section-title">4. Evaluasi Pra Anestesi dan Sedasi (EPAS)</h5>

                                        <div class="mb-3">
                                            <h6 class="fw-bold" style="min-width: 200px;">Keadaan Pra-Bedah</h6>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Tek. Darah (mmHg)</label>
                                            <div class="col-sm-4">
                                                <input type="number" name="tekanan_darah_sistole" class="form-control"
                                                    placeholder="Sistole">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="number" name="tekanan_darah_diastole" class="form-control"
                                                    placeholder="Diastole">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="text" name="nadi" class="form-control"
                                                placeholder="frekuensi nadi per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="text" name="nafas" class="form-control"
                                                placeholder="frekuensi nafas per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Respirasi</label>
                                            <select name="respirasi" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Spontan">Spontan</option>
                                                <option value="Assisted">Assisted</option>
                                                <option value="Controlled">Controlled</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Saturasi Oksigen (%)</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="saturasi_tanpa_bantuan" class="form-control"
                                                    placeholder="Tanpa bantuan O₂">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="saturasi_dengan_bantuan" class="form-control"
                                                    placeholder="Dengan bantuan O₂">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suhu (℃)</label>
                                            <input type="number" name="suhu" class="form-control"
                                                placeholder="suhu dalam celcius">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">AVPU</label>
                                            <select class="form-select" name="avpu">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="0">Sadar Baik/Alert : 0</option>
                                                <option value="1">Berespon dengan kata-kata/Voice: 1</option>
                                                <option value="2">Hanya berespon jika dirangsang nyeri/pain: 2
                                                </option>
                                                <option value="3">Pasien tidak sadar/unresponsive: 3</option>
                                                <option value="4">Gelisah atau bingung: 4</option>
                                                <option value="5">Acute Confusional States: 5</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Glasgow Coma Scale (GCS)</label>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary text-white"
                                                    data-bs-toggle="modal" data-bs-target="#gcsModal">
                                                    Skor
                                                </button>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="gcs_nilai" class="form-control" readonly>
                                                <input type="hidden" name="gcs_total" id="gcs_total_input">
                                            </div>
                                            @push('modals')
                                                @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.modal-create-gcs')
                                            @endpush
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Golongan Darah</label>
                                            <input type="text" name="golongan_darah" class="form-control"
                                                placeholder="suhu dalam celcius">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Akses Intravena (Tempat Dan Ukuran)</label>
                                            <input type="text" name="akses_intravena" class="form-control"
                                                placeholder="tempat dan ukuran">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status Fisik ASA</label>
                                            <select name="status_fisik_asa" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="I">I</option>
                                                <option value="II">II</option>
                                                <option value="II">III</option>
                                                <option value="IV">IV</option>
                                                <option value="V">V</option>
                                                <option value="VI">VI</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <h6 class="fw-bold" style="min-width: 200px;">Dukungan Oksigen</h6>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemberian Oksigen Kepada Pasien</label>
                                            <select name="dukungan_pemberian_oksigen" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="1">Udara Bebas</option>
                                                <option value="2">Kanul Nasal</option>
                                                <option value="3">Simple Mark</option>
                                                <option value="4">Rebreathing Mark</option>
                                                <option value="5">No-Rebreathing Mark</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jika Pasien Memerlukan Support
                                                Pernapasan</label>
                                            <input type="text" name="dukungan_support_pernapasan" class="form-control"
                                                placeholder="jelaskan">
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Jika Pasien Terintubasi</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="dukungan_terintubasi_o2" class="form-control"
                                                    placeholder="Dengan bantuan O₂">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="dukungan_terintubasi_spo2" class="form-control"
                                                    placeholder="persen(%)">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <h6 class="fw-bold" style="min-width: 200px;">Antropometri</h6>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tinggi Badan (Kg)</label>
                                            <input type="text" name="antropometri_tinggi_badan" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="text" name="antropometri_berat_badan" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Indeks Massa Tubuh (IMT)</label>
                                            <input type="text" name="antropometri_imt" class="form-control bg-light"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Luas Permukaan Tubuh (LPT)</label>
                                            <input type="text" name="antropometri_lpt" class="form-control bg-light"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Obat Dan Pemantauan Selama Prosedur Dengan
                                                Anestesi Dan Sedasi</label>
                                            <input type="text" name="antropometri_obat_dan_pemantauan" class="form-control"
                                                placeholder="jelaskan">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pemantauanAnestesiPAS">
                                        <h5 class="section-title">5. Pemantauan Selama Anestesi dan Sedasi (PSAS)</h5>

                                        <div class="alert alert-info">
                                            <small>Data ini wajib di isi setiap 5 menit sekali data tersebut berupa Tekanan
                                                Darah, Nadi, Nafas, dan Saturasi Oksigen (SpO₂)</small>
                                        </div>

                                        <form id="monitoringFormPAS" class="pas-form">
                                            <!-- Hidden input to store all data in JSON format -->
                                            <input type="hidden" name="all_monitoring_data" id="all_monitoring_data_pas"
                                                value="[]">

                                            <div class="form-group row">
                                                <label class="col-sm-3">Data Waktu Jam</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="time" name="waktu_pemantauan_pas"
                                                            id="waktu_pemantauan_pas" class="form-control pas-input">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tek Darah (mmHg)</label>
                                                <input type="number" name="tekanan_darah_pantau_pas"
                                                    id="tekanan_darah_pantau_pas" class="form-control pas-input"
                                                    placeholder="tekanan darah">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                                <input type="number" name="nadi_pantau_pas" id="nadi_pantau_pas"
                                                    class="form-control pas-input" placeholder="frekuensi nadi per menit">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                                <input type="number" name="nafas_pantau_pas" id="nafas_pantau_pas"
                                                    class="form-control pas-input" placeholder="frekuensi nafas per menit">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Saturasi Oksigen (SpO₂) Persen (%)</label>
                                                <input type="number" name="saturasi_oksigen_pantau_pas"
                                                    id="saturasi_oksigen_pantau_pas" class="form-control pas-input"
                                                    placeholder="persen (%)" min="0" max="100">
                                            </div>

                                            <div class="text-end mb-4">
                                                <button type="button" id="saveButtonPAS" class="btn btn-primary pas-btn">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                                <button type="button" id="loadDataButtonPAS"
                                                    class="btn btn-secondary ms-2 pas-btn">
                                                    <i class="fas fa-sync"></i> Muat Data Contoh
                                                </button>
                                                <button type="button" id="resetDataButtonPAS"
                                                    class="btn btn-danger ms-2 pas-btn">
                                                    <i class="fas fa-trash"></i> Reset Data
                                                </button>
                                            </div>
                                        </form>

                                        <h6 class="mt-4">Graphics Selama Anestesi dan sedasi</h6>

                                        <div class="alert alert-secondary">
                                            <small>Graphics menunjukkan Tekanan Darah, Nadi, Nafas, dan Saturasi Oksigen
                                                (SpO₂) persen (%) dalam setiap 5 menit sekali</small>
                                        </div>

                                        <canvas id="vitalSignsChartPAS" height="150"></canvas>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap mb-2">
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Mulai Anestesi dan Sedasi : <strong>X</strong>
                                                        </label>
                                                    </div>
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Status Anestesi dan Sedasi : <strong>X</strong>
                                                        </label>
                                                    </div>
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Mulai Prosedur : <strong>O</strong>
                                                        </label>
                                                    </div>
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Selesai Prosedur : <strong>O</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hal Penting Yang Terjadi Selama Anestesi Dan
                                                Sedasi :</label>
                                            <textarea name="hal_penting" id="hal_penting_pas"
                                                class="form-control pas-textarea" rows="3"
                                                placeholder="jelaskan komplikasi yang sampang: intervensi jalan nafas, pemberian antidotum, resusitasi, dll"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kedalaman Anestesi Dan Sedasi</label>
                                            <select name="kedalaman_anestesi" id="kedalaman_anestesi_pas"
                                                class="form-control pas-select">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Tak Tersedia">Tak Tersedia (typical response/ cooperation for
                                                    this patient)</option>
                                                <option value="Ringan">Ringan (anxiolysis)</option>
                                                <option value="Sedang">Sedang (purpaseful response to verbal commands/ light
                                                    toctie secsation)</option>
                                                <option value="Dalam">Dalam (purpaseful response after repeated verbal/
                                                    painful stumutation)</option>
                                                <option value="Anastesi Umum">Anastesi Umum (Unarousable)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Respon Terhadap Anestesi Dan Sedasi</label>
                                            <select name="respon_anestesi" id="respon_anestesi_pas"
                                                class="form-control pas-select">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Sangat baik">Sangat baik, tenang dan kooperatif</option>
                                                <option value="Baik">Baik (kadang-kadang mengigil/ rasa penuruhi nafas
                                                    berkurang)</option>
                                                <option value="Cukup">Cukup (meringis/menangis dan prosedur
                                                    terganggu/tertunda)</option>
                                                <option value="Kurang">Kurang (agitasi/stres yang menganggu prosedur)
                                                </option>
                                                <option value="Jelek">Jelek (gerakan aktif, mengigil, menangis, prosedur
                                                    tertunda)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="catatanKamarPemulihanCKP">
                                        <h5 class="section-title">6. Catatan Kamar Pemulihan (CKP)</h5>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Data Masuk Jam</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="time" name="jam_masuk_pemulihan_ckp"
                                                        id="jam_masuk_pemulihan_ckp" class="form-control ckp-input">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jalan Nafas</label>
                                            <select name="jalan_nafas_ckp" id="jalan_nafas_ckp"
                                                class="form-control ckp-select">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Spontan">Spontan</option>
                                                <option value="Dibantu">Dibantu</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jika Jalan Nafas Spontan</label>
                                            <select name="nafas_spontan_ckp" id="nafas_spontan_ckp"
                                                class="form-control ckp-select">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Adekuat Bersuara">Adekuat Bersuara</option>
                                                <option value="Penyumbatan">Penyumbatan</option>
                                                <option value="Membutuhkan Bantuan Alat">Membutuhkan Bantuan Alat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesadaran</label>
                                            <select name="kesadaran_pemulihan_ckp" id="kesadaran_pemulihan_ckp"
                                                class="form-control ckp-select">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="Sadar Penuh">Sadar Penuh</option>
                                                <option value="Belum Sadar Penuh">Belum Sadar Penuh</option>
                                                <option value="Tidur Dalam">Tidur Dalam</option>
                                                <option value="VAS">VAS</option>
                                            </select>
                                        </div>

                                        <div class="alert alert-info mt-4">
                                            <small>Data observasi ini wajib di isi setiap 5 menit sekali, data tersebut
                                                berupa Tekanan Darah, Nadi, Nafas, Saturasi Oksigen (SpO₂), dan Tanda Vital
                                                Stabil (TVS)</small>
                                        </div>

                                        <!-- Changed from form to div to be part of the main form -->
                                        <div id="observasiFormCKP" class="ckp-form">
                                            <!-- Hidden input to store all data in JSON format -->
                                            <input type="hidden" name="all_observasi_data_ckp" id="all_observasi_data_ckp"
                                                value="[]">

                                            <div class="form-group row">
                                                <label class="col-sm-3">Data Waktu Jam</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="time" name="waktu_observasi_ckp"
                                                            id="waktu_observasi_ckp" class="form-control ckp-input">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                                <input type="number" name="tekanan_darah_pemulihan_ckp"
                                                    id="tekanan_darah_pemulihan_ckp" class="form-control ckp-input"
                                                    placeholder="tekanan darah">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                                <input type="number" name="nadi_pemulihan_ckp" id="nadi_pemulihan_ckp"
                                                    class="form-control ckp-input" placeholder="frekuensi nadi per menit">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                                <input type="number" name="nafas_pemulihan_ckp" id="nafas_pemulihan_ckp"
                                                    class="form-control ckp-input" placeholder="frekuensi nafas per menit">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Saturasi Oksigen (SpO₂) Persen (%)</label>
                                                <input type="number" name="saturasi_oksigen_pemulihan_ckp"
                                                    id="saturasi_oksigen_pemulihan_ckp" class="form-control ckp-input"
                                                    placeholder="persen (%)" min="0" max="100">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tanda Vital Stabil</label>
                                                <input type="number" name="tanda_vital_stabil_ckp"
                                                    id="tanda_vital_stabil_ckp" class="form-control ckp-input"
                                                    placeholder="nilai">
                                            </div>

                                            <div class="text-end mb-4">
                                                <button type="button" id="saveObservasiButtonCKP"
                                                    class="btn btn-primary ckp-btn">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                                <button type="button" id="loadSampleButtonCKP"
                                                    class="btn btn-secondary ms-2 ckp-btn">
                                                    <i class="fas fa-sync"></i> Muat Data Contoh
                                                </button>
                                                <button type="button" id="resetDataButtonCKP"
                                                    class="btn btn-danger ms-2 ckp-btn">
                                                    <i class="fas fa-trash"></i> Reset Data
                                                </button>
                                            </div>
                                        </div>

                                        <h6 class="mt-4">Graphics Pasca Anestesi dan sedasi</h6>

                                        <div class="alert alert-secondary">
                                            <small>Graphics menunjukkan Tekanan Darah, Nadi, Nafas, Saturasi Oksigen (SpO₂),
                                                dan Tanda Vital Stabil (TVS) dalam setiap 5 menit sekali</small>
                                        </div>

                                        <canvas id="recoveryVitalChartCKP" height="150"></canvas>

                                        <div class="row mt-3 mb-4">
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3 mb-2">
                                                        <span class="badge bg-primary me-1"></span> Tekanan Darah
                                                    </div>
                                                    <div class="me-3 mb-2">
                                                        <span class="badge bg-success me-1"></span> Nadi
                                                    </div>
                                                    <div class="me-3 mb-2">
                                                        <span class="badge bg-info me-1"></span> Nafas
                                                    </div>
                                                    <div class="me-3 mb-2">
                                                        <span class="badge bg-warning me-1"></span> SPO₂
                                                    </div>
                                                    <div class="me-3 mb-2">
                                                        <span class="badge bg-danger me-1"></span> TVS
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap mb-2">
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Mulai Anestesi dan Sedasi : <strong>X</strong>
                                                        </label>
                                                    </div>
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Status Anestesi dan Sedasi : <strong>X</strong>
                                                        </label>
                                                    </div>
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Mulai Prosedur : <strong>O</strong>
                                                        </label>
                                                    </div>
                                                    <div class="me-3">
                                                        <label class="form-check-label">
                                                            Selesai Prosedur : <strong>O</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Jenis Skala
                                                NYERI</label>
                                            <select class="form-select" id="jenisSkalaSelect" name="jenis_skala_nyeri">
                                                <option value="" selected>Pilih</option>
                                                <option value="nrs">Scale NRS, VAS, VRS</option>
                                                <option value="flacc">Face, Legs, Activity, Cry, Consolability (FLACC)
                                                </option>
                                                <option value="cries">Crying, Requires, Increased, Expression, Sleepless
                                                    (CRIES)</option>
                                            </select>
                                        </div>

                                        <!-- Hidden input untuk menyimpan semua data skala nyeri dalam JSON -->
                                        <input type="hidden" id="painScaleDataJSON" name="pain_scale_data_json" value="{}">

                                        <div id="selectedScaleInfo" class="mt-3 d-none">
                                            <button id="scaleInfoBtn" class="btn btn-info" hidden></button>
                                        </div>
                                        <div id="selectedScaleDisplay" class="mt-3 d-none">
                                            {{-- Akan diisi melalui JavaScript saat tombol simpan di modal ditekan --}}
                                        </div>
                                        @push('modals')
                                            @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.modal-skala-nyeri')
                                        @endpush

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Nilai Skala
                                                Nyeri</label>
                                            <input type="number" class="form-control" name="skala_nyeri"
                                                id="skala_nyeri_main" value="{{ old('skala_nyeri', 0) }}" min="0" max="10"
                                                readonly>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Kesimpulan Nyeri</label>
                                            <div id="kesimpulanNyeri" class="p-3 bg-success text-white rounded">Nyeri
                                                Ringan
                                            </div>
                                            <input type="hidden" name="kesimpulan_nyeri" id="kesimpulanNyeriInput"
                                                value="Nyeri Ringan">
                                        </div>

                                        {{-- skala pada pasien --}}
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Skala Pada Pasien</label>
                                            <select name="skala_pasien" id="skalaPasien" class="form-control">
                                                <option value="" disabled selected>Pilih skala Pemantauan Pasca-Anestesi
                                                </option>
                                                <option value="bromage">Bromage Score (SAB/Subarachnoid Block)</option>
                                                <option value="steward">Steward Score (Anak-anak)</option>
                                                <option value="aldrete">Score Aldrete</option>
                                                <option value="padds">Score PADDS (Khusus Rawat Jalan)</option>
                                            </select>
                                        </div>

                                        <!-- Hidden input untuk menyimpan semua data dalam format JSON -->
                                        <input type="hidden" id="patientScoreDataJSON" name="patient_score_data_json"
                                            value="{}">

                                        <!-- Bromage Score Form - Initially Hidden -->
                                        <div id="bromageScoreForm" class="score-form" style="display: none;">
                                            <h5 class="text-center mt-3">Penilaian Bromage Score (SAB/Subarachnoid Block)
                                            </h5>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Score Pasca Anestesi dan Sedasi</th>
                                                        <th>Jam</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Post anestesi vital sign</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>Jam pasca anestesi</span>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="bromage_time" value="15">
                                                                    <label class="form-check-label">15'</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="bromage_time" value="30">
                                                                    <label class="form-check-label">30'</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="bromage_time" value="45">
                                                                    <label class="form-check-label">45'</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="bromage_time" value="1">
                                                                    <label class="form-check-label">1</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="bromage_time" value="2">
                                                                    <label class="form-check-label">2</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gerakan penuh dari tungkai</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="bromage_gerakan_penuh"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_gerakan_penuh_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_gerakan_penuh_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_gerakan_penuh_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_gerakan_penuh_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_gerakan_penuh_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tak mampu ekstensi tungkai</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="bromage_tak_ekstensi"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_ekstensi_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_ekstensi_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_ekstensi_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_ekstensi_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_ekstensi_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tak mampu fleksi/lutut</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="bromage_tak_fleksi"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_fleksi_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_fleksi_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_fleksi_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_fleksi_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_fleksi_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tak mampu fleksi/pergerakan kaki</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="bromage_tak_pergerakan"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_jam_pindah_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_jam_pindah_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_jam_pindah_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_jam_pindah_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_jam_pindah_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jam Pindah Ruang Perawatan</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="bromage_jam_pindah"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_pergerakan_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_pergerakan_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_pergerakan_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_pergerakan_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="bromage_tak_pergerakan_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Steward Score Form - Initially Hidden -->
                                        <div id="stewardScoreForm" class="score-form" style="display: none;">
                                            <h5 class="text-center mt-3">Penilaian Steward Score (Anak-anak)</h5>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Score Pasca Anestesi dan Sedasi</th>
                                                        <th>Jam</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Post anestesi vital sign</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>Jam pasca anestesi</span>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="steward_time" value="15">
                                                                    <label class="form-check-label">15'</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="steward_time" value="30">
                                                                    <label class="form-check-label">30'</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="steward_time" value="45">
                                                                    <label class="form-check-label">45'</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="steward_time" value="1">
                                                                    <label class="form-check-label">1</label>
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="steward_time" value="2">
                                                                    <label class="form-check-label">2</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Kesadaran
                                                            <select name="steward_kesadaran"
                                                                class="form-select ms-2 d-inline-block w-25">
                                                                <option value="" selected>Pilih</option>
                                                                <option value="Sadar Penuh" selected>Sadar Penuh</option>
                                                                <option value="Bangun jika Dipanggil" selected>Bangun jika
                                                                    Dipanggil</option>
                                                                <option value="Belum Respon" selected>Belum Respon</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="steward_kesadaran_jam"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_kesadaran_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_kesadaran_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_kesadaran_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_kesadaran_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_kesadaran_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Respirasi
                                                            <select name="steward_respirasi"
                                                                class="form-select ms-2 d-inline-block w-25">
                                                                <option value="" selected>Pilih</option>
                                                                <option value="Batuk/ Manangis" selected>Batuk/ Manangis
                                                                </option>
                                                                <option value="Berusaha Bernafas" selected>Berusaha Bernafas
                                                                </option>
                                                                <option value="Perlu Bantuan Bernafas" selected>Perlu
                                                                    Bantuan Bernafas</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="steward_respirasi_jam"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_respirasi_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_respirasi_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_respirasi_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_respirasi_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_respirasi_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Aktivitas Motorik
                                                            <select name="steward_motorik"
                                                                class="form-select ms-2 d-inline-block w-25">
                                                                <option value="" selected>Pilih</option>
                                                                <option value="Gerakan Beraturan" selected>Gerakan Beraturan
                                                                </option>
                                                                <option value="Gerakan Beraturan" selected>Gerakan Beraturan
                                                                </option>
                                                                <option value="Tidak Bergerak" selected>Tidak Bergerak
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="steward_motorik_jam"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_motorik_15">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_motorik_30">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_motorik_45">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_motorik_1">
                                                                </div>
                                                                <div class="form-check ms-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="steward_motorik_2">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jam Pindah Ruang</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="far fa-clock me-2"></i>
                                                                <input type="time" name="steward_jam_pindah"
                                                                    class="form-control form-control-sm w-25" value="Jam">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Aldrete Score Form - Initially Hidden -->
                                        <div id="aldreteScoreForm" class="score-form" style="display: none;">
                                            <h5 class="text-center mt-3">Penilaian Score Aldrete</h5>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Aktivitas Motorik</label>
                                                <select name="aktivitas_motorik" class="form-control">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="0">Seluruh ekstremitas dapat digerakkan</option>
                                                    <option value="1">Dua akstremitas dapat digerakkan</option>
                                                    <option value="2">Tidak dapat bergerak</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Respirasi</label>
                                                <select name="respirasi" class="form-control">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="0">Dapat bernapas dalam dan batuk</option>
                                                    <option value="1">Dangkal namun pertukaran udara adekuat</option>
                                                    <option value="2">Apneu atau obstruksi</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Sirkulasi</label>
                                                <select name="aldrete_sirkulasi" class="form-control">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="0">Tekanan darah menyimpang < 20 mmHg dari tekanan darah
                                                            pre anestesi</option>
                                                    <option value="1">Tekanan darah menyimpang 20-50 mmHg dari tekanan darah
                                                        pre anestesi</option>
                                                    <option value="2">Tekanan darah menyimpang >50 mmHg dari tekanan darah
                                                        pre anestesi</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Kesadaran</label>
                                                <select name="aldrete_kesadaran" class="form-control">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="0">Tidak berespon</option>
                                                    <option value="1">Bangun namun 'epat kembali tertidur</option>
                                                    <option value="2">Sadar serta orientasi</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Warna Kulit</label>
                                                <select name="aldrete_warna_kulit" class="form-control">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="0">Sianosis</option>
                                                    <option value="1">Pucat, ikterik</option>
                                                    <option value="2">Merah muda</option>
                                                </select>
                                            </div>

                                            <div class="bg-success text-white p-2 rounded mb-3">
                                                <strong>Kesimpulan : </strong> Boleh pindah ruang / Tidak Boleh pindah ruang
                                            </div>

                                            <h6 class="text-center mt-2">Data Penilaian Score Aldrete</h6>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tanggal Jam Pasca Anestesi</label>
                                                <div class="input-group">
                                                    <input type="datetime-local" name="aldrete_tanggal"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Interval/Jam</th>
                                                        <th>Skor</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="far fa-clock"></i></span>
                                                                <input type="time" name="interval_jam_1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="skor_1" class="form-control" min="0">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan_1" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="far fa-clock"></i></span>
                                                                <input type="time" name="interval_jam_2"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="skor_2" class="form-control" min="0">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan_2" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="far fa-clock"></i></span>
                                                                <input type="time" name="interval_jam_3"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="skor_3" class="form-control" min="0">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan_3" class="form-control">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="bg-success text-white p-2 rounded mb-3">
                                                <strong>Kesimpulan : </strong> Boleh pindah ruang / Tidak Boleh pindah ruang
                                            </div>
                                        </div>

                                        <!-- PADDS Score Form - Initially Hidden -->
                                        <div id="paddsScoreForm" class="score-form" style="display: none;">
                                            <h5 class="text-center mt-3">Penilaian Score PADDS (Khusus Rawat Jalan)</h5>

                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2">Tanda Vital</label>
                                                <select class="form-select" name="padds_tanda_vital" id="paddsTandaVital">
                                                    <option value="" selected>pilih</option>
                                                    <option value="2">Tekanan darah dan nadi 15-24% dari pre Op</option>
                                                    <option value="1">Tekanan darah dan nadi 25-40% dari pre Op</option>
                                                    <option value="0">Tekanan darah dan nadi >40% dari pre Op</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2">Aktivitas</label>
                                                <select class="form-select" name="padds_aktivitas" id="paddsAktivitas">
                                                    <option value="" selected>pilih</option>
                                                    <option value="2">Berjalan normal, tidak pusing saat berdiri</option>
                                                    <option value="1">Butuh bantuan untuk berjalan</option>
                                                    <option value="0">Tidak dapat berjalan</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2">Mual/muntah</label>
                                                <select class="form-select" name="padds_mual_muntah" id="paddsMualMuntah">
                                                    <option value="" selected>pilih</option>
                                                    <option value="2">Tidak ada atau ringan, tetap bisa makan</option>
                                                    <option value="1">Sedang, terkontrol dengan obat</option>
                                                    <option value="0">Berat, tidak terkontrol dengan obat</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2">Perdarahan</label>
                                                <select class="form-select" name="padds_perdarahan" id="paddsPerdarahan">
                                                    <option value="" selected>pilih</option>
                                                    <option value="2">Minimal (tidak perlu ganti verban)</option>
                                                    <option value="1">Sedang (perlu ganti verban 1-2 kali)</option>
                                                    <option value="0">Berat (perlu ganti verban 3 kali atau lebih)</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2">Nyeri</label>
                                                <select class="form-select" name="padds_nyeri" id="paddsNyeri">
                                                    <option value="" selected>pilih</option>
                                                    <option value="2">Nyeri ringan, nyaman, dapat diterima</option>
                                                    <option value="1">Nyeri sedang sampai berat, terkontrol dengan analgesik
                                                        oral</option>
                                                    <option value="0">Nyeri berat, tidak terkontrol dengan analgesik oral
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2"
                                                    style="background-color: #177F75; color: white; padding: 8px;">Kesimpulan
                                                    :</label>
                                                <div id="paddsKesimpulan" class="p-3 text-white rounded"
                                                    style="background-color: #177F75;">
                                                    Boleh pindah ruang / Tidak Boleh pindah ruang
                                                </div>
                                                <input type="hidden" name="padds_kesimpulan" id="paddsKesimpulanInput"
                                                    value="Boleh pindah ruang / Tidak Boleh pindah ruang">
                                            </div>

                                            <!-- Tabel Rekaman Waktu -->
                                            <div class="mt-4">
                                                <h6>Data Penilaian Score PADDS (Khusus Rawat Jalan)</h6>

                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Jam Pasca Anestesi</label>
                                                    <div class="input-group">
                                                        <input type="datetime-local" class="form-control"
                                                            name="padds_tanggal_jam" id="paddsTanggalJam">
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal/Jam</th>
                                                                <th>Skor</th>
                                                                <th>Kesimpulan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="paddsTimeTable">
                                                            <tr>
                                                                <td><i class="far fa-clock"></i> Jam</td>
                                                                <td>Skor</td>
                                                                <td>Kesimpulan</td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="far fa-clock"></i> Jam</td>
                                                                <td>Skor</td>
                                                                <td>Kesimpulan</td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="far fa-clock"></i> Jam</td>
                                                                <td>Skor</td>
                                                                <td>Kesimpulan</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 mt-4">
                                                <label class="d-block mb-2"
                                                    style="background-color: #177F75; color: white; padding: 8px;">Kesimpulan
                                                    :</label>
                                                <div id="paddsFinalKesimpulan" class="p-3 text-white rounded"
                                                    style="background-color: #177F75;">
                                                    Boleh pindah ruang / Tidak Boleh pindah ruang
                                                </div>
                                                <input type="hidden" name="padds_final_kesimpulan"
                                                    id="paddsFinalKesimpulanInput"
                                                    value="Boleh pindah ruang / Tidak Boleh pindah ruang">
                                            </div>

                                        </div>
                                        {{-- end skala pada pasien --}}

                                        <div class="form-group row">
                                            <label class="col-sm-3">Keluar Kamar Pulih Jam</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="time" name="jam_keluar" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala Nyeri VAS</label>
                                            <input type="number" name="nilai_skala_vas" class="form-control"
                                                placeholder="Nilai 0-10">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lanjut Ke Ruang</label>
                                            <select name="lanjut_ruang" class="form-control">
                                                <option value="" disabled selected>pilih</option>
                                                <option value="ICU">ICU</option>
                                                <option value="PICU">PICU</option>
                                                <option value="NICU">NICU</option>
                                                <option value="Lanjutkan pulang">Lanjutkan pulang</option>
                                                <option value="Bangsal">Bangsal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Catatan Ruang Pemulihan</label>
                                            <textarea name="catatan_pemulihan" class="form-control" rows="2"
                                                placeholder="Catatan Ruang Pemulihan kepada pasien"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="instruksiPascaBedah">
                                        <h5 class="section-title">7. Instruksi Pasca Bedah (IPB)</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bila Kesakitan</label>
                                            <input type="text" name="bila_kesakitan" class="form-control"
                                                placeholder="jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bila Mual/Muntah</label>
                                            <input type="text" name="bila_mual_muntah" class="form-control"
                                                placeholder="jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Antibiotika</label>
                                            <input type="text" name="antibiotika" class="form-control"
                                                placeholder="Antibiotika yang digunakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Obat-Obatan Lain</label>
                                            <input type="text" name="obat_lain" class="form-control"
                                                placeholder="obat lain yang digunakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Cairan Infus</label>
                                            <input type="text" name="cairan_infus" class="form-control"
                                                placeholder="cairan infus yang digunakan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Minum</label>
                                            <input type="text" name="minum" class="form-control"
                                                placeholder="Minum yang diberikan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemantauan Tanda Vital Setiap</label>
                                            <input type="time" name="pemantauan_tanda_vital" class="form-control"
                                                placeholder="01:10 jam">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Selama Berapa Jam Pemantauan Dilakukan</label>
                                            <input type="text" name="durasi_pemantauan" class="form-control"
                                                placeholder="contoh selama 24 jam, kemudian setiap 1 jam selama 6 jam">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">E-Signature Dokter</label>
                                            <select name="dokter_edukasi" id="dokter_edukasi" class="form-select select2">
                                                <option value="">--Pilih--</option>
                                                @foreach ($dokterAnastesi as $item)
                                                    <option value="{{ $item->kd_dokter }}">{{ $item->dokter->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lain-Lain</label>
                                            <textarea name="lain_lain" class="form-control" rows="3"
                                                placeholder="Lain-lain"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">HardCopy Form Perlengkapan</label>
                                            <input type="file" name="hardcopyform" class="form-control">
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
