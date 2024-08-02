<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;

class Edit extends Component
{

    public $heading;

    public $category_id, $name, $name_sv, $status;

    protected function rules()
    {
        return [
            'name'    => ['required'],
            'name_sv' => ['required'],
            'status'  => ['required','not_in:'],
        ];
    }

    protected function messages()
    {
        return [
            'name.required'    => 'required',
            'name_sv.required' => 'required',
            'status.required'  => 'required',
            'status.not_in' => 'Invalid status selected',

        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function mount($id)
    {
        $this->category_id = $id;
        $category = Category::where('id', $this->category_id)->first();

        $this->name = $category->name;
        $this->name_sv = $category->name_sv;
        $this->status = $category->status;
    }

    public function update()
    {
        $data = $this->validate();

        Category::where('id', $this->category_id)->update($data);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Category updated successfully!',
        ]);
    }

    public function render()
    {
        $this->heading = "Edit";
        return view('livewire.admin.category.edit')
            ->layout('layouts.app');
    }
}
