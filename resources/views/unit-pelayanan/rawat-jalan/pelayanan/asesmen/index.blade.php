@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <!-- Tambahkan ini ke tag <style> atau file CSS -->
    <style>
        /* Sticky untuk side kiri khusus di dalam modal #detailPasienModal */
        #detailPasienModal .patient-card {
            position: sticky;
            top: 0;
            max-height: 100vh;
            overflow-y: auto;
            padding-right: 10px;
        }

        /* Scroll untuk konten di sebelah kanan hanya dalam modal */
        #detailPasienModal .col-md-9 {
            max-height: 100vh;
            overflow-y: auto;
        }

        /* Garis pemisah tipis antar section */
        .form-line {
            border-bottom: 1px solid #e0e0e0;
            /* Ubah warna dan ketebalan sesuai kebutuhan */
            margin-bottom: 20px;
            /* Tambahkan margin bawah untuk spasi antar section */
            padding-bottom: 15px;
        }

        .pemeriksaan-fisik {
            margin-bottom: 20px;
        }

        .pemeriksaan-item {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .pemeriksaan-item:last-child {
            border-bottom: none;
        }

        .tambah-keterangan {
            padding: 0px 5px;
        }

        .keterangan {
            margin-top: 10px;
        }

        .triase-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .triase-doa {
            background-color: #343a40;
        }

        .triase-resusitasi {
            background-color: #dc3545;
        }

        .triase-emergency {
            background-color: #dc3545;
        }

        .triase-urgent {
            background-color: #ffc107;
            color: black;
        }

        .triase-false-emergency {
            background-color: #28a745;
        }

        #reTriaseTable {
            table-layout: fixed;
            width: 100%;
        }

        #reTriaseTable td {
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        #reTriaseTable td:nth-child(1) {
            width: 15%;
        }

        /* Tanggal dan Jam */
        #reTriaseTable td:nth-child(2) {
            width: 20%;
        }

        /* Keluhan */
        #reTriaseTable td:nth-child(3) {
            width: 45%;
        }

        /* Vital Sign */
        #reTriaseTable td:nth-child(4) {
            width: 20%;
        }

        /* Re-Triase/EWS */

        #reTriaseTable ul {
            padding-left: 20px;
            margin: 0;
        }

        #reTriaseTable li {
            margin-bottom: 5px;
        }

        .triase-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Tambahkan ini ke file CSS Anda */
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #22a6b3;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            margin-left: 10px;
        }

        button.loading {
            position: relative;
            pointer-events: none;
        }

        button.loading .loading-spinner {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        }

        button.loading .loading-text {
            opacity: 0.6;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="asesmen-tab" data-bs-toggle="tab"
                                    data-bs-target="#asesmen" type="button" role="tab" aria-controls="asesmen"
                                    aria-selected="true">Asesmen Awal
                                    Medis</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="skrining-tab" data-bs-toggle="tab" data-bs-target="#skrining"
                                    type="button" role="tab" aria-controls="skrining" aria-selected="false">Skrining
                                    Khusus</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="asesmen" role="tabpanel"
                                aria-labelledby="asesmen-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen.index-asesmenawal')
                            </div>
                            <div class="tab-pane fade" id="skrining" role="tabpanel" aria-labelledby="skrining-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen.index-skriningkhusus')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.querySelectorAll('.tambah-keterangan').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);
                if (targetElement.style.display === 'none') {
                    targetElement.style.display = 'block';
                } else {
                    targetElement.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('.row');
                const keteranganDiv = row.querySelector('.keterangan-index');
                const tambahButton = row.querySelector('.tambah-keterangan');
                if (this.checked) {
                    keteranganDiv.style.display = 'none';
                    tambahButton.disabled = true;
                } else {
                    tambahButton.disabled = false;
                }
            });
        });

        function getVitalSignData() {
            const vitalSign = {};
            vitalSign.gcs = window.gcsData || {
                eye: { value: 0, description: "" },
                verbal: { value: 0, description: "" },
                motoric: { value: 0, description: "" },
                total: 0
            };
            const fields = [
                'td_sistole', 'td_diastole', 'nadi', 'resp', 'suhu', 'avpu', 'spo2_tanpa_o2', 'spo2_dengan_o2'
            ];

            fields.forEach(field => {
                const element = document.querySelector(`[name="vital_sign[${field}]"]`);
                if (element && element.value) {
                    vitalSign[field] = element.value;
                }
            });

            return JSON.stringify(vitalSign);
        }

        function getTindakanResusitasiData() {
            const tindakanResusitasi = {
                air_way: [],
                breathing: [],
                circulation: []
            };

            document.querySelectorAll('input[name^="tindakan_resusitasi[air_way]"]:checked').forEach(checkbox => {
                tindakanResusitasi.air_way.push(checkbox.value);
            });

            document.querySelectorAll('input[name^="tindakan_resusitasi[breathing]"]:checked').forEach(checkbox => {
                tindakanResusitasi.breathing.push(checkbox.value);
            });

            document.querySelectorAll('input[name^="tindakan_resusitasi[circulation]"]:checked').forEach(checkbox => {
                tindakanResusitasi.circulation.push(checkbox.value);
            });

            return JSON.stringify(tindakanResusitasi);
        }

        function getAntropometriData() {
            const antropometri = {};
            const fields = ['tb', 'bb', 'ling_kepala', 'lpt', 'imt'];

            fields.forEach(field => {
                const element = document.querySelector(`[name="antropometri[${field}]"]`);
                if (element && element.value) {
                    antropometri[field] = element.value;
                }
            });

            return JSON.stringify(antropometri);
        }

        document.getElementById('asesmenForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var alergiDataJson = window.getAlergiData();
            var reTriaseDataJson = window.getReTriageData();
            var diagnosaDataJson = window.getDiagnosaData();
            var alatDataJson = window.getAlatTerpasangData();
            var tindaklanjutDataJson = window.getTindakLanjutData();

            var hiddenAlergiInput = document.createElement('input');
            hiddenAlergiInput.type = 'hidden';
            hiddenAlergiInput.name = 'riwayat_alergi';
            hiddenAlergiInput.value = alergiDataJson;

            var hiddenReTriaseInput = document.createElement('input');
            hiddenReTriaseInput.type = 'hidden';
            hiddenReTriaseInput.name = 'retriage_data';
            hiddenReTriaseInput.value = reTriaseDataJson;

            var hiddenDiagnosaInput = document.createElement('input');
            hiddenDiagnosaInput.type = 'hidden';
            hiddenDiagnosaInput.name = 'diagnosa_data';
            hiddenDiagnosaInput.value = diagnosaDataJson;

            var hiddenAlatInput = document.createElement('input');
            hiddenAlatInput.type = 'hidden';
            hiddenAlatInput.name = 'alat_terpasang_data';
            hiddenAlatInput.value = alatDataJson;

            var hiddenTindakLanjutInput = document.createElement('input');
            hiddenTindakLanjutInput.type = 'hidden';
            hiddenTindakLanjutInput.name = 'tindak_lanjut_data';
            hiddenTindakLanjutInput.value = tindaklanjutDataJson;

            this.appendChild(hiddenAlergiInput);
            this.appendChild(hiddenReTriaseInput);
            this.appendChild(hiddenDiagnosaInput);
            this.appendChild(hiddenAlatInput);
            this.appendChild(hiddenTindakLanjutInput);

            this.submit();
        });

        // Funsi Submit Ajax
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('asesmenForm');
            const submitButton = document.getElementById('saveForm');
            const modalId = '#detailPasienModal'

            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Tambahkan efek loading ke button
                submitButton.classList.add('loading');
                submitButton.innerHTML =
                    '<div class="loading-spinner"></div><span class="loading-text">Mengirim...</span>';

                var formData = new FormData(form);
                console.log(window.getReTriageData());
                

                // Tambahkan data tambahan ke formData
                formData.append('antropometri', getAntropometriData());
                formData.append('vital_sign', getVitalSignData());
                formData.append('tindakan_resusitasi', getTindakanResusitasiData());
                formData.append('riwayat_alergi', window.getAlergiData ? window.getAlergiData() : '');
                formData.append('retriage_data', window.getReTriageData() ? window.getReTriageData() : '');
                formData.append('tindak_lanjut_data', window.getTindakLanjutData ? window
                    .getTindakLanjutData() : '');
                formData.append('diagnosa_data', window.getDiagnosaData ? window.getDiagnosaData() : '');
                formData.append('alat_terpasang_data', window.getAlatTerpasangData ? window
                    .getAlatTerpasangData() : '');

                var pemeriksaanFisik = [];
                document.querySelectorAll('.pemeriksaan-item').forEach(function(item) {
                    var checkbox = item.querySelector('.form-check-input');
                    if (checkbox) {
                        var id = checkbox.id.replace('-normal-index', '');
                        var isNormal = checkbox.checked;
                        var keteranganInput = item.querySelector('.keterangan-index input');
                        var keterangan = keteranganInput ? keteranganInput.value : '';

                        pemeriksaanFisik.push({
                            id: id,
                            is_normal: isNormal,
                            keterangan: keterangan
                        });
                    }
                });

                formData.append('pemeriksaan_fisik', JSON.stringify(pemeriksaanFisik));
                // console.log(formData);
                // return false;
                // Kirim data menggunakan Fetch API 
                
                console.log(form.action);
                console.log("sssasasa");
                           
                
                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                console.log('Response error:', text);
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Terjadi kesalahan saat mengirim data.',
                                    position: 'topRight'
                                });
                                throw new Error(text);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);

                        // Tampilkan pesan sukses
                        iziToast.success({
                            title: 'Sukses',
                            message: 'Data berhasil dikirim.',
                            position: 'topRight'
                        });

                        // Hapus efek loading dari button
                        submitButton.classList.remove('loading');
                        submitButton.innerHTML = 'Kirim';

                        // Tutup modal
                        $(modalId).modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        submitButton.classList.remove('loading');
                        submitButton.innerHTML = 'Kirim';

                        iziToast.error({
                            title: 'Error',
                            message: 'Terjadi kesalahan saat mengirim data.',
                            position: 'topRight'
                        });
                    });
            });

        });
    </script>
@endpush
