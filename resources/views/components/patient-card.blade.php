<div class="position-relative patient-card">
    <div class="status-indicators">
        <div class="status-indicator red"></div>
        <div class="status-indicator orange"></div>
        <div class="status-indicator green"></div>
    </div>

    <div class="patient-photo">
        <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
    </div>

    <div class="patient-info">
        <h6>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</h6>
        <p class="mb-0">
            {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
        </p>
        <small>{{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})</small>

        <div class="patient-meta mt-2">
            <p class="mb-0"><i class="bi bi-file-earmark-medical"></i>RM: {{ $dataMedis->pasien->kd_pasien }}</p>
            <p class="mb-0"><i class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') }}</p>
            <p><i class="bi bi-hospital"></i>{{ $dataMedis->unit->bagian->bagian }} ({{ $dataMedis->unit->nama_unit }})</p>
        </div>
    </div>
</div>

<div class="mt-2 patient-card">
    <div class="card-header">
        <h4>Task:</h4>
    </div>
    <div class="card-body">
        <ul class="timeline-xs">
            <li class="timeline-item success">
                <div class="margin-left-15">
                    <p>Asesmen Awal Medis</p>
                </div>
            </li>
            <li class="timeline-item success">
                <div class="margin-left-15">
                    <p>Asesmen Awal Keperawatan</p>
                </div>
            </li>
            <li class="timeline-item success">
                <div class="margin-left-15">
                    <p>Order Laboratorium</p>
                </div>
            </li>
            <li class="timeline-item info">
                <div class="margin-left-15">
                    <p>Resume Medis -(belum final)</p>
                </div>
            </li>
            <li class="timeline-item info">
                <div class="margin-left-15">
                    <p>Perintah Rawat Inap</p>
                </div>
            </li>
            <li class="timeline-item info">
                <div class="margin-left-15">
                    <p>Selesai</p>
                </div>
            </li>
        </ul>
    </div>
</div>
