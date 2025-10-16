@props(['pelayananUrl'])

<div class="accordion accordion-flush" id="patientMenuAccordionOperasi">
    {{-- Menu Direct (tanpa submenu) --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/update-informasi-pasien" class="list-group-item list-group-item-action">
                <i class="bi bi-person-fill-gear me-2"></i> Update Informasi Pasien
            </a>
            <a href="{{ $pelayananUrl }}/identitas-pasien" class="list-group-item list-group-item-action">
                <i class="bi bi-card-text me-2"></i> Identitas Pasien
            </a>
            <a href="{{ $pelayananUrl }}/informed-consent" class="list-group-item list-group-item-action">
                <i class="bi bi-file-earmark-check me-2"></i> Informed Consent
            </a>
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
                data-bs-target="#mutasiMenuOperasi">
                <i class="bi bi-arrow-left-right me-2"></i> Mutasi Pasien
            </button>
        </h2>
        <div id="mutasiMenuOperasi" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionOperasi">
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
                    <a href="{{ $pelayananUrl }}/rujuk-keluar-rs" class="list-group-item list-group-item-action">
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

    {{-- Order Pelayanan --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#orderMenuOperasi">
                <i class="bi bi-clipboard-plus me-2"></i> Order Pelayanan
            </button>
        </h2>
        <div id="orderMenuOperasi" class="accordion-collapse collapse" data-bs-parent="#patientMenuAccordionOperasi">
            <div class="accordion-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ $pelayananUrl }}/operasi" class="list-group-item list-group-item-action">
                        Operasi
                    </a>
                    <a href="{{ $pelayananUrl }}/rehabilitasi-medis" class="list-group-item list-group-item-action">
                        Rehabilitasi Medis
                    </a>
                    <a href="{{ $pelayananUrl }}/hemodialisa" class="list-group-item list-group-item-action">
                        Hemodialisa
                    </a>
                    <a href="{{ $pelayananUrl }}/forensik" class="list-group-item list-group-item-action">
                        Forensik
                    </a>
                    <a href="{{ $pelayananUrl }}/cath-lab" class="list-group-item list-group-item-action">
                        Cath Lab
                    </a>
                    <a href="{{ $pelayananUrl }}/rujukan-ambulance" class="list-group-item list-group-item-action">
                        Rujukan/Ambulance
                    </a>
                    <a href="{{ $pelayananUrl }}/tindakan-klinik" class="list-group-item list-group-item-action">
                        Tindakan Klinik
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Direct Lanjutan --}}
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
            <a href="{{ $pelayananUrl }}/asuhan-keperawatan" class="list-group-item list-group-item-action">
                <i class="bi bi-heart-pulse me-2"></i> Asuhan Keperawatan
            </a>
        </div>
    </div>
</div>
