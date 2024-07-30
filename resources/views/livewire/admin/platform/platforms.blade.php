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
                <a class="btn" style="background: #0EA7C1; color:white" href="{{ url('admin/platform/create') }}"> Create
                </a>
            </h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
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
                    </select>
                </div>
                <div class="col-md-3">
                    <label for=""> Select Category </label>
                    <select wire:model="filterByCategory" class="form-control form-select me-2">
                        <option value="" selected> Select Category </option>
                        @foreach ($categories as $val => $category)
                            <option value="{{ $val }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for=""> Search by Title </label>
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
                                <th> Icon </th>
                                <th> Title </th>
                                <th> Category </th>
                                <th> Type </th>
                                <th> Base Url </th>
                                <th> Status </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($platforms['platforms'] as $platform)
                                <tr>
                                    <td>
                                        <div class="img-holder">
                                            <img src="{{ asset(isImageExist($platform->icon, 'platform')) }}">
                                        </div>
                                    </td>
                                    <td> {{ $platform->title }}</td>
                                    <td>
                                        {{ $platform->category }}
                                    </td>
                                    <th>
                                        @if ($platform->pro == 1)
                                            Pro
                                        @else
                                            Free
                                        @endif
                                    </th>
                                    <td>
                                        {{ $platform->baseURL ? $platform->baseURL : '--' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ model_status($platform)['background'] }} me-1">
                                            {{ model_status($platform)['status'] }}
                                        </span>
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
                                                    href="{{ url('admin/platform/' . $platform->id . '/edit') }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                                <!--<a class="btn btn-icon btn-outline-secondary" data-bs-toggle="tooltip"-->
                                                <!--    data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"-->
                                                <!--    title=""-->
                                                <!--    data-bs-original-title="<i class='bx bx-trash bx-xs' ></i> <span>Delete</span>"-->
                                                <!--    href="javascript:void(0)"-->
                                                <!--    wire:click="confirmModal('{{ $platform->id }}')">-->
                                                <!--    <i class="bx bx-trash"></i>-->
                                                <!--</a>-->
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
                        @if ($platforms['platforms']->count() > 0)
                            {{ $platforms['platforms']->links() }}
                        @else
                            <p class="text-center"> No Record Found </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    @include('partials.confirm_modal')

</div>

@section('script')
    <script>
        window.addEventListener('swal:modal', event => {
            $('#confirmModal').modal('hide');
            swal({
                title: event.detail.message,
                icon: event.detail.type,
            });
        });

        window.addEventListener('confirmModal', event => {
            $('#confirmModal').modal('show');
        });
    </script>
@endsection
