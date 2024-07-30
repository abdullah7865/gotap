<?php

namespace App\Http\Livewire\Admin\Card;

use App\Models\Card;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $cards, $total, $heading;

    public $searchQuery = '', $filterByType, $filterByStatus;

    public $types = [], $statuses = [];

    public $type, $description, $quantity, $cardId, $alert_status = 0;

    protected $rules = [
        'description' => 'required',
        'quantity' => 'numeric|min:1'
    ];

    public function mount()
    {
        $this->statuses = [
            '1' => 'Active',
            '2' => 'Deactive',
        ];
    }

    public function store()
    {
        $this->validate();

        for ($i = 0; $i < $this->quantity; $i++) {
            Card::create([
                'uuid' => Str::uuid(),
                // 'type' => $this->type,
                'description' => $this->description,
                'status' => 0,
            ]);
        }

        $this->resetModal();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Card created successfully!',
        ]);
    }

    public function edit($id)
    {
        $this->cardId = $id;
        $card = Card::find($id);
        if ($card) {
            // $this->type = $card->type;
            $this->description = $card->description;
            $this->dispatchBrowserEvent('show-edit-modal');
        } else {
            redirect()->back();
        }
    }

    public function update()
    {
        $this->validate();
        Card::where('id', $this->cardId)
            ->update([
                // 'type' => $this->type,
                'description' => $this->description
            ]);

        $this->resetModal();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Card updated successfully!',
        ]);
    }

    public function deleteConfirmModal($id)
    {
        $this->cardId = $id;
        $this->methodType = 'destroy';
        $this->modalActionBtnText = 'Delete';
        $this->modalActionBtnColor = 'bg-danger';
        $this->modalBody = 'You want to delete card!';
        $this->dispatchBrowserEvent('open-confirm-modal');
    }

    public function destroy()
    {
        $card = Card::where('id', $this->cardId);
        $card->delete();

        $this->methodType = '';
        $this->modalActionBtnText = '';
        $this->modalActionBtnColor = '';
        $this->modalBody = '';

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Card deleted sccessfully!',
        ]);
    }

    public function deactivateConfirmModal($id)
    {
        $this->cardId = $id;
        $this->methodType = 'deactivate';
        $this->modalActionBtnText = 'Deactivate';
        $this->modalActionBtnColor = 'bg-danger';
        $this->modalBody = 'You want to deactivate card!';
        $this->dispatchBrowserEvent('open-confirm-modal');
    }

    public function deactivate()
    {
        $card = Card::where('id', $this->cardId);
        $card->update([
            'status' => 0,
        ]);

        $this->methodType = '';
        $this->modalActionBtnText = '';
        $this->modalActionBtnColor = '';
        $this->modalBody = '';

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Card deactivated sccessfully!',
        ]);
    }

    public function activateConfirmModal($id)
    {
        $this->cardId = $id;
        $this->methodType = 'activate';
        $this->modalActionBtnText = 'Activate';
        $this->modalActionBtnColor = 'bg-success';
        $this->modalBody = 'You want to activate card!';
        $this->dispatchBrowserEvent('open-confirm-modal');
    }

    public function activate()
    {
        $card = Card::where('id', $this->cardId);
        $card->update([
            'status' => 1,
        ]);

        $this->methodType = '';
        $this->modalActionBtnText = '';
        $this->modalActionBtnColor = '';
        $this->modalBody = '';

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Card activated sccessfully!',
        ]);
    }

    public function resetModal()
    {
        $this->type = '';
        $this->description = '';
        $this->quantity = 1;
    }

    public function clearSessionMessage()
    {
        $this->alert_status = 0;
    }

    public function closeModal()
    {
        $this->resetModal();
        $this->dispatchBrowserEvent('close-modal');
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

    public function updatedFilterByStatus()
    {
        $this->resetPage();
    }

    // public function updatedFilterByType()
    // {
    //     $this->resetPage();
    // }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function getFilteredData()
    {
        $filteredData = Card::when($this->searchQuery, function ($query) {
            $query->where('uuid', 'like', "%$this->searchQuery%");
        })
            // ->when($this->filterByType, function ($query) {
            //     $query->where('type', 'like', "%$this->filterByType%");
            // })
            ->when($this->filterByStatus, function ($query) {
                if ($this->filterByStatus == 1) {
                    $query->where('status', 1);
                }
                if ($this->filterByStatus == 2) {
                    $query->where('status', 0);
                }
            });
        // ->orderBy('created_at', 'desc');
        return $filteredData;
    }

    public function render()
    {
        return view('livewire.admin.card.edit');
    }
}
