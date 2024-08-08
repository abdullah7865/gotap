<div>
    <div>
        <div class="d-flex justify-content-between">
            <h2 class="card-header">
                <a href="{{ url('admin/users') }}"> Users </a> / {{ $heading }}
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($photo && !is_string($photo))
                                            <img src="{{ $photo->temporaryUrl() }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170">
                                        @else
                                            {{-- <img src="{{ asset(isImageExist($preview_photo, 'profile')) }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170"> --}}

                                                <img src="{{ asset(Storage::url($preview_photo)) }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170">
                                        @endif

                                        <div wire:loading wire:target="photo" wire:key="photo">
                                            <i class="fa fa-spinner fa-spin mt-2 ml-2"></i>
                                        </div>

                                        <div class="photo-upload btn" style="background: #0EA7C1; color:white">
                                            <span>Upload Profile Photo</span>
                                            <input type="file" class="photo-input" wire:model="photo"
                                                accept="image/png, image/jpeg, image/jpg, image/webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($cover_photo && !is_string($cover_photo))
                                            <img src="{{ $cover_photo->temporaryUrl() }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170">
                                        @else
                                            <img src="{{ asset(isImageExist($preview_cover_photo)) }}" alt="user-avatar"
                                                class="d-block rounded" height="200" width="170">
                                            {{-- @if ($preview_cover_photo)
                                                <img src="{{ asset(isImageExist($preview_cover_photo)) }}"
                                                    alt="user-avatar" class="d-block rounded" height="200"
                                                    width="170">
                                            @else
                                                <img src="{{ asset('frame_2.webp') }}" alt="user-avatar"
                                                    class="d-block rounded" height="200" width="170">
                                            @endif --}}
                                        @endif

                                        <div wire:loading wire:target="cover_photo" wire:key="cover_photo">
                                            <i class="fa fa-spinner fa-spin mt-2 ml-2"></i>
                                        </div>

                                        <div class="photo_cover-upload btn" style="background: #0EA7C1; color:white">
                                            <span>Upload Cover Photo</span>
                                            <input type="file" class="photo_cover-input" wire:model="cover_photo"
                                                accept="image/png, image/jpeg, image/jpg, image/webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Name
                                        @error('name')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="John doe">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Email
                                    </label>
                                    <input type="email" wire:model="email" class="form-control"
                                        placeholder="Johndoe@gmail.com">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Username <span style="color:red"> * </span>
                                        @error('username')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" wire:model="username" class="form-control"
                                        placeholder="john-doe">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Phone
                                    </label>
                                    <input type="text" wire:model="phone" class="form-control"
                                        placeholder="658 799 8941">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Job title
                                    </label>
                                    <input type="text" wire:model="job_title" class="form-control" placeholder="CEO">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Company
                                    </label>
                                    <input type="text" wire:model="company" class="form-control"
                                        placeholder="Facebook">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Bio
                                    </label>
                                    <textarea class="form-control" wire:model="bio" placeholder="bio here..."></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Verified <span class="text-danger"> * </span>
                                        @error('verified')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <select class="form-select" wire:model="verified">
                                        <option value="-1" selected="">Select</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Show In All Users <span class="text-danger"> * </span>
                                        @error('featured')
                                            <span class="text-danger error-message">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <select class="form-select" wire:model="featured">
                                        <option value="" selected="">Select</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn" style="background: #0EA7C1; color:white">Update</button>
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
    </script>
@endsection
