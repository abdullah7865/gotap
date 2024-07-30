<?php

namespace App\Http\Livewire\Admin\Platform;

use App\Models\Category;
use App\Models\Platform;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;

    public $heading, $categories;

    public
        $title,
        $icon,
        $pro,
        $category_id,
        $status,
        $placeholder_en,
        $placeholder_sv,
        $description_en,
        $description_sv,
        $baseURL,
        $input;

    protected function rules()
    {
        return [
            'title'                  =>        ['required'],
            'icon'                   =>        ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],
            'pro'                    =>        ['required'],
            'category_id'            =>        ['required'],
            'status'                 =>        ['required'],
            'placeholder_en'         =>        ['sometimes'],
            'placeholder_sv'         =>        ['sometimes'],
            'description_en'         =>        ['sometimes'],
            'description_sv'         =>        ['sometimes'],
            'baseURL'                =>        ['sometimes'],
            'input'                  =>        ['required'],
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function mount()
    {
        $this->categories = Category::all()->pluck('name', 'id')->toArray();
    }

    public function store()
    {
        $data = $this->validate();

        if ($this->icon) {
            $image = $this->icon;
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/uploads/coverPhotos', $imageName);
            $data['icon'] = 'uploads/coverPhotos/' . $imageName;
        }


        Platform::create($data);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Platform created successfully!',
        ]);
    }

    public function render()
    {
        $this->heading = 'Create';
        return view('livewire.admin.platform.create')
            ->layout('layouts.app');
    }
}
