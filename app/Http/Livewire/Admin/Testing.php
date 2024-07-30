<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Testing extends Component
{
    public $name;
    public $email;
    public $formData = [];
    public $edit = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function submit()
    {
        $this->validate();

        if ($this->edit !== null) {
            $this->formData[$this->edit] = [
                'name' => $this->name,
                'email' => $this->email,
            ];
            $this->edit = null;
        } else {
            $this->formData[] = [
                'name' => $this->name,
                'email' => $this->email,
            ];
        }

        $this->resetForm();
    }

    public function edit($index)
    {
        $this->edit = $index;
        $this->name = $this->formData[$index]['name'];
        $this->email = $this->formData[$index]['email'];
    }

    public function delete($index)
    {
        unset($this->formData[$index]);
        $this->formData = array_values($this->formData);
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.admin.testing');
    }
}
