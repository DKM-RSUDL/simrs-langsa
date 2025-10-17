@props(['pelayananUrl'])

<div class="accordion accordion-flush" id="patientMenuAccordionRawatJalan">
    {{-- Menu Direct (tanpa submenu) --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/update-informasi-pasien" class="list-group-item list-group-item-action">
                <i class="bi bi-person-fill-gear me-2"></i> Update Informasi Pasien
            </a>
            <a href="{{ $pelayananUrl }}/identitas-pasien" class="list-group-item list-group-item-action">
                <i class="bi bi-card-text me-2"></i> Identitas Pasien
            </a>
            <a href="{{ $pelayananUrl }}/general-consent" class="list-group-item list-group-item-action">
                <i class="bi bi-file-earmark-check me-2"></i> General Consent
            </a>
        </div>
    </div>

    {{-- Persetujuan --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#persetujuanMenuRJ">
                <i class="bi bi-file-earmark-check me-2"></i> Persetujuan
            </button>
        </h2>
        <div id="persetujuanMenuRJ" class="accordion-collapse collapse"
            data-bs-parent="#patientMenuAccordionRawatJalan">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/anestesi-sedasi" class="list-group-item list-group-item-action">
                        Anestesi dan Sedasi
                    </a>
                    <a href="{{ $pelayananUrl }}/persetujuan-transfusi-darah"
                        class="list-group-item list-group-item-action">
                        Persetujuan Transfusi Darah
                    </a>
                    <a href="{{ $pelayananUrl }}/covid-19" class="list-group-item list-group-item-action">
                        Covid 19
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Direct Lanjutan --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/edukasi-informasi" class="list-group-item list-group-item-action">
                <i class="bi bi-book me-2"></i> Edukasi dan Informasi
            </a>
            <a href="{{ $pelayananUrl }}/jaminan-asuransi" class="list-group-item list-group-item-action">
                <i class="bi bi-shield-check me-2"></i> Jaminan/Asuransi
            </a>
            <a href="{{ $pelayananUrl }}/registrasi-rawat-inap" class="list-group-item list-group-item-action">
                <i class="bi bi-clipboard-check me-2"></i> Registrasi Rawat Inap
            </a>
        </div>
    </div>

    {{-- Mutasi Pasien --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#mutasiMenuRJ">
                <i class="bi bi-arrow-left-right me-2"></i> Mutasi Pasien
            </button>
        </h2>
        <div id="mutasiMenuRJ" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionRawatJalan">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/pindah-ruangan" class="list-group-item list-group-item-action">
                        Pindah Ruangan / Rawat Inap
                    </a>
                    <a href="{{ $pelayananUrl }}/pulang-berobat-jalan" class="list-group-item list-group-item-action">
                        Pulangkan (Berobat Jalan)
                    </a>
                    <a href="{{ $pelayananUrl }}/pulang-aps" class="list-group-item list-group-item-action">
                        Pulangkan (APS)
                    </a>
                    <a href="{{ $pelayananUrl }}/rujuk-antar-rs" class="list-group-item list-group-item-action">
                        Rujuk Keluar RS
                    </a>
                    <a href="{{ $pelayananUrl }}/meninggal-dunia" class="list-group-item list-group-item-action">
                        Meninggal Dunia
                    </a>
                    <a href="{{ $pelayananUrl }}/batal-berobat" class="list-group-item list-group-item-action">
                        Batal Berobat
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Transfusi Darah --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#transfusiMenuRJ">
                <i class="bi bi-droplet me-2"></i> Transfusi Darah
            </button>
        </h2>
        <div id="transfusiMenuRJ" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionRawatJalan">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/permintaan-darah" class="list-group-item list-group-item-action">
                        Order
                    </a>
                    <a href="{{ $pelayananUrl }}/pengawasan-darah" class="list-group-item list-group-item-action">
                        Pengawasan
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Surat-Surat --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#suratMenuRJ">
                <i class="bi bi-envelope me-2"></i> Surat-Surat
            </button>
        </h2>
        <div id="suratMenuRJ" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionRawatJalan">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/penundaan" class="list-group-item list-group-item-action">
                        Penundaan Pelayanan
                    </a>
                    <a href="{{ $pelayananUrl }}/permintaan-second-opinion"
                        class="list-group-item list-group-item-action">
                        Permintaan Second Opinion
                    </a>
                    <a href="{{ $pelayananUrl }}/pernyataan-dpjp" class="list-group-item list-group-item-action">
                        Pernyataan DPJP
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Direct Terakhir --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/billing-system" class="list-group-item list-group-item-action">
                <i class="bi bi-receipt me-2"></i> Billing System
            </a>
            <a href="{{ $pelayananUrl }}/finalisasi" class="list-group-item list-group-item-action">
                <i class="bi bi-check-circle me-2"></i> Finalisasi
            </a>
            <a href="{{ $pelayananUrl }}/status-pasien" class="list-group-item list-group-item-action">
                <i class="bi bi-info-circle me-2"></i> Status Pasien
            </a>
            <a href="{{ $pelayananUrl }}/permintaan-darah" class="list-group-item list-group-item-action">
                <i class="bi bi-droplet me-2"></i> Permintaan Darah
            </a>
        </div>
    </div>
</div>
