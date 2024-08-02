<div>
    <div>
        <div class="d-flex justify-content-between">
            <h2 class="card-header">
                <a href="{{ url('admin/platforms') }}"> Platforms </a> / {{ $heading }}
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <form wire:submit.prevent="store">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($icon && !is_string($icon))
                                            <img src="{{ $icon->temporaryUrl() }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170">
                                        @else
                                            <img src="{{ asset(isImageExist('frame_2.webp', 'platform')) }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170">
                                        @endif
                                        <div wire:loading wire:target="icon" wire:key="icon">
                                            <i class="fa fa-spinner fa-spin mt-2 ml-2"></i>
                                        </div>

                                        <div class="icon-upload btn" style="background: #0EA7C1; color:white">
                                            <span>Upload Icon</span>
                                            <input type="file" class="icon-input" wire:model="icon"
                                                accept="image/png, image/jpeg, image/jpg, image/webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Title <span class="text-danger"> * </span>
                                        @error('title')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" wire:model="title" class="form-control"
                                        placeholder="Enter title">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Category <span class="text-danger"> * </span>
                                        @error('category_id')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <select class="form-select" wire:model="category_id">
                                        <option value="" selected="">Select</option>
                                        @foreach ($categories as $val => $category)
                                            <option value="{{ $val }}"> {{ $category }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Type <span class="text-danger"> * </span>
                                        @error('pro')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <select class="form-select" wire:model="pro">
                                        <option value="" selected="">Select</option>
                                        <option value="1">Pro</option>
                                        <option value="0">Free</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
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
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Placeholder (English)
                                    </label>
                                    <input type="text" wire:model="placeholder_en" class="form-control"
                                        placeholder="Enter placeholder in english for this platform">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Placeholder (Espanol)
                                    </label>
                                    <input type="text" wire:model="placeholder_sv" class="form-control"
                                        placeholder="Enter placeholder in Espanol for this platform">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Description (English)
                                    </label>
                                    <input type="text" wire:model="description_en" class="form-control"
                                        placeholder="Enter description in english for this platform">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Description (Espanol)
                                    </label>
                                    <input type="text" wire:model="description_sv" class="form-control"
                                        placeholder="Enter description in Espanol for this platform">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Base URL
                                    </label>
                                    <input type="text" wire:model="baseURL" class="form-control"
                                        placeholder="Enter Base URL i.e https://facebook.com/">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Input Type <span class="text-danger"> * </span>
                                        @error('input')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <select class="form-select" wire:model="input">
                                        <option value="" selected="">Select</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                        <option value="username">Username</option>
                                        <option value="url">Url</option>
                                        <option value="other">Other</option>
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
