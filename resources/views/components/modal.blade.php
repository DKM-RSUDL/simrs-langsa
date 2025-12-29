<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $size ? 'modal-' . $size : '' }}">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- ================= BODY ================= --}}
            @if($confirm)
                <form id="{{ $idForm }}" {{ $attributes }} method="POST">
                    <div class="modal-body">
                        {{ $slot }}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <x-button-submit-confirm label="Simpan" />
                    </div>
                </form>
            @else
                <div class="modal-body">
                    {{ $slot }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="button" id="save-modal" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>