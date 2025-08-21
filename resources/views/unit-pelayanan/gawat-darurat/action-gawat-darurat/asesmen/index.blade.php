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
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.index-asesmenawal')
                            </div>
                            <div class="tab-pane fade" id="skrining" role="tabpanel" aria-labelledby="skrining-tab">
                                {{-- TAB 2. buatlah list disini --}}
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
        document.addEventListener('DOMContentLoaded', function() {
            // === Kode untuk handle pemeriksaan fisik ===
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.getElementById(targetId);
                    const parentItem = this.closest('.pemeriksaan-item');
                    const normalCheckbox = parentItem.querySelector('.form-check-input');

                    if (targetElement.style.display === 'none') {
                        targetElement.style.display = 'block';
                        if (normalCheckbox) {
                            normalCheckbox.checked = false;
                        }
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

            // === Kode untuk IMT LPT ===
            const tbInput = document.querySelector('input[name="antropometri[tb]"]');
            const bbInput = document.querySelector('input[name="antropometri[bb]"]');
            const imtInput = document.querySelector('input[name="antropometri[imt]"]');
            const lptInput = document.querySelector('input[name="antropometri[lpt]"]');

            if (tbInput && bbInput && imtInput && lptInput) {
                imtInput.readOnly = true;
                lptInput.readOnly = true;
                tbInput.addEventListener('input', calculateIMT_LPT);
                bbInput.addEventListener('input', calculateIMT_LPT);
            }

            // === Kode untuk tindak lanjut ===
            let tindakLanjutData = null;

            function updateRawatInapDiagnosis() {
                const diagnosisRanapInput = document.getElementById('diagnosis_ranap');
                if (diagnosisRanapInput && window.getDiagnosaData) {
                    try {
                        const diagnoses = JSON.parse(window.getDiagnosaData());
                        if (Array.isArray(diagnoses) && diagnoses.length > 0) {
                            diagnosisRanapInput.value = diagnoses.join('\n');
                        }
                    } catch (error) {
                        console.error('Error parsing diagnosis data:', error);
                    }
                }
            }

            document.querySelectorAll('input[name="tindakLanjut"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    toggleInputFields(this.value);
                    saveTindakLanjut();
                });
            });

            function toggleInputFields(selectedOption) {
                // Hide all input fields first
                const allFields = [
                    'formRujukKeluar',
                    'formpulangSembuh',
                    'formberobatJalan',
                    'formMenolakRawatInap',
                    'formmeninggalDunia',
                    'formDOA',
                    'formRawatInap',
                    'formKamarOperasi'
                ];
                
                allFields.forEach(field => {
                    document.getElementById(field).style.display = 'none';
                });

                // Show relevant fields based on selection
                switch(selectedOption) {
                    case 'rawatInap':
                        document.getElementById('formRawatInap').style.display = 'block';
                        updateRawatInapDiagnosis();
                        break;
                    case 'kamarOperasi':
                        document.getElementById('formKamarOperasi').style.display = 'block';
                        break;
                    case 'menolakRawatInap':
                        document.getElementById('formMenolakRawatInap').style.display = 'block';
                        break;
                    case 'rujukKeluar':
                        document.getElementById('formRujukKeluar').style.display = 'block';
                        break;
                    case 'pulangSembuh':
                        document.getElementById('formpulangSembuh').style.display = 'block';
                        break;
                    case 'berobatJalan':
                        document.getElementById('formberobatJalan').style.display = 'block';
                        break;
                    case 'meninggalDunia':
                        document.getElementById('formmeninggalDunia').style.display = 'block';
                        break;
                    case 'deathoffarrival':
                        document.getElementById('formDOA').style.display = 'block';
                        break;
                }
            }

            const formFields = [
                'tanggalDoa',
                'jamDoa',
                'alasanMenolak',
                'tanggalMeninggal',
                'jamMeninggal',
                'tujuan_rujuk',
                'alasan_rujuk',
                'transportasi_rujuk',
                'tanggalPulang',
                'jamPulang',
                'alasan_pulang',
                'tanggal_rajal',
                'poli_unit_tujuan',
                'kamarOperasi',
                'kondisi_pulang',
                'tanggalRawatInap',
                'jamRawatInap',
                'keluhanUtama_ranap',
                'hasilPemeriksaan_ranap',
                'jalannyaPenyakit_ranap',
                'diagnosis_ranap',
                'tindakan_ranap',
                'anjuran_ranap'
            ];

            formFields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                if (element) {
                    element.addEventListener('change', saveTindakLanjut);
                }
            });


            function saveTindakLanjut() {
                const selectedOption = document.querySelector('input[name="tindakLanjut"]:checked');
                if (!selectedOption) return;

                tindakLanjutData = {
                    option: selectedOption.value,
                    // Rawat Inap fields
                    tanggalRawatInap: document.getElementById('tanggalRawatInap')?.value || '',
                    jamRawatInap: document.getElementById('jamRawatInap')?.value || '',
                    keluhanUtama_ranap: document.getElementById('keluhanUtama_ranap')?.value || '',
                    hasilPemeriksaan_ranap: document.getElementById('hasilPemeriksaan_ranap')?.value || '',
                    jalannyaPenyakit_ranap: document.getElementById('jalannyaPenyakit_ranap')?.value || '',
                    diagnosis_ranap: document.getElementById('diagnosis_ranap')?.value || '',
                    tindakan_ranap: document.getElementById('tindakan_ranap')?.value || '',
                    anjuran_ranap: document.getElementById('anjuran_ranap')?.value || '',
                    // Kamar Operasi fields
                    kamarOperasi: document.getElementById('kamarOperasi')?.value || '',
                    // Menolak Rawat Inap fields
                    alasanMenolak: document.getElementById('alasanMenolak')?.value || '',
                    // Rujuk Keluar fields
                    tujuan_rujuk: document.getElementById('tujuan_rujuk')?.value || '',
                    alasan_rujuk: document.getElementById('alasan_rujuk')?.value || '',
                    transportasi_rujuk: document.getElementById('transportasi_rujuk')?.value || '',
                    // Pulang Sembuh fields
                    tanggalPulang: document.getElementById('tanggalPulang')?.value || '',
                    jamPulang: document.getElementById('jamPulang')?.value || '',
                    alasan_pulang: document.getElementById('alasan_pulang')?.value || '',
                    kondisi_pulang: document.getElementById('kondisi_pulang')?.value || '',
                    // Berobat Jalan fields
                    tanggal_rajal: document.getElementById('tanggal_rajal')?.value || '',
                    poli_unit_tujuan: document.getElementById('poli_unit_tujuan')?.value || '',
                    // Meninggal Dunia fields
                    tanggalMeninggal: document.getElementById('tanggalMeninggal')?.value || '',
                    jamMeninggal: document.getElementById('jamMeninggal')?.value || '',
                    // DOA fields
                    tanggalDoa: document.getElementById('tanggalDoa')?.value || '',
                    jamDoa: document.getElementById('jamDoa')?.value || ''
                };
            }

            window.getTindakLanjutData = function() {
                return tindakLanjutData ? JSON.stringify(tindakLanjutData) : null;
            };

            function fillVitalSignFromTriase() {
                const vitalSignContainer = document.querySelector('[data-triase-vital-sign]');
                const vitalSignData = vitalSignContainer?.dataset.triaseVitalSign;
                
                if (vitalSignData) {
                    try {
                        const vitalSign = JSON.parse(vitalSignData);
                        
                        // Mapping untuk vital sign
                        const vitalSignMapping = {
                            'sistole': 'td_sistole',
                            'diastole': 'td_diastole',
                            'nadi': 'nadi',
                            'respiration': 'resp',
                            'suhu': 'suhu',
                            'spo2_tanpa_o2': 'spo2_tanpa_o2',
                            'spo2_dengan_o2': 'spo2_dengan_o2'
                        };

                        // Isi form vital sign
                        Object.entries(vitalSignMapping).forEach(([triaseKey, formKey]) => {
                            const input = document.querySelector(`[name="vital_sign[${formKey}]"]`);
                            if (input && vitalSign[triaseKey]) {
                                input.value = vitalSign[triaseKey];
                            }
                        });

                        // Mapping untuk antropometri
                        const antropometriMapping = {
                            'tinggi_badan': 'tb',
                            'berat_badan': 'bb'
                        };

                        // Isi form antropometri
                        Object.entries(antropometriMapping).forEach(([triaseKey, formKey]) => {
                            const input = document.querySelector(`[name="antropometri[${formKey}]"]`);
                            if (input && vitalSign[triaseKey]) {
                                input.value = vitalSign[triaseKey];
                                // Trigger event input untuk menghitung IMT dan LPT
                                input.dispatchEvent(new Event('input'));
                            }
                        });

                    } catch (e) {
                        console.error('Error parsing vital sign data:', e);
                    }
                }
            }

            fillVitalSignFromTriase();

            // Juga panggil saat modal dibuka (jika menggunakan modal)
            const asesmenModal = document.getElementById('asesmenModal');
            if (asesmenModal) {
                asesmenModal.addEventListener('show.bs.modal', fillVitalSignFromTriase);
            }

            // === Kode untuk handle submit form dengan ajax ===
            const form = document.getElementById('asesmenForm');
            const submitButton = document.getElementById('saveForm');
            const modalId = '#detailPasienModal';

            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                submitButton.classList.add('loading');
                submitButton.innerHTML =
                    '<div class="loading-spinner"></div><span class="loading-text">Mengirim...</span>';

                var formData = new FormData(form);

                formData.append('antropometri', getAntropometriData());
                formData.append('vital_sign', getVitalSignData());
                formData.append('tindakan_resusitasi', getTindakanResusitasiData());
                formData.append('riwayat_alergi', window.getAlergiData ? window.getAlergiData() : '');
                formData.append('retriage_data', window.getReTriageData ? window.getReTriageData() : '');
                formData.append('diagnosa_data', window.getDiagnosaData ? window.getDiagnosaData() : '');
                formData.append('alat_terpasang_data', window.getAlatTerpasangData ? window.getAlatTerpasangData() : '');
                formData.append('tindak_lanjut_data', window.getTindakLanjutData ? window.getTindakLanjutData() : '');

                var pemeriksaanFisik = [];
                document.querySelectorAll('.pemeriksaan-item').forEach(function(item) {
                    var checkbox = item.querySelector('.form-check-input');
                    if (checkbox) {
                        var fullId = checkbox.id;
                        var id = fullId.replace('show_', '').replace('_normal', '');

                        var isNormal = checkbox.checked;
                        var keteranganDiv = item.querySelector('.keterangan');
                        var keteranganInput = keteranganDiv ? keteranganDiv.querySelector('input') :
                            null;
                        var keterangan = keteranganInput ? keteranganInput.value : '';

                        if (!isNormal && keterangan) {
                            pemeriksaanFisik.push({
                                id: parseInt(id),
                                is_normal: 0,
                                keterangan: keterangan
                            });
                        } else if (isNormal) {
                            pemeriksaanFisik.push({
                                id: parseInt(id),
                                is_normal: 1,
                                keterangan: ''
                            });
                        }
                    }
                });

                formData.append('pemeriksaan_fisik', JSON.stringify(pemeriksaanFisik));

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
                        iziToast.success({
                            title: 'Sukses',
                            message: 'Data berhasil dikirim.',
                            position: 'topRight'
                        });

                        submitButton.classList.remove('loading');
                        submitButton.innerHTML = 'Kirim';

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

        // === Helper functions yang dipanggil saat submit ===
        function getVitalSignData() {
            const vitalSign = {};
            vitalSign.gcs = window.gcsData || {
                eye: {
                    value: 0,
                    description: ""
                },
                verbal: {
                    value: 0,
                    description: ""
                },
                motoric: {
                    value: 0,
                    description: ""
                },
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

        function calculateIMT_LPT() {
            const tbInput = document.querySelector('input[name="antropometri[tb]"]');
            const bbInput = document.querySelector('input[name="antropometri[bb]"]');
            const imtInput = document.querySelector('input[name="antropometri[imt]"]');
            const lptInput = document.querySelector('input[name="antropometri[lpt]"]');

            if (!tbInput || !bbInput || !imtInput || !lptInput) return;

            const tinggiCm = parseFloat(tbInput.value);
            const berat = parseFloat(bbInput.value);

            if (!isNaN(tinggiCm) && !isNaN(berat) && tinggiCm > 0) {
                const tinggiMeter = tinggiCm / 100;
                const imt = berat / (tinggiMeter * tinggiMeter);
                const lpt = (tinggiCm * berat) / 3600;

                imtInput.value = imt.toFixed(2);
                lptInput.value = lpt.toFixed(2);
            } else {
                imtInput.value = '';
                lptInput.value = '';
            }
        }
    </script>
@endpush
