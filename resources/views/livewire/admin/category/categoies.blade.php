<div>
    <div>
        <div class="d-flex justify-content-between">
            <h2 class="card-header">
                {{ $heading }}
                <span>
                    <h5 style="margin-top:10px"> Total: {{ $total }} </h4>
                </span>
            </h2>
            <h5 class="card-header">
                <a class="btn" style="background: #0EA7C1; color:white" href="{{ url('admin/category/create') }}"> Create
                </a>
            </h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3 offset-3">
                    <label for=""> Select status </label>
                    <select wire:model="filterByStatus" class="form-control form-select me-2">
                        <option value="" selected> Select Status </option>
                        @foreach ($statuses as $val => $status)
                            <option value="{{ $val }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for=""> Sort by </label>
                    <select wire:model="sortBy" class="form-control form-select me-2">
                        <option value="" selected> Select Sort </option>
                        <option value="created_asc"> Created Date (Low to High)</option>
                        <option value="created_desc"> Created Date (High to Low)</option>
                        <option value="platforms_asc"> Platforms (Low to High)</option>
                        <option value="platforms_desc"> Platforms (High to Low)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for=""> Search by Name </label>
                    <input class="form-control me-2" type="search" wire:model.debounce.500ms="searchQuery"
                        placeholder="Search" aria-label="Search">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive text-nowrap">
                    <table class="table admin-table">
                        <thead class="table-light">
                            <tr>
                                <th> Title(en) </th>
                                <th> Title(sv) </th>
                                <th> Platforms </th>
                                <th> Status </th>
                                <th> Created at </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($categories['categories'] as $category)
                                <tr>
                                    <td> {{ $category->name }}</td>
                                    <td>
                                        {{ $category->name_sv }}
                                    </td>
                                    <td>
                                        {{ $category->total_platforms }}
                                    </td>
                                    <td>
                                        <span class="badge {{ model_status($category)['background'] }} me-1">
                                            {{ model_status($category)['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ defaultDateFormat($category->created_at) }}
                                    </td>
                                    <td class="action-td">
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt3"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                <a class="btn btn-icon btn-outline-secondary" data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                    title=""
                                                    data-bs-original-title="<i class='bx bx-edit-alt bx-xs' ></i> <span>Edit</span>"
                                                    href="{{ url('admin/category/' . $category->id . '/edit') }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="demo-inline-spacing">
                        @if ($categories['categories']->count() > 0)
                            {{ $categories['categories']->links() }}
                        @else
                            <p class="text-center"> No Record Found </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    {{-- @include('livewire.admin.merchant.create_modal')
    @include('livewire.admin.merchant.edit_modal')
    @include('livewire.admin.merchant.edit_password')
    @include('livewire.admin.merchant.edit_balance')
    @include('admin.partials.confirm_modal') --}}

</div>

@section('script')
    {{-- <script>
        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                icon: event.detail.type,
            });
        });

        window.addEventListener('show-create-modal', event => {
            $('#createMerchantModal').modal('show')
        });

        window.addEventListener('show-edit-modal', event => {
            $('#editMerchantModal').modal('show')
        });

        window.addEventListener('edit-password-modal', event => {
            $('#editPasswordModal').modal('show')
        });

        window.addEventListener('edit-balance-modal', event => {
            $('#editBalanceModal').modal('show')
        });

        window.addEventListener('close-modal', event => {
            $('#createMerchantModal').modal('hide');
            $('#editMerchantModal').modal('hide')
            $('#confirmModal').modal('hide');
            $('#editPasswordModal').modal('hide')
            $('#editBalanceModal').modal('hide')
        });

        window.addEventListener('open-confirm-modal', event => {
            $('#confirmModal').modal('show');
        });
    </script> --}}
@endsection
