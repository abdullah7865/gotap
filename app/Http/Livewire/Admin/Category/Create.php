<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{

    public $heading;

    public $name, $name_sv, $status;

    protected function rules()
    {
        return [
            'name'   => ['required'],
            'name_sv' => ['required'],
            'status' => ['required', 'not_in:'],
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'required',
            'name_sv.required' => 'required',
            'status.required' => 'required',
            'status.not_in' => 'Invalid status selected',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function store()
    {
        $data = $this->validate();

        Category::create($data);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Category created successfully!',
        ]);
    }

    public function render()
    {
        $this->heading = "Create";
        return view('livewire.admin.category.create')
            ->layout('layouts.app');
    }
}
