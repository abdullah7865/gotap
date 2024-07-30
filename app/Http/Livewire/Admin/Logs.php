<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Logs extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // filter valriables
    public $searchQuery = '';

    public $logs, $total, $heading;

    public function updatedFilterByStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function getFilteredData()
    {

        $filteredData = DB::table('logs')->select(
            'message',
            'file',
            'line',
            'created_at',
        )
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($query) {
                    $query->where('message', 'like', "%$this->searchQuery%")
                        ->orWhere('file', 'like', "%$this->searchQuery%");
                });
            })
            ->whereDate('created_at', now())
            ->orderBy('created_at', 'desc');

        return $filteredData;
    }

    public function render()
    {

        $data = $this->getFilteredData();

        $this->heading = "Logs";
        $this->logs = $data->paginate(10);

        $this->total = $this->logs->total();

        $this->logs = ['logs' => $this->logs];

        return view('livewire.admin.logs')
            ->layout('layouts.app');
    }
}
