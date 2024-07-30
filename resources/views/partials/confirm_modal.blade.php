<div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
    aria-hidden="true">
    <form wire:submit.prevent="{{ $methodType }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="disableLabel">{{ $modalTitle }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 20px">{{ $modalBody }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="submit" class="btn {{ $modalActionBtnColor }}" style="color:white">
                        {{ $modalActionBtnText }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
