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
                <a class="btn" style="background: #0EA7C1; color:white" href="{{ url('admin/card/create') }}"> Create
                </a>
                <button class="btn btn-info text-center" {{ $total == 0 ? 'disabled' : '' }} wire:click="exportCsv">
                    <i class="mdi mdi-download me-2 "></i>
                    Download CSV
                </button>
            </h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3 offset-6">
                    <label for=""> Select status </label>
                    <select wire:model="filterByStatus" class="form-control form-select me-2">
                        <option value="" selected> Select Status </option>
                        @foreach ($statuses as $val => $status)
                            <option value="{{ $val }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for=""> Search by Uuid or Description </label>
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
                                <th>Uuid</th>
                                <th>Assigned To</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($cards['cards'] as $card)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input id="card-{{ $card->id }}" type="hidden"
                                                    value="{{ $card->uuid }}">
                                                {{ $card->uuid }}
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:void(0)" onclick="copy('{{ $card->id }}')">
                                                    <i class="bx bx-clipboard" data-toggle="tooltip"
                                                        data-placement="top" title="Copy Link" aria-hidden="true"></i>
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $card->username ? $card->username : '--' }}
                                    </td>
                                    <td>
                                        {{ $card->description ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ model_status($card)['background'] }} me-1">
                                            {{ model_status($card)['status'] }}
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
                                                    href="{{ url('admin/card/' . $card->id . '/edit') }}">
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
                        @if ($cards['cards']->count() > 0)
                            {{ $cards['cards']->links() }}
                        @else
                            <p class="text-center"> No Record Found </p>
                        @endif
                    </div>
                </div>
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

        function copy(id) {
            let url = window.location.origin + '/card_id' + '/' + $('#card-' + id).val();

            const textArea = document.createElement("textarea");
            textArea.value = url;
            document.body.appendChild(textArea);

            // Select and copy the text
            textArea.select();
            document.execCommand("copy");

            // Remove the text area
            document.body.removeChild(textArea);

            alert("copied");
        }
    </script>
@endsection
