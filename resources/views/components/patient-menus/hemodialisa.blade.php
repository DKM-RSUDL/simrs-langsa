@props(['pelayananUrl'])

<div class="accordion accordion-flush" id="patientMenuAccordionHD">
    {{-- Menu Direct - Hemodialisa hanya punya 1 menu --}}
    <div class="accordion-item">
        <div class="list-group list-group-flush">
            <a href="{{ $pelayananUrl }}/persetujuan-transfusi-darah" class="list-group-item list-group-item-action">
                <i class="bi bi-droplet-fill me-2"></i> Persetujuan Transfusi Darah
            </a>
        </div>
    </div>
</div>
