<div class="d-flex flex-column gap-4">

    {{-- === Alkohol === --}}
    <div class="col-md-12 {{ !empty($viewMode) ? 'p-3 rounded' : '' }}">
        <label class="form-label fw-bold">Alkohol:</label>
        <div class="d-flex align-items-center justify-content-between gap-3">
            @foreach (['tidak' => 'Tidak', 'ya' => 'Ya', 'berhenti' => 'Berhenti'] as $val => $label)
                <div class="form-check">
                    <input class="form-check-input" type="radio" 
                        name="alkohol" id="alkohol_{{ $val }}" value="{{ $val }}"
                        {{ ($KebiasaanData['alkohol']['status'] ?? '') == $val ? 'checked' : '' }}
                        @if(!empty($viewMode)) disabled @endif>
                    <label class="form-check-label" for="alkohol_{{ $val }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>

        <div class="alkohol-detail mt-2"
            style="{{ ($KebiasaanData['alkohol']['status'] ?? '') == 'ya' ? 'display:block;' : 'display:none;' }}">
            <div class="d-flex gap-2 align-items-end mb-2">
                <div class="col">
                    <label class="form-label">Jenis:</label>
                    <input type="text" 
                        class="form-control form-control-sm {{ !empty($viewMode) ? 'bg-secondary-subtle border-0' : '' }}" 
                        name="alkohol_jenis"
                        placeholder="Jenis alkohol/obat" 
                        value="{{ $KebiasaanData['alkohol']['jenis'] ?? '' }}"
                        @if(!empty($viewMode)) readonly disabled @endif>
                </div>
            </div>
        </div>
    </div>

    {{-- === Merokok === --}}
    <div class="col-md-12 {{ !empty($viewMode) ? 'p-3 rounded' : '' }}">
        <label class="form-label fw-bold">Merokok:</label>
        <div class="d-flex align-items-center justify-content-between gap-3">
            @foreach (['tidak' => 'Tidak', 'ya' => 'Ya', 'berhenti' => 'Berhenti'] as $val => $label)
                <div class="form-check">
                    <input class="form-check-input" type="radio"
                        name="merokok" id="merokok_{{ $val }}" value="{{ $val }}"
                        {{ ($KebiasaanData['merokok']['status'] ?? '') == $val ? 'checked' : '' }}
                        @if(!empty($viewMode)) disabled @endif>
                    <label class="form-check-label" for="merokok_{{ $val }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>

        <div class="merokok-detail mt-2" 
            style="{{ ($KebiasaanData['merokok']['status'] ?? '') == 'ya' ? 'display:block;' : 'display:none;' }}">
            
            @if(empty($viewMode))
            <div class="mt-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary add-merokok">
                    <i class="fa fa-plus me-1"></i> Tambah
                </button>
            </div>
            @endif

            @forelse ($KebiasaanData['merokok']['detail'] ?? [] as $detail)
                <div class="d-flex gap-2 align-items-end mb-2 consumption-row">
                    <div class="col">
                        <label class="form-label">Jenis:</label>
                        <input type="text" class="form-control form-control-sm {{ !empty($viewMode) ? 'bg-secondary-subtle border-0' : '' }}" 
                            name="merokok_jenis[]"
                            value="{{ $detail['jenis'] ?? '' }}" placeholder="Jenis rokok"
                            @if(!empty($viewMode)) readonly disabled @endif>
                    </div>
                    <div class="col">
                        <label class="form-label">Jumlah/hari:</label>
                        <input type="text" class="form-control form-control-sm {{ !empty($viewMode) ? 'bg-secondary-subtle border-0' : '' }}" 
                            name="merokok_jumlah[]"
                            value="{{ $detail['jml'] ?? '' }}" placeholder="Batang per hari"
                            @if(!empty($viewMode)) readonly disabled @endif>
                    </div>
                    <div class="col">
                        <label class="form-label">Lama (tahun):</label>
                        <input type="text" class="form-control form-control-sm {{ !empty($viewMode) ? 'bg-secondary-subtle border-0' : '' }}" 
                            name="merokok_lama[]"
                            value="{{ $detail['lama'] ?? '' }}" placeholder="Lama merokok"
                            @if(!empty($viewMode)) readonly disabled @endif>
                    </div>

                    @if(empty($viewMode))
                    <div>
                        <button type="button" class="btn btn-danger btn-sm remove-consumption">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    @endif
                </div>
            @empty
                @if(empty($viewMode))
                <div class="d-flex gap-2 align-items-end mb-2 consumption-row">
                    <div class="col">
                        <label class="form-label">Jenis:</label>
                        <input type="text" class="form-control form-control-sm" name="merokok_jenis[]" placeholder="Jenis rokok">
                    </div>
                    <div class="col">
                        <label class="form-label">Jumlah/hari:</label>
                        <input type="text" class="form-control form-control-sm" name="merokok_jumlah[]" placeholder="Batang per hari">
                    </div>
                    <div class="col">
                        <label class="form-label">Lama (tahun):</label>
                        <input type="text" class="form-control form-control-sm" name="merokok_lama[]" placeholder="Lama merokok">
                    </div>
                </div>
                @endif
            @endforelse
        </div>
    </div>

    {{-- === Obat === --}}
    <div class="col-md-12 {{ !empty($viewMode) ? 'p-3 rounded' : '' }}">
        <label class="form-label fw-bold">Obat-obatan:</label>
        <div class="d-flex align-items-center justify-content-between gap-3">
            @foreach (['tidak' => 'Tidak', 'ya' => 'Ya', 'berhenti' => 'Berhenti'] as $val => $label)
                <div class="form-check">
                    <input class="form-check-input" type="radio" 
                        name="obat" id="obat_{{ $val }}" value="{{ $val }}"
                        {{ ($KebiasaanData['obat']['status'] ?? '') == $val ? 'checked' : '' }}
                        @if(!empty($viewMode)) disabled @endif>
                    <label class="form-check-label" for="obat_{{ $val }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>

        <div class="obat-detail mt-2"
            style="{{ ($KebiasaanData['obat']['status'] ?? '') == 'ya' ? 'display:block;' : 'display:none;' }}">
            @if(empty($viewMode))
            <div class="mt-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary add-obat">
                    <i class="fa fa-plus me-1"></i> Tambah
                </button>
            </div>
            @endif

            @forelse($KebiasaanData['obat']['detail'] ?? [] as $item)
                <div class="d-flex gap-2 align-items-end mb-2 consumption-row">
                    <div class="col">
                        <label class="form-label">Jenis obat:</label>
                        <input type="text" class="form-control form-control-sm {{ !empty($viewMode) ? 'bg-secondary-subtle border-0' : '' }}"
                            name="obat_jenis[]" value="{{ $item }}" placeholder="Jenis obat"
                            @if(!empty($viewMode)) readonly disabled @endif>
                    </div>

                    @if(empty($viewMode))
                    <div>
                        <button type="button" class="btn btn-danger btn-sm remove-consumption">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    @endif
                </div>
            @empty
                @if(empty($viewMode))
                <div class="d-flex gap-2 align-items-end mb-2 consumption-row">
                    <div class="col">
                        <label class="form-label">Jenis obat:</label>
                        <input type="text" class="form-control form-control-sm" name="obat_jenis[]" placeholder="Jenis obat">
                    </div>
                </div>
                @endif
            @endforelse
        </div>
    </div>
</div>

@if(empty($viewMode))
<script>
document.addEventListener('DOMContentLoaded', function() {
    ['alkohol', 'merokok', 'obat'].forEach(field => {
        document.querySelectorAll(`input[name="${field}"]`).forEach(radio => {
            radio.addEventListener('change', function() {
                const detail = document.querySelector(`.${field}-detail`);
                if (detail) detail.style.display = this.value === 'ya' ? 'block' : 'none';
            });
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-merokok')) {
            let container = document.querySelector('.merokok-detail');
            let template = container.querySelector('.consumption-row');
            if (template) {
                let newRow = template.cloneNode(true);
                newRow.querySelectorAll('input').forEach(i => i.value = '');
                container.appendChild(newRow);
            }
        }
        if (e.target.closest('.add-obat')) {
            let container = document.querySelector('.obat-detail');
            let template = container.querySelector('.consumption-row');
            if (template) {
                let newRow = template.cloneNode(true);
                newRow.querySelectorAll('input').forEach(i => i.value = '');
                container.appendChild(newRow);
            }
        }
        if (e.target.closest('.remove-consumption')) {
            e.target.closest('.consumption-row').remove();
        }
    });
});
</script>
@endif
