<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Traveling Dialysis - {{ $dataMedis->pasien->nama_pasien }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0px 5px;  /* atas-bawah 5px, kiri-kanan 20px */
            padding: 0;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000000;
            box-shadow: 0 2px 0 0 #000000;
            padding-bottom: 5px;
        }
        
        .logo-section {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        
        .logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: center;
        }
        
        .hospital-info {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-left: 2px;
        }

        .kota-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 1px;
        }
        
        .hospital-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 1px;
        }
        
        .hospital-address {
            font-size: 10px;
            color: #666;
        }
        
        .title {
            background-color: #4CAF50;
            color: rgb(0, 0, 0);
            padding: 2px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 5px 0;
        }
        
        .content {
            margin: 20px 0;
        }
        
        .row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }
        
        .label {
            display: table-cell;
            width: 200px;
            font-weight: bold;
            vertical-align: top;
            padding-right: 10px;
        }
        
        .value {
            display: table-cell;
            vertical-align: top;
        }
        
        .checkbox-group {
            margin: 5px 0;
        }
        
        .checkbox-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 3px;
        }
        
        .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
            margin-right: 5px;
            text-align: center;
            line-height: 10px;
            font-size: 10px;
        }
        
        .checked {
            background-color: #e11313;
            color: white;
        }
        
        .serologic-table {
            border-collapse: collapse;
            width: 60%;  /* Dari 100% jadi 60% */
            margin: 10px 0;
        }

        .serologic-table td, .serologic-table th {
            border: 1px solid #000;
            padding: 3px;  /* Dari 5px jadi 3px */
            text-align: center;
            font-size: 10px;  /* Tambahkan font lebih kecil */
        }
        
        .serologic-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature {
            margin-top: 60px;
        }
        
        .medication-list {
            margin: 10px 0;
        }
        
        .medication-item {
            margin-bottom: 2px;
        }

        .medication-text {
            white-space: pre-line;
            display: inline-block;
            vertical-align: top;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="logo">
                <img src="{{ public_path('assets/img/logo-kota-langsa.png') }}" 
                    style="width: 100px; height: 100px;" 
                    alt="Logo Kota Langsa">
            </div>
            <div class="hospital-info">
                <div class="kota-name">PEMERINTAH KOTA LANGSA</div>
                <div class="hospital-name">RUMAH SAKIT UMUM DAERAH LANGSA</div>
                <div class="hospital-address">
                    Alamat : Jln. Jend. A. Yani No. 1 Kota Langsa – Provinsi Pemerintah Aceh<br>
                    Telp. (0641) 21009 - 21457 – 21662 Fax. (0641) 22051<br>
                    E-mail : rsudlangsa@gmail.com, rsudlangsa@yahoo.com Website : rsud.langsakota.go.id<br>
                    <strong>KOTA LANGSA</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="title">TRAVELLING DIALYSIS</div>

    <div class="content">
        <!-- Patient Information -->
        <div class="row">
            <div class="label">Patient's Name</div>
            <div class="value">: {{ strtoupper($dataMedis->pasien->nama ?? '-') }}</div>
        </div>
        
        <div class="row">
            <div class="label">Age</div>
            <div class="value">: {{ $dataMedis->pasien->umur ?? '-' }} years</div>
        </div>
        
        <div class="row">
            <div class="label">Sex</div>
            <div class="value">
                : {{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Male' : 'Female' }}
            </div>
        </div>
        
        <div class="row">
            <div class="label">Recent Address</div>
            <div class="value">: {{ $dataMedis->pasien->alamat ?? '-' }}</div>
        </div>
        
        <div class="row">
            <div class="label">Diagnosis</div>
            <div class="value">: {{ $dataTraveling->diagnosis ?? '-' }}</div>
        </div>
        
        <div class="row">
            <div class="label">Home Dialyzed or Center Dialyzed</div>
            <div class="value">: {{ $dataTraveling->dialysis_location ?? '-' }}</div>
        </div>
        
        <div class="row">
            <div class="label">Date of first dialysisi</div>
            <div class="value">: {{ $dataTraveling->date_first_dialysis ? \Carbon\Carbon::parse($dataTraveling->date_first_dialysis)->format('d F Y') : '-' }}</div>
        </div>

        <!-- Blood Pressure -->
        <div class="row">
            <div class="label">Recent Blood Pressure Status</div>
            <div class="value">:</div>
            <div class="row">
                <div class="label" style="width: 150px;">Pre –Dialysis</div>
                <div class="value">: {{ $dataTraveling->pre_dialysis_bp ?? '-' }} mmHg</div>
            </div>
            <div class="row">
                <div class="label" style="width: 150px;">Post –Dialisis</div>
                <div class="value">: {{ $dataTraveling->post_dialysis_bp ?? '-' }} mmHg</div>
            </div>
        </div>

        <!-- Vascular Access -->
        <div class="row mt-2">
            <div class="label">VaskulerAccesa</div>
            <div class="value">: 
                @php
                    $vascularAccess = $dataTraveling->vascular_access ? json_decode($dataTraveling->vascular_access) : [];
                @endphp
                <span class="checkbox {{ in_array('av_shunt', $vascularAccess) ? 'checked' : '' }}"></span> Av Shunt
                <span class="checkbox {{ in_array('cdl', $vascularAccess) ? 'checked' : '' }}"></span> CDL
                <span class="checkbox {{ in_array('femoral', $vascularAccess) ? 'checked' : '' }}"></span> Femoral
            </div>
        </div>

        <!-- Type Dialyzer -->
        <div class="row mt-2">
            <div class="label">Type Dialyzer</div>
            <div class="value">:
                @php
                    $typeDialyzer = $dataTraveling->type_dialyzer ? json_decode($dataTraveling->type_dialyzer) : [];
                @endphp
                <span class="checkbox {{ in_array('f7_hps', $typeDialyzer) ? 'checked' : '' }}"></span> F7 HPS
                <span class="checkbox {{ in_array('f8_hps', $typeDialyzer) ? 'checked' : '' }}"></span> F8 HPS
                <span class="checkbox {{ in_array('elisio', $typeDialyzer) ? 'checked' : '' }}"></span> Elisio
            </div>
        </div>

        <!-- Flow Rates -->
        <div class="row">
            <div class="label">Blood Flow Rate (QB)</div>
            <div class="value">: {{ $dataTraveling->blood_flow_rate ?? '-' }} ml/minute</div>
        </div>
        
        <div class="row">
            <div class="label">Type Dialysate</div>
            <div class="value">: {{ $dataTraveling->type_dialysate ?? '-' }}</div>
        </div>
        
        <div class="row">
            <div class="label">Dialysate Flow Rate</div>
            <div class="value">: {{ $dataTraveling->dialysate_flow_rate ?? '-' }} ml/minute</div>
        </div>

        <!-- Anticoagulant -->
        <div class="row">
            <div class="label">Anticoagulant</div>
            <div class="value">: {{ $dataTraveling->anticoagulant ?? '-' }}</div>
        </div>
        
        <div class="row">
            <div class="label">Loding dose</div>
            <div class="value">: {{ $dataTraveling->loading_dose ?? '-' }} ui</div>
        </div>
        
        <div class="row">
            <div class="label">Maintenance</div>
            <div class="value">: {{ $dataTraveling->maintenance ?? '-' }} ui</div>
        </div>

        <!-- Patient Info -->
        <div class="row">
            <div class="label">Patien's Dry Weight</div>
            <div class="value">: {{ $dataTraveling->patient_dry_weight ?? '-' }} kg</div>
        </div>
        
        <div class="row">
            <div class="label">Uf Goal</div>
            <div class="value">: {{ $dataTraveling->uf_goal ?? '-' }} ml</div>
        </div>
        
        <div class="row">
            <div class="label">Uf Rate</div>
            <div class="value">: {{ $dataTraveling->uf_rate ?? '-' }}</div>
        </div>
        
        <div class="row">
            <div class="label">Number of Run Per Week</div>
            <div class="value">: {{ $dataTraveling->number_run_per_week ?? '-' }} week</div>
        </div>
        
        <div class="row">
            <div class="label">Length of Dialysis</div>
            <div class="value">: {{ $dataTraveling->length_dialysis ?? '-' }} hours</div>
        </div>

        <!-- Complications -->
        <div class="row">
            <div class="label">Complication During Dialysis</div>
            <div class="value">: {{ $dataTraveling->complication_dialysis ?? '-' }}</div>
        </div>

        <!-- Allergic -->
        <div class="row">
            <div class="label">Allergic</div>
            <div class="value">:
                @if($alergiPasien->count() > 0)
                    @foreach($alergiPasien as $alergi)
                        {{ $alergi->nama_alergi }} ({{ $alergi->jenis_alergi }}){{ !$loop->last ? ', ' : '' }}
                    @endforeach
                @else
                    -
                @endif
            </div>
        </div>

        <!-- Serologic Test -->
        <div class="row mt-4">
            <div class="label">Serelogic Test</div>
            <div class="value">
                <table class="serologic-table" style="margin-left: 0; width: 60%; display: inline-table;">
                    <tr>
                        <td>Hbsag</td>
                        <td>{{ $dataTraveling->hbsag_result ?? '-' }}</td>
                        <td>{{ $dataTraveling->hbsag_date ? \Carbon\Carbon::parse($dataTraveling->hbsag_date)->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Anti HCV</td>
                        <td>{{ $dataTraveling->anti_hcv_result ?? '-' }}</td>
                        <td>{{ $dataTraveling->anti_hcv_date ? \Carbon\Carbon::parse($dataTraveling->anti_hcv_date)->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Anti HIV</td>
                        <td>{{ $dataTraveling->anti_hiv_result ?? '-' }}</td>
                        <td>{{ $dataTraveling->anti_hiv_date ? \Carbon\Carbon::parse($dataTraveling->anti_hiv_date)->format('d F Y') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Current Medication -->
        <div class="row">
            <div class="label">Current medication</div>
            <div class="value">: {{ $dataTraveling->current_medication ?? '-' }}</div>
        </div>

        <!-- Relevant Clinical History -->
        <div class="row">
            <div class="label">Relevant Clinical History</div>
            <div class="value">: 
                @if($dataTraveling->relevant_clinical_history)
                    @php
                        $medications = json_decode($dataTraveling->relevant_clinical_history, true);
                    @endphp
                    @if($medications && count($medications) > 0)
                        @foreach($medications as $medication)
                            @if($loop->first)
                                {{ $medication['name'] ?? '-' }}
                                @if(isset($medication['frequency']) && $medication['frequency'])
                                    {{ $medication['frequency'] }}
                                @endif
                            @else
                                <br>&nbsp;&nbsp;{{ $medication['name'] ?? '-' }}
                                @if(isset($medication['frequency']) && $medication['frequency'])
                                    {{ $medication['frequency'] }}
                                @endif
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                @else
                    -
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>Langsa, {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
        <div>Sincerely your's,</div>
        
        <div class="signature">
            <div><strong>( {{ $dataTraveling->userCreated->name ?? 'dr. Misriani, Sp.PD, Finasim' }} )</strong></div>
            <div>Nip : {{ $dataTraveling->userCreated->nip ?? '197909042005042001' }}</div>
        </div>
    </div>
</body>
</html>