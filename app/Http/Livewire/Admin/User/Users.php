<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Users extends Component
{

    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';

    // filter valriables
    public $searchQuery = '', $filterByStatus, $sortBy = '';

    public $users, $total, $heading, $statuses = [];

    public function mount()
    {
        $this->statuses = [
            '1' => 'Active',
            '2' => 'Deactive',
        ];
    }

    public function updatedFilterByStatus()
    {
        $this->resetPage();
    }
    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function getFilteredData()
    {
        $filteredData = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.username',
            'users.photo',
            'users.status',
            'users.tiks',
            'users.created_at',
            DB::raw('(SELECT COUNT(*) FROM user_cards WHERE user_cards.user_id = users.id) AS total_products')
        )
            ->when($this->filterByStatus, function ($query) {
                if ($this->filterByStatus == 2) {
                    $query->where('users.status', 0);
                }
                if ($this->filterByStatus == 1) {
                    $query->where('users.status', 1);
                }
            })
            ->when($this->sortBy, function ($query) {
                if ($this->sortBy == 'created_asc') {
                    $query->orderBy('created_at', 'asc');
                }
                if ($this->sortBy == 'created_desc') {
                    $query->orderBy('created_at', 'desc');
                }
                if ($this->sortBy == 'products_asc') {
                    $query->orderBy('total_products', 'asc');
                }
                if ($this->sortBy == 'products_desc') {
                    $query->orderBy('total_products', 'desc');
                }
            })
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($query) {
                    $query->where('users.name', 'like', "%$this->searchQuery%")
                        ->orWhere('users.username', 'like', "%$this->searchQuery%")
                        ->orWhere('users.email', 'like', "%$this->searchQuery%");
                });
            })
            ->orderBy('users.created_at', 'desc');

        return $filteredData;
    }

    public function render()
    {
        $data = $this->getFilteredData();

        $this->heading = "Users";
        $this->users = $data->paginate(10);

        $this->total = $this->users->total();

        $this->users = ['users' => $this->users];

        return view('livewire.admin.user.users')
            ->layout('layouts.app');
    }
}
