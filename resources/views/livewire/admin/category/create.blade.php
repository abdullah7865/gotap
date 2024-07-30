<div>
    <div>
        <div class="d-flex justify-content-between">
            <h2 class="card-header">
                <a href="{{ url('admin/categories') }}"> Categories </a> / {{ $heading }}
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <form wire:submit.prevent="store">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Title (English) <span class="text-danger"> * </span>
                                        @error('name')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="John doe">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Title (Swedish) <span class="text-danger"> * </span>
                                        @error('name_sv')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" wire:model="name_sv" class="form-control"
                                        placeholder="John doe">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Status <span class="text-danger"> * </span>
                                        @error('status')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <select class="form-select" wire:model="status">
                                        <option value="" selected="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn" style="background: #0EA7C1; color:white">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                icon: event.detail.type,
            });
        });

        // window.addEventListener('show-create-modal', event => {
        //     $('#createMerchantModal').modal('show')
        // });

        // window.addEventListener('show-edit-modal', event => {
        //     $('#editMerchantModal').modal('show')
        // });

        // window.addEventListener('edit-password-modal', event => {
        //     $('#editPasswordModal').modal('show')
        // });

        // window.addEventListener('edit-balance-modal', event => {
        //     $('#editBalanceModal').modal('show')
        // });

        // window.addEventListener('close-modal', event => {
        //     $('#createMerchantModal').modal('hide');
        //     $('#editMerchantModal').modal('hide')
        //     $('#confirmModal').modal('hide');
        //     $('#editPasswordModal').modal('hide')
        //     $('#editBalanceModal').modal('hide')
        // });

        // window.addEventListener('open-confirm-modal', event => {
        //     $('#confirmModal').modal('show');
        // });
    </script>
@endsection
