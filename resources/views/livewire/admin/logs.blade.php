@section('style')
    <style>
        td {
            padding: 8px;
            border: 1px solid black;
        }
    </style>
@endsection

<div>
    <div>
        <div class="d-flex justify-content-between">
            <h2 class="card-header">
                {{ $heading }}
                <span>
                    <h5 style="margin-top:10px"> Total: {{ $total }} </h4>
                </span>
            </h2>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-3 offset-9">
                    <label for=""> Search by message or file </label>
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
                                <th> Created At </th>
                                <th> File </th>
                                <th> Line </th>
                                <th> Message </th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($logs['logs'] as $log)
                                <tr class="bg-dark text-white">
                                    <td style="font-size: 16px">
                                        {{ defaultDateFormat($log->created_at) }}
                                    </td>
                                    <td style="font-size: 16px">
                                        {{ $log->file }}
                                    </td>
                                    <td style="font-size: 16px">
                                        {{ $log->line }}
                                    </td>
                                    <td
                                        style="white-space: normal; overflow: hidden; text-overflow: clip; font-size: 16px">
                                        {{ $log->message }}
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
                        @if ($logs['logs']->count() > 0)
                            {{ $logs['logs']->links() }}
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
@endsection
