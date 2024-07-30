<?php

namespace App\Http\Livewire\Admin\Card;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Card;

use Illuminate\Support\Str;
use App\Traits\ExportData;

class Cards extends Component
{

    use WithPagination, ExportData;

    protected $paginationTheme = 'bootstrap';

    public $cards, $total, $heading;

    public $searchQuery = '', $filterByType, $filterByStatus;

    public $types = [], $statuses = [];

    public function mount()
    {
        $this->statuses = [
            '1' => 'Active',
            '2' => 'Inactive',
        ];
    }

    public function exportCsv()
    {
        return redirect()->route('export')->with(
            [
                'file_name' => 'cards.csv',
                'data' => $this->getFilteredData()->get()
            ]
        );
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function getFilteredData()
    {
        $filteredData = Card::select(
            'cards.id',
            'cards.uuid',
            'cards.description',
            'cards.status',
            'users.username',
        )
            ->leftJoin('user_cards', 'user_cards.card_id', 'cards.id')
            ->leftJoin('users', 'users.id', 'user_cards.user_id')
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($query) {
                    $query->where('cards.uuid', 'like', "%$this->searchQuery%")
                        ->orWhere( 'like', "%$this->searchQuery%")
                        ->orWhere('users.username', 'like', "%$this->searchQuery%");
                });
            })
            ->when($this->filterByStatus, function ($query) {
                if ($this->filterByStatus == 1) {
                    $query->where('cards.status', 1);
                }
                if ($this->filterByStatus == 2) {
                    $query->where('cards.status', 0);
                }
            });
        return $filteredData;
    }

    public function render()
    {
        $data = $this->getFilteredData();

        $this->total = $data->get()->count();

        $this->heading = "Cards";

        $this->cards = $data->paginate(10);

        $this->cards = ['cards' => $this->cards];

        return view('livewire.admin.card.cards', $this->cards)
            ->layout('layouts.app');
    }
}
